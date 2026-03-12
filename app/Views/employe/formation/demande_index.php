<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --e-primary:        #6BAF6B;
        --e-primary-pale:   rgba(107,175,107,0.10);
        --e-primary-border: rgba(107,175,107,0.25);
        --c-green-pale:    rgba(74,103,65,0.15);
        --c-green-border:  rgba(74,103,65,0.35);
        --c-red-pale:      rgba(224,82,82,0.10);
        --c-red-border:    rgba(224,82,82,0.25);
        --c-blue-pale:     rgba(58,123,213,0.10);
        --c-blue-border:   rgba(58,123,213,0.25);
        --c-yellow-pale:   rgba(255,193,7,0.10);
        --c-yellow-border: rgba(255,193,7,0.30);
        --c-purple-pale:   rgba(155,89,182,0.10);
        --c-purple-border: rgba(155,89,182,0.25);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .stat-strip {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px; margin-bottom: 18px;
    }

    .stat-pill {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 10px; padding: 12px 14px;
        display: flex; align-items: center; gap: 10px;
        transition: border-color 0.2s, transform 0.2s;
    }

    .stat-pill:hover { border-color: rgba(255,255,255,0.12); transform: translateY(-2px); }

    .stat-pill-icon {
        width: 34px; height: 34px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0;
    }

    .sp-primary { background: var(--e-primary-pale); color: var(--e-primary); }
    .sp-yellow  { background: var(--c-yellow-pale);  color: #ffc107; }
    .sp-blue    { background: var(--c-blue-pale);    color: #5B9BF0; }
    .sp-green   { background: var(--c-green-pale);   color: #7ab86a; }
    .sp-red     { background: var(--c-red-pale);     color: #ff8080; }

    .stat-pill-val   { font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
    .stat-pill-label { font-size: 0.68rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

    /* ===== FILTRES ===== */
    .filter-panel {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; margin-bottom: 14px; overflow: hidden;
    }

    .filter-panel-head {
        padding: 11px 16px; display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; user-select: none; transition: background 0.2s;
    }

    .filter-panel-head:hover { background: rgba(255,255,255,0.02); }

    .filter-panel-head-left {
        display: flex; align-items: center; gap: 9px;
        color: var(--c-text); font-size: 0.82rem; font-weight: 600;
    }

    .filter-panel-head-left i { color: var(--e-primary); }

    .filter-badge {
        background: var(--e-primary); color: #111;
        font-size: 0.62rem; font-weight: 800;
        padding: 1px 7px; border-radius: 10px; display: none;
    }

    .filter-badge.visible { display: inline; }
    .filter-chevron { color: var(--c-muted); font-size: 0.72rem; transition: transform 0.25s; }
    .filter-chevron.open { transform: rotate(180deg); }

    .filter-body { border-top: 1px solid var(--c-border); padding: 14px 16px; display: none; }
    .filter-body.open { display: block; }

    .filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 10px; align-items: end; margin-bottom: 10px;
    }

    .filter-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 10px; align-items: end;
    }

    .filter-group { display: flex; flex-direction: column; }

    .filter-label {
        font-size: 0.67rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 4px;
    }

    .filter-search-wrap { position: relative; }
    .filter-search-wrap i {
        position: absolute; left: 9px; top: 50%;
        transform: translateY(-50%); color: var(--c-muted);
        font-size: 0.72rem; pointer-events: none;
    }

    .filter-input, .filter-select {
        width: 100%; background: #111; border: 1px solid var(--c-border);
        border-radius: 7px; color: var(--c-text); font-size: 0.78rem;
        outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; height: 34px;
    }

    .filter-search-wrap .filter-input { padding: 0 10px 0 28px; }
    .filter-input  { padding: 0 10px; }
    .filter-select { padding: 0 10px; cursor: pointer; }
    .filter-input:focus, .filter-select:focus { border-color: var(--e-primary-border); }
    .filter-input::placeholder { color: var(--c-muted); }
    .filter-select option { background: #1a1a1a; }

    .btn-reset {
        background: rgba(220,53,69,0.10); border: 1px solid rgba(220,53,69,0.25);
        color: #ff8080; font-weight: 600; border-radius: 7px;
        padding: 0 12px; font-size: 0.75rem; cursor: pointer;
        transition: all 0.2s; display: none; align-items: center;
        gap: 5px; white-space: nowrap; height: 34px;
    }

    .btn-reset:hover { background: rgba(220,53,69,0.2); }
    .btn-reset.visible { display: inline-flex; }

    /* ===== BOUTONS ===== */
    .btn-primary {
        background: linear-gradient(135deg, var(--e-primary), #4a8a4a);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 8px 15px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(107,175,107,0.3); color: #fff; }

    .btn-icon {
        width: 28px; height: 28px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.7rem; cursor: pointer; transition: all 0.2s;
        text-decoration: none; border: none; flex-shrink: 0;
    }

    .btn-icon-view   { background: var(--c-blue-pale);   color: #5B9BF0; border: 1px solid var(--c-blue-border); }
    .btn-icon-edit   { background: var(--e-primary-pale); color: var(--e-primary); border: 1px solid var(--e-primary-border); }
    .btn-icon-delete { background: var(--c-red-pale);    color: #ff8080; border: 1px solid var(--c-red-border); }
    .btn-icon:hover  { transform: scale(1.1); }

    /* ===== TABLEAU ===== */
    .table-wrapper {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; overflow: hidden;
    }

    .table-head-bar {
        padding: 12px 16px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 8px;
    }

    .table-head-bar h6 {
        color: #fff; font-size: 0.83rem; font-weight: 600; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }

    .table-head-bar h6 i { color: var(--e-primary); }

    .dmd-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .dmd-table thead th {
        padding: 8px 14px; font-size: 0.67rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--e-primary); background: var(--e-primary-pale);
        border-bottom: 1px solid var(--e-primary-border); white-space: nowrap;
    }

    .dmd-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .dmd-table tbody tr:last-child td { border-bottom: none; }
    .dmd-table tbody tr { transition: background 0.15s; }
    .dmd-table tbody tr:hover td { background: rgba(107,175,107,0.02); }

    /* ===== BADGES ===== */
    .badge-statut {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.67rem; font-weight: 700; white-space: nowrap;
    }

    .bs-attente    { background: var(--c-yellow-pale);  border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bs-approuve   { background: var(--c-blue-pale);    border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bs-rejete     { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-valide-rh  { background: var(--c-green-pale);   border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bs-rejete-rh  { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }

    .statut-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }

    .badge-type {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 20px; font-size: 0.67rem; font-weight: 600;
    }

    .bt-demande    { background: var(--e-primary-pale); border: 1px solid var(--e-primary-border); color: var(--e-primary); }
    .bt-invitation { background: var(--c-purple-pale);  border: 1px solid var(--c-purple-border);  color: #bb8fce; }

    /* ===== NO RESULTS ===== */
    .no-results { display: none; }
    .no-results.visible { display: table-row; }

    .table-foot {
        padding: 11px 16px; border-top: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between;
    }

    .table-foot-info { font-size: 0.73rem; color: var(--c-muted); }

    /* ===== ALERTS ===== */
    .alert-success-dark {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        border-radius: 10px; padding: 11px 16px; color: #7ab86a;
        font-size: 0.82rem; display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
    }

    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
    }

    /* ===== MODAL ===== */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.65); z-index: 1040;
        backdrop-filter: blur(3px); align-items: center; justify-content: center;
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #1e1e1e; border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px; padding: 26px; width: 100%; max-width: 380px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5); animation: modal-in 0.2s ease;
    }

    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-btns { display: flex; gap: 10px; margin-top: 20px; }
    .modal-btns > * { flex: 1; justify-content: center; }

    .btn-cancel-modal {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }

    .btn-cancel-modal:hover { background: rgba(255,255,255,0.04); }

    .btn-danger {
        background: linear-gradient(135deg, #c0392b, #922b21);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }

    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(192,57,43,0.35); }

    @media (max-width: 1100px) { .stat-strip { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 992px)  { .filter-row { grid-template-columns: 1fr 1fr 1fr; } .filter-row-2 { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 576px)  { .stat-strip { grid-template-columns: repeat(2, 1fr); } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$idEmp = $idEmp ?? session()->get('id_Emp');

$total     = count($demandes);
$enAttente = count(array_filter($demandes, fn($d) => $d['Statut_DFrm'] === 'en_attente'));
$approuve  = count(array_filter($demandes, fn($d) => $d['Statut_DFrm'] === 'approuve'));
$valideRH  = count(array_filter($demandes, fn($d) => $d['Statut_DFrm'] === 'valide_rh'));
$rejetes   = count(array_filter($demandes, fn($d) => in_array($d['Statut_DFrm'], ['rejete','rejete_rh'])));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-file-alt me-2" style="color:var(--e-primary);"></i>Mes demandes de formation</h1>
        <p><?= date('d/m/Y') ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('formation') ?>" class="btn-primary" style="background:rgba(58,123,213,0.15);border:1px solid rgba(58,123,213,0.3);color:#5B9BF0;box-shadow:none;">
            <i class="fas fa-chalkboard-teacher"></i> Catalogue
        </a>
        <a href="<?= base_url('demande-formation/create') ?>" class="btn-primary">
            <i class="fas fa-plus"></i> Nouvelle demande
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-triangle"></i> <?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<!-- Stats -->
<div class="stat-strip">
    <div class="stat-pill"><div class="stat-pill-icon sp-primary"><i class="fas fa-list"></i></div><div><div class="stat-pill-val" id="cnt-total">0</div><div class="stat-pill-label">Total</div></div></div>
    <div class="stat-pill"><div class="stat-pill-icon sp-yellow"><i class="fas fa-clock"></i></div><div><div class="stat-pill-val" id="cnt-attente">0</div><div class="stat-pill-label">En attente</div></div></div>
    <div class="stat-pill"><div class="stat-pill-icon sp-blue"><i class="fas fa-user-check"></i></div><div><div class="stat-pill-val" id="cnt-approuve">0</div><div class="stat-pill-label">Approuvé</div></div></div>
    <div class="stat-pill"><div class="stat-pill-icon sp-green"><i class="fas fa-check-double"></i></div><div><div class="stat-pill-val" id="cnt-valide">0</div><div class="stat-pill-label">Validé RH</div></div></div>
    <div class="stat-pill"><div class="stat-pill-icon sp-red"><i class="fas fa-times-circle"></i></div><div><div class="stat-pill-val" id="cnt-rejete">0</div><div class="stat-pill-label">Rejeté</div></div></div>
</div>

<!-- Filtres -->
<div class="filter-panel">
    <div class="filter-panel-head" onclick="toggleFilters()">
        <div class="filter-panel-head-left">
            <i class="fas fa-sliders-h"></i>
            Filtres
            <span class="filter-badge" id="filter-badge">0</span>
        </div>
        <i class="fas fa-chevron-down filter-chevron open" id="filter-chevron"></i>
    </div>
    <div class="filter-body open" id="filter-body">
        <div class="filter-row">
            <div class="filter-group">
                <div class="filter-label">Recherche</div>
                <div class="filter-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" class="filter-input" id="f-search" placeholder="Formation, motif...">
                </div>
            </div>
            <div class="filter-group">
                <div class="filter-label">Statut</div>
                <select class="filter-select" id="f-statut">
                    <option value="">Tous</option>
                    <option value="en_attente">En attente</option>
                    <option value="approuve">Approuvé Chef</option>
                    <option value="rejete">Rejeté Chef</option>
                    <option value="valide_rh">Validé RH</option>
                    <option value="rejete_rh">Rejeté RH</option>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Type</div>
                <select class="filter-select" id="f-type">
                    <option value="">Tous</option>
                    <option value="demande">Demande</option>
                    <option value="invitation">Invitation</option>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Année</div>
                <select class="filter-select" id="f-annee">
                    <option value="">Toutes</option>
                    <?php
                    $annees = array_unique(array_map(fn($d) => date('Y', strtotime($d['DateDemande'])), $demandes));
                    rsort($annees);
                    foreach ($annees as $a): ?>
                    <option value="<?= $a ?>"><?= $a ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">&nbsp;</div>
                <button type="button" class="btn-reset" id="btn-reset" onclick="resetFilters()">
                    <i class="fas fa-times"></i> Effacer
                </button>
            </div>
        </div>
        <div class="filter-row-2">
            <div class="filter-group">
                <div class="filter-label">Demande — du</div>
                <input type="date" class="filter-input" id="f-demande-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Demande — au</div>
                <input type="date" class="filter-input" id="f-demande-to">
            </div>
            <div class="filter-group">
                <div class="filter-label">Formation — du</div>
                <input type="date" class="filter-input" id="f-debut-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Formation — au</div>
                <input type="date" class="filter-input" id="f-debut-to">
            </div>
        </div>
    </div>
</div>

<!-- Tableau -->
<div class="table-wrapper">
    <div class="table-head-bar">
        <h6><i class="fas fa-table"></i> Mes demandes</h6>
        <span class="table-foot-info" id="count-label">
            <strong style="color:var(--c-soft);"><?= $total ?></strong> demande(s)
        </span>
    </div>
    <table class="dmd-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Formation</th>
                <th>Type</th>
                <th>Motif</th>
                <th>Date demande</th>
                <th>Début prévu</th>
                <th>Statut</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody id="dmd-tbody">
            <?php foreach ($demandes as $i => $d):
                $statut = $d['Statut_DFrm'] ?? 'en_attente';
                $dateD  = $d['DateDemande'] ?? '';
                $debutF = $d['DateDebut_Libre'] ?? ($d['DateDebut_Frm'] ?? '');
                $desc   = !empty($d['Description_Frm']) ? $d['Description_Frm'] : ($d['Description_Libre'] ?? '');
                $motif  = $d['Motif'] ?? '';

                [$bsCls, $bsLabel, $bsDot] = match($statut) {
                    'en_attente' => ['bs-attente',   'En attente',    '#ffc107'],
                    'approuve'   => ['bs-approuve',  'Approuvé Chef', '#5B9BF0'],
                    'rejete'     => ['bs-rejete',    'Rejeté Chef',   '#ff8080'],
                    'valide_rh'  => ['bs-valide-rh', 'Validé RH',     '#7ab86a'],
                    'rejete_rh'  => ['bs-rejete-rh', 'Rejeté RH',     '#ff8080'],
                    default      => ['bs-attente',    $statut,         '#ffc107'],
                };

                $typeLabel = $d['Type_DFrm'] === 'invitation' ? 'Invitation' : 'Demande';
                $typeCls   = $d['Type_DFrm'] === 'invitation' ? 'bt-invitation' : 'bt-demande';
                $typeIcon  = $d['Type_DFrm'] === 'invitation' ? 'fa-envelope' : 'fa-hand-paper';

                $canEdit   = $statut === 'en_attente';
                $canDelete = $statut === 'en_attente';
            ?>
            <tr class="dmd-row"
                data-desc="<?= strtolower(esc($desc . ' ' . $motif)) ?>"
                data-statut="<?= esc($statut) ?>"
                data-type="<?= esc($d['Type_DFrm'] ?? '') ?>"
                data-annee="<?= $dateD ? date('Y', strtotime($dateD)) : '' ?>"
                data-demande="<?= $dateD ?>"
                data-debut="<?= $debutF ?>"
            >
                <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;width:32px;"><?= $i + 1 ?></td>

                <td style="max-width:180px;">
                    <div style="color:#fff;font-weight:500;font-size:0.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        <?= !empty($desc) ? esc(mb_substr($desc, 0, 50)) . (mb_strlen($desc) > 50 ? '…' : '') : '<span style="color:var(--c-muted);">Formation libre</span>' ?>
                    </div>
                </td>

                <td>
                    <span class="badge-type <?= $typeCls ?>">
                        <i class="fas <?= $typeIcon ?>"></i> <?= $typeLabel ?>
                    </span>
                </td>

                <td style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?= !empty($motif) ? esc(mb_substr($motif, 0, 40)) . (mb_strlen($motif) > 40 ? '…' : '') : '<span style="color:var(--c-muted);">-</span>' ?>
                </td>

                <td style="white-space:nowrap;color:var(--c-muted);font-size:0.75rem;">
                    <?= $dateD ? date('d/m/Y', strtotime($dateD)) : '-' ?>
                </td>

                <td style="white-space:nowrap;">
                    <?= $debutF ? date('d/m/Y', strtotime($debutF)) : '<span style="color:var(--c-muted);">-</span>' ?>
                </td>

                <td>
                    <span class="badge-statut <?= $bsCls ?>">
                        <span class="statut-dot" style="background:<?= $bsDot ?>;"></span>
                        <?= $bsLabel ?>
                    </span>
                </td>

                <td style="text-align:center;">
                    <div style="display:inline-flex;align-items:center;gap:5px;">
                        <a href="<?= base_url('demande-formation/show/' . $d['id_DFrm']) ?>"
                           class="btn-icon btn-icon-view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if ($canEdit): ?>
                        <a href="<?= base_url('demande-formation/edit/' . $d['id_DFrm']) ?>"
                           class="btn-icon btn-icon-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($canDelete): ?>
                        <button class="btn-icon btn-icon-delete" title="Supprimer"
                                onclick="confirmDelete(<?= (int)$d['id_DFrm'] ?>, '<?= esc($desc ?: 'cette demande', 'js') ?>')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>

            <tr class="no-results" id="no-results">
                <td colspan="8">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:28px 0;">
                        <i class="fas fa-search" style="font-size:1.4rem;color:var(--c-muted);opacity:0.4;"></i>
                        <span style="color:var(--c-muted);font-size:0.82rem;">Aucune demande ne correspond aux filtres.</span>
                        <button onclick="resetFilters()"
                                style="background:transparent;border:1px solid var(--e-primary-border);color:var(--e-primary);border-radius:7px;padding:5px 12px;font-size:0.75rem;cursor:pointer;">
                            <i class="fas fa-times"></i> Effacer les filtres
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="table-foot">
        <span class="table-foot-info" id="footer-count"><?= $total ?> demande(s) affichée(s)</span>
    </div>
</div>

<!-- Modal suppression -->
<div class="modal-overlay" id="modal-delete">
    <div class="modal-box">
        <div style="width:46px;height:46px;border-radius:12px;background:var(--c-red-pale);border:1px solid var(--c-red-border);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 style="color:#fff;font-size:0.9rem;font-weight:700;text-align:center;margin-bottom:8px;">Confirmer la suppression</h5>
        <p style="color:var(--c-muted);font-size:0.8rem;text-align:center;line-height:1.5;margin:0;">
            Supprimer la demande :<br>
            <strong id="modal-dmd-label" style="color:var(--c-soft);"></strong>
        </p>
        <div class="modal-btns">
            <button class="btn-cancel-modal" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
            <button class="btn-danger" id="btn-confirm-delete">
                <i class="fas fa-trash-alt"></i> Confirmer
            </button>
        </div>
    </div>
</div>

<form id="form-delete" method="POST" style="display:none;"><?= csrf_field() ?></form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    function animCount(id, target) {
        var el = document.getElementById(id);
        if (!el) return;
        var current = 0, step = Math.max(1, Math.ceil(target / 30));
        var timer = setInterval(function () {
            current = Math.min(current + step, target);
            el.textContent = current;
            if (current >= target) clearInterval(timer);
        }, 20);
    }

    animCount('cnt-total',   <?= (int)$total ?>);
    animCount('cnt-attente', <?= (int)$enAttente ?>);
    animCount('cnt-approuve',<?= (int)$approuve ?>);
    animCount('cnt-valide',  <?= (int)$valideRH ?>);
    animCount('cnt-rejete',  <?= (int)$rejetes ?>);

    window.toggleFilters = function () {
        document.getElementById('filter-body').classList.toggle('open');
        document.getElementById('filter-chevron').classList.toggle('open');
    };

    var rows      = document.querySelectorAll('.dmd-row');
    var noResult  = document.getElementById('no-results');
    var badge     = document.getElementById('filter-badge');
    var btnReset  = document.getElementById('btn-reset');
    var footCount = document.getElementById('footer-count');
    var countLbl  = document.getElementById('count-label');

    function getVal(id) { var el = document.getElementById(id); return el ? el.value : ''; }

    function applyFilters() {
        var search      = getVal('f-search').trim().toLowerCase();
        var statut      = getVal('f-statut');
        var type        = getVal('f-type');
        var annee       = getVal('f-annee');
        var demandeFrom = getVal('f-demande-from');
        var demandeTo   = getVal('f-demande-to');
        var debutFrom   = getVal('f-debut-from');
        var debutTo     = getVal('f-debut-to');

        var actifs = [search, statut, type, annee, demandeFrom, demandeTo, debutFrom, debutTo]
            .filter(function (v) { return v !== ''; }).length;

        badge.textContent = actifs;
        actifs > 0 ? badge.classList.add('visible')    : badge.classList.remove('visible');
        actifs > 0 ? btnReset.classList.add('visible') : btnReset.classList.remove('visible');

        var visible = 0;

        rows.forEach(function (row) {
            var match =
                (search      === '' || row.dataset.desc.includes(search)) &&
                (statut      === '' || row.dataset.statut  === statut) &&
                (type        === '' || row.dataset.type    === type) &&
                (annee       === '' || row.dataset.annee   === annee) &&
                (demandeFrom === '' || row.dataset.demande >= demandeFrom) &&
                (demandeTo   === '' || row.dataset.demande <= demandeTo) &&
                (debutFrom   === '' || row.dataset.debut   >= debutFrom) &&
                (debutTo     === '' || row.dataset.debut   <= debutTo);

            if (match) {
                row.style.display = '';
                visible++;
                var numCell = row.querySelector('.row-num');
                if (numCell) numCell.textContent = visible;
            } else {
                row.style.display = 'none';
            }
        });

        noResult.classList.toggle('visible', visible === 0);
        footCount.textContent = visible + ' demande(s) affichée(s)';
        countLbl.innerHTML    = '<strong style="color:rgba(255,255,255,0.55);">' + visible + '</strong> demande(s)';
    }

    window.resetFilters = function () {
        ['f-search','f-statut','f-type','f-annee',
         'f-demande-from','f-demande-to','f-debut-from','f-debut-to']
        .forEach(function (id) { var el = document.getElementById(id); if (el) el.value = ''; });
        applyFilters();
    };

    ['f-search','f-statut','f-type','f-annee',
     'f-demande-from','f-demande-to','f-debut-from','f-debut-to']
    .forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input',  applyFilters);
            el.addEventListener('change', applyFilters);
        }
    });

    // Modal suppression
    var deleteUrl = '';

    window.confirmDelete = function (id, label) {
        document.getElementById('modal-dmd-label').textContent = label;
        deleteUrl = '<?= base_url('demande-formation/delete/') ?>' + id;
        document.getElementById('modal-delete').classList.add('show');
    };

    window.closeDeleteModal = function () {
        document.getElementById('modal-delete').classList.remove('show');
        deleteUrl = '';
    };

    document.getElementById('btn-confirm-delete').addEventListener('click', function () {
        if (!deleteUrl) return;
        document.getElementById('form-delete').action = deleteUrl;
        document.getElementById('form-delete').submit();
    });

    document.getElementById('modal-delete').addEventListener('click', function (e) {
        if (e.target === this) window.closeDeleteModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') window.closeDeleteModal();
    });

})();
</script>
<?= $this->endSection() ?>