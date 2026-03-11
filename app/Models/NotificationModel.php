<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table      = 'notification';
    protected $primaryKey = 'id_Notif';

    protected $allowedFields = [
        'Titre_Notif',
        'Message_Notif',
        'Type_Notif',
        'Lu_Notif',
        'DateHeure_Notif',
        'id_Emp_Dest',
        'id_Emp_Src',
        'Lien_Notif',
    ];

    protected $useTimestamps = false;

    // ── Envoyer une notification ──────────────────────────────
    public function envoyer(
        int    $dest,
        string $titre,
        string $message,
        string $type  = 'info',
        string $lien  = null,
        int    $src   = null
    ): void {
        $this->insert([
            'Titre_Notif'     => $titre,
            'Message_Notif'   => $message,
            'Type_Notif'      => $type,
            'Lu_Notif'        => 0,
            'DateHeure_Notif' => date('Y-m-d H:i:s'),
            'id_Emp_Dest'     => $dest,
            'id_Emp_Src'      => $src,
            'Lien_Notif'      => $lien,
        ]);
    }

    // ── Envoyer à plusieurs destinataires ─────────────────────
    public function envoyerMultiple(
        array  $dests,
        string $titre,
        string $message,
        string $type = 'info',
        string $lien = null,
        int    $src  = null
    ): void {
        foreach ($dests as $dest) {
            $this->envoyer((int)$dest, $titre, $message, $type, $lien, $src);
        }
    }

    // ── Nombre de non lues pour un employé ───────────────────
    public function nonLues(int $idEmp): int
    {
        return $this->where('id_Emp_Dest', $idEmp)
                    ->where('Lu_Notif', 0)
                    ->countAllResults();
    }

    // ── 5 dernières notifications ─────────────────────────────
    public function dernieres(int $idEmp, int $limit = 5): array
    {
        return $this->where('id_Emp_Dest', $idEmp)
                    ->orderBy('DateHeure_Notif', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    // ── Marquer une notification comme lue ────────────────────
    public function marquerLue(int $idNotif): void
    {
        $this->update($idNotif, ['Lu_Notif' => 1]);
    }

    // ── Marquer toutes comme lues ─────────────────────────────
    public function marquerToutesLues(int $idEmp): void
    {
        $this->where('id_Emp_Dest', $idEmp)
             ->where('Lu_Notif', 0)
             ->set(['Lu_Notif' => 1])
             ->update();
    }

    // ── Toutes les notifs paginées ────────────────────────────
    public function toutesParEmploye(int $idEmp): array
    {
        return $this->where('id_Emp_Dest', $idEmp)
                    ->orderBy('DateHeure_Notif', 'DESC')
                    ->findAll();
    }
}