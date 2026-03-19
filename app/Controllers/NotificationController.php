<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notif;

    public function __construct()
    {
        $this->notif = new NotificationModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }
    private function idPfl(): int { return (int) session()->get('id_Pfl'); }

    private function profileView(string $page, array $data = []): string
    {
        $folder = match ($this->idPfl()) {
            1       => 'rh',
            2       => 'chef',
            3       => 'employe',
            default => 'employe',
        };
        return view("{$folder}/notifications/{$page}", $data);
    }

    // ══════════════════════════════════════════════════════════
    // INDEX — toutes les notifications
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $db = \Config\Database::connect();

        $notifications = $db->table('notification')
            ->select('notification.*, employe.Nom_Emp AS src_nom, employe.Prenom_Emp AS src_prenom')
            ->join('employe', 'employe.id_Emp = notification.id_Emp_Src', 'left')
            ->where('notification.id_Emp_Dest', $this->idEmp())
            ->orderBy('notification.DateHeure_Notif', 'DESC')
            ->get()->getResultArray();

        $nonLues = count(array_filter($notifications, fn($n) => $n['Lu_Notif'] == 0));

        return $this->profileView('index', [
            'title'         => 'Notifications',
            'notifications' => $notifications,
            'nonLues'       => $nonLues,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // LIRE — marquer une notification comme lue (AJAX)
    // ══════════════════════════════════════════════════════════
    public function lire($id)
    {
        $db = \Config\Database::connect();
        $db->table('notification')
            ->where('id_Notif', $id)
            ->where('id_Emp_Dest', $this->idEmp())
            ->update(['Lu_Notif' => 1]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        return redirect()->to('notifications');
    }

    // ══════════════════════════════════════════════════════════
    // LIRE TOUTES — marquer toutes comme lues
    // ══════════════════════════════════════════════════════════
    public function lireToutes()
    {
        $db = \Config\Database::connect();
        $db->table('notification')
            ->where('id_Emp_Dest', $this->idEmp())
            ->where('Lu_Notif', 0)
            ->update(['Lu_Notif' => 1]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        return redirect()->to('notifications');
    }

    // ══════════════════════════════════════════════════════════
    // COUNT — nombre de non lues (AJAX polling navbar)
    // ══════════════════════════════════════════════════════════
    public function count()
    {
        $idEmp = $this->idEmp();

        if (!$idEmp) {
            return $this->response->setJSON(['count' => 0]);
        }

        $db = \Config\Database::connect();
        $n  = $db->table('notification')
            ->where('id_Emp_Dest', $idEmp)
            ->where('Lu_Notif', 0)
            ->countAllResults();

        return $this->response->setJSON(['count' => $n]);
    }

    // ══════════════════════════════════════════════════════════
    // SSE — Server-Sent Events pour notifications temps réel
    // ══════════════════════════════════════════════════════════
    public function stream()
    {
        $idEmp = $this->idEmp();

        if (!$idEmp) {
            return $this->response->setStatusCode(401);
        }

        // Headers SSE obligatoires
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        header('Connection: keep-alive');

        // Désactiver le buffer de sortie
        if (ob_get_level()) ob_end_clean();

        $db        = \Config\Database::connect();
        $dernierVu = (int) ($this->request->getGet('last_id') ?? 0);
        $maxIter   = 30; // 30 × 2s = 60s puis reconnexion auto côté client

        for ($i = 0; $i < $maxIter; $i++) {

            $nouvelles = $db->table('notification')
                ->select('notification.*, employe.Nom_Emp AS src_nom, employe.Prenom_Emp AS src_prenom')
                ->join('employe', 'employe.id_Emp = notification.id_Emp_Src', 'left')
                ->where('notification.id_Emp_Dest', $idEmp)
                ->where('notification.id_Notif >', $dernierVu)
                ->orderBy('notification.id_Notif', 'ASC')
                ->get()->getResultArray();

            if (!empty($nouvelles)) {
                $dernierVu = max(array_column($nouvelles, 'id_Notif'));

                $nonLues = $db->table('notification')
                    ->where('id_Emp_Dest', $idEmp)
                    ->where('Lu_Notif', 0)
                    ->countAllResults();

                echo "data: " . json_encode([
                    'notifications' => $nouvelles,
                    'count'         => $nonLues,
                    'last_id'       => $dernierVu,
                ]) . "\n\n";

                flush();
            }

            sleep(2);
        }

        // Signal de reconnexion au client après 60s
        echo "event: reconnect\ndata: {}\n\n";
        flush();
        exit;
    }

    // ══════════════════════════════════════════════════════════
    // DELETE — supprimer une notification
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('notification')
            ->where('id_Notif', $id)
            ->where('id_Emp_Dest', $this->idEmp())
            ->delete();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        return redirect()->to('notifications')->with('success', 'Notification supprimée.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE ALL — supprimer toutes les notifications lues
    // ══════════════════════════════════════════════════════════
    public function deleteToutes()
    {
        $db = \Config\Database::connect();
        $db->table('notification')
            ->where('id_Emp_Dest', $this->idEmp())
            ->where('Lu_Notif', 1)
            ->delete();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        return redirect()->to('notifications')->with('success', 'Notifications lues supprimées.');
    }
}