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
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr auto;
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
    .filter-select {
        width: 100%; background: #111; border: 1px solid var(--c-border);
        border-radius: 7px; color: var(--c-text);
        font-size: 0.8rem; outline: none;
        transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; height: 36px;
    }

    .filter-search-wrap input { padding: 0 10px 0 30px; }
    .filter-select { padding: 0 10px; cursor: pointer; }

    .filter-search-wrap input:focus,
    .filter-select:focus { border-color: var(--c-orange-border); }

    .filter-search-wrap input::placeholder { color: var(--c-muted); }
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
        border-color: rgba(220,53,69,0.5); color: #ff8080;
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

    .btn-green {
        background: linear-gradient(135deg, #2D6A4F, #1e4d38);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 8px 15px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-green:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(45,106,79,0.35); color: #fff; }

    .btn-outline-blue {
        background: transparent; border: 1px solid var(--c-blue-border);
        color: #5B9BF0; font-weight: 600; border-radius: 8px;
        padding: 7px 15px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-outline-blue:hover { background: var(--c-blue-pale); color: #5B9BF0; }

    .btn-outline-green {
        background: transparent; border: 1px solid var(--c-green-border);
        color: #7ab86a; font-weight: 600; border-radius: 8px;
        padding: 7px 15px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-outline-green:hover { background: var(--c-green-pale); color: #7ab86a; }

    .btn-outline-orange {
        background: transparent; border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-weight: 600; border-radius: 8px;
        padding: 7px 15px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-outline-orange:hover { background: var(--c-orange-pale); color: var(--c-orange); }

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

    /* Scroll horizontal sur mobile */
    .table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

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

    .emp-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; min-width: 680px; }

    .emp-table thead th {
        padding: 9px 14px; font-size: 0.68rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border); white-space: nowrap;
    }

    .emp-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .emp-table tbody tr:last-child td { border-bottom: none; }
    .emp-table tbody tr { transition: background 0.15s; }
    .emp-table tbody tr:hover td { background: rgba(245,166,35,0.03); }
    .emp-table tbody tr.hidden-row { display: none; }

    .emp-identity { display: flex; align-items: center; gap: 9px; }

    .emp-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700; color: var(--c-orange);
        flex-shrink: 0; text-transform: uppercase;
    }

    .emp-avatar.female { background: rgba(255,105,180,0.1); border-color: rgba(255,105,180,0.25); color: #ff8fbf; }

    .emp-name  { color: #fff; font-weight: 600; font-size: 0.83rem; margin: 0; line-height: 1.2; }
    .emp-email { color: var(--c-muted); font-size: 0.7rem; margin-top: 1px; }

    .badge-dir, .badge-grade, .badge-profil, .badge-dispo {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 20px;
        font-size: 0.68rem; font-weight: 600; white-space: nowrap;
    }

    .badge-dir    { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .badge-grade  { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .badge-profil { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .badge-dispo.oui { background: var(--c-green-pale); border: 1px solid var(--c-green-border); color: #7ab86a; }
    .badge-dispo.non { background: var(--c-red-pale);   border: 1px solid var(--c-red-border);   color: #ff8080; }

    .dispo-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .dispo-dot.oui { background: #7ab86a; }
    .dispo-dot.non { background: #ff8080; }

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

    /* ===== MODAL IMPORT ===== */
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
        border-radius: 14px; padding: 26px; width: 100%; max-width: 480px;
        position: relative; z-index: 1051;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: modal-in 0.2s ease;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-box.sm { max-width: 390px; }

    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
    }

    .modal-head h5 {
        color: #fff; font-size: 0.95rem; font-weight: 700; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }

    .modal-head h5 i { color: var(--c-orange); }

    .modal-close {
        background: transparent; border: none; color: var(--c-muted);
        cursor: pointer; font-size: 1rem; padding: 0; line-height: 1;
        transition: color 0.2s;
    }

    .modal-close:hover { color: #fff; }

    /* Zone de depot fichier */
    .drop-zone {
        border: 2px dashed rgba(255,255,255,0.12);
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        margin-bottom: 16px;
        position: relative;
    }

    .drop-zone:hover,
    .drop-zone.dragover {
        border-color: var(--c-orange-border);
        background: var(--c-orange-pale);
    }

    .drop-zone input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }

    .drop-zone-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: var(--c-orange); margin: 0 auto 10px;
    }

    .drop-zone p {
        color: var(--c-soft); font-size: 0.83rem; margin: 0;
    }

    .drop-zone small {
        color: var(--c-muted); font-size: 0.72rem;
        display: block; margin-top: 5px;
    }

    .drop-zone .file-chosen {
        color: var(--c-orange); font-size: 0.82rem;
        font-weight: 600; margin-top: 8px; display: none;
    }

    /* Lien modele */
    .import-template-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #5B9BF0; font-size: 0.78rem; text-decoration: none;
        margin-bottom: 16px; transition: color 0.2s;
    }

    .import-template-link:hover { color: #7ab5ff; }

    /* Barre de progression import */
    .import-progress {
        display: none;
        margin-bottom: 14px;
    }

    .import-progress-bar {
        height: 4px; border-radius: 2px;
        background: rgba(255,255,255,0.06);
        overflow: hidden; margin-bottom: 6px;
    }

    .import-progress-fill {
        height: 100%; background: var(--c-orange);
        border-radius: 2px; width: 0%;
        transition: width 0.3s ease;
    }

    .import-progress-label {
        font-size: 0.72rem; color: var(--c-muted); text-align: center;
    }

    /* Resultats import */
    .import-result {
        display: none;
        border-radius: 8px; padding: 10px 14px;
        font-size: 0.8rem; margin-bottom: 14px;
    }

    .import-result.success {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border); color: #7ab86a;
    }

    .import-result.error {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border); color: #ff8080;
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

    /* ===== DROPDOWN EXPORT ===== */
    .export-dropdown { position: relative; display: inline-block; }

    .export-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        background: #222;
        border: 1px solid var(--c-border);
        border-radius: 10px;
        padding: 6px;
        min-width: 180px;
        z-index: 200;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        animation: modal-in 0.15s ease;
    }

    .export-menu.open { display: block; }

    .export-menu-item {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 12px; border-radius: 7px;
        color: var(--c-soft); font-size: 0.82rem;
        text-decoration: none; cursor: pointer;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
    }

    .export-menu-item:hover { background: rgba(255,255,255,0.05); color: #fff; }

    .export-menu-item i { width: 16px; text-align: center; }

    .export-menu-item.excel i { color: #7ab86a; }
    .export-menu-item.csv   i { color: #5B9BF0; }

    .export-menu-sep {
        height: 1px; background: var(--c-border); margin: 4px 0;
    }

    .export-note {
        padding: 6px 12px;
        font-size: 0.68rem;
        color: var(--c-muted);
        line-height: 1.4;
    }

    /* ===== PAGE HEADER ===== */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1100px) {
        .filter-grid { grid-template-columns: 1fr 1fr 1fr 1fr; }
    }

    @media (max-width: 992px) {
        .stat-strip  { grid-template-columns: repeat(2, 1fr); }
        .filter-grid { grid-template-columns: 1fr 1fr 1fr; }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header > div:last-child {
            width: 100%;
            justify-content: flex-start;
        }
    }

    @media (max-width: 768px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }

        .table-head-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .export-menu {
            right: auto;
            left: 0;
        }

        .modal-box {
            padding: 18px;
            border-radius: 12px;
        }

        .modal-btns {
            flex-direction: column;
        }

        .modal-btns > * {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .stat-strip { grid-template-columns: repeat(2, 1fr); }
        .filter-grid { grid-template-columns: 1fr; }

        .stat-pill-val   { font-size: 1.1rem; }
        .stat-pill-label { font-size: 0.62rem; }
        .stat-pill       { padding: 10px 12px; gap: 8px; }

        .table-foot {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-orange,
        .btn-green,
        .btn-outline-blue { font-size: 0.75rem; padding: 7px 11px; }

        .modal-box { padding: 16px; }

        .drop-zone { padding: 20px 14px; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-users me-2" style="color:#F5A623;"></i>Gestion des Employes</h1>
        <p>Liste complete du personnel &mdash; <?= date('d/m/Y') ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">

        <!-- Bouton Importer -->
        <button class="btn-green" onclick="openImportModal()">
            <i class="fas fa-file-upload"></i> Importer
        </button>

        <!-- Dropdown Export -->
        <div class="export-dropdown" id="export-dropdown">
            <button class="btn-outline-blue" onclick="toggleExportMenu()">
                <i class="fas fa-file-download"></i> Exporter
                <i class="fas fa-chevron-down" style="font-size:0.65rem;margin-left:2px;"></i>
            </button>
            <div class="export-menu" id="export-menu">
                <div class="export-note" id="export-note">
                    Export des employes affiches
                </div>
                <div class="export-menu-sep"></div>
                <a href="<?= base_url('employe/export-excel') ?>" class="export-menu-item excel" id="link-excel">
                    <i class="fas fa-file-excel"></i> Exporter en Excel (.xlsx)
                </a>
                <a href="<?= base_url('employe/export-csv') ?>" class="export-menu-item csv" id="link-csv">
                    <i class="fas fa-file-csv"></i> Exporter en CSV
                </a>
            </div>
        </div>

        <!-- Bouton Nouvel employe -->
        <a href="<?= base_url('employe/create') ?>" class="btn-orange">
            <i class="fas fa-user-plus"></i> Nouvel employe
        </a>

    </div>
</div>

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

<?php if (session()->getFlashdata('import_errors')): ?>
<div class="alert-error-dark" style="flex-direction:column;align-items:flex-start;gap:6px;">
    <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Des erreurs ont ete detectees lors de l'import :</strong>
    </div>
    <ul style="margin:0;padding-left:20px;font-size:0.78rem;">
        <?php foreach (session()->getFlashdata('import_errors') as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<?php
$totalEmp    = count($employes);
$disponibles = count(array_filter($employes, fn($e) => (int)$e['Disponibilite_Emp'] === 1));
$absents     = $totalEmp - $disponibles;
$hommes      = count(array_filter($employes, fn($e) => (int)$e['Sexe_Emp'] === 1));
$femmes      = $totalEmp - $hommes;
$dirUniques  = count(array_unique(array_filter(array_column($employes, 'Nom_Dir'))));
?>

<!-- Stats -->
<div class="stat-strip">
    <div class="stat-pill">
        <div class="stat-pill-icon sp-orange"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-total">0</div>
            <div class="stat-pill-label">Total employes</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-green"><i class="fas fa-user-check"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-dispo">0</div>
            <div class="stat-pill-label">Disponibles</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-red"><i class="fas fa-user-clock"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-abs">0</div>
            <div class="stat-pill-label">Absents</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-blue"><i class="fas fa-building"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-dir">0</div>
            <div class="stat-pill-label">Directions</div>
        </div>
    </div>
</div>

<!-- Filtres client -->
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
                <div class="filter-label">Recherche libre</div>
                <div class="filter-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="f-search" placeholder="Nom, prenom, email..." autocomplete="off">
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-label">Direction</div>
                <select id="f-dir" class="filter-select">
                    <option value="">Toutes</option>
                    <?php foreach ($directions as $dir): ?>
                    <option value="<?= esc($dir['Nom_Dir']) ?>"><?= esc($dir['Nom_Dir']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">Grade</div>
                <select id="f-grd" class="filter-select">
                    <option value="">Tous</option>
                    <?php foreach ($grades as $grd): ?>
                    <option value="<?= esc($grd['Libelle_Grd']) ?>"><?= esc($grd['Libelle_Grd']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">Profil</div>
                <select id="f-pfl" class="filter-select">
                    <option value="">Tous</option>
                    <?php foreach ($profils as $pfl): ?>
                    <option value="<?= esc($pfl['Libelle_Pfl']) ?>"><?= esc($pfl['Libelle_Pfl']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">Sexe</div>
                <select id="f-sexe" class="filter-select">
                    <option value="">Tous</option>
                    <option value="1">Homme</option>
                    <option value="0">Femme</option>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">Disponibilite</div>
                <select id="f-dispo" class="filter-select">
                    <option value="">Tous</option>
                    <option value="1">Disponible</option>
                    <option value="0">Absent</option>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">&nbsp;</div>
                <button type="button" class="btn-reset-all" id="btn-reset" onclick="resetFilters()">
                    <i class="fas fa-times-circle"></i> Annuler les filtres
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Tableau -->
<div class="table-wrapper">
    <div class="table-head-bar">
        <h6><i class="fas fa-table"></i> Liste du personnel</h6>
        <span style="font-size:0.75rem;color:var(--c-muted);" id="table-count-label">
            <strong style="color:var(--c-soft);"><?= $totalEmp ?></strong> employe(s)
            &nbsp;|&nbsp;
            <span style="color:#5B9BF0;">H : <?= $hommes ?></span>
            &nbsp;
            <span style="color:#ff8fbf;">F : <?= $femmes ?></span>
        </span>
    </div>

    <table class="emp-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Employe</th>
                <th>Direction</th>
                <th>Grade</th>
                <th>Profil</th>
                <th>Disponibilite</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody id="emp-tbody">
            <?php foreach ($employes as $i => $emp): ?>
            <tr class="emp-row"
                data-nom="<?= strtolower(esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp'])) ?>"
                data-email="<?= strtolower(esc($emp['Email_Emp'])) ?>"
                data-dir="<?= esc($emp['Nom_Dir'] ?? '') ?>"
                data-grd="<?= esc($emp['Libelle_Grd'] ?? '') ?>"
                data-pfl="<?= esc($emp['Libelle_Pfl'] ?? '') ?>"
                data-sexe="<?= (int)$emp['Sexe_Emp'] ?>"
                data-dispo="<?= (int)$emp['Disponibilite_Emp'] ?>"
            >
                <td class="row-num" style="color:var(--c-muted);font-size:0.72rem;width:36px;"><?= $i + 1 ?></td>

                <td>
                    <div class="emp-identity">
                        <div class="emp-avatar <?= (int)$emp['Sexe_Emp'] === 0 ? 'female' : '' ?>">
                            <?= mb_substr($emp['Nom_Emp'], 0, 1) . mb_substr($emp['Prenom_Emp'], 0, 1) ?>
                        </div>
                        <div>
                            <p class="emp-name"><?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?></p>
                            <div class="emp-email"><?= esc($emp['Email_Emp']) ?></div>
                        </div>
                    </div>
                </td>

                <td>
                    <?php if (!empty($emp['Nom_Dir'])): ?>
                    <span class="badge-dir">
                        <i class="fas fa-building" style="font-size:0.58rem;"></i>
                        <?= esc($emp['Nom_Dir']) ?>
                    </span>
                    <?php else: ?>
                    <span style="color:var(--c-muted);font-size:0.72rem;">Non affecte</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if (!empty($emp['Libelle_Grd'])): ?>
                    <span class="badge-grade"><?= esc($emp['Libelle_Grd']) ?></span>
                    <?php else: ?>
                    <span style="color:var(--c-muted);">-</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if (!empty($emp['Libelle_Pfl'])): ?>
                    <span class="badge-profil"><?= esc($emp['Libelle_Pfl']) ?></span>
                    <?php else: ?>
                    <span style="color:var(--c-muted);">-</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ((int)$emp['Disponibilite_Emp'] === 1): ?>
                    <span class="badge-dispo oui"><span class="dispo-dot oui"></span> Disponible</span>
                    <?php else: ?>
                    <span class="badge-dispo non"><span class="dispo-dot non"></span> Absent</span>
                    <?php endif; ?>
                </td>

                <td style="text-align:center;">
                    <div style="display:inline-flex;align-items:center;gap:5px;">
                        <a href="<?= base_url('employe/show/' . $emp['id_Emp']) ?>"
                           class="btn-icon btn-icon-view" title="Voir la fiche">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= base_url('employe/edit/' . $emp['id_Emp']) ?>"
                           class="btn-icon btn-icon-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <?php if ((int)$emp['id_Emp'] !== (int)session()->get('id_Emp')): ?>
                        <button
                            class="btn-icon btn-icon-delete"
                            title="Supprimer"
                            onclick="confirmDelete(<?= (int)$emp['id_Emp'] ?>, '<?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp'], 'js') ?>')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <?php else: ?>
                        <span class="btn-icon"
                              style="opacity:0.2;cursor:not-allowed;background:transparent;border:1px solid var(--c-border);"
                              title="Votre propre compte">
                            <i class="fas fa-lock" style="color:var(--c-muted);font-size:0.65rem;"></i>
                        </span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>

            <tr class="no-results-row" id="no-results-row">
                <td colspan="7">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:30px 0;">
                        <i class="fas fa-search" style="font-size:1.5rem;color:var(--c-muted);opacity:0.4;"></i>
                        <span style="color:var(--c-muted);font-size:0.83rem;">Aucun employe ne correspond aux filtres appliques.</span>
                        <button onclick="resetFilters()" class="btn-outline-orange" style="font-size:0.75rem;padding:5px 12px;margin-top:4px;">
                            <i class="fas fa-times"></i> Effacer les filtres
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="table-foot">
        <span class="table-foot-info" id="footer-count"><?= $totalEmp ?> employe(s) affiche(s)</span>
    </div>
</div>


<!-- ===== MODAL IMPORT ===== -->
<div class="modal-overlay" id="modal-import">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="fas fa-file-upload"></i> Importer des employes</h5>
            <button class="modal-close" onclick="closeImportModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <a href="<?= base_url('employe/modele') ?>" class="import-template-link">
            <i class="fas fa-download"></i>
            Telecharger le modele de fichier (.xlsx)
        </a>

        <form id="form-import" action="<?= base_url('employe/import') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="drop-zone" id="drop-zone">
                <input type="file" name="fichier_import" id="fichier-input" accept=".xlsx,.xls,.csv">
                <div class="drop-zone-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <p>Glissez votre fichier ici ou cliquez pour parcourir</p>
                <small>Formats acceptes : Excel (.xlsx, .xls) et CSV (.csv) &mdash; 5 Mo max</small>
                <div class="file-chosen" id="file-chosen-name"></div>
            </div>

            <div class="import-progress" id="import-progress">
                <div class="import-progress-bar">
                    <div class="import-progress-fill" id="import-progress-fill"></div>
                </div>
                <div class="import-progress-label" id="import-progress-label">Traitement en cours...</div>
            </div>

            <div class="import-result" id="import-result"></div>

            <!-- Colonnes attendues -->
            <div style="background:#111;border:1px solid var(--c-border);border-radius:8px;padding:12px;margin-bottom:16px;">
                <div style="font-size:0.7rem;color:var(--c-muted);text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">
                    Colonnes attendues dans le fichier
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:5px;">
                    <?php
                    $cols = ['Nom','Prenom','Email','Telephone','Adresse','Sexe (0=F/1=H)',
                             'Date naissance','Date embauche','Direction','Grade','Profil','Mot de passe'];
                    foreach ($cols as $col):
                    ?>
                    <span style="background:rgba(255,255,255,0.05);border:1px solid var(--c-border);border-radius:5px;padding:2px 7px;font-size:0.68rem;color:var(--c-soft);">
                        <?= $col ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="modal-btns">
                <button type="button" class="btn-cancel-modal" onclick="closeImportModal()">
                    <i class="fas fa-times"></i> Annuler
                </button>
                <button type="submit" class="btn-green" id="btn-import-submit" disabled>
                    <i class="fas fa-file-upload"></i> Lancer l'import
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL SUPPRESSION ===== -->
<div class="modal-overlay" id="modal-delete-emp">
    <div class="modal-box sm">
        <div style="width:50px;height:50px;border-radius:13px;background:var(--c-red-pale);border:1px solid var(--c-red-border);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#ff8080;margin:0 auto 14px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 style="color:#fff;font-size:0.95rem;font-weight:700;text-align:center;margin-bottom:8px;">Confirmer la suppression</h5>
        <p style="color:var(--c-muted);font-size:0.82rem;text-align:center;margin-bottom:20px;line-height:1.5;">
            Vous etes sur le point de supprimer le dossier de<br>
            <strong id="modal-emp-name" style="color:var(--c-soft);"></strong>.<br>
            Cette action est irreversible.
        </p>
        <div class="modal-btns">
            <button class="btn-cancel-modal" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
            <button class="btn-danger" id="btn-confirm-delete">
                <i class="fas fa-trash-alt"></i> Supprimer
            </button>
        </div>
    </div>
</div>

<form id="form-delete-emp" method="POST" style="display:none;">
    <?= csrf_field() ?>
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function() {

    // ===== COMPTEURS =====
    function animateCounter(id, target) {
        const el = document.getElementById(id);
        if (!el) return;
        let current = 0;
        const step = Math.max(1, target / (1000 / 16));
        const timer = setInterval(function() {
            current += step;
            if (current >= target) { el.textContent = target; clearInterval(timer); }
            else { el.textContent = Math.floor(current); }
        }, 16);
    }

    animateCounter('cnt-total', <?= (int)$totalEmp ?>);
    animateCounter('cnt-dispo', <?= (int)$disponibles ?>);
    animateCounter('cnt-abs',   <?= (int)$absents ?>);
    animateCounter('cnt-dir',   <?= (int)$dirUniques ?>);

    // ===== FILTRES =====
    window.toggleFilters = function() {
        document.getElementById('filter-body').classList.toggle('open');
        document.getElementById('filter-chevron').classList.toggle('open');
    };

    const rows      = document.querySelectorAll('.emp-row');
    const noResults = document.getElementById('no-results-row');
    const badge     = document.getElementById('filter-badge');
    const footCount = document.getElementById('footer-count');
    const btnReset  = document.getElementById('btn-reset');

    function applyFilters() {
        const search = document.getElementById('f-search').value.trim().toLowerCase();
        const dir    = document.getElementById('f-dir').value;
        const grd    = document.getElementById('f-grd').value;
        const pfl    = document.getElementById('f-pfl').value;
        const sexe   = document.getElementById('f-sexe').value;
        const dispo  = document.getElementById('f-dispo').value;

        let actifs = [search, dir, grd, pfl, sexe, dispo].filter(v => v !== '').length;

        if (actifs > 0) {
            badge.textContent = actifs;
            badge.classList.add('visible');
            btnReset.classList.add('visible');
        } else {
            badge.classList.remove('visible');
            btnReset.classList.remove('visible');
        }

        // Mettre a jour le lien d'export avec les filtres visibles
        updateExportLinks();

        let visible = 0;
        rows.forEach(function(row) {
            const match =
                (search === '' || row.dataset.nom.includes(search) || row.dataset.email.includes(search)) &&
                (dir    === '' || row.dataset.dir  === dir)  &&
                (grd    === '' || row.dataset.grd  === grd)  &&
                (pfl    === '' || row.dataset.pfl  === pfl)  &&
                (sexe   === '' || row.dataset.sexe === sexe) &&
                (dispo  === '' || row.dataset.dispo === dispo);

            if (match) {
                row.classList.remove('hidden-row');
                visible++;
                const numCell = row.querySelector('.row-num');
                if (numCell) numCell.textContent = visible;
            } else {
                row.classList.add('hidden-row');
            }
        });

        noResults.classList.toggle('visible', visible === 0);
        footCount.textContent = visible + ' employe(s) affiche(s)';
    }

    window.resetFilters = function() {
        ['f-search','f-dir','f-grd','f-pfl','f-sexe','f-dispo'].forEach(function(id) {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        applyFilters();
    };

    document.getElementById('f-search').addEventListener('input',  applyFilters);
    document.getElementById('f-dir').addEventListener('change',    applyFilters);
    document.getElementById('f-grd').addEventListener('change',    applyFilters);
    document.getElementById('f-pfl').addEventListener('change',    applyFilters);
    document.getElementById('f-sexe').addEventListener('change',   applyFilters);
    document.getElementById('f-dispo').addEventListener('change',  applyFilters);

    // ===== EXPORT : mettre a jour les liens selon les filtres actifs =====
    function updateExportLinks() {
        const visibleIds = [];
        rows.forEach(function(row) {
            if (!row.classList.contains('hidden-row')) {
                // Extraire l'id depuis le lien "voir"
                const linkView = row.querySelector('.btn-icon-view');
                if (linkView) {
                    const parts = linkView.href.split('/');
                    visibleIds.push(parts[parts.length - 1]);
                }
            }
        });

        const count = visibleIds.length;
        const noteEl = document.getElementById('export-note');
        noteEl.textContent = count + ' employe(s) sera(ont) exporte(s)';

        const params = visibleIds.length > 0 ? '?ids=' + visibleIds.join(',') : '';
        document.getElementById('link-excel').href = '<?= base_url('employe/export-excel') ?>' + params;
        document.getElementById('link-csv').href   = '<?= base_url('employe/export-csv') ?>'   + params;
    }

    updateExportLinks();

    // ===== DROPDOWN EXPORT =====
    window.toggleExportMenu = function() {
        document.getElementById('export-menu').classList.toggle('open');
    };

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('export-dropdown');
        if (!dropdown.contains(e.target)) {
            document.getElementById('export-menu').classList.remove('open');
        }
    });

    // ===== MODAL IMPORT =====
    window.openImportModal = function() {
        document.getElementById('modal-import').classList.add('show');
    };

    window.closeImportModal = function() {
        document.getElementById('modal-import').classList.remove('show');
        document.getElementById('import-result').style.display = 'none';
        document.getElementById('import-progress').style.display = 'none';
        document.getElementById('file-chosen-name').style.display = 'none';
        document.getElementById('fichier-input').value = '';
        document.getElementById('btn-import-submit').disabled = true;
    };

    // Afficher le nom du fichier choisi
    document.getElementById('fichier-input').addEventListener('change', function() {
        const nameEl = document.getElementById('file-chosen-name');
        if (this.files.length > 0) {
            nameEl.textContent = this.files[0].name;
            nameEl.style.display = 'block';
            document.getElementById('btn-import-submit').disabled = false;
        } else {
            nameEl.style.display = 'none';
            document.getElementById('btn-import-submit').disabled = true;
        }
    });

    // Drag & drop
    const dropZone = document.getElementById('drop-zone');

    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', function() {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const input = document.getElementById('fichier-input');
            // Transferer le fichier dans l'input
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            input.dispatchEvent(new Event('change'));
        }
    });

    // Fermer modal en cliquant le backdrop
    document.getElementById('modal-import').addEventListener('click', function(e) {
        if (e.target === this) window.closeImportModal();
    });

    // ===== MODAL SUPPRESSION =====
    let deleteUrl = '';

    window.confirmDelete = function(id, nom) {
        document.getElementById('modal-emp-name').textContent = nom;
        deleteUrl = '<?= base_url('employe/delete/') ?>' + id;
        document.getElementById('modal-delete-emp').classList.add('show');
    };

    window.closeDeleteModal = function() {
        document.getElementById('modal-delete-emp').classList.remove('show');
        deleteUrl = '';
    };

    document.getElementById('btn-confirm-delete').addEventListener('click', function() {
        if (!deleteUrl) return;
        document.getElementById('form-delete-emp').action = deleteUrl;
        document.getElementById('form-delete-emp').submit();
    });

    document.getElementById('modal-delete-emp').addEventListener('click', function(e) {
        if (e.target === this) window.closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.closeImportModal();
            window.closeDeleteModal();
        }
    });

    // Deplacer modals au niveau du body
    document.addEventListener('DOMContentLoaded', function() {
        document.body.appendChild(document.getElementById('modal-delete-emp'));
        document.body.appendChild(document.getElementById('form-delete-emp'));
    });

})();
</script>
<?= $this->endSection() ?>