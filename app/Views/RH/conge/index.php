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
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    /* ===== STATS ===== */
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        margin-bottom: 18px;
    }

    .stat-pill {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 10px; padding: 12px 14px;
        display: flex; align-items: center; gap: 10px;
        transition: border-color 0.2s, transform 0.2s; cursor: default;
    }

    .stat-pill:hover { border-color: rgba(255,255,255,0.12); transform: translateY(-2px); }

    .stat-pill-icon {
        width: 34px; height: 34px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0;
    }

    .sp-orange { background: var(--c-orange-pale);       color: var(--c-orange); }
    .sp-yellow { background: var(--c-yellow-pale);       color: #ffc107; }
    .sp-blue   { background: var(--c-blue-pale);         color: #5B9BF0; }
    .sp-green  { background: var(--c-green-pale);        color: #7ab86a; }
    .sp-red    { background: var(--c-red-pale);          color: #ff8080; }
    .sp-grey   { background: rgba(150,150,150,0.10);     color: #888; }

    .stat-pill-val   { font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
    .stat-pill-label { font-size: 0.68rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

    /* ===== SOLDE BANNER ===== */
    .solde-banner {
        background: var(--c-surface);
        border: 1px solid var(--c-orange-border);
        border-radius: 10px; padding: 12px 18px;
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 14px; flex-wrap: wrap;
    }

    .solde-banner-title { font-size: 0.72rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; }
    .solde-banner-val   { font-size: 1.4rem; font-weight: 900; color: var(--c-orange); line-height: 1; }
    .solde-sep          { width: 1px; height: 36px; background: var(--c-border); flex-shrink: 0; }

    /* ===== ONGLETS PRINCIPAUX ===== */
    .main-tabs {
        display: flex; gap: 4px;
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 12px; padding: 6px;
        margin-bottom: 16px; flex-wrap: wrap;
    }

    .main-tab-btn {
        padding: 9px 20px; border-radius: 8px; border: none;
        background: transparent; color: var(--c-muted);
        font-size: 0.82rem; font-weight: 600; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;
        white-space: nowrap;
    }

    .main-tab-btn:hover { color: var(--c-soft); background: rgba(255,255,255,0.03); }

    .main-tab-btn.active {
        background: var(--c-orange-pale);
        border: 1px solid var(--c-orange-border);
        color: var(--c-orange);
    }

    .main-tab-count {
        background: rgba(255,255,255,0.08); color: var(--c-muted);
        font-size: 0.65rem; font-weight: 700;
        padding: 1px 7px; border-radius: 10px;
    }

    .main-tab-btn.active .main-tab-count {
        background: var(--c-orange-border); color: var(--c-orange);
    }

    .main-tab-panel { display: none; }
    .main-tab-panel.active { display: block; }

    /* ===== FILTRES ===== */
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
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
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

    .table-head-bar h6 i { color: var(--c-orange); }

    .conge-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .conge-table thead th {
        padding: 8px 14px; font-size: 0.67rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border); white-space: nowrap;
    }

    .conge-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .conge-table tbody tr:last-child td { border-bottom: none; }
    .conge-table tbody tr { transition: background 0.15s; }
    .conge-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    /* ===== IDENTITE ===== */
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

    /* ===== BADGES ===== */
    .badge-statut {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.67rem; font-weight: 700; white-space: nowrap;
    }

    .bs-attente       { background: var(--c-yellow-pale);       border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bs-approuve-chef { background: var(--c-blue-pale);         border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bs-rejete-chef   { background: var(--c-red-pale);          border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-valide-rh     { background: var(--c-green-pale);        border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bs-rejete-rh     { background: var(--c-red-pale);          border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-expire        { background: rgba(150,150,150,0.10);     border: 1px solid rgba(150,150,150,0.25); color: #888; }

    .statut-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }

    .badge-type {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-size: 0.67rem; font-weight: 600;
        padding: 2px 8px; border-radius: 20px; white-space: nowrap;
    }

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

    /* ===== MODAL SUPPRESSION ===== */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.65); z-index: 1040;
        backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
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

    .btn-cancel-modal:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .btn-danger {
        background: linear-gradient(135deg, #c0392b, #922b21);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }

    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(192,57,43,0.35); }

    @media (max-width: 992px) {
        .stat-strip   { grid-template-columns: repeat(3, 1fr); }
        .filter-row   { grid-template-columns: 1fr 1fr 1fr; }
        .filter-row-2 { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
        .filter-row   { grid-template-columns: 1fr 1fr; }
        .filter-row-2 { grid-template-columns: 1fr 1fr; }
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .conge-table   { min-width: 650px; }
        .solde-banner  { gap: 10px; }
        .solde-sep     { display: none; }
        .page-header   { flex-direction: column; align-items: flex-start; gap: 10px; }
    }

    @media (max-width: 576px) {
        .stat-strip   { grid-template-columns: repeat(2, 1fr); }
        .filter-row   { grid-template-columns: 1fr; }
        .filter-row-2 { grid-template-columns: 1fr; }
        .conge-table thead th:nth-child(7), .conge-table tbody td:nth-child(7) { display: none; }
        .conge-table thead th:nth-child(8), .conge-table tbody td:nth-child(8) { display: none; }
        .conge-table { min-width: 420px; }
        .main-tabs    { flex-direction: column; }
        .main-tab-btn { width: 100%; justify-content: space-between; }
    }

</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$idPfl = $idPfl ?? session()->get('id_Pfl');
$idEmp = $idEmp ?? session()->get('id_Emp');

$mesConges  = array_values(array_filter($conges, fn($c) => $c['id_Emp'] == $idEmp));
$tousConges = $conges;

// Stats globales
$total        = count($tousConges);
$enAttente    = count(array_filter($tousConges, fn($c) => $c['Statut_Cge'] === 'en_attente'));
$approuveChef = count(array_filter($tousConges, fn($c) => $c['Statut_Cge'] === 'approuve_chef'));
$valideRH     = count(array_filter($tousConges, fn($c) => $c['Statut_Cge'] === 'valide_rh'));
$rejetes      = count(array_filter($tousConges, fn($c) => in_array($c['Statut_Cge'], ['rejete_chef', 'rejete_rh'])));
$expires      = count(array_filter($tousConges, fn($c) => $c['Statut_Cge'] === 'expire'));

// Solde
$solde = null;
$db    = \Config\Database::connect();
$solde = $db->table('solde_conge')
            ->where('id_Emp', $idEmp)
            ->where('Annee_Sld', date('Y'))
            ->get()->getRowArray();

// Helper peutModifier (cohérent avec le contrôleur)
function peutModifierConge(array $c, int $idEmp, int $idPfl): bool
{
    if ($c['id_Emp'] != $idEmp) return false;
    $s = $c['Statut_Cge'];
    // Chef sur sa propre demande auto-approuvée, RH pas encore agi
    if ($idPfl == 2 && $s === 'approuve_chef' && empty($c['id_Emp_ValidRH'])) return true;
    return $s === 'en_attente';
}
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-umbrella-beach me-2" style="color:#F5A623;"></i>Congés</h1>
        <p><?= date('d/m/Y') ?></p>
    </div>
    <a href="<?= base_url('conge/create') ?>" class="btn-orange">
        <i class="fas fa-plus"></i> Nouvelle demande
    </a>
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

<!-- Solde -->
<?php if ($solde): ?>
<div class="solde-banner">
    <div>
        <div class="solde-banner-title">Mon solde <?= date('Y') ?></div>
        <div class="solde-banner-val">
            <?= (int)$solde['NbJoursDroit_Sld'] - (int)$solde['NbJoursPris_Sld'] ?>
            <span style="font-size:0.8rem;font-weight:500;color:var(--c-muted);">jours restants</span>
        </div>
    </div>
    <div class="solde-sep"></div>
    <div>
        <div class="solde-banner-title">Pris</div>
        <div style="font-size:1.1rem;font-weight:700;color:var(--c-soft);"><?= (int)$solde['NbJoursPris_Sld'] ?></div>
    </div>
    <div class="solde-sep"></div>
    <div>
        <div class="solde-banner-title">Droit total</div>
        <div style="font-size:1.1rem;font-weight:700;color:var(--c-soft);"><?= (int)$solde['NbJoursDroit_Sld'] ?></div>
    </div>
    <?php $pct = $solde['NbJoursDroit_Sld'] > 0
        ? round(($solde['NbJoursPris_Sld'] / $solde['NbJoursDroit_Sld']) * 100) : 0; ?>
    <div style="flex:1;min-width:120px;">
        <div style="display:flex;justify-content:space-between;font-size:0.68rem;color:var(--c-muted);margin-bottom:5px;">
            <span>Consommation</span><span><?= $pct ?>%</span>
        </div>
        <div style="height:5px;background:rgba(255,255,255,0.06);border-radius:3px;overflow:hidden;">
            <div style="height:100%;width:<?= $pct ?>%;background:linear-gradient(90deg,var(--c-orange),#d4891a);border-radius:3px;"></div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Stats — 6 pills -->
<div class="stat-strip">
    <div class="stat-pill">
        <div class="stat-pill-icon sp-orange"><i class="fas fa-list"></i></div>
        <div><div class="stat-pill-val" id="cnt-total">0</div><div class="stat-pill-label">Total</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-yellow"><i class="fas fa-clock"></i></div>
        <div><div class="stat-pill-val" id="cnt-attente">0</div><div class="stat-pill-label">En attente</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-blue"><i class="fas fa-user-check"></i></div>
        <div><div class="stat-pill-val" id="cnt-chef">0</div><div class="stat-pill-label">Approuvé Chef</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-green"><i class="fas fa-check-double"></i></div>
        <div><div class="stat-pill-val" id="cnt-valide">0</div><div class="stat-pill-label">Validé RH</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-red"><i class="fas fa-times-circle"></i></div>
        <div><div class="stat-pill-val" id="cnt-rejete">0</div><div class="stat-pill-label">Rejetés</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-grey"><i class="fas fa-hourglass-end"></i></div>
        <div><div class="stat-pill-val" id="cnt-expire">0</div><div class="stat-pill-label">Expirés</div></div>
    </div>
</div>

<!-- Onglets -->
<div class="main-tabs">
    <button class="main-tab-btn active" id="tab-btn-mes" onclick="switchMainTab('mes', this)">
        <i class="fas fa-user"></i> Mes demandes
        <span class="main-tab-count" id="cnt-mes-tab"><?= count($mesConges) ?></span>
    </button>
    <?php if ($idPfl != 3): ?>
    <button class="main-tab-btn" id="tab-btn-tous" onclick="switchMainTab('tous', this)">
        <i class="fas fa-users"></i> Tous les congés
        <span class="main-tab-count" id="cnt-tous-tab"><?= count($tousConges) ?></span>
    </button>
    <?php endif; ?>
</div>

<?php
function renderCongeTable(array $rows, string $prefix, int $idPfl, int $idEmp, array $typesConge, array $directions): void
{
    $isTous  = ($prefix === 'tous');
    $hasDir  = ($idPfl == 1 && $isTous);
    $colspan = ($isTous && $idPfl != 3) ? 10 : 9;
?>
<div class="filter-panel">
    <div class="filter-panel-head" onclick="toggleFilters('<?= $prefix ?>')">
        <div class="filter-panel-head-left">
            <i class="fas fa-sliders-h"></i> Filtres
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
                    <input type="text" class="filter-input" id="<?= $prefix ?>-f-search" placeholder="Nom, libellé...">
                </div>
            </div>
            <div class="filter-group">
                <div class="filter-label">Statut</div>
                <select class="filter-select" id="<?= $prefix ?>-f-statut">
                    <option value="">Tous</option>
                    <option value="en_attente">En attente</option>
                    <option value="approuve_chef">Approuvé Chef</option>
                    <option value="rejete_chef">Refusé Chef</option>
                    <option value="valide_rh">Validé RH</option>
                    <option value="rejete_rh">Rejeté RH</option>
                    <option value="expire">Expiré</option>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Type de congé</div>
                <select class="filter-select" id="<?= $prefix ?>-f-type">
                    <option value="">Tous</option>
                    <?php foreach ($typesConge as $tc): ?>
                    <option value="<?= esc($tc['Libelle_Tcg']) ?>"><?= esc($tc['Libelle_Tcg']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($hasDir): ?>
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
                <div class="filter-label">Année</div>
                <select class="filter-select" id="<?= $prefix ?>-f-annee">
                    <option value="">Toutes</option>
                    <?php
                    $annees = array_unique(array_map(fn($c) => date('Y', strtotime($c['DateDebut_Cge'])), $rows));
                    rsort($annees);
                    foreach ($annees as $annee): ?>
                    <option value="<?= $annee ?>"><?= $annee ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">&nbsp;</div>
                <button type="button" class="btn-reset" id="<?= $prefix ?>-btn-reset"
                        onclick="resetFilters('<?= $prefix ?>')">
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
                <div class="filter-label">Demande — du</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-demande-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Demande — au</div>
                <input type="date" class="filter-input" id="<?= $prefix ?>-f-demande-to">
            </div>
            <div class="filter-group">
                <div class="filter-label">Durée min (j)</div>
                <input type="number" class="filter-input" id="<?= $prefix ?>-f-duree-min"
                       placeholder="Ex : 5" min="1" style="padding:0 10px;">
            </div>
        </div>
    </div>
</div>

<div class="table-wrapper">
    <div class="table-head-bar">
        <h6><i class="fas fa-table"></i> <?= $isTous ? 'Toutes les demandes' : 'Mes demandes' ?></h6>
        <span class="table-foot-info" id="<?= $prefix ?>-count-label">
            <strong style="color:var(--c-soft);"><?= count($rows) ?></strong> demande(s)
        </span>
    </div>
    <table class="conge-table">
        <thead>
            <tr>
                <th>#</th>
                <?php if ($isTous && $idPfl != 3): ?><th>Demandeur</th><?php endif; ?>
                <th>Type</th>
                <th>Libellé</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Durée</th>
                <th>Demande</th>
                <th>Statut</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody id="<?= $prefix ?>-tbody">
            <?php foreach ($rows as $i => $c):
                $debut   = $c['DateDebut_Cge'];
                $fin     = $c['DateFin_Cge'];
                $nbJours = (new \DateTime($debut))->diff(new \DateTime($fin))->days + 1;
                $statut  = $c['Statut_Cge'] ?? 'en_attente';

                [$bsCls, $bsLabel, $bsDot] = match($statut) {
                    'en_attente'    => ['bs-attente',       'En attente',    '#ffc107'],
                    'approuve_chef' => ['bs-approuve-chef', 'Approuvé Chef', '#5B9BF0'],
                    'rejete_chef'   => ['bs-rejete-chef',   'Refusé Chef',   '#ff8080'],
                    'valide_rh'     => ['bs-valide-rh',     'Validé RH',     '#7ab86a'],
                    'rejete_rh'     => ['bs-rejete-rh',     'Rejeté RH',     '#ff8080'],
                    'expire'        => ['bs-expire',        'Expiré',        '#888'],
                    default         => ['bs-attente',        $statut,         '#ffc107'],
                };

                // Logique cohérente avec le contrôleur
                $canEdit   = peutModifierConge($c, $idEmp, $idPfl);
                $canDelete = ($idPfl == 1) || peutModifierConge($c, $idEmp, $idPfl);
            ?>
            <tr class="<?= $prefix ?>-row"
                data-nom="<?= strtolower(esc(($c['Nom_Emp'] ?? '') . ' ' . ($c['Prenom_Emp'] ?? ''))) ?>"
                data-libelle="<?= strtolower(esc($c['Libelle_Cge'])) ?>"
                data-statut="<?= esc($statut) ?>"
                data-type="<?= esc($c['Libelle_Tcg'] ?? '') ?>"
                data-dir="<?= esc($c['Nom_Dir'] ?? '') ?>"
                data-annee="<?= date('Y', strtotime($debut)) ?>"
                data-debut="<?= $debut ?>"
                data-demande="<?= $c['DateDemande_Cge'] ?>"
                data-duree="<?= $nbJours ?>"
            >
                <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;width:32px;"><?= $i + 1 ?></td>

                <?php if ($isTous && $idPfl != 3): ?>
                <td>
                    <div class="emp-identity">
                        <div class="emp-avatar">
                            <?= mb_substr($c['Nom_Emp'] ?? '?', 0, 1) . mb_substr($c['Prenom_Emp'] ?? '', 0, 1) ?>
                        </div>
                        <div>
                            <p class="emp-name"><?= esc(($c['Nom_Emp'] ?? '') . ' ' . ($c['Prenom_Emp'] ?? '')) ?></p>
                            <?php if (!empty($c['Nom_Dir'])): ?>
                            <div class="emp-dir"><?= esc($c['Nom_Dir']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <?php endif; ?>

                <td>
                    <?php if (!empty($c['Libelle_Tcg'])): ?>
                    <span class="badge-type"><?= esc($c['Libelle_Tcg']) ?></span>
                    <?php else: ?>
                    <span style="color:var(--c-muted);">-</span>
                    <?php endif; ?>
                </td>

                <td style="color:var(--c-text);font-weight:500;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?= esc($c['Libelle_Cge']) ?>
                </td>

                <td><?= date('d/m/Y', strtotime($debut)) ?></td>
                <td><?= date('d/m/Y', strtotime($fin)) ?></td>
                <td><span class="duree-pill"><?= $nbJours ?> j</span></td>
                <td style="color:var(--c-muted);font-size:0.75rem;"><?= date('d/m/Y', strtotime($c['DateDemande_Cge'])) ?></td>

                <td>
                    <span class="badge-statut <?= $bsCls ?>">
                        <span class="statut-dot" style="background:<?= $bsDot ?>;"></span>
                        <?= $bsLabel ?>
                    </span>
                </td>

                <td style="text-align:center;">
                    <div style="display:inline-flex;align-items:center;gap:5px;">
                        <a href="<?= base_url('conge/show/' . $c['id_Cge']) ?>"
                           class="btn-icon btn-icon-view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if ($canEdit): ?>
                        <a href="<?= base_url('conge/edit/' . $c['id_Cge']) ?>"
                           class="btn-icon btn-icon-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($canDelete): ?>
                        <button class="btn-icon btn-icon-delete"
                                title="Annuler / Supprimer"
                                onclick="confirmDelete(<?= (int)$c['id_Cge'] ?>, '<?= esc($c['Libelle_Cge'], 'js') ?>')">
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
                        <span style="color:var(--c-muted);font-size:0.82rem;">Aucune demande ne correspond aux filtres.</span>
                        <button onclick="resetFilters('<?= $prefix ?>')"
                                style="background:transparent;border:1px solid var(--c-orange-border);color:var(--c-orange);border-radius:7px;padding:5px 12px;font-size:0.75rem;cursor:pointer;">
                            <i class="fas fa-times"></i> Effacer les filtres
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="table-foot">
        <span class="table-foot-info" id="<?= $prefix ?>-footer-count"><?= count($rows) ?> demande(s) affichée(s)</span>
    </div>
</div>
<?php } ?>

<div class="main-tab-panel active" id="panel-mes">
    <?php renderCongeTable($mesConges, 'mes', $idPfl, $idEmp, $typesConge, $directions); ?>
</div>

<?php if ($idPfl != 3): ?>
<div class="main-tab-panel" id="panel-tous">
    <?php renderCongeTable($tousConges, 'tous', $idPfl, $idEmp, $typesConge, $directions); ?>
</div>
<?php endif; ?>

<!-- Modal suppression -->
<div class="modal-overlay" id="modal-delete">
    <div class="modal-box">
        <div style="width:46px;height:46px;border-radius:12px;background:var(--c-red-pale);border:1px solid var(--c-red-border);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 style="color:#fff;font-size:0.9rem;font-weight:700;text-align:center;margin-bottom:8px;">Confirmer l'annulation</h5>
        <p style="color:var(--c-muted);font-size:0.8rem;text-align:center;line-height:1.5;margin:0;">
            Vous allez annuler la demande :<br>
            <strong id="modal-conge-label" style="color:var(--c-soft);"></strong>
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
(function() {

    function animCount(id, target) {
        var el = document.getElementById(id);
        if (!el) return;
        var current = 0, step = Math.max(1, Math.ceil(target / 30));
        var timer = setInterval(function() {
            current = Math.min(current + step, target);
            el.textContent = current;
            if (current >= target) clearInterval(timer);
        }, 20);
    }

    animCount('cnt-total',   <?= (int)$total ?>);
    animCount('cnt-attente', <?= (int)$enAttente ?>);
    animCount('cnt-chef',    <?= (int)$approuveChef ?>);
    animCount('cnt-valide',  <?= (int)$valideRH ?>);
    animCount('cnt-rejete',  <?= (int)$rejetes ?>);
    animCount('cnt-expire',  <?= (int)$expires ?>);

    window.switchMainTab = function(tab, btn) {
        document.querySelectorAll('.main-tab-panel').forEach(function(p) { p.classList.remove('active'); });
        document.querySelectorAll('.main-tab-btn').forEach(function(b)   { b.classList.remove('active'); });
        document.getElementById('panel-' + tab).classList.add('active');
        btn.classList.add('active');
    };

    window.toggleFilters = function(prefix) {
        document.getElementById(prefix + '-filter-body').classList.toggle('open');
        document.getElementById(prefix + '-filter-chevron').classList.toggle('open');
    };

    function buildFilter(prefix) {
        var rows       = document.querySelectorAll('.' + prefix + '-row');
        var noResult   = document.getElementById(prefix + '-no-results');
        var badge      = document.getElementById(prefix + '-filter-badge');
        var btnReset   = document.getElementById(prefix + '-btn-reset');
        var footCount  = document.getElementById(prefix + '-footer-count');
        var countLabel = document.getElementById(prefix + '-count-label');

        function getVal(id) { var el = document.getElementById(id); return el ? el.value : ''; }

        function applyFilters() {
            var search      = getVal(prefix + '-f-search').trim().toLowerCase();
            var statut      = getVal(prefix + '-f-statut');
            var type        = getVal(prefix + '-f-type');
            var dir         = getVal(prefix + '-f-dir');
            var annee       = getVal(prefix + '-f-annee');
            var debutFrom   = getVal(prefix + '-f-debut-from');
            var debutTo     = getVal(prefix + '-f-debut-to');
            var demandeFrom = getVal(prefix + '-f-demande-from');
            var demandeTo   = getVal(prefix + '-f-demande-to');
            var dureeMin    = parseInt(getVal(prefix + '-f-duree-min')) || 0;

            var actifs = [search, statut, type, dir, annee, debutFrom, debutTo, demandeFrom, demandeTo]
                .filter(function(v) { return v !== ''; }).length + (dureeMin > 0 ? 1 : 0);

            badge.textContent = actifs;
            actifs > 0 ? badge.classList.add('visible')    : badge.classList.remove('visible');
            actifs > 0 ? btnReset.classList.add('visible') : btnReset.classList.remove('visible');

            var visible = 0;

            rows.forEach(function(row) {
                var debut = row.dataset.debut, demande = row.dataset.demande;
                var duree = parseInt(row.dataset.duree) || 0;

                var match =
                    (search === '' || row.dataset.nom.includes(search) || row.dataset.libelle.includes(search)) &&
                    (statut === '' || row.dataset.statut === statut) &&
                    (type   === '' || row.dataset.type === type) &&
                    (dir    === '' || row.dataset.dir === dir) &&
                    (annee  === '' || row.dataset.annee === annee) &&
                    (debutFrom   === '' || debut >= debutFrom) &&
                    (debutTo     === '' || debut <= debutTo) &&
                    (demandeFrom === '' || demande >= demandeFrom) &&
                    (demandeTo   === '' || demande <= demandeTo) &&
                    (dureeMin === 0 || duree >= dureeMin);

                row.style.display = match ? '' : 'none';
                if (match) {
                    visible++;
                    var numCell = row.querySelector('.row-num');
                    if (numCell) numCell.textContent = visible;
                }
            });

            noResult.classList.toggle('visible', visible === 0);
            footCount.textContent = visible + ' demande(s) affichée(s)';
            countLabel.innerHTML  = '<strong style="color:rgba(255,255,255,0.55);">' + visible + '</strong> demande(s)';
        }

        window['resetFilters'] = function(p) {
            if (p !== prefix) return;
            [prefix+'-f-search', prefix+'-f-statut', prefix+'-f-type', prefix+'-f-dir',
             prefix+'-f-annee', prefix+'-f-debut-from', prefix+'-f-debut-to',
             prefix+'-f-demande-from', prefix+'-f-demande-to', prefix+'-f-duree-min']
            .forEach(function(id) { var el = document.getElementById(id); if (el) el.value = ''; });
            applyFilters();
        };

        [prefix+'-f-search', prefix+'-f-statut', prefix+'-f-type', prefix+'-f-dir',
         prefix+'-f-annee', prefix+'-f-debut-from', prefix+'-f-debut-to',
         prefix+'-f-demande-from', prefix+'-f-demande-to', prefix+'-f-duree-min']
        .forEach(function(id) {
            var el = document.getElementById(id);
            if (el) { el.addEventListener('input', applyFilters); el.addEventListener('change', applyFilters); }
        });
    }

    buildFilter('mes');
    <?php if ($idPfl != 3): ?>buildFilter('tous');<?php endif; ?>

    // Modal suppression
    var deleteUrl = '';

    window.confirmDelete = function(id, label) {
        document.getElementById('modal-conge-label').textContent = label;
        deleteUrl = '<?= base_url('conge/delete/') ?>' + id;
        document.getElementById('modal-delete').classList.add('show');
    };

    window.closeDeleteModal = function() {
        document.getElementById('modal-delete').classList.remove('show');
        deleteUrl = '';
    };

    document.getElementById('btn-confirm-delete').addEventListener('click', function() {
        if (!deleteUrl) return;
        document.getElementById('form-delete').action = deleteUrl;
        document.getElementById('form-delete').submit();
    });

    document.getElementById('modal-delete').addEventListener('click', function(e) {
        if (e.target === this) window.closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') window.closeDeleteModal(); });

    document.addEventListener('DOMContentLoaded', function() {
        document.body.appendChild(document.getElementById('modal-delete'));
        document.body.appendChild(document.getElementById('form-delete'));
    });

})();
</script>
<?= $this->endSection() ?>