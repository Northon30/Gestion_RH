<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58,123,213,0.12);
        --c-primary-border: rgba(58,123,213,0.25);
        --c-accent:         #5B9BF0;
        --c-green:          #90c97f;
        --c-red:            #ff6b7a;
        --c-orange:         #F5A623;
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.6);
    }

    .filter-bar {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .filter-bar select,
    .filter-bar input {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 0.82rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .filter-bar select:focus,
    .filter-bar input:focus { border-color: var(--c-primary); }
    .filter-bar select option { background: #222; }

    .filter-bar label {
        color: var(--c-muted);
        font-size: 0.78rem;
        white-space: nowrap;
    }

    .filter-group { display: flex; align-items: center; gap: 7px; }

    .btn-filter-reset {
        background: transparent;
        border: 1px solid rgba(220,53,69,0.3);
        color: var(--c-red);
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 0.78rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-filter-reset:hover { background: rgba(220,53,69,0.1); }

    .main-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        overflow: hidden;
    }

    .main-card-head {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .main-card-head h5 {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .main-card-head h5 i { color: var(--c-primary); }

    .btn-primary-c {
        background: linear-gradient(135deg, var(--c-primary), #2A5FAA);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 7px 16px;
        font-size: 0.82rem;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-primary-c:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(58,123,213,0.3); color: #fff; }

    .table-c { width: 100%; border-collapse: collapse; font-size: 0.83rem; }

    .table-c thead th {
        padding: 10px 16px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.7px;
        text-transform: uppercase;
        color: var(--c-accent);
        background: var(--c-primary-pale);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        white-space: nowrap;
    }

    .table-c tbody td {
        padding: 12px 16px;
        color: var(--c-soft);
        border-bottom: 1px solid rgba(255,255,255,0.03);
        vertical-align: middle;
    }

    .table-c tbody tr:last-child td { border-bottom: none; }
    .table-c tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .emp-cell { display: flex; align-items: center; gap: 9px; }
    .emp-av {
        width: 30px; height: 30px; border-radius: 50%;
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-accent); font-size: 0.72rem; font-weight: 700;
        flex-shrink: 0;
    }
    .emp-name { font-weight: 500; color: rgba(255,255,255,0.8); font-size: 0.83rem; }
    .emp-dir  { color: var(--c-muted); font-size: 0.72rem; }

    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 600; white-space: nowrap;
    }
    .badge-status.en_attente    { background: rgba(245,166,35,0.12); border: 1px solid rgba(245,166,35,0.3); color: var(--c-orange); }
    .badge-status.approuve_chef { background: var(--c-primary-pale); border: 1px solid var(--c-primary-border); color: var(--c-accent); }
    .badge-status.rejete_chef   { background: rgba(220,53,69,0.12);  border: 1px solid rgba(220,53,69,0.3); color: var(--c-red); }
    .badge-status.valide_rh     { background: rgba(144,201,127,0.12); border: 1px solid rgba(144,201,127,0.3); color: var(--c-green); }
    .badge-status.rejete_rh     { background: rgba(220,53,69,0.12);  border: 1px solid rgba(220,53,69,0.3); color: var(--c-red); }

    .badge-type {
        display: inline-flex; align-items: center;
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        color: var(--c-accent);
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 500;
    }

    .badge-mine {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(245,166,35,0.1);
        border: 1px solid rgba(245,166,35,0.2);
        color: var(--c-orange);
        padding: 2px 7px; border-radius: 10px;
        font-size: 0.68rem; font-weight: 600;
    }

    .action-btn {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--c-muted);
        width: 30px; height: 30px;
        border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.78rem;
        transition: all 0.2s;
        text-decoration: none;
        cursor: pointer;
    }
    .action-btn:hover { border-color: var(--c-primary); color: var(--c-accent); background: var(--c-primary-pale); }
    .action-btn.approve:hover { border-color: var(--c-green); color: var(--c-green); background: rgba(144,201,127,0.1); }
    .action-btn.reject:hover  { border-color: var(--c-red);   color: var(--c-red);   background: rgba(220,53,69,0.1); }

    .empty-state {
        padding: 50px 20px;
        text-align: center;
        color: var(--c-muted);
    }
    .empty-state i { font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.3; }

    .alert-success-dark {
        background: rgba(144,201,127,0.1);
        border: 1px solid rgba(144,201,127,0.25);
        color: var(--c-green);
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.85rem;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }
    .alert-error-dark {
        background: rgba(220,53,69,0.1);
        border: 1px solid rgba(220,53,69,0.25);
        color: var(--c-red);
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.85rem;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }

    /* Modal */
    .modal-dark { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.65); align-items: center; justify-content: center; }
    .modal-dark.is-open { display: flex; }
    .modal-box { background: #1e1e1e; border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; width: 420px; max-width: 95vw; overflow: hidden; }
    .modal-head { padding: 18px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; }
    .modal-head h6 { color: #fff; font-size: 0.95rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 8px; }
    .modal-close { background: none; border: none; color: var(--c-muted); font-size: 1.1rem; cursor: pointer; }
    .modal-close:hover { color: #fff; }
    .modal-body { padding: 20px; }
    .modal-foot { padding: 15px 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: flex-end; gap: 10px; }

    .form-control-dark {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.88rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
        resize: vertical;
    }
    .form-control-dark:focus { border-color: var(--c-primary); background: rgba(255,255,255,0.07); }
    .form-label-dark { color: var(--c-muted); font-size: 0.82rem; margin-bottom: 6px; display: block; }

    .btn-approve { background: linear-gradient(135deg, #2D6A4F, #1e4d38); border: none; color: #fff; font-weight: 600; border-radius: 8px; padding: 8px 18px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; }
    .btn-approve:hover { box-shadow: 0 4px 12px rgba(45,106,79,0.4); }
    .btn-reject  { background: linear-gradient(135deg, #dc3545, #a71d2a); border: none; color: #fff; font-weight: 600; border-radius: 8px; padding: 8px 18px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; }
    .btn-reject:hover  { box-shadow: 0 4px 12px rgba(220,53,69,0.4); }
    .btn-cancel  { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: var(--c-soft); border-radius: 8px; padding: 8px 16px; font-size: 0.85rem; cursor: pointer; }
    .btn-cancel:hover { background: rgba(255,255,255,0.1); }

    .tab-pills { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
    .tab-pill {
        padding: 6px 14px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.04); color: var(--c-muted);
        transition: all 0.2s;
    }
    .tab-pill:hover,
    .tab-pill.active { background: var(--c-primary-pale); border-color: var(--c-primary-border); color: var(--c-accent); }
    .tab-pill .pill-count { background: rgba(255,255,255,0.1); border-radius: 10px; padding: 1px 6px; font-size: 0.68rem; margin-left: 4px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$labStatut = [
    'en_attente'    => 'En attente',
    'approuve_chef' => 'Approuvé Chef',
    'rejete_chef'   => 'Refusé Chef',
    'valide_rh'     => 'Validé RH',
    'rejete_rh'     => 'Rejeté RH',
];

$mesConges   = array_filter($conges, fn($c) => $c['id_Emp'] == $idEmp);
$autresConges = array_filter($conges, fn($c) => $c['id_Emp'] != $idEmp);
$aValider    = array_filter($conges, fn($c) => $c['id_Emp'] != $idEmp && $c['Statut_Cge'] == 'en_attente');
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-check me-2" style="color:var(--c-primary);"></i>Gestion des Congés</h1>
        <p>Suivez et approuvez les demandes de congé de votre direction</p>
    </div>
    <a href="<?= base_url('conge/create') ?>" class="btn-primary-c">
        <i class="fas fa-plus"></i> Ma demande
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Onglets -->
<div class="tab-pills">
    <div class="tab-pill active" data-tab="direction">
        Direction <span class="pill-count"><?= count($autresConges) ?></span>
    </div>
    <div class="tab-pill" data-tab="avalider">
        À approuver <span class="pill-count" style="background:rgba(245,166,35,0.2);color:var(--c-orange);"><?= count($aValider) ?></span>
    </div>
    <div class="tab-pill" data-tab="mes">
        Mes congés <span class="pill-count"><?= count($mesConges) ?></span>
    </div>
</div>

<!-- Filtres -->
<div class="filter-bar">
    <div class="filter-group">
        <label><i class="fas fa-filter me-1"></i>Statut</label>
        <select id="f-statut">
            <option value="">Tous</option>
            <?php foreach ($labStatut as $val => $lab): ?>
            <option value="<?= $val ?>"><?= $lab ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="filter-group">
        <label>Type</label>
        <select id="f-type">
            <option value="">Tous</option>
            <?php foreach ($typesConge as $t): ?>
            <option value="<?= $t['id_Tcg'] ?>"><?= esc($t['Libelle_Tcg']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="filter-group">
        <label>Recherche</label>
        <input type="text" id="f-search" placeholder="Nom employé...">
    </div>
    <button class="btn-filter-reset" onclick="resetFiltres()">
        <i class="fas fa-times"></i> Réinitialiser
    </button>
</div>

<!-- Tableau direction -->
<div id="tab-direction" class="tab-content">
    <div class="main-card">
        <div class="main-card-head">
            <h5><i class="fas fa-users"></i> Congés de la direction</h5>
            <span style="color:var(--c-muted);font-size:0.78rem;" id="count-direction"><?= count($autresConges) ?> demande(s)</span>
        </div>
        <?php if (!empty($autresConges)): ?>
        <table class="table-c" id="table-direction">
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Durée</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autresConges as $c): ?>
                <?php
                $debut = new DateTime($c['DateDebut_Cge']);
                $fin   = new DateTime($c['DateFin_Cge']);
                $duree = $debut->diff($fin)->days + 1;
                $initiales = strtoupper(mb_substr($c['Prenom_Emp'], 0, 1) . mb_substr($c['Nom_Emp'], 0, 1));
                ?>
                <tr data-statut="<?= $c['Statut_Cge'] ?>"
                    data-type="<?= $c['id_Tcg'] ?>"
                    data-nom="<?= strtolower($c['Nom_Emp'] . ' ' . $c['Prenom_Emp']) ?>">
                    <td>
                        <div class="emp-cell">
                            <div class="emp-av"><?= $initiales ?></div>
                            <div>
                                <div class="emp-name"><?= esc($c['Prenom_Emp'] . ' ' . $c['Nom_Emp']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge-type"><?= esc($c['Libelle_Tcg']) ?></span></td>
                    <td><?= date('d/m/Y', strtotime($c['DateDebut_Cge'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['DateFin_Cge'])) ?></td>
                    <td><span style="color:var(--c-muted);font-size:0.8rem;"><?= $duree ?> j</span></td>
                    <td><span class="badge-status <?= $c['Statut_Cge'] ?>"><?= $labStatut[$c['Statut_Cge']] ?? $c['Statut_Cge'] ?></span></td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="<?= base_url('conge/show/' . $c['id_Cge']) ?>" class="action-btn" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($c['Statut_Cge'] == 'en_attente'): ?>
                            <button class="action-btn approve" title="Approuver"
                                onclick="openApprouver(<?= $c['id_Cge'] ?>, '<?= esc($c['Prenom_Emp'] . ' ' . $c['Nom_Emp']) ?>')">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="action-btn reject" title="Refuser"
                                onclick="openRefuser(<?= $c['id_Cge'] ?>, '<?= esc($c['Prenom_Emp'] . ' ' . $c['Nom_Emp']) ?>')">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-calendar-check"></i>
            Aucune demande de congé dans votre direction
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Tableau à valider -->
<div id="tab-avalider" class="tab-content" style="display:none;">
    <div class="main-card">
        <div class="main-card-head">
            <h5><i class="fas fa-clock" style="color:var(--c-orange);"></i> Demandes à approuver</h5>
            <span style="color:var(--c-orange);font-size:0.78rem;"><?= count($aValider) ?> en attente</span>
        </div>
        <?php $aValiderArr = array_values($aValider); ?>
        <?php if (!empty($aValiderArr)): ?>
        <table class="table-c">
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Durée</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aValiderArr as $c): ?>
                <?php
                $debut = new DateTime($c['DateDebut_Cge']);
                $fin   = new DateTime($c['DateFin_Cge']);
                $duree = $debut->diff($fin)->days + 1;
                $initiales = strtoupper(mb_substr($c['Prenom_Emp'], 0, 1) . mb_substr($c['Nom_Emp'], 0, 1));
                ?>
                <tr>
                    <td>
                        <div class="emp-cell">
                            <div class="emp-av"><?= $initiales ?></div>
                            <div>
                                <div class="emp-name"><?= esc($c['Prenom_Emp'] . ' ' . $c['Nom_Emp']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge-type"><?= esc($c['Libelle_Tcg']) ?></span></td>
                    <td><?= date('d/m/Y', strtotime($c['DateDebut_Cge'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['DateFin_Cge'])) ?></td>
                    <td><span style="color:var(--c-muted);font-size:0.8rem;"><?= $duree ?> j</span></td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="<?= base_url('conge/show/' . $c['id_Cge']) ?>" class="action-btn" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="action-btn approve" title="Approuver"
                                onclick="openApprouver(<?= $c['id_Cge'] ?>, '<?= esc($c['Prenom_Emp'] . ' ' . $c['Nom_Emp']) ?>')">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="action-btn reject" title="Refuser"
                                onclick="openRefuser(<?= $c['id_Cge'] ?>, '<?= esc($c['Prenom_Emp'] . ' ' . $c['Nom_Emp']) ?>')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-check-circle" style="color:var(--c-green);opacity:1;"></i>
            Aucune demande en attente d'approbation
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Mes congés -->
<div id="tab-mes" class="tab-content" style="display:none;">
    <div class="main-card">
        <div class="main-card-head">
            <h5><i class="fas fa-user"></i> Mes demandes de congé</h5>
            <a href="<?= base_url('conge/create') ?>" class="btn-primary-c">
                <i class="fas fa-plus"></i> Nouvelle
            </a>
        </div>
        <?php $mesCongesArr = array_values($mesConges); ?>
        <?php if (!empty($mesCongesArr)): ?>
        <table class="table-c">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Libellé</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Durée</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mesCongesArr as $c): ?>
                <?php
                $debut = new DateTime($c['DateDebut_Cge']);
                $fin   = new DateTime($c['DateFin_Cge']);
                $duree = $debut->diff($fin)->days + 1;
                ?>
                <tr>
                    <td><span class="badge-type"><?= esc($c['Libelle_Tcg']) ?></span></td>
                    <td style="color:rgba(255,255,255,0.7);"><?= esc($c['Libelle_Cge']) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['DateDebut_Cge'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['DateFin_Cge'])) ?></td>
                    <td><span style="color:var(--c-muted);font-size:0.8rem;"><?= $duree ?> j</span></td>
                    <td><span class="badge-status <?= $c['Statut_Cge'] ?>"><?= $labStatut[$c['Statut_Cge']] ?? $c['Statut_Cge'] ?></span></td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="<?= base_url('conge/show/' . $c['id_Cge']) ?>" class="action-btn" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($c['Statut_Cge'] == 'en_attente'): ?>
                            <a href="<?= base_url('conge/edit/' . $c['id_Cge']) ?>" class="action-btn" title="Modifier">
                                <i class="fas fa-pen"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-calendar-plus"></i>
            Vous n'avez pas encore fait de demande de congé
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Approuver -->
<div class="modal-dark" id="modal-approuver">
    <div class="modal-box">
        <div class="modal-head">
            <h6><i class="fas fa-check-circle" style="color:var(--c-green);"></i> Approuver le congé</h6>
            <button class="modal-close" onclick="closeModal('modal-approuver')"><i class="fas fa-times"></i></button>
        </div>
        <form method="post" id="form-approuver">
            <?= csrf_field() ?>
            <div class="modal-body">
                <p style="color:var(--c-soft);font-size:0.85rem;margin-bottom:14px;">
                    Approuver la demande de <strong id="approuver-nom" style="color:#fff;"></strong> ?
                    <br><small style="color:var(--c-muted);">La demande sera transmise au RH pour validation finale.</small>
                </p>
                <label class="form-label-dark">Commentaire (optionnel)</label>
                <textarea class="form-control-dark" name="commentaire" rows="3" placeholder="Commentaire..."></textarea>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="closeModal('modal-approuver')">Annuler</button>
                <button type="submit" class="btn-approve"><i class="fas fa-check me-1"></i> Approuver</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Refuser -->
<div class="modal-dark" id="modal-refuser">
    <div class="modal-box">
        <div class="modal-head">
            <h6><i class="fas fa-times-circle" style="color:var(--c-red);"></i> Refuser le congé</h6>
            <button class="modal-close" onclick="closeModal('modal-refuser')"><i class="fas fa-times"></i></button>
        </div>
        <form method="post" id="form-refuser">
            <?= csrf_field() ?>
            <div class="modal-body">
                <p style="color:var(--c-soft);font-size:0.85rem;margin-bottom:14px;">
                    Refuser la demande de <strong id="refuser-nom" style="color:#fff;"></strong> ?
                </p>
                <label class="form-label-dark">Motif de refus <span style="color:var(--c-red);">*</span></label>
                <textarea class="form-control-dark" name="commentaire" rows="3" placeholder="Motif obligatoire..." required></textarea>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="closeModal('modal-refuser')">Annuler</button>
                <button type="submit" class="btn-reject"><i class="fas fa-times me-1"></i> Refuser</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
// Onglets
document.querySelectorAll('.tab-pill').forEach(function(pill) {
    pill.addEventListener('click', function() {
        document.querySelectorAll('.tab-pill').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
        this.classList.add('active');
        document.getElementById('tab-' + this.dataset.tab).style.display = 'block';
    });
});

// Filtres
function applyFiltres() {
    var statut = document.getElementById('f-statut').value;
    var type   = document.getElementById('f-type').value;
    var search = document.getElementById('f-search').value.toLowerCase();
    var rows   = document.querySelectorAll('#table-direction tbody tr');
    var visible = 0;

    rows.forEach(function(row) {
        var ok = true;
        if (statut && row.dataset.statut !== statut) ok = false;
        if (type   && row.dataset.type   !== type)   ok = false;
        if (search && !row.dataset.nom.includes(search)) ok = false;
        row.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });

    document.getElementById('count-direction').textContent = visible + ' demande(s)';
}

function resetFiltres() {
    document.getElementById('f-statut').value = '';
    document.getElementById('f-type').value   = '';
    document.getElementById('f-search').value = '';
    applyFiltres();
}

['f-statut','f-type','f-search'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', applyFiltres);
});

// Modals
function openApprouver(id, nom) {
    document.getElementById('approuver-nom').textContent = nom;
    document.getElementById('form-approuver').action = '<?= base_url('conge/approuver/') ?>' + id;
    document.getElementById('modal-approuver').classList.add('is-open');
}

function openRefuser(id, nom) {
    document.getElementById('refuser-nom').textContent = nom;
    document.getElementById('form-refuser').action = '<?= base_url('conge/refuser/') ?>' + id;
    document.getElementById('modal-refuser').classList.add('is-open');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('is-open');
}

document.querySelectorAll('.modal-dark').forEach(function(m) {
    m.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
</script>
<?= $this->endSection() ?>