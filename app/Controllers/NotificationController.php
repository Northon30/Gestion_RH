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
    // LIRE TOUTES — marquer toutes comme lues (AJAX)
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
        $db = \Config\Database::connect();
        $n  = $db->table('notification')
            ->where('id_Emp_Dest', $this->idEmp())
            ->where('Lu_Notif', 0)
            ->countAllResults();

        return $this->response->setJSON(['count' => $n]);
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

        return redirect()->to('notifications')->with('success', 'Notifications lues supprimées.');
    }
}