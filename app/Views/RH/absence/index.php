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
        --c-yellow-pale:   rgba(255,193,7,0.10);
        --c-yellow-border: rgba(255,193,7,0.30);
        --c-purple-pale:   rgba(155,89,182,0.10);
        --c-purple-border: rgba(155,89,182,0.25);
        --c-grey-pale:     rgba(180,180,180,0.08);
        --c-grey-border:   rgba(180,180,180,0.20);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    /* ===== STAT STRIP ===== */
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        margin-bottom: 18px;
    }

    .stat-pill {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: border-color 0.2s, transform 0.2s;
        cursor: default;
        min-width: 0;
    }

    .stat-pill:hover { border-color: rgba(255,255,255,0.12); transform: translateY(-2px); }

    .stat-pill-icon {
        width: 34px; height: 34px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0;
    }

    .sp-orange { background: var(--c-orange-pale);  color: var(--c-orange); }
    .sp-yellow { background: var(--c-yellow-pale);  color: #ffc107; }
    .sp-blue   { background: var(--c-blue-pale);    color: #5B9BF0; }
    .sp-green  { background: var(--c-green-pale);   color: #7ab86a; }
    .sp-red    { background: var(--c-red-pale);     color: #ff8080; }
    .sp-purple { background: var(--c-purple-pale);  color: #bb8fce; }

    .stat-pill-val   { font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
    .stat-pill-label { font-size: 0.65rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* ===== TABS ===== */
    .main-tabs {
        display: flex;
        gap: 4px;
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 12px;
        padding: 6px;
        margin-bottom: 16px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .main-tabs::-webkit-scrollbar { display: none; }

    .main-tab-btn {
        padding: 9px 20px; border-radius: 8px; border: none;
        background: transparent; color: var(--c-muted);
        font-size: 0.82rem; font-weight: 600; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 8px; white-space: nowrap; flex-shrink: 0;
    }

    .main-tab-btn:hover { color: var(--c-soft); background: rgba(255,255,255,0.03); }

    .main-tab-btn.active {
        background: var(--c-orange-pale);
        border: 1px solid var(--c-orange-border);
        color: var(--c-orange);
    }

    .main-tab-count {
        background: rgba(255,255,255,0.08); color: var(--c-muted);
        font-size: 0.65rem; font-weight: 700; padding: 1px 7px; border-radius: 10px;
    }

    .main-tab-btn.active .main-tab-count {
        background: var(--c-orange-border); color: var(--c-orange);
    }

    .main-tab-panel { display: none; }
    .main-tab-panel.active { display: block; }

    /* ===== FILTER PANEL ===== */
    .filter-panel {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; margin-bottom: 14px; overflow: hidden;
    }

    .filter-panel-head {
        padding: 11px 16px;
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; user-select: none; transition: background 0.2s;
    }

    .filter-panel-head:hover { background: rgba(255,255,255,0.02); }

    .filter-panel-head-left {
        display: flex; align-items: center; gap: 9px;
        color: var(--c-text); font-size: 0.82rem; font-weight: 600;
    }

    .filter-panel-head-left i { color: var(--c-orange); }

    .filter-badge {
        background: var(--c-orange); color: #111;
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
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto;
        gap: 10px; align-items: end; margin-bottom: 10px;
    }

    .filter-row-2 {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
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
    .filter-input:focus, .filter-select:focus { border-color: var(--c-orange-border); }
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
        font-size: 0.7rem; cursor: pointer; transition: all 0.2s;
        text-decoration: none; border: none; flex-shrink: 0;
    }

    .btn-icon-view   { background: var(--c-blue-pale);   color: #5B9BF0; border: 1px solid var(--c-blue-border); }
    .btn-icon-edit   { background: var(--c-orange-pale); color: var(--c-orange); border: 1px solid var(--c-orange-border); }
    .btn-icon-delete { background: var(--c-red-pale);    color: #ff8080; border: 1px solid var(--c-red-border); }
    .btn-icon:hover  { transform: scale(1.1); }

    /* ===== TABLE ===== */
    .table-wrapper {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; overflow: hidden;
    }

    .table-scroll-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
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

    .table-head-bar h6 i { color: var(--c-orange); }

    .abs-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; min-width: 700px; }

    .abs-table thead th {
        padding: 8px 14px; font-size: 0.67rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border); white-space: nowrap;
    }

    .abs-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .abs-table tbody tr:last-child td { border-bottom: none; }
    .abs-table tbody tr { transition: background 0.15s; }
    .abs-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    /* ===== IDENTITÉ EMPLOYÉ ===== */
    .emp-identity { display: flex; align-items: center; gap: 9px; }

    .emp-avatar {
        width: 30px; height: 30px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem; font-weight: 700; color: var(--c-orange);
        flex-shrink: 0; text-transform: uppercase;
    }

    .emp-name { color: #fff; font-weight: 600; font-size: 0.8rem; margin: 0; line-height: 1.2; }
    .emp-dir  { color: var(--c-muted); font-size: 0.68rem; margin-top: 1px; }

    /* ===== BADGES STATUT ===== */
    .badge-statut {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.67rem; font-weight: 700; white-space: nowrap;
    }

    .bs-attente      { background: var(--c-yellow-pale);  border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bs-valide-rh    { background: var(--c-blue-pale);    border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bs-rejete-rh    { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-approuve     { background: var(--c-green-pale);   border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bs-rejete       { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-expire       { background: var(--c-grey-pale);    border: 1px solid var(--c-grey-border);   color: rgba(255,255,255,0.4); }

    .statut-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }

    .badge-type {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-size: 0.67rem; font-weight: 600;
        padding: 2px 8px; border-radius: 20px; white-space: nowrap;
    }

    .badge-justif {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 20px;
        white-space: nowrap;
    }

    .bj-oui { background: var(--c-green-pale);      border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bj-non { background: var(--c-red-pale);        border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bj-na  { background: rgba(255,255,255,0.04);   border: 1px solid var(--c-border);        color: var(--c-muted); }

    .duree-pill {
        background: rgba(255,255,255,0.04); border: 1px solid var(--c-border);
        color: var(--c-soft); font-size: 0.72rem; font-weight: 600;
        padding: 2px 8px; border-radius: 6px; white-space: nowrap;
    }

    /* ===== NO RESULTS ===== */
    .no-results { display: none; }
    .no-results.visible { display: table-row; }

    /* ===== TABLE FOOT ===== */
    .table-foot {
        padding: 11px 16px; border-top: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 8px;
    }

    .table-foot-info { font-size: 0.73rem; color: var(--c-muted); }

    /* ===== ALERTES ===== */
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
        backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
        padding: 16px;
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #1e1e1e; border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px; padding: 26px; width: 100%; max-width: 380px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: modal-in 0.2s ease;
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

    /* ===== CARDS MOBILE (vue liste sur petits écrans) ===== */
    .abs-card-list { display: none; }

    .abs-card {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 10px; padding: 13px 14px; margin-bottom: 8px;
        transition: border-color 0.2s;
    }

    .abs-card:hover { border-color: rgba(245,166,35,0.2); }

    .abs-card-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 8px; margin-bottom: 10px;
    }

    .abs-card-meta { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 8px; }

    .abs-card-row {
        display: flex; align-items: center; justify-content: space-between;
        font-size: 0.75rem; color: var(--c-muted); margin-top: 6px;
    }

    .abs-card-actions {
        display: flex; gap: 6px; margin-top: 10px;
        padding-top: 10px; border-top: 1px solid var(--c-border);
    }

    .abs-card-actions .btn-icon { width: 32px; height: 32px; font-size: 0.75rem; }

    /* ===== RESPONSIVE ===== */

    /* Large desktop → tableau complet */
    @media (max-width: 1200px) {
        .stat-strip { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 992px) {
        .filter-row {
            grid-template-columns: 1fr 1fr 1fr;
        }
        .filter-row-2 {
            grid-template-columns: 1fr 1fr 1fr;
        }
        .stat-strip { grid-template-columns: repeat(3, 1fr); }
    }

    /* Tablette : on masque la table, on affiche les cards */
    @media (max-width: 768px) {
        .stat-strip { grid-template-columns: repeat(2, 1fr); }

        .stat-pill-val { font-size: 1.1rem; }

        .filter-row {
            grid-template-columns: 1fr 1fr;
        }
        .filter-row-2 {
            grid-template-columns: 1fr 1fr;
        }

        .abs-table-desktop { display: none; }
        .abs-card-list { display: block; }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .page-header .btn-orange { width: 100%; justify-content: center; }
    }

    @media (max-width: 576px) {
        .stat-strip { grid-template-columns: repeat(2, 1fr); gap: 7px; }
        .stat-pill { padding: 10px 10px; gap: 7px; }
        .stat-pill-icon { width: 28px; height: 28px; font-size: 0.72rem; }
        .stat-pill-val { font-size: 1rem; }

        .filter-row,
        .filter-row-2 {
            grid-template-columns: 1fr;
        }

        .main-tab-btn { padding: 8px 12px; font-size: 0.78rem; }

        .modal-box { padding: 18px; }
        .modal-btns { flex-direction: column; }
    }

    @media (max-width: 380px) {
        .stat-strip { grid-template-columns: repeat(2, 1fr); }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$idPfl = $idPfl ?? session()->get('id_Pfl');
$idEmp = $idEmp ?? session()->get('id_Emp');

$mesAbsences    = array_values(array_filter($absences, fn($a) => $a['id_Emp'] == $idEmp));
$toutesAbsences = $absences;

// ── Compteurs corrigés avec les bons statuts ──────────────────
$total          = count($toutesAbsences);
$enAttente      = count(array_filter($toutesAbsences, fn($a) => $a['Statut_Abs'] === 'en_attente'));
$valideRH       = count(array_filter($toutesAbsences, fn($a) => $a['Statut_Abs'] === 'valide_rh'));
$approuve       = count(array_filter($toutesAbsences, fn($a) => $a['Statut_Abs'] === 'approuve_chef'));
$rejetes        = count(array_filter($toutesAbsences, fn($a) => in_array($a['Statut_Abs'], ['rejete_rh','rejete_chef'])));

$db        = \Config\Database::connect();
$idsJustif = array_column(
    $db->table('piece_justificative')
       ->select('id_Abs')
       ->where('Statut_PJ', 'validee')
       ->groupBy('id_Abs')
       ->get()->getResultArray(),
    'id_Abs'
);
$justifiees = count(array_filter($toutesAbsences, fn($a) => in_array($a['id_Abs'], $idsJustif)));

// ── Statuts considérés comme "traités" (justifiée pertinente) ──
$statutsTraites = ['valide_rh', 'rejete_rh', 'approuve_chef', 'rejete_chef'];
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-times me-2" style="color:#F5A623;"></i>Absences</h1>
        <p><?= date('d/m/Y') ?></p>
    </div>
    <a href="<?= base_url('absence/create') ?>" class="btn-orange">
        <i class="fas fa-plus"></i> Déclarer une absence
    </a>
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

<!-- ── Stats ─────────────────────────────────────────────────── -->
<div class="stat-strip">
    <div class="stat-pill">
        <div class="stat-pill-icon sp-orange"><i class="fas fa-list"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-total">0</div>
            <div class="stat-pill-label">Total</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-yellow"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-attente">0</div>
            <div class="stat-pill-label">En attente</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-blue"><i class="fas fa-check"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-valide-rh">0</div>
            <div class="stat-pill-label">Validé RH</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-green"><i class="fas fa-check-double"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-approuve">0</div>
            <div class="stat-pill-label">Approuvé Chef</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-red"><i class="fas fa-times-circle"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-rejete">0</div>
            <div class="stat-pill-label">Rejetés</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-purple"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-justif">0</div>
            <div class="stat-pill-label">Justifiées</div>
        </div>
    </div>
</div>

<!-- ── Onglets ────────────────────────────────────────────────── -->
<div class="main-tabs">
    <button class="main-tab-btn active" onclick="switchMainTab('mes', this)">
        <i class="fas fa-user"></i>
        Mes absences
        <span class="main-tab-count"><?= count($mesAbsences) ?></span>
    </button>
    <?php if ($idPfl != 3): ?>
    <button class="main-tab-btn" onclick="switchMainTab('tous', this)">
        <i class="fas fa-users"></i>
        Toutes les absences
        <span class="main-tab-count"><?= count($toutesAbsences) ?></span>
    </button>
    <?php endif; ?>
</div>

<?php
// ══════════════════════════════════════════════════════════════
// HELPER : détermine si on peut modifier/supprimer (miroir peutModifier())
// ══════════════════════════════════════════════════════════════
function canEditAbsence(array $a, int $idEmp, int $idPfl): bool
{
    if ($a['id_Emp'] != $idEmp) return false;

    $statut = $a['Statut_Abs'];

    // Chef pour lui-même : modifiable si approuve_chef ET RH pas encore validé
    if ($idPfl == 2 && $statut === 'approuve_chef' && empty($a['id_Emp_ValidRH'])) {
        return true;
    }

    return $statut === 'en_attente';
}

// ══════════════════════════════════════════════════════════════
// HELPER : mapping badge statut
// ══════════════════════════════════════════════════════════════
function badgeStatut(string $statut): array
{
    return match($statut) {
        'en_attente'    => ['bs-attente',   'En attente',     '#ffc107'],
        'approuve_chef' => ['bs-approuve',  'Approuvé Chef',  '#7ab86a'],
        'rejete_chef'   => ['bs-rejete',    'Rejeté Chef',    '#ff8080'],
        'valide_rh'     => ['bs-valide-rh', 'Validé RH',      '#5B9BF0'],
        'rejete_rh'     => ['bs-rejete-rh', 'Rejeté RH',      '#ff8080'],
        'expire'        => ['bs-expire',    'Expiré',         'rgba(255,255,255,0.3)'],
        default         => ['bs-attente',    $statut,          '#ffc107'],
    };
}

// ══════════════════════════════════════════════════════════════
// FUNCTION PRINCIPALE : rendu tableau + cards
// ══════════════════════════════════════════════════════════════
function renderAbsenceTable(
    array $rows,
    string $prefix,
    int $idPfl,
    int $idEmp,
    array $typesAbsence,
    array $directions,
    array $idsJustif,
    array $statutsTraites
): void {
    $isTous  = ($prefix === 'tous');
    $colspan = ($isTous && $idPfl != 3) ? 11 : 10;
?>

<!-- ── Filtres ──────────────────────────────────────────────── -->
<div class="filter-panel">
    <div class="filter-panel-head" onclick="toggleFilters_<?= $prefix ?>()">
        <div class="filter-panel-head-left">
            <i class="fas fa-sliders-h"></i>
            Filtres
            <span class="filter-badge" id="<?= $prefix ?>-filter-badge">0</span>
        </div>
        <i class="fas fa-chevron-down filter-chevron open" id="<?= $prefix ?>-filter-chevron"></i>
    </div>
    <div class="filter-body open" id="<?= $prefix ?>-filter-body">
        <div class="filter-row">
            <div class="filter-group">
                <div class="filter-label">Recherche</div>
                <div class="filter-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" class="filter-input" id="<?= $prefix ?>-f-search"
                           placeholder="Nom, motif...">
                </div>
            </div>
            <div class="filter-group">
                <div class="filter-label">Statut</div>
                <select class="filter-select" id="<?= $prefix ?>-f-statut">
                    <option value="">Tous</option>
                    <option value="en_attente">En attente</option>
                    <option value="approuve_chef">Approuvé Chef</option>
                    <option value="rejete_chef">Rejeté Chef</option>
                    <option value="valide_rh">Validé RH</option>
                    <option value="rejete_rh">Rejeté RH</option>
                    <option value="expire">Expiré</option>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Type d'absence</div>
                <select class="filter-select" id="<?= $prefix ?>-f-type">
                    <option value="">Tous</option>
                    <?php foreach ($typesAbsence as $ta): ?>
                    <option value="<?= esc($ta['Libelle_TAbs']) ?>">
                        <?= esc($ta['Libelle_TAbs']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($isTous && $idPfl == 1): ?>
            <div class="filter-group">
                <div class="filter-label">Direction</div>
                <select class="filter-select" id="<?= $prefix ?>-f-dir">
                    <option value="">Toutes</option>
                    <?php foreach ($directions as $dir): ?>
                    <option value="<?= esc($dir['Nom_Dir']) ?>"><?= esc($dir['Nom_Dir']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php else: ?>
            <div><input type="hidden" id="<?= $prefix ?>-f-dir" value=""></div>
            <?php endif; ?>
            <div class="filter-group">
                <div class="filter-label">Justifiée</div>
                <select class="filter-select" id="<?= $prefix ?>-f-justif">
                    <option value="">Toutes</option>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">&nbsp;</div>
                <button type="button" class="btn-reset" id="<?= $prefix ?>-btn-reset"
                        onclick="resetFilters_<?= $prefix ?>()">
                    <i class="fas fa-times"></i> Effacer
                </button>
            </div>
        </div>
        <div class="filter-row-2">
            <div class="filter-group">
                <div class="filter-label">Début — du</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-debut-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Début — au</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-debut-to">
            </div>
            <div class="filter-group">
                <div class="filter-label">Fin — du</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-fin-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Fin — au</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-fin-to">
            </div>
            <div class="filter-group">
                <div class="filter-label">Demande — du</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-demande-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Demande — au</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-demande-to">
            </div>
        </div>
    </div>
</div>

<!-- ── Table desktop ─────────────────────────────────────────── -->
<div class="table-wrapper abs-table-desktop">
    <div class="table-head-bar">
        <h6>
            <i class="fas fa-table"></i>
            <?= $isTous ? 'Toutes les absences' : 'Mes absences' ?>
        </h6>
        <span class="table-foot-info" id="<?= $prefix ?>-count-label">
            <strong style="color:var(--c-soft);"><?= count($rows) ?></strong> absence(s)
        </span>
    </div>
    <div class="table-scroll-wrap">
        <table class="abs-table">
            <thead>
                <tr>
                    <th>#</th>
                    <?php if ($isTous && $idPfl != 3): ?><th>Employé</th><?php endif; ?>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Durée</th>
                    <th>Motif</th>
                    <th>Demande</th>
                    <th>Justifiée</th>
                    <th>Statut</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="<?= $prefix ?>-tbody">
                <?php foreach ($rows as $i => $a):
                    $debut     = $a['DateDebut_Abs'];
                    $fin       = $a['DateFin_Abs'];
                    $statut    = $a['Statut_Abs'] ?? 'en_attente';
                    $estJustif = in_array($a['id_Abs'], $idsJustif);
                    $estTraite = in_array($statut, $statutsTraites);

                    $nbJours = '-';
                    if ($debut && $fin) {
                        $nbJours = (new \DateTime($debut))->diff(new \DateTime($fin))->days + 1;
                    }

                    [$bsCls, $bsLabel, $bsDot] = badgeStatut($statut);

                    // ── Droits modification corrigés ──
                    $canEdit   = canEditAbsence($a, $idEmp, $idPfl);
                    $canDelete = $canEdit;

                    $motif = !empty($a['Motif_Abs'])
                        ? $a['Motif_Abs']
                        : (!empty($a['Rapport_Abs']) ? $a['Rapport_Abs'] : '');
                ?>
                <tr class="<?= $prefix ?>-row"
                    data-nom="<?= strtolower(esc(($a['Nom_Emp'] ?? '') . ' ' . ($a['Prenom_Emp'] ?? ''))) ?>"
                    data-motif="<?= strtolower(esc($motif)) ?>"
                    data-statut="<?= esc($statut) ?>"
                    data-type="<?= esc($a['Libelle_TAbs'] ?? '') ?>"
                    data-dir="<?= esc($a['Nom_Dir'] ?? '') ?>"
                    data-justif="<?= $estJustif ? '1' : '0' ?>"
                    data-debut="<?= $debut ?>"
                    data-fin="<?= $fin ?? '' ?>"
                    data-demande="<?= $a['DateDemande_Abs'] ?>"
                >
                    <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;width:32px;"><?= $i + 1 ?></td>

                    <?php if ($isTous && $idPfl != 3): ?>
                    <td>
                        <div class="emp-identity">
                            <div class="emp-avatar">
                                <?= mb_substr($a['Nom_Emp'] ?? '?', 0, 1) . mb_substr($a['Prenom_Emp'] ?? '', 0, 1) ?>
                            </div>
                            <div>
                                <p class="emp-name"><?= esc(($a['Nom_Emp'] ?? '') . ' ' . ($a['Prenom_Emp'] ?? '')) ?></p>
                                <?php if (!empty($a['Nom_Dir'])): ?>
                                <div class="emp-dir"><?= esc($a['Nom_Dir']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <?php endif; ?>

                    <td>
                        <?php if (!empty($a['Libelle_TAbs'])): ?>
                        <span class="badge-type"><?= esc($a['Libelle_TAbs']) ?></span>
                        <?php else: ?>
                        <span style="color:var(--c-muted);">-</span>
                        <?php endif; ?>
                    </td>

                    <td><?= $debut ? date('d/m/Y', strtotime($debut)) : '-' ?></td>

                    <td><?= $fin ? date('d/m/Y', strtotime($fin)) : '<span style="color:var(--c-muted);">-</span>' ?></td>

                    <td>
                        <?php if ($nbJours !== '-'): ?>
                        <span class="duree-pill"><?= $nbJours ?> j</span>
                        <?php else: ?>
                        <span style="color:var(--c-muted);">-</span>
                        <?php endif; ?>
                    </td>

                    <td style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--c-soft);">
                        <?= !empty($motif)
                            ? esc(mb_substr($motif, 0, 50)) . (mb_strlen($motif) > 50 ? '…' : '')
                            : '<span style="color:var(--c-muted);">-</span>' ?>
                    </td>

                    <td style="color:var(--c-muted);font-size:0.75rem;">
                        <?= ($a['DateDemande_Abs'] && $a['DateDemande_Abs'] !== '0000-00-00')
                            ? date('d/m/Y', strtotime($a['DateDemande_Abs']))
                            : '<span style="color:var(--c-muted);">-</span>' ?>
                    </td>

                    <td>
                        <?php if ($estTraite): ?>
                            <span class="badge-justif <?= $estJustif ? 'bj-oui' : 'bj-non' ?>">
                                <i class="fas <?= $estJustif ? 'fa-check' : 'fa-times' ?>"></i>
                                <?= $estJustif ? 'Oui' : 'Non' ?>
                            </span>
                        <?php else: ?>
                            <span class="badge-justif bj-na">—</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="badge-statut <?= $bsCls ?>">
                            <span class="statut-dot" style="background:<?= $bsDot ?>;"></span>
                            <?= $bsLabel ?>
                        </span>
                    </td>

                    <td style="text-align:center;">
                        <div style="display:inline-flex;align-items:center;gap:5px;">
                            <a href="<?= base_url('absence/show/' . $a['id_Abs']) ?>"
                               class="btn-icon btn-icon-view" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($canEdit): ?>
                            <a href="<?= base_url('absence/edit/' . $a['id_Abs']) ?>"
                               class="btn-icon btn-icon-edit" title="Modifier">
                                <i class="fas fa-pen"></i>
                            </a>
                            <?php endif; ?>
                            <?php if ($canDelete): ?>
                            <button class="btn-icon btn-icon-delete" title="Supprimer"
                                    onclick="confirmDelete(<?= (int)$a['id_Abs'] ?>, '<?= esc($a['Libelle_TAbs'] ?? 'cette absence', 'js') ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tr class="no-results" id="<?= $prefix ?>-no-results">
                    <td colspan="<?= $colspan ?>">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:28px 0;">
                            <i class="fas fa-search" style="font-size:1.4rem;color:var(--c-muted);opacity:0.4;"></i>
                            <span style="color:var(--c-muted);font-size:0.82rem;">Aucune absence ne correspond aux filtres.</span>
                            <button onclick="resetFilters_<?= $prefix ?>()"
                                    style="background:transparent;border:1px solid var(--c-orange-border);color:var(--c-orange);border-radius:7px;padding:5px 12px;font-size:0.75rem;cursor:pointer;">
                                <i class="fas fa-times"></i> Effacer les filtres
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-foot">
        <span class="table-foot-info" id="<?= $prefix ?>-footer-count">
            <?= count($rows) ?> absence(s) affichée(s)
        </span>
    </div>
</div>

<!-- ── Cards mobile ──────────────────────────────────────────── -->
<div class="abs-card-list" id="<?= $prefix ?>-card-list">
    <?php foreach ($rows as $i => $a):
        $debut     = $a['DateDebut_Abs'];
        $fin       = $a['DateFin_Abs'];
        $statut    = $a['Statut_Abs'] ?? 'en_attente';
        $estJustif = in_array($a['id_Abs'], $idsJustif);
        $estTraite = in_array($statut, $statutsTraites);

        $nbJours = '-';
        if ($debut && $fin) {
            $nbJours = (new \DateTime($debut))->diff(new \DateTime($fin))->days + 1;
        }

        [$bsCls, $bsLabel, $bsDot] = badgeStatut($statut);

        $canEdit   = canEditAbsence($a, $idEmp, $idPfl);
        $canDelete = $canEdit;

        $motif = !empty($a['Motif_Abs'])
            ? $a['Motif_Abs']
            : (!empty($a['Rapport_Abs']) ? $a['Rapport_Abs'] : '');
    ?>
    <div class="abs-card <?= $prefix ?>-card"
         data-nom="<?= strtolower(esc(($a['Nom_Emp'] ?? '') . ' ' . ($a['Prenom_Emp'] ?? ''))) ?>"
         data-motif="<?= strtolower(esc($motif)) ?>"
         data-statut="<?= esc($statut) ?>"
         data-type="<?= esc($a['Libelle_TAbs'] ?? '') ?>"
         data-dir="<?= esc($a['Nom_Dir'] ?? '') ?>"
         data-justif="<?= $estJustif ? '1' : '0' ?>"
         data-debut="<?= $debut ?>"
         data-fin="<?= $fin ?? '' ?>"
         data-demande="<?= $a['DateDemande_Abs'] ?>"
    >
        <div class="abs-card-header">
            <div>
                <?php if ($isTous && $idPfl != 3): ?>
                <div class="emp-identity" style="margin-bottom:6px;">
                    <div class="emp-avatar">
                        <?= mb_substr($a['Nom_Emp'] ?? '?', 0, 1) . mb_substr($a['Prenom_Emp'] ?? '', 0, 1) ?>
                    </div>
                    <div>
                        <p class="emp-name"><?= esc(($a['Nom_Emp'] ?? '') . ' ' . ($a['Prenom_Emp'] ?? '')) ?></p>
                        <?php if (!empty($a['Nom_Dir'])): ?>
                        <div class="emp-dir"><?= esc($a['Nom_Dir']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($a['Libelle_TAbs'])): ?>
                <span class="badge-type"><?= esc($a['Libelle_TAbs']) ?></span>
                <?php endif; ?>
            </div>
            <span class="badge-statut <?= $bsCls ?>">
                <span class="statut-dot" style="background:<?= $bsDot ?>;"></span>
                <?= $bsLabel ?>
            </span>
        </div>

        <div class="abs-card-meta">
            <span style="font-size:0.78rem;color:var(--c-soft);">
                <i class="fas fa-calendar" style="color:var(--c-orange);margin-right:4px;"></i>
                <?= $debut ? date('d/m/Y', strtotime($debut)) : '-' ?>
                <?php if ($fin): ?>
                → <?= date('d/m/Y', strtotime($fin)) ?>
                <?php endif; ?>
            </span>
            <?php if ($nbJours !== '-'): ?>
            <span class="duree-pill"><?= $nbJours ?> j</span>
            <?php endif; ?>
        </div>

        <?php if (!empty($motif)): ?>
        <div style="font-size:0.76rem;color:var(--c-muted);margin-bottom:4px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
            <i class="fas fa-align-left" style="margin-right:4px;"></i>
            <?= esc(mb_substr($motif, 0, 60)) . (mb_strlen($motif) > 60 ? '…' : '') ?>
        </div>
        <?php endif; ?>

        <div class="abs-card-row">
            <span>Demande : <?= ($a['DateDemande_Abs'] && $a['DateDemande_Abs'] !== '0000-00-00') ? date('d/m/Y', strtotime($a['DateDemande_Abs'])) : '-' ?></span>
            <?php if ($estTraite): ?>
            <span class="badge-justif <?= $estJustif ? 'bj-oui' : 'bj-non' ?>" style="font-size:0.62rem;">
                <i class="fas <?= $estJustif ? 'fa-check' : 'fa-times' ?>"></i>
                <?= $estJustif ? 'Justifiée' : 'Non justifiée' ?>
            </span>
            <?php endif; ?>
        </div>

        <div class="abs-card-actions">
            <a href="<?= base_url('absence/show/' . $a['id_Abs']) ?>"
               class="btn-icon btn-icon-view" title="Voir" style="flex:1;justify-content:center;">
                <i class="fas fa-eye"></i>
            </a>
            <?php if ($canEdit): ?>
            <a href="<?= base_url('absence/edit/' . $a['id_Abs']) ?>"
               class="btn-icon btn-icon-edit" title="Modifier" style="flex:1;justify-content:center;">
                <i class="fas fa-pen"></i>
            </a>
            <?php endif; ?>
            <?php if ($canDelete): ?>
            <button class="btn-icon btn-icon-delete" title="Supprimer"
                    onclick="confirmDelete(<?= (int)$a['id_Abs'] ?>, '<?= esc($a['Libelle_TAbs'] ?? 'cette absence', 'js') ?>')"
                    style="flex:1;justify-content:center;">
                <i class="fas fa-trash-alt"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- No results mobile -->
    <div class="no-results" id="<?= $prefix ?>-no-results-card"
         style="background:var(--c-surface);border:1px solid var(--c-border);border-radius:10px;padding:28px 16px;text-align:center;">
        <i class="fas fa-search" style="font-size:1.4rem;color:var(--c-muted);opacity:0.4;display:block;margin-bottom:8px;"></i>
        <span style="color:var(--c-muted);font-size:0.82rem;">Aucune absence ne correspond aux filtres.</span><br>
        <button onclick="resetFilters_<?= $prefix ?>()"
                style="margin-top:10px;background:transparent;border:1px solid var(--c-orange-border);color:var(--c-orange);border-radius:7px;padding:5px 12px;font-size:0.75rem;cursor:pointer;">
            <i class="fas fa-times"></i> Effacer les filtres
        </button>
    </div>

    <div class="table-foot" style="background:var(--c-surface);border:1px solid var(--c-border);border-radius:10px;margin-top:4px;">
        <span class="table-foot-info" id="<?= $prefix ?>-footer-count-card">
            <?= count($rows) ?> absence(s) affichée(s)
        </span>
    </div>
</div>

<?php
} // end renderAbsenceTable
?>

<!-- ── Panels onglets ─────────────────────────────────────────── -->
<div class="main-tab-panel active" id="panel-mes">
    <?php renderAbsenceTable($mesAbsences, 'mes', $idPfl, $idEmp, $typesAbsence, $directions, $idsJustif, $statutsTraites); ?>
</div>

<?php if ($idPfl != 3): ?>
<div class="main-tab-panel" id="panel-tous">
    <?php renderAbsenceTable($toutesAbsences, 'tous', $idPfl, $idEmp, $typesAbsence, $directions, $idsJustif, $statutsTraites); ?>
</div>
<?php endif; ?>

<!-- ── Modal suppression ─────────────────────────────────────── -->
<div class="modal-overlay" id="modal-delete">
    <div class="modal-box">
        <div style="width:46px;height:46px;border-radius:12px;background:var(--c-red-pale);border:1px solid var(--c-red-border);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 style="color:#fff;font-size:0.9rem;font-weight:700;text-align:center;margin-bottom:8px;">Confirmer la suppression</h5>
        <p style="color:var(--c-muted);font-size:0.8rem;text-align:center;line-height:1.5;margin:0;">
            Vous allez supprimer :<br>
            <strong id="modal-abs-label" style="color:var(--c-soft);"></strong>
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

<form id="form-delete" method="POST" style="display:none;">
    <?= csrf_field() ?>
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    // ── Compteurs animés ─────────────────────────────────────
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

    animCount('cnt-total',     <?= (int)$total ?>);
    animCount('cnt-attente',   <?= (int)$enAttente ?>);
    animCount('cnt-valide-rh', <?= (int)$valideRH ?>);
    animCount('cnt-approuve',  <?= (int)$approuve ?>);
    animCount('cnt-rejete',    <?= (int)$rejetes ?>);
    animCount('cnt-justif',    <?= (int)$justifiees ?>);

    // ── Switch onglet ────────────────────────────────────────
    window.switchMainTab = function (tab, btn) {
        document.querySelectorAll('.main-tab-panel').forEach(function (p) { p.classList.remove('active'); });
        document.querySelectorAll('.main-tab-btn').forEach(function (b)   { b.classList.remove('active'); });
        document.getElementById('panel-' + tab).classList.add('active');
        btn.classList.add('active');
    };

    // ── Toggle filtres ───────────────────────────────────────
    window.toggleFilters_mes = function () {
        document.getElementById('mes-filter-body').classList.toggle('open');
        document.getElementById('mes-filter-chevron').classList.toggle('open');
    };

    <?php if ($idPfl != 3): ?>
    window.toggleFilters_tous = function () {
        document.getElementById('tous-filter-body').classList.toggle('open');
        document.getElementById('tous-filter-chevron').classList.toggle('open');
    };
    <?php endif; ?>

    // ── Factory filtres ──────────────────────────────────────
    function buildFilter(prefix) {
        // Cibles desktop (rows tableau)
        var rows         = document.querySelectorAll('.' + prefix + '-row');
        // Cibles mobile (cards)
        var cards        = document.querySelectorAll('.' + prefix + '-card');
        var noResult     = document.getElementById(prefix + '-no-results');
        var noResultCard = document.getElementById(prefix + '-no-results-card');
        var badge        = document.getElementById(prefix + '-filter-badge');
        var btnReset     = document.getElementById(prefix + '-btn-reset');
        var footCount    = document.getElementById(prefix + '-footer-count');
        var footCountCard= document.getElementById(prefix + '-footer-count-card');
        var countLbl     = document.getElementById(prefix + '-count-label');

        var filterIds = [
            prefix + '-f-search',
            prefix + '-f-statut',
            prefix + '-f-type',
            prefix + '-f-dir',
            prefix + '-f-justif',
            prefix + '-f-debut-from',
            prefix + '-f-debut-to',
            prefix + '-f-fin-from',
            prefix + '-f-fin-to',
            prefix + '-f-demande-from',
            prefix + '-f-demande-to'
        ];

        function getVal(id) {
            var el = document.getElementById(id);
            return el ? el.value : '';
        }

        function matchRow(dataset) {
            var search      = getVal(prefix + '-f-search').trim().toLowerCase();
            var statut      = getVal(prefix + '-f-statut');
            var type        = getVal(prefix + '-f-type');
            var dir         = getVal(prefix + '-f-dir');
            var justif      = getVal(prefix + '-f-justif');
            var debutFrom   = getVal(prefix + '-f-debut-from');
            var debutTo     = getVal(prefix + '-f-debut-to');
            var finFrom     = getVal(prefix + '-f-fin-from');
            var finTo       = getVal(prefix + '-f-fin-to');
            var demandeFrom = getVal(prefix + '-f-demande-from');
            var demandeTo   = getVal(prefix + '-f-demande-to');

            var debut   = dataset.debut;
            var fin     = dataset.fin;
            var demande = dataset.demande;

            return (
                (search      === '' || dataset.nom.includes(search) || dataset.motif.includes(search)) &&
                (statut      === '' || dataset.statut === statut) &&
                (type        === '' || dataset.type   === type) &&
                (dir         === '' || dataset.dir    === dir) &&
                (justif      === '' || dataset.justif === justif) &&
                (debutFrom   === '' || debut   >= debutFrom) &&
                (debutTo     === '' || debut   <= debutTo) &&
                (finFrom     === '' || fin     >= finFrom) &&
                (finTo       === '' || fin     <= finTo) &&
                (demandeFrom === '' || demande >= demandeFrom) &&
                (demandeTo   === '' || demande <= demandeTo)
            );
        }

        function applyFilters() {
            var search      = getVal(prefix + '-f-search').trim();
            var statut      = getVal(prefix + '-f-statut');
            var type        = getVal(prefix + '-f-type');
            var dir         = getVal(prefix + '-f-dir');
            var justif      = getVal(prefix + '-f-justif');
            var debutFrom   = getVal(prefix + '-f-debut-from');
            var debutTo     = getVal(prefix + '-f-debut-to');
            var finFrom     = getVal(prefix + '-f-fin-from');
            var finTo       = getVal(prefix + '-f-fin-to');
            var demandeFrom = getVal(prefix + '-f-demande-from');
            var demandeTo   = getVal(prefix + '-f-demande-to');

            var actifs = [search, statut, type, dir, justif,
                          debutFrom, debutTo, finFrom, finTo, demandeFrom, demandeTo]
                .filter(function (v) { return v !== ''; }).length;

            badge.textContent = actifs;
            actifs > 0 ? badge.classList.add('visible')    : badge.classList.remove('visible');
            actifs > 0 ? btnReset.classList.add('visible') : btnReset.classList.remove('visible');

            var visible = 0;

            // Filtrer les lignes du tableau desktop
            rows.forEach(function (row) {
                var ok = matchRow(row.dataset);
                if (ok) {
                    row.style.display = '';
                    visible++;
                    var numCell = row.querySelector('.row-num');
                    if (numCell) numCell.textContent = visible;
                } else {
                    row.style.display = 'none';
                }
            });

            // Filtrer les cards mobile (même logique)
            var visibleCards = 0;
            cards.forEach(function (card) {
                var ok = matchRow(card.dataset);
                if (ok) {
                    card.style.display = '';
                    visibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            // No results desktop
            if (noResult) noResult.classList.toggle('visible', visible === 0);
            // No results mobile
            if (noResultCard) noResultCard.classList.toggle('visible', visibleCards === 0);

            if (footCount)     footCount.textContent     = visible + ' absence(s) affichée(s)';
            if (footCountCard) footCountCard.textContent = visibleCards + ' absence(s) affichée(s)';
            if (countLbl)      countLbl.innerHTML = '<strong style="color:rgba(255,255,255,0.55);">' + visible + '</strong> absence(s)';
        }

        window['resetFilters_' + prefix] = function () {
            filterIds.forEach(function (id) {
                var el = document.getElementById(id);
                if (el) el.value = '';
            });
            applyFilters();
        };

        filterIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) {
                el.addEventListener('input',  applyFilters);
                el.addEventListener('change', applyFilters);
            }
        });
    }

    buildFilter('mes');
    <?php if ($idPfl != 3): ?>
    buildFilter('tous');
    <?php endif; ?>

    // ── Modal suppression ────────────────────────────────────
    var deleteUrl = '';

    window.confirmDelete = function (id, label) {
        document.getElementById('modal-abs-label').textContent = label;
        deleteUrl = '<?= base_url('absence/delete/') ?>' + id;
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

    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('modal-delete');
        var form  = document.getElementById('form-delete');
        if (modal) document.body.appendChild(modal);
        if (form)  document.body.appendChild(form);
    });

})();
</script>
<?= $this->endSection() ?>