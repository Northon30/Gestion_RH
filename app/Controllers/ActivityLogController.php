<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class ActivityLogController extends BaseController
{
    protected $log;

    public function __construct()
    {
        $this->log = new ActivityLogModel();
    }

    public function index()
    {
        if ((int) session()->get('id_Pfl') !== 1) {
            return redirect()->to('dashboard')->with('error', 'Accès refusé.');
        }

        $db = \Config\Database::connect();

        // Listes pour les filtres
        $modules = $db->table('activity_logs')
            ->select('Module_Log')
            ->distinct()
            ->orderBy('Module_Log')
            ->get()->getResultArray();

        $actions = $db->table('activity_logs')
            ->select('Action_Log')
            ->distinct()
            ->orderBy('Action_Log')
            ->get()->getResultArray();

        $employes = $db->table('employe')
            ->select('id_Emp, Nom_Emp, Prenom_Emp')
            ->orderBy('Nom_Emp')
            ->get()->getResultArray();

        // Stats globales
        $totalLogs    = $db->table('activity_logs')->countAllResults();
        $logsAujourdhui = $db->table('activity_logs')
            ->where('DATE(DateHeure_Log)', date('Y-m-d'))
            ->countAllResults();
        $actionsCreate = $db->table('activity_logs')->where('Action_Log', 'CREATE')->countAllResults();
        $actionsDelete = $db->table('activity_logs')->where('Action_Log', 'DELETE')->countAllResults();

        $data = [
            'title'         => 'Logs d\'activité',
            'modules'       => array_column($modules, 'Module_Log'),
            'actions'       => array_column($actions, 'Action_Log'),
            'employes'      => $employes,
            'totalLogs'     => $totalLogs,
            'logsAujourdhui'=> $logsAujourdhui,
            'actionsCreate' => $actionsCreate,
            'actionsDelete' => $actionsDelete,
        ];

        return view('rh/activity_log/index', $data);
    }

    // Endpoint AJAX — retourne JSON
    public function fetch()
    {
        if ((int) session()->get('id_Pfl') !== 1) {
            return $this->response->setJSON(['error' => 'Accès refusé.'])->setStatusCode(403);
        }

        $db = \Config\Database::connect();

        $q       = $this->request->getGet('q');
        $module  = $this->request->getGet('module');
        $action  = $this->request->getGet('action');
        $id_Emp  = $this->request->getGet('id_Emp');
        $date_du = $this->request->getGet('date_du');
        $date_au = $this->request->getGet('date_au');
        $page    = max(1, (int) $this->request->getGet('page'));
        $perPage = 25;
        $offset  = ($page - 1) * $perPage;

        $builder = $db->table('activity_logs')
            ->select('activity_logs.*, employe.Nom_Emp, employe.Prenom_Emp')
            ->join('employe', 'employe.id_Emp = activity_logs.id_Emp', 'left')
            ->orderBy('activity_logs.DateHeure_Log', 'DESC');

        if (!empty($q)) {
            $builder->groupStart()
                    ->like('activity_logs.Description_Log', $q)
                    ->orLike('activity_logs.Module_Log', $q)
                    ->orLike('activity_logs.Action_Log', $q)
                    ->orLike('employe.Nom_Emp', $q)
                    ->orLike('employe.Prenom_Emp', $q)
                    ->orLike('activity_logs.IpAdresse_Log', $q)
                    ->groupEnd();
        }

        if (!empty($module))  $builder->where('activity_logs.Module_Log', $module);
        if (!empty($action))  $builder->where('activity_logs.Action_Log', $action);
        if (!empty($id_Emp))  $builder->where('activity_logs.id_Emp', $id_Emp);
        if (!empty($date_du)) $builder->where('DATE(activity_logs.DateHeure_Log) >=', $date_du);
        if (!empty($date_au)) $builder->where('DATE(activity_logs.DateHeure_Log) <=', $date_au);

        // Clone pour le count total
        $total = $db->table('activity_logs')
            ->select('activity_logs.id_Log')
            ->join('employe', 'employe.id_Emp = activity_logs.id_Emp', 'left');

        if (!empty($q)) {
            $total->groupStart()
                  ->like('activity_logs.Description_Log', $q)
                  ->orLike('activity_logs.Module_Log', $q)
                  ->orLike('activity_logs.Action_Log', $q)
                  ->orLike('employe.Nom_Emp', $q)
                  ->orLike('employe.Prenom_Emp', $q)
                  ->orLike('activity_logs.IpAdresse_Log', $q)
                  ->groupEnd();
        }
        if (!empty($module))  $total->where('activity_logs.Module_Log', $module);
        if (!empty($action))  $total->where('activity_logs.Action_Log', $action);
        if (!empty($id_Emp))  $total->where('activity_logs.id_Emp', $id_Emp);
        if (!empty($date_du)) $total->where('DATE(activity_logs.DateHeure_Log) >=', $date_du);
        if (!empty($date_au)) $total->where('DATE(activity_logs.DateHeure_Log) <=', $date_au);

        $totalCount = $total->countAllResults();
        $logs       = $builder->limit($perPage, $offset)->get()->getResultArray();

        return $this->response->setJSON([
            'logs'       => $logs,
            'total'      => $totalCount,
            'page'       => $page,
            'perPage'    => $perPage,
            'totalPages' => (int) ceil($totalCount / $perPage),
        ]);
    }

    public function clear()
    {
        if ((int) session()->get('id_Pfl') !== 1) {
            return redirect()->to('dashboard')->with('error', 'Accès refusé.');
        }

        \Config\Database::connect()->table('activity_logs')->truncate();

        return redirect()->to('activity-log')->with('success', 'Logs effacés avec succès.');
    }
}