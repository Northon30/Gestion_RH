<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-orange:        #F5A623;
        --c-orange-pale:   rgba(245,166,35,0.10);
        --c-orange-border: rgba(245,166,35,0.25);
        --c-green-pale:    rgba(74,103,65,0.15);
        --c-green-border:  rgba(74,103,65,0.35);
        --c-red-pale:      rgba(224,82,82,0.10);
        --c-red-border:    rgba(224,82,82,0.25);
        --c-blue-pale:     rgba(58,123,213,0.10);
        --c-blue-border:   rgba(58,123,213,0.25);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .show-grid { display:grid; grid-template-columns:300px 1fr; gap:16px; align-items:start; }

    /* ===== CARD ===== */
    .card { background:var(--c-surface); border:1px solid var(--c-border); border-radius:14px; overflow:hidden; }

    .card-header {
        padding:14px 18px; border-bottom:1px solid var(--c-border);
        display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
    }

    .card-header-left { display:flex; align-items:center; gap:10px; }

    .card-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-orange); font-size:0.82rem; flex-shrink:0;
    }

    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }

    .card-count {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.68rem; font-weight:700;
        padding:2px 9px; border-radius:10px;
    }

    /* ===== INFO ===== */
    .info-body { padding:16px 18px; }

    .info-row {
        display:flex; flex-direction:column; gap:3px;
        padding:10px 0; border-bottom:1px solid var(--c-border);
    }

    .info-row:first-child { padding-top:0; }
    .info-row:last-child  { border-bottom:none; padding-bottom:0; }

    .info-label {
        font-size:0.67rem; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.6px; font-weight:600;
    }

    .info-value { color:var(--c-text); font-size:0.82rem; }

    .badge-type {
        display:inline-flex; align-items:center; gap:4px;
        padding:3px 10px; border-radius:20px; font-size:0.68rem; font-weight:700;
        background:var(--c-blue-pale); border:1px solid var(--c-blue-border); color:#5B9BF0;
    }

    .badge-avenir   { background:var(--c-green-pale); border:1px solid var(--c-green-border); color:#7ab86a; }
    .badge-passe    { background:rgba(255,255,255,0.05); border:1px solid var(--c-border); color:var(--c-muted); }
    .badge-aujourd  { background:var(--c-orange-pale); border:1px solid var(--c-orange-border); color:var(--c-orange); }

    /* ===== FORMULAIRE AJOUT MULTI-PARTICIPANT ===== */
    .add-form { padding:14px 16px; }

    .form-group-sm { display:flex; flex-direction:column; gap:5px; }

    .form-label-sm {
        font-size:0.68rem; font-weight:600; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.5px;
    }

    .emp-search-input {
        background:#111; border:1px solid var(--c-border);
        border-radius:8px 8px 0 0; color:var(--c-text); font-size:0.78rem;
        padding:8px 10px 8px 30px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif; width:100%; border-bottom:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,0.3)' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:9px center;
    }

    .emp-search-input:focus { border-color:var(--c-orange-border); }

    .emp-checklist {
        background:#111; border:1px solid var(--c-border);
        border-radius:0 0 8px 8px; max-height:180px; overflow-y:auto;
        scrollbar-width:thin; scrollbar-color:rgba(245,166,35,0.3) transparent;
    }

    .emp-checklist::-webkit-scrollbar { width:4px; }
    .emp-checklist::-webkit-scrollbar-thumb { background:rgba(245,166,35,0.3); border-radius:4px; }

    .emp-check-item {
        display:flex; align-items:center; gap:10px;
        padding:7px 10px; border-bottom:1px solid var(--c-border);
        cursor:pointer; transition:background 0.12s; user-select:none;
    }

    .emp-check-item:last-child { border-bottom:none; }
    .emp-check-item:hover { background:rgba(245,166,35,0.04); }
    .emp-check-item.selected { background:var(--c-orange-pale); }

    .emp-check-item input[type="checkbox"] {
        accent-color:var(--c-orange); width:14px; height:14px; flex-shrink:0; cursor:pointer;
    }

    .emp-check-name { color:var(--c-text); font-size:0.78rem; font-weight:500; flex:1; min-width:0; }
    .emp-check-dir  { color:var(--c-muted); font-size:0.68rem; white-space:nowrap; }

    .emp-checklist-empty {
        padding:16px; text-align:center; color:var(--c-muted); font-size:0.78rem;
    }

    .add-form-footer {
        display:flex; align-items:center; justify-content:space-between;
        gap:8px; margin-top:10px; flex-wrap:wrap;
    }

    .select-all-btn {
        background:transparent; border:none; color:var(--c-muted);
        font-size:0.72rem; cursor:pointer; padding:0; transition:color 0.15s;
        display:inline-flex; align-items:center; gap:5px;
    }

    .select-all-btn:hover { color:var(--c-orange); }

    .selected-count {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.68rem; font-weight:700;
        padding:2px 9px; border-radius:10px; display:none;
    }

    /* ===== FILTRES ===== */
    .filter-bar {
        display:flex; gap:8px; padding:10px 14px;
        border-bottom:1px solid var(--c-border); flex-wrap:wrap; align-items:flex-end;
    }

    .filter-group-sm { display:flex; flex-direction:column; gap:4px; }

    .filter-lbl-sm {
        font-size:0.62rem; font-weight:600; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.5px;
    }

    .filter-ctrl-sm {
        background:#111; border:1px solid var(--c-border);
        border-radius:7px; color:var(--c-text); font-size:0.75rem;
        padding:6px 9px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif;
    }

    .filter-ctrl-sm:focus { border-color:var(--c-orange-border); }
    .filter-ctrl-sm option { background:#1a1a1a; }

    /* ===== TABLE ===== */
    .emp-table { width:100%; border-collapse:collapse; font-size:0.8rem; }

    .emp-table thead th {
        padding:8px 14px; font-size:0.65rem; font-weight:700;
        letter-spacing:0.8px; text-transform:uppercase;
        color:var(--c-orange); background:var(--c-orange-pale);
        border-bottom:1px solid var(--c-orange-border);
    }

    .emp-table tbody td {
        padding:10px 14px; color:var(--c-soft);
        border-bottom:1px solid var(--c-border); vertical-align:middle;
    }

    .emp-table tbody tr:last-child td { border-bottom:none; }
    .emp-table tbody tr:hover td { background:rgba(245,166,35,0.02); }

    .emp-avatar {
        width:28px; height:28px; border-radius:50%;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.62rem; font-weight:700; color:var(--c-orange);
        text-transform:uppercase; flex-shrink:0; vertical-align:middle; margin-right:8px;
    }

    /* ===== BOUTONS ===== */
    .btn-icon {
        width:27px; height:27px; border-radius:6px;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.65rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none;
    }

    .btn-icon-orange { background:var(--c-orange-pale); color:var(--c-orange); border:1px solid var(--c-orange-border); }
    .btn-icon-red    { background:var(--c-red-pale);    color:#ff8080;          border:1px solid var(--c-red-border); }
    .btn-icon-green  { background:var(--c-green-pale);  color:#7ab86a;          border:1px solid var(--c-green-border); }
    .btn-icon:hover  { transform:scale(1.1); }

    .btn-orange {
        background:linear-gradient(135deg,var(--c-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:8px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-orange:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(245,166,35,0.3); color:#111; }

    .btn-ghost {
        background:transparent; border:1px solid var(--c-border);
        color:var(--c-soft); font-weight:600; border-radius:8px;
        padding:8px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--c-text); }

    .btn-submit-sm {
        background:linear-gradient(135deg,var(--c-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:8px 16px; font-size:0.78rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; white-space:nowrap;
    }

    .btn-submit-sm:hover { transform:translateY(-1px); }

    .btn-notif {
        background:var(--c-blue-pale); border:1px solid var(--c-blue-border);
        color:#5B9BF0; font-weight:700; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-notif:hover { transform:translateY(-1px); }

    .btn-danger {
        background:linear-gradient(135deg,#c0392b,#922b21);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }

    .btn-danger:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(192,57,43,0.35); }

    /* Alerts */
    .alert-success-dark {
        background:var(--c-green-pale); border:1px solid var(--c-green-border);
        border-radius:10px; padding:11px 16px; color:#7ab86a;
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    .alert-error-dark {
        background:var(--c-red-pale); border:1px solid var(--c-red-border);
        border-radius:10px; padding:11px 16px; color:#ff8080;
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    .empty-state { padding:36px; text-align:center; color:var(--c-muted); font-size:0.8rem; }
    .empty-state i { font-size:1.6rem; opacity:0.2; margin-bottom:8px; display:block; }

    /* ===== MULTI-SELECT AJOUT PARTICIPANT ===== */
    .emp-search-input {
        background:#111; border:1px solid var(--c-border);
        border-radius:8px 8px 0 0; color:var(--c-text); font-size:0.78rem;
        padding:8px 10px 8px 30px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif; width:100%; border-bottom:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,0.3)' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:9px center;
    }

    .emp-search-input:focus { border-color:var(--c-orange-border); }

    .emp-checklist {
        background:#111; border:1px solid var(--c-border);
        border-radius:0 0 8px 8px; max-height:180px; overflow-y:auto;
        scrollbar-width:thin; scrollbar-color:rgba(245,166,35,0.3) transparent;
    }

    .emp-checklist::-webkit-scrollbar { width:4px; }
    .emp-checklist::-webkit-scrollbar-thumb { background:rgba(245,166,35,0.3); border-radius:4px; }

    .emp-check-item {
        display:flex; align-items:center; gap:10px;
        padding:7px 10px; border-bottom:1px solid var(--c-border);
        cursor:pointer; transition:background 0.12s; user-select:none;
    }

    .emp-check-item:last-child { border-bottom:none; }
    .emp-check-item:hover { background:rgba(245,166,35,0.04); }
    .emp-check-item.selected { background:var(--c-orange-pale); }

    .emp-check-item input[type="checkbox"] {
        accent-color:var(--c-orange); width:14px; height:14px; flex-shrink:0; cursor:pointer;
    }

    .emp-check-name { color:var(--c-text); font-size:0.78rem; font-weight:500; flex:1; min-width:0; }
    .emp-check-dir  { color:var(--c-muted); font-size:0.68rem; white-space:nowrap; }

    .emp-checklist-empty {
        padding:16px; text-align:center; color:var(--c-muted); font-size:0.78rem;
    }

    .add-form-footer {
        display:flex; align-items:center; justify-content:space-between;
        gap:8px; margin-top:10px; flex-wrap:wrap;
    }

    .select-all-btn {
        background:transparent; border:none; color:var(--c-muted);
        font-size:0.72rem; cursor:pointer; padding:0; transition:color 0.15s;
        display:inline-flex; align-items:center; gap:5px;
    }

    .select-all-btn:hover { color:var(--c-orange); }

    .selected-count {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.68rem; font-weight:700;
        padding:2px 9px; border-radius:10px;
    }

    /* ===== PANNEAU SLIDE-IN AJOUT ===== */
    .panel-overlay {
        display:none; position:fixed; inset:0;
        background:rgba(0,0,0,0.55); z-index:1050;
        backdrop-filter:blur(3px);
    }

    .panel-overlay.is-open { display:block; }

    .panel-slide {
        position:fixed; top:0; right:0; height:100%; width:420px; max-width:95vw;
        background:#1a1a1a; border-left:1px solid rgba(255,255,255,0.08);
        box-shadow:-20px 0 60px rgba(0,0,0,0.5);
        transform:translateX(100%); transition:transform 0.28s cubic-bezier(0.4,0,0.2,1);
        z-index:1051; display:flex; flex-direction:column;
    }

    .panel-overlay.is-open .panel-slide { transform:translateX(0); }

    .panel-head {
        padding:16px 18px; border-bottom:1px solid rgba(255,255,255,0.06);
        display:flex; align-items:center; justify-content:space-between; flex-shrink:0;
    }

    .panel-head-left { display:flex; align-items:center; gap:10px; }

    .panel-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-orange); font-size:0.82rem; flex-shrink:0;
    }

    .panel-title    { color:#fff; font-size:0.88rem; font-weight:700; margin:0; }
    .panel-subtitle { color:var(--c-muted); font-size:0.72rem; margin:2px 0 0; }

    .panel-close {
        width:28px; height:28px; border-radius:7px;
        background:transparent; border:1px solid rgba(255,255,255,0.08);
        color:var(--c-muted); cursor:pointer; display:flex;
        align-items:center; justify-content:center; font-size:0.75rem;
        transition:all 0.15s; flex-shrink:0;
    }

    .panel-close:hover { background:var(--c-red-pale); border-color:var(--c-red-border); color:#ff8080; }

    /* Raccourcis direction */
    .shortcuts-bar {
        padding:10px 14px; border-bottom:1px solid rgba(255,255,255,0.06);
        display:flex; gap:6px; flex-wrap:wrap; flex-shrink:0;
    }

    .shortcut-btn {
        background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08);
        color:var(--c-muted); border-radius:20px; padding:4px 12px;
        font-size:0.7rem; font-weight:600; cursor:pointer; transition:all 0.15s;
        display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
    }

    .shortcut-btn:hover { background:var(--c-orange-pale); border-color:var(--c-orange-border); color:var(--c-orange); }
    .shortcut-btn.active { background:var(--c-orange-pale); border-color:var(--c-orange-border); color:var(--c-orange); }

    /* Recherche + filtre */
    .panel-filters {
        padding:10px 14px; border-bottom:1px solid rgba(255,255,255,0.06);
        display:flex; gap:8px; flex-shrink:0;
    }

    .panel-search {
        flex:1; background:#111; border:1px solid rgba(255,255,255,0.08);
        border-radius:8px; color:var(--c-text); font-size:0.78rem;
        padding:7px 10px 7px 28px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,0.25)' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:9px center;
    }

    .panel-search:focus { border-color:var(--c-orange-border); }

    .panel-dir-filter {
        background:#111; border:1px solid rgba(255,255,255,0.08);
        border-radius:8px; color:var(--c-muted); font-size:0.75rem;
        padding:7px 9px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif; max-width:130px;
    }

    .panel-dir-filter:focus { border-color:var(--c-orange-border); }
    .panel-dir-filter option { background:#1a1a1a; }

    /* Liste scrollable */
    .panel-list {
        flex:1; overflow-y:auto; padding:6px 0;
        scrollbar-width:thin; scrollbar-color:rgba(245,166,35,0.25) transparent;
    }

    .panel-list::-webkit-scrollbar { width:4px; }
    .panel-list::-webkit-scrollbar-thumb { background:rgba(245,166,35,0.25); border-radius:4px; }

    .panel-emp-item {
        display:flex; align-items:center; gap:10px;
        padding:8px 16px; cursor:pointer; transition:background 0.12s;
        border-bottom:1px solid rgba(255,255,255,0.03);
    }

    .panel-emp-item:last-child { border-bottom:none; }
    .panel-emp-item:hover { background:rgba(245,166,35,0.04); }
    .panel-emp-item.selected { background:var(--c-orange-pale); }

    .panel-emp-item input[type="checkbox"] {
        accent-color:var(--c-orange); width:14px; height:14px; flex-shrink:0; cursor:pointer;
    }

    .panel-emp-avatar {
        width:28px; height:28px; border-radius:50%;
        background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08);
        display:flex; align-items:center; justify-content:center;
        font-size:0.62rem; font-weight:700; color:var(--c-soft);
        text-transform:uppercase; flex-shrink:0;
    }

    .panel-emp-item.selected .panel-emp-avatar {
        background:var(--c-orange-pale); border-color:var(--c-orange-border);
        color:var(--c-orange);
    }

    .panel-emp-name { color:var(--c-text); font-size:0.8rem; font-weight:500; flex:1; min-width:0; }
    .panel-emp-dir  { color:var(--c-muted); font-size:0.68rem; white-space:nowrap; }

    .panel-empty {
        padding:30px; text-align:center; color:var(--c-muted); font-size:0.8rem;
    }

    .panel-empty i { font-size:1.4rem; opacity:0.2; display:block; margin-bottom:8px; }

    /* Footer panneau */
    .panel-footer {
        padding:12px 16px; border-top:1px solid rgba(255,255,255,0.06);
        display:flex; align-items:center; justify-content:space-between;
        gap:10px; flex-shrink:0; flex-wrap:wrap;
    }

    .panel-selected-badge {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.72rem; font-weight:700;
        padding:3px 10px; border-radius:10px;
    }

    .btn-panel-add {
        background:linear-gradient(135deg,var(--c-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:9px 20px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }

    .btn-panel-add:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(245,166,35,0.3); }
    .btn-panel-add:disabled { opacity:0.4; cursor:not-allowed; transform:none; box-shadow:none; }

    /* Modal retirer */
    .modal-overlay {
        display:none; position:fixed; inset:0;
        background:rgba(0,0,0,0.65); z-index:1040;
        backdrop-filter:blur(3px); align-items:center; justify-content:center;
    }

    .modal-overlay.is-open { display:flex; }

    .modal-box {
        background:#1e1e1e; border:1px solid rgba(255,255,255,0.08);
        border-radius:14px; padding:24px; width:100%; max-width:380px;
        box-shadow:0 20px 60px rgba(0,0,0,0.5);
    }

    @media (max-width:900px) { .show-grid { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$evt    = $evenement;
$today  = date('Y-m-d');
$statut = $evt['Date_Evt'] > $today ? 'avenir' : ($evt['Date_Evt'] === $today ? 'aujourd_hui' : 'passe');
$total  = count($participants);
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-alt me-2" style="color:#F5A623;"></i><?= esc($evt['Description_Evt']) ?></h1>
        <p><?= date('d/m/Y', strtotime($evt['Date_Evt'])) ?> · <?= $total ?> participant(s)</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('evenement') ?>" class="btn-ghost">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <?php if ($idPfl == 1): ?>
        <button type="button" class="btn-orange" onclick="openPanel()">
            <i class="fas fa-user-plus"></i> Ajouter des participants
        </button>
        <a href="<?= base_url('evenement/edit/' . $evt['id_Evt']) ?>" class="btn-ghost">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <?php if ($total > 0): ?>
        <form action="<?= base_url('evenement/notifier-participants/' . $evt['id_Evt']) ?>" method="POST" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit" class="btn-notif">
                <i class="fas fa-bell"></i> Notifier (<?= $total ?>)
            </button>
        </form>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark">
    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark">
    <i class="fas fa-exclamation-triangle"></i> <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<div class="show-grid">

    <!-- COL GAUCHE — Infos + Ajout participant -->
    <div style="display:flex;flex-direction:column;gap:16px;">

        <!-- Infos -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon"><i class="fas fa-info-circle"></i></div>
                    <p class="card-title">Informations</p>
                </div>
            </div>
            <div class="info-body">
                <div class="info-row">
                    <span class="info-label">Description</span>
                    <span class="info-value" style="font-weight:700;"><?= esc($evt['Description_Evt']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Type</span>
                    <span class="badge-type"><?= esc($evt['Libelle_Tev'] ?? '-') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-value">
                        <?= date('d/m/Y', strtotime($evt['Date_Evt'])) ?>
                        <?php if ($statut === 'avenir'): ?>
                        <span class="badge-type badge-avenir" style="margin-left:6px;font-size:0.65rem;">À venir</span>
                        <?php elseif ($statut === 'aujourd_hui'): ?>
                        <span class="badge-type badge-aujourd" style="margin-left:6px;font-size:0.65rem;">Aujourd'hui</span>
                        <?php else: ?>
                        <span class="badge-type badge-passe" style="margin-left:6px;font-size:0.65rem;">Passé</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Participants</span>
                    <span class="info-value" style="font-size:1.1rem;font-weight:800;color:var(--c-orange);">
                        <?= $total ?>
                    </span>
                </div>
            </div>
        </div>

    </div><!-- /COL GAUCHE -->

    <!-- COL DROITE — Participants -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <p class="card-title">Participants</p>
            </div>
            <span class="card-count" id="part-count"><?= $total ?></span>
        </div>

        <!-- Filtres automatiques JS -->
        <div class="filter-bar">
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">Recherche</label>
                <input type="text" id="f-search" class="filter-ctrl-sm"
                       placeholder="Nom ou prénom..." style="width:160px;">
            </div>
            <?php if ($idPfl == 1): ?>
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">Direction</label>
                <select id="f-dir" class="filter-ctrl-sm">
                    <option value="">Toutes</option>
                    <?php foreach ($directions as $dir): ?>
                    <option value="<?= strtolower(esc($dir['Nom_Dir'])) ?>"><?= esc($dir['Nom_Dir']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">&nbsp;</label>
                <button type="button" class="btn-danger" id="btn-reset"
                        style="display:none;" onclick="resetFilters()">
                    <i class="fas fa-times"></i> Réinitialiser
                </button>
            </div>
        </div>

        <?php if (empty($participants)): ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            Aucun participant pour cet événement.
        </div>
        <?php else: ?>
        <table class="emp-table" id="part-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Participant</th>
                    <?php if ($idPfl == 1): ?><th>Direction</th><?php endif; ?>
                    <th>Grade</th>
                    <th>Date inscription</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="part-tbody">
                <?php foreach ($participants as $i => $p): ?>
                <tr class="part-row"
                    data-nom="<?= strtolower(esc(($p['Nom_Emp'] ?? '') . ' ' . ($p['Prenom_Emp'] ?? ''))) ?>"
                    data-dir="<?= strtolower(esc($p['Nom_Dir'] ?? '')) ?>">
                    <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                    <td>
                        <a href="<?= base_url('employe/show/' . $p['id_Emp']) ?>"
                           style="text-decoration:none;display:inline-flex;align-items:center;">
                            <span class="emp-avatar">
                                <?= mb_substr($p['Nom_Emp'] ?? '?', 0, 1) . mb_substr($p['Prenom_Emp'] ?? '', 0, 1) ?>
                            </span>
                            <span style="color:#fff;font-weight:500;">
                                <?= esc(($p['Nom_Emp'] ?? '') . ' ' . ($p['Prenom_Emp'] ?? '')) ?>
                            </span>
                        </a>
                    </td>
                    <?php if ($idPfl == 1): ?>
                    <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($p['Nom_Dir'] ?? '-') ?></td>
                    <?php endif; ?>
                    <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($p['Libelle_Grd'] ?? '-') ?></td>
                    <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                        <?= $p['Dte_Sig'] ? date('d/m/Y', strtotime($p['Dte_Sig'])) : '-' ?>
                    </td>
                    <td style="text-align:center;">
                        <div style="display:inline-flex;gap:5px;">
                            <a href="<?= base_url('employe/show/' . $p['id_Emp']) ?>"
                               class="btn-icon btn-icon-orange" title="Voir l'employé">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($idPfl == 1): ?>
                            <button class="btn-icon btn-icon-red" title="Retirer"
                                    onclick="confirmRetirer(<?= $p['Id_Ptr'] ?>, '<?= esc(($p['Nom_Emp'] ?? '') . ' ' . ($p['Prenom_Emp'] ?? ''), 'js') ?>')">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="no-match" style="display:none;padding:30px;text-align:center;">
            <i class="fas fa-search" style="font-size:1.4rem;color:var(--c-muted);opacity:0.3;display:block;margin-bottom:8px;"></i>
            <span style="color:var(--c-muted);font-size:0.82rem;">Aucun participant ne correspond.</span>
        </div>

        <div style="padding:10px 16px;border-top:1px solid var(--c-border);">
            <span style="font-size:0.73rem;color:var(--c-muted);" id="part-footer">
                <?= $total ?> participant(s)
            </span>
        </div>
        <?php endif; ?>
    </div>

</div><!-- /.show-grid -->

<?php if ($idPfl == 1): ?>
<!-- ===== PANNEAU SLIDE-IN AJOUT PARTICIPANTS ===== -->
<div class="panel-overlay" id="panel-overlay" onclick="closePanelIfOutside(event)">
    <div class="panel-slide" id="panel-slide">

        <!-- En-tête panneau -->
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fas fa-user-plus"></i></div>
                <div>
                    <p class="panel-title">Ajouter des participants</p>
                    <p class="panel-subtitle">
                        <?= count($employesSans) ?> employé(s) disponible(s)
                    </p>
                </div>
            </div>
            <button type="button" class="panel-close" onclick="closePanel()" title="Fermer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Raccourcis rapides -->
        <?php if (!empty($directions)): ?>
        <div class="shortcuts-bar">
            <span style="font-size:0.65rem;color:var(--c-muted);text-transform:uppercase;
                         letter-spacing:0.5px;font-weight:600;align-self:center;">
                Sélection rapide :
            </span>
            <button type="button" class="shortcut-btn" id="sh-tous"
                    onclick="selectRapide('tous')">
                <i class="fas fa-building"></i> Toute l'entreprise
            </button>
            <?php foreach ($directions as $dir): ?>
            <button type="button" class="shortcut-btn"
                    onclick="selectRapide('dir', '<?= $dir['id_Dir'] ?>')">
                <i class="fas fa-sitemap"></i> <?= esc($dir['Nom_Dir']) ?>
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Recherche + filtre direction -->
        <div class="panel-filters">
            <input type="text" id="panel-search" class="panel-search"
                   placeholder="Rechercher..."
                   oninput="filterPanel()">
            <?php if (!empty($directions)): ?>
            <select id="panel-dir" class="panel-dir-filter" onchange="filterPanel()">
                <option value="">Toutes directions</option>
                <?php foreach ($directions as $dir): ?>
                <option value="<?= $dir['id_Dir'] ?>"><?= esc($dir['Nom_Dir']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
        </div>

        <!-- Liste des employés à cocher -->
        <form action="<?= base_url('evenement/ajouter-participants/' . $evt['id_Evt']) ?>"
              method="POST" id="form-panel" style="display:contents;">
            <?= csrf_field() ?>

            <div class="panel-list" id="panel-list">
                <?php if (empty($employesSans)): ?>
                <div class="panel-empty">
                    <i class="fas fa-check-double"></i>
                    Tous les employés participent déjà.
                </div>
                <?php else: ?>
                <?php foreach ($employesSans as $emp): ?>
                <label class="panel-emp-item"
                       data-nom="<?= strtolower(esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp'])) ?>"
                       data-dir="<?= $emp['id_Dir'] ?? '' ?>">
                    <input type="checkbox" name="ids_Emp[]"
                           value="<?= $emp['id_Emp'] ?>"
                           onchange="updatePanelState()">
                    <span class="panel-emp-avatar">
                        <?= mb_substr($emp['Nom_Emp'], 0, 1) . mb_substr($emp['Prenom_Emp'] ?? '', 0, 1) ?>
                    </span>
                    <span class="panel-emp-name">
                        <?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>
                    </span>
                    <span class="panel-emp-dir"><?= esc($emp['Nom_Dir'] ?? '') ?></span>
                </label>
                <?php endforeach; ?>
                <div class="panel-empty" id="panel-empty" style="display:none;">
                    <i class="fas fa-search"></i> Aucun résultat.
                </div>
                <?php endif; ?>
            </div>

            <!-- Footer panneau -->
            <div class="panel-footer">
                <div style="display:flex;align-items:center;gap:8px;">
                    <button type="button" onclick="togglePanelAll()"
                            style="background:transparent;border:none;color:var(--c-muted);
                                   font-size:0.72rem;cursor:pointer;display:flex;
                                   align-items:center;gap:5px;padding:0;"
                            id="btn-panel-all">
                        <i class="fas fa-check-square"></i> Tout sélectionner
                    </button>
                    <span class="panel-selected-badge" id="panel-badge" style="display:none;">
                        0 sélectionné(s)
                    </span>
                </div>
                <button type="submit" form="form-panel" class="btn-panel-add"
                        id="btn-panel-submit" disabled>
                    <i class="fas fa-user-plus"></i>
                    <span id="btn-panel-label">Ajouter</span>
                </button>
            </div>

        </form>

    </div>
</div>
<?php endif; ?>

<!-- Modal retirer participant -->
<div class="modal-overlay" id="modal-retirer">
    <div class="modal-box">
        <div style="width:44px;height:44px;border-radius:11px;background:var(--c-red-pale);
                    border:1px solid var(--c-red-border);display:flex;align-items:center;
                    justify-content:center;font-size:1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-user-minus"></i>
        </div>
        <p style="color:#fff;font-size:0.88rem;font-weight:700;text-align:center;margin-bottom:4px;">
            Retirer le participant
        </p>
        <p style="color:var(--c-muted);font-size:0.78rem;text-align:center;margin-bottom:16px;"
           id="modal-retirer-msg"></p>
        <div style="display:flex;gap:10px;">
            <button type="button" onclick="closeModal()"
                    style="flex:1;background:transparent;border:1px solid var(--c-border);
                           color:var(--c-soft);font-weight:600;border-radius:8px;
                           padding:9px;font-size:0.8rem;cursor:pointer;">
                <i class="fas fa-times"></i> Annuler
            </button>
            <form id="form-retirer" method="POST" style="flex:1;">
                <?= csrf_field() ?>
                <button type="submit"
                        style="width:100%;background:linear-gradient(135deg,#c0392b,#922b21);
                               border:none;color:#fff;font-weight:700;border-radius:8px;
                               padding:9px;font-size:0.8rem;cursor:pointer;">
                    <i class="fas fa-user-minus"></i> Retirer
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    // ===== FILTRES TABLE PARTICIPANTS =====
    var rows     = document.querySelectorAll('.part-row');
    var btnReset = document.getElementById('btn-reset');
    var count    = document.getElementById('part-count');
    var footer   = document.getElementById('part-footer');
    var noMatch  = document.getElementById('no-match');

    function applyFilters() {
        var search = document.getElementById('f-search').value.trim().toLowerCase();
        var dirEl  = document.getElementById('f-dir');
        var dir    = dirEl ? dirEl.value.toLowerCase() : '';

        var actifs = [search, dir].filter(function (v) { return v !== ''; }).length;
        btnReset.style.display = actifs > 0 ? '' : 'none';

        var visible = 0;
        rows.forEach(function (row) {
            var match =
                (search === '' || row.dataset.nom.includes(search)) &&
                (dir    === '' || row.dataset.dir.includes(dir));

            row.style.display = match ? '' : 'none';
            if (match) {
                visible++;
                var numCell = row.querySelector('.row-num');
                if (numCell) numCell.textContent = visible;
            }
        });

        if (count)  count.textContent  = visible + ' participant(s)';
        if (footer) footer.textContent = visible + ' participant(s) affiché(s)';
        if (noMatch) noMatch.style.display = visible === 0 && rows.length > 0 ? 'block' : 'none';
    }

    window.resetFilters = function () {
        ['f-search', 'f-dir'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });
        applyFilters();
    };

    ['f-search', 'f-dir'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input',  applyFilters);
            el.addEventListener('change', applyFilters);
        }
    });

    // ===== MODAL RETIRER =====
    window.confirmRetirer = function (idPtr, nom) {
        var modal = document.getElementById('modal-retirer');
        var msg   = document.getElementById('modal-retirer-msg');
        var form  = document.getElementById('form-retirer');
        msg.innerHTML = 'Retirer <strong style="color:#fff;">' + nom + '</strong> de cet événement ?';
        form.action = '<?= base_url('evenement/retirer-participant/') ?>' + idPtr;
        modal.classList.add('is-open');
    };

    window.closeModal = function () {
        document.getElementById('modal-retirer').classList.remove('is-open');
    };

    document.getElementById('modal-retirer').addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    // ===== PANNEAU SLIDE-IN =====
    var overlay = document.getElementById('panel-overlay');
    var _panelAllSelected = false;

    window.openPanel = function () {
        if (overlay) {
            overlay.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            var s = document.getElementById('panel-search');
            if (s) setTimeout(function () { s.focus(); }, 280);
        }
    };

    window.closePanel = function () {
        if (overlay) {
            overlay.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    };

    window.closePanelIfOutside = function (e) {
        if (e.target === overlay) closePanel();
    };

    // Filtre live dans le panneau
    window.filterPanel = function () {
        var q      = (document.getElementById('panel-search').value || '').trim().toLowerCase();
        var dirSel = document.getElementById('panel-dir');
        var dirVal = dirSel ? dirSel.value : '';

        var items  = document.querySelectorAll('.panel-emp-item');
        var shown  = 0;

        items.forEach(function (item) {
            var nomMatch = q === '' || item.dataset.nom.includes(q);
            var dirMatch = dirVal === '' || item.dataset.dir === dirVal;
            var visible  = nomMatch && dirMatch;
            item.style.display = visible ? '' : 'none';
            if (visible) shown++;
        });

        var empty = document.getElementById('panel-empty');
        if (empty) empty.style.display = shown === 0 ? '' : 'none';

        _panelAllSelected = false;
        updatePanelAllBtn();
    };

    // Sélection rapide : direction ou toute l'entreprise
    window.selectRapide = function (type, dirId) {
        var items = document.querySelectorAll('.panel-emp-item');
        items.forEach(function (item) {
            if (item.style.display === 'none') return;
            var cb = item.querySelector('input[type="checkbox"]');
            if (!cb) return;
            var match = type === 'tous' || item.dataset.dir === dirId;
            cb.checked = match;
            if (match) item.classList.add('selected');
            else item.classList.remove('selected');
        });
        updatePanelState();
    };

    // Tout sélectionner / désélectionner (visibles)
    window.togglePanelAll = function () {
        _panelAllSelected = !_panelAllSelected;
        var items = document.querySelectorAll('.panel-emp-item');
        items.forEach(function (item) {
            if (item.style.display === 'none') return;
            var cb = item.querySelector('input[type="checkbox"]');
            if (!cb) return;
            cb.checked = _panelAllSelected;
            if (_panelAllSelected) item.classList.add('selected');
            else item.classList.remove('selected');
        });
        updatePanelAllBtn();
        updatePanelState();
    };

    function updatePanelAllBtn() {
        var btn = document.getElementById('btn-panel-all');
        if (!btn) return;
        btn.innerHTML = _panelAllSelected
            ? '<i class="fas fa-square"></i> Tout désélectionner'
            : '<i class="fas fa-check-square"></i> Tout sélectionner';
    }

    // Sync état case + highlight item
    window.updatePanelState = function () {
        var checked = 0;
        document.querySelectorAll('.panel-emp-item').forEach(function (item) {
            var cb = item.querySelector('input[type="checkbox"]');
            if (cb && cb.checked) {
                item.classList.add('selected');
                checked++;
            } else {
                item.classList.remove('selected');
            }
        });

        var badge  = document.getElementById('panel-badge');
        var submit = document.getElementById('btn-panel-submit');
        var label  = document.getElementById('btn-panel-label');

        if (badge) {
            badge.textContent = checked + ' sélectionné(s)';
            badge.style.display = checked > 0 ? '' : 'none';
        }

        if (submit) {
            submit.disabled = checked === 0;
        }

        if (label) {
            label.textContent = checked > 0
                ? 'Ajouter (' + checked + ')'
                : 'Ajouter';
        }

        _panelAllSelected = false;
        updatePanelAllBtn();
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
            closePanel();
        }
    });

})();
</script>
<?= $this->endSection() ?>