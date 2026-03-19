<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-orange:        #F5A623;
        --c-orange-pale:   rgba(245, 166, 35, 0.10);
        --c-orange-border: rgba(245, 166, 35, 0.25);
        --c-green-pale:    rgba(74, 103, 65, 0.15);
        --c-green-border:  rgba(74, 103, 65, 0.35);
        --c-red-pale:      rgba(224, 82, 82, 0.10);
        --c-red-border:    rgba(224, 82, 82, 0.25);
        --c-blue-pale:     rgba(58, 123, 213, 0.10);
        --c-blue-border:   rgba(58, 123, 213, 0.25);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-border-hover:  rgba(255,255,255,0.12);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    /* ===== STATS ===== */
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .stat-pill {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex; align-items: center; gap: 12px;
        transition: border-color 0.2s, transform 0.2s;
    }

    .stat-pill:hover { border-color: var(--c-border-hover); transform: translateY(-2px); }

    .stat-pill-icon {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; flex-shrink: 0;
    }

    .sp-orange { background: var(--c-orange-pale); color: var(--c-orange); }
    .sp-green  { background: var(--c-green-pale);  color: #7ab86a; }
    .sp-blue   { background: var(--c-blue-pale);   color: #5B9BF0; }
    .sp-red    { background: var(--c-red-pale);    color: #ff8080; }

    .stat-pill-val   { font-size: 1.4rem; font-weight: 800; color: #fff; line-height: 1; }
    .stat-pill-label { font-size: 0.7rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.6px; margin-top: 2px; }

    /* ===== PANNEAU FILTRES ===== */
    .filter-panel {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .filter-panel-head {
        padding: 12px 18px;
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; user-select: none; transition: background 0.2s;
    }

    .filter-panel-head:hover { background: rgba(255,255,255,0.02); }

    .filter-panel-head-left {
        display: flex; align-items: center; gap: 10px;
        color: var(--c-text); font-size: 0.83rem; font-weight: 600;
    }

    .filter-panel-head-left i { color: var(--c-orange); }

    .filter-badge {
        background: var(--c-orange); color: #111;
        font-size: 0.62rem; font-weight: 800;
        padding: 1px 7px; border-radius: 10px; display: none;
    }

    .filter-badge.visible { display: inline; }

    .filter-toggle-icon {
        color: var(--c-muted); font-size: 0.72rem; transition: transform 0.25s;
    }

    .filter-toggle-icon.open { transform: rotate(180deg); }

    .filter-panel-body {
        border-top: 1px solid var(--c-border);
        padding: 14px 18px; display: none;
    }

    .filter-panel-body.open { display: block; }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 10px;
        align-items: end;
    }

    .filter-group { display: flex; flex-direction: column; }

    .filter-label {
        font-size: 0.68rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 4px;
    }

    .filter-search-wrap { position: relative; }

    .filter-search-wrap i {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%); color: var(--c-muted);
        font-size: 0.75rem; pointer-events: none;
    }

    .filter-search-wrap input,
    .filter-select,
    .filter-input {
        width: 100%; background: #111; border: 1px solid var(--c-border);
        border-radius: 7px; color: var(--c-text);
        font-size: 0.8rem; outline: none;
        transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; height: 36px;
    }

    .filter-search-wrap input { padding: 0 10px 0 30px; }
    .filter-select  { padding: 0 10px; cursor: pointer; }
    .filter-input   { padding: 0 10px; }

    .filter-search-wrap input:focus,
    .filter-select:focus,
    .filter-input:focus { border-color: var(--c-orange-border); }

    .filter-search-wrap input::placeholder,
    .filter-input::placeholder { color: var(--c-muted); }
    .filter-select option { background: #1a1a1a; }

    .btn-reset-all {
        background: rgba(220,53,69,0.12);
        border: 1px solid rgba(220,53,69,0.3);
        color: #ff8080; font-weight: 600; border-radius: 7px;
        padding: 0 14px; font-size: 0.78rem; cursor: pointer;
        transition: all 0.2s; display: none; align-items: center;
        gap: 6px; white-space: nowrap; height: 36px;
    }

    .btn-reset-all:hover {
        background: rgba(220,53,69,0.22);
        border-color: rgba(220,53,69,0.5);
    }

    .btn-reset-all.visible { display: inline-flex; }

    /* ===== BOUTONS ===== */
    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 8px 15px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-icon {
        width: 28px; height: 28px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.72rem; cursor: pointer; transition: all 0.2s;
        text-decoration: none; border: none; flex-shrink: 0;
    }

    .btn-icon-view   { background: var(--c-blue-pale);   color: #5B9BF0; border: 1px solid var(--c-blue-border); }
    .btn-icon-edit   { background: var(--c-orange-pale); color: var(--c-orange); border: 1px solid var(--c-orange-border); }
    .btn-icon-delete { background: var(--c-red-pale);    color: #ff8080; border: 1px solid var(--c-red-border); }
    .btn-icon:hover  { transform: scale(1.12); }

    /* ===== TABLEAU ===== */
    .table-wrapper {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 12px;
        overflow: hidden;
    }

    .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    .table-head-bar {
        padding: 13px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 8px;
    }

    .table-head-bar h6 {
        color: #fff; font-size: 0.85rem; font-weight: 600; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }

    .table-head-bar h6 i { color: var(--c-orange); }

    .dir-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; min-width: 480px; }

    .dir-table thead th {
        padding: 9px 14px; font-size: 0.68rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border); white-space: nowrap;
    }

    .dir-table tbody td {
        padding: 11px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .dir-table tbody tr:last-child td { border-bottom: none; }
    .dir-table tbody tr { transition: background 0.15s; }
    .dir-table tbody tr:hover td { background: rgba(245,166,35,0.03); }
    .dir-table tbody tr.hidden-row { display: none; }

    .dir-identity { display: flex; align-items: center; gap: 10px; }

    .dir-avatar {
        width: 34px; height: 34px; border-radius: 9px;
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; color: #7ab86a; flex-shrink: 0;
    }

    .dir-name-main { color: #fff; font-weight: 600; font-size: 0.83rem; }

    .badge-eff {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange);
    }

    .badge-eff.zero {
        background: rgba(255,255,255,0.04); border-color: var(--c-border);
        color: var(--c-muted);
    }

    .no-results-row { display: none; }
    .no-results-row.visible { display: table-row; }

    .table-foot {
        padding: 12px 18px; border-top: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 8px;
    }

    .table-foot-info { font-size: 0.75rem; color: var(--c-muted); }

    /* ===== ALERTS ===== */
    .alert-success-dark {
        background: rgba(74,103,65,0.15); border: 1px solid var(--c-green-border);
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
        backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
        padding: 16px;
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #1e1e1e; border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px; padding: 26px; width: 100%; max-width: 390px;
        position: relative; z-index: 1051;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: modal-in 0.2s ease;
    }

    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-btns { display: flex; gap: 10px; }
    .modal-btns > * { flex: 1; justify-content: center; }

    .btn-cancel-modal {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }

    .btn-cancel-modal:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .btn-danger {
        background: linear-gradient(135deg, #c0392b, #922b21);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }

    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(192,57,43,0.35); }

    /* ===== PAGE HEADER ===== */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px; margin-bottom: 20px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .stat-strip  { grid-template-columns: repeat(2, 1fr); }
        .filter-grid { grid-template-columns: 1fr 1fr 1fr; }
    }

    @media (max-width: 768px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
        .table-head-bar { flex-direction: column; align-items: flex-start; }
    }

    @media (max-width: 576px) {
        .stat-strip  { grid-template-columns: repeat(2, 1fr); }
        .filter-grid { grid-template-columns: 1fr; }
        .stat-pill-val { font-size: 1.1rem; }
        .modal-btns  { flex-direction: column; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$totalDir = count($directions);
$avecEmp  = count(array_filter($directions, fn($d) => (int)$d['effectif'] > 0));
$sansEmp  = $totalDir - $avecEmp;
$totalEmp = array_sum(array_column($directions, 'effectif'));
?>

<!-- Header -->
<div class="page-header">
    <div>
        <h1><i class="fas fa-building me-2" style="color:#F5A623;"></i>Gestion des Directions</h1>
        <p>Répertoire des directions &mdash; <?= date('d/m/Y') ?></p>
    </div>
    <a href="<?= base_url('direction/create') ?>" class="btn-orange">
        <i class="fas fa-plus"></i> Nouvelle Direction
    </a>
</div>

<!-- Alertes -->
<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark">
    <i class="fas fa-check-circle"></i>
    <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark">
    <i class="fas fa-exclamation-triangle"></i>
    <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="stat-strip">
    <div class="stat-pill">
        <div class="stat-pill-icon sp-orange"><i class="fas fa-building"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-total">0</div>
            <div class="stat-pill-label">Total directions</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-green"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-emp">0</div>
            <div class="stat-pill-label">Total employés</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-blue"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-avec">0</div>
            <div class="stat-pill-label">Avec effectif</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-red"><i class="fas fa-minus-circle"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-sans">0</div>
            <div class="stat-pill-label">Sans effectif</div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="filter-panel">
    <div class="filter-panel-head" onclick="toggleFilters()">
        <div class="filter-panel-head-left">
            <i class="fas fa-sliders-h"></i>
            Filtres de recherche
            <span class="filter-badge" id="filter-badge">0</span>
        </div>
        <i class="fas fa-chevron-down filter-toggle-icon open" id="filter-chevron"></i>
    </div>

    <div class="filter-panel-body open" id="filter-body">
        <div class="filter-grid">

            <div class="filter-group">
                <div class="filter-label">Recherche</div>
                <div class="filter-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="f-search" placeholder="Nom de la direction..." autocomplete="off">
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-label">Effectif min</div>
                <input type="number" id="f-eff-min" class="filter-input" placeholder="0" min="0">
            </div>

            <div class="filter-group">
                <div class="filter-label">Effectif max</div>
                <input type="number" id="f-eff-max" class="filter-input" placeholder="∞" min="0">
            </div>

            <div class="filter-group">
                <div class="filter-label">Trier par</div>
                <select id="f-sort" class="filter-select">
                    <option value="nom-asc">Nom A → Z</option>
                    <option value="nom-desc">Nom Z → A</option>
                    <option value="eff-desc">Effectif ↓</option>
                    <option value="eff-asc">Effectif ↑</option>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">&nbsp;</div>
                <button type="button" class="btn-reset-all" id="btn-reset" onclick="resetFilters()">
                    <i class="fas fa-times-circle"></i> Réinitialiser
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Tableau -->
<div class="table-wrapper">
    <div class="table-head-bar">
        <h6><i class="fas fa-table"></i> Liste des directions</h6>
        <span style="font-size:0.75rem;color:var(--c-muted);" id="table-count-label">
            <strong style="color:var(--c-soft);"><?= $totalDir ?></strong> direction(s)
            &nbsp;|&nbsp;
            <span style="color:#7ab86a;"><?= $totalEmp ?> employé(s) au total</span>
        </span>
    </div>

    <div class="table-scroll">
        <table class="dir-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Direction</th>
                    <th>Effectif</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="dir-tbody">

                <?php foreach ($directions as $i => $dir): ?>
                <tr class="dir-row"
                    data-nom="<?= strtolower(esc($dir['Nom_Dir'])) ?>"
                    data-effectif="<?= (int)$dir['effectif'] ?>">

                    <td class="row-num" style="color:var(--c-muted);font-size:0.72rem;width:36px;"><?= $i + 1 ?></td>

                    <td>
                        <div class="dir-identity">
                            <div class="dir-avatar"><i class="fas fa-building"></i></div>
                            <span class="dir-name-main"><?= esc($dir['Nom_Dir']) ?></span>
                        </div>
                    </td>

                    <td>
                        <?php $eff = (int)$dir['effectif']; ?>
                        <span class="badge-eff <?= $eff === 0 ? 'zero' : '' ?>">
                            <i class="fas fa-users" style="font-size:0.6rem;"></i>
                            <?= $eff ?> employé<?= $eff > 1 ? 's' : '' ?>
                        </span>
                    </td>

                    <td style="text-align:center;">
                        <div style="display:inline-flex;align-items:center;gap:5px;">
                            <a href="<?= base_url('direction/show/' . $dir['id_Dir']) ?>"
                               class="btn-icon btn-icon-view" title="Voir les employés">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= base_url('direction/edit/' . $dir['id_Dir']) ?>"
                               class="btn-icon btn-icon-edit" title="Modifier">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button
                                class="btn-icon btn-icon-delete"
                                title="Supprimer"
                                onclick="confirmDelete(<?= (int)$dir['id_Dir'] ?>, '<?= esc($dir['Nom_Dir'], 'js') ?>', <?= (int)$dir['effectif'] ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tr class="no-results-row" id="no-results-row">
                    <td colspan="4">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:30px 0;">
                            <i class="fas fa-search" style="font-size:1.5rem;color:var(--c-muted);opacity:0.4;"></i>
                            <span style="color:var(--c-muted);font-size:0.83rem;">Aucune direction ne correspond aux filtres appliqués.</span>
                            <button onclick="resetFilters()"
                                style="background:transparent;border:1px solid var(--c-orange-border);color:var(--c-orange);font-weight:600;border-radius:8px;padding:5px 12px;font-size:0.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:6px;margin-top:4px;">
                                <i class="fas fa-times"></i> Effacer les filtres
                            </button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="table-foot">
        <span class="table-foot-info" id="footer-count"><?= $totalDir ?> direction(s) affichée(s)</span>
    </div>
</div>

<!-- Modal suppression -->
<div class="modal-overlay" id="modal-delete-dir">
    <div class="modal-box">
        <div style="width:50px;height:50px;border-radius:13px;background:var(--c-red-pale);border:1px solid var(--c-red-border);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#ff8080;margin:0 auto 14px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 style="color:#fff;font-size:0.95rem;font-weight:700;text-align:center;margin-bottom:8px;">
            Confirmer la suppression
        </h5>
        <p style="color:var(--c-muted);font-size:0.82rem;text-align:center;margin-bottom:6px;line-height:1.5;">
            Supprimer la direction<br>
            <strong id="modal-dir-name" style="color:var(--c-soft);"></strong> ?
        </p>
        <p id="modal-dir-warning"
           style="display:none;color:#ff8080;font-size:0.76rem;text-align:center;background:var(--c-red-pale);border:1px solid var(--c-red-border);border-radius:8px;padding:8px 12px;margin-bottom:14px;">
            <i class="fas fa-info-circle me-1"></i>
            Impossible : cette direction contient des employés.
        </p>
        <p style="color:var(--c-muted);font-size:0.76rem;text-align:center;margin-bottom:20px;">
            Cette action est irréversible.
        </p>
        <!-- Boutons normaux -->
        <div class="modal-btns" id="modal-dir-btns">
            <button class="btn-cancel-modal" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
            <button class="btn-danger" id="btn-confirm-delete">
                <i class="fas fa-trash-alt"></i> Supprimer
            </button>
        </div>
        <!-- Bouton si direction verrouillée -->
        <div id="modal-dir-btns-locked" style="display:none;">
            <button class="btn-cancel-modal" style="width:100%;justify-content:center;" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Fermer
            </button>
        </div>
    </div>
</div>

<form id="form-delete-dir" method="POST" style="display:none;"></form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    /* ── Compteurs animés ── */
    function animateCounter(id, target) {
        const el = document.getElementById(id);
        if (!el) return;
        let current = 0;
        const step = Math.max(1, target / (800 / 16));
        const timer = setInterval(function () {
            current += step;
            if (current >= target) { el.textContent = target; clearInterval(timer); }
            else { el.textContent = Math.floor(current); }
        }, 16);
    }

    animateCounter('cnt-total', <?= (int)$totalDir ?>);
    animateCounter('cnt-emp',   <?= (int)$totalEmp ?>);
    animateCounter('cnt-avec',  <?= (int)$avecEmp ?>);
    animateCounter('cnt-sans',  <?= (int)$sansEmp ?>);

    /* ── Toggle filtres ── */
    window.toggleFilters = function () {
        document.getElementById('filter-body').classList.toggle('open');
        document.getElementById('filter-chevron').classList.toggle('open');
    };

    /* ── Filtres ── */
    const allRows   = Array.from(document.querySelectorAll('.dir-row'));
    const noResults = document.getElementById('no-results-row');
    const badge     = document.getElementById('filter-badge');
    const footCount = document.getElementById('footer-count');
    const btnReset  = document.getElementById('btn-reset');
    const tbody     = document.getElementById('dir-tbody');

    function applyFilters() {
        const search = document.getElementById('f-search').value.trim().toLowerCase();
        const effMin = parseInt(document.getElementById('f-eff-min').value) || 0;
        const effMax = parseInt(document.getElementById('f-eff-max').value) || Infinity;
        const sort   = document.getElementById('f-sort').value;

        const actifs = [
            search,
            document.getElementById('f-eff-min').value,
            document.getElementById('f-eff-max').value,
        ].filter(v => v !== '').length + (sort !== 'nom-asc' ? 1 : 0);

        badge.textContent = actifs;
        badge.classList.toggle('visible', actifs > 0);
        btnReset.classList.toggle('visible', actifs > 0);

        let visible = allRows.filter(function (row) {
            const nom = row.dataset.nom || '';
            const eff = parseInt(row.dataset.effectif) || 0;
            if (search && !nom.includes(search)) return false;
            if (eff < effMin) return false;
            if (eff > effMax) return false;
            return true;
        });

        visible.sort(function (a, b) {
            const aN = a.dataset.nom, bN = b.dataset.nom;
            const aE = parseInt(a.dataset.effectif), bE = parseInt(b.dataset.effectif);
            if (sort === 'nom-asc')  return aN.localeCompare(bN);
            if (sort === 'nom-desc') return bN.localeCompare(aN);
            if (sort === 'eff-desc') return bE - aE;
            if (sort === 'eff-asc')  return aE - bE;
            return 0;
        });

        allRows.forEach(r => r.classList.add('hidden-row'));
        visible.forEach(function (r, idx) {
            r.classList.remove('hidden-row');
            tbody.insertBefore(r, noResults);
            const numCell = r.querySelector('.row-num');
            if (numCell) numCell.textContent = idx + 1;
        });

        noResults.classList.toggle('visible', visible.length === 0);
        footCount.textContent = visible.length + ' direction(s) affichée(s)';
    }

    window.resetFilters = function () {
        document.getElementById('f-search').value  = '';
        document.getElementById('f-eff-min').value = '';
        document.getElementById('f-eff-max').value = '';
        document.getElementById('f-sort').value    = 'nom-asc';
        applyFilters();
    };

    document.getElementById('f-search').addEventListener('input',  applyFilters);
    document.getElementById('f-eff-min').addEventListener('input', applyFilters);
    document.getElementById('f-eff-max').addEventListener('input', applyFilters);
    document.getElementById('f-sort').addEventListener('change',   applyFilters);

    /* ── Modal suppression ── */
    let deleteUrl = '';

    window.confirmDelete = function (id, nom, effectif) {
        document.getElementById('modal-dir-name').textContent = nom;
        const warning    = document.getElementById('modal-dir-warning');
        const btns       = document.getElementById('modal-dir-btns');
        const btnsLocked = document.getElementById('modal-dir-btns-locked');

        if (effectif > 0) {
            warning.style.display    = 'block';
            btns.style.display       = 'none';
            btnsLocked.style.display = 'block';
            deleteUrl = '';
        } else {
            warning.style.display    = 'none';
            btns.style.display       = 'flex';
            btnsLocked.style.display = 'none';
            deleteUrl = '<?= base_url('direction/delete/') ?>' + id;
        }

        document.getElementById('modal-delete-dir').classList.add('show');
    };

    window.closeDeleteModal = function () {
        document.getElementById('modal-delete-dir').classList.remove('show');
        deleteUrl = '';
    };

    document.getElementById('btn-confirm-delete').addEventListener('click', function () {
        if (!deleteUrl) return;
        document.getElementById('form-delete-dir').action = deleteUrl;
        document.getElementById('form-delete-dir').submit();
    });

    document.getElementById('modal-delete-dir').addEventListener('click', function (e) {
        if (e.target === this) window.closeDeleteModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') window.closeDeleteModal();
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.body.appendChild(document.getElementById('modal-delete-dir'));
        document.body.appendChild(document.getElementById('form-delete-dir'));
    });

})();
</script>
<?= $this->endSection() ?>