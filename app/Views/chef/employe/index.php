<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        /* === Thème Chef : bleu === */
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58, 123, 213, 0.12);
        --c-primary-border: rgba(58, 123, 213, 0.28);
        --c-accent:         #5B9BF0;

        /* Alias orange → primary pour compatibilité */
        --c-orange:        #3A7BD5;
        --c-orange-pale:   rgba(58, 123, 213, 0.12);
        --c-orange-border: rgba(58, 123, 213, 0.28);

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

    .sp-orange { background: var(--c-primary-pale); color: var(--c-accent); }
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

    .filter-panel-head-left i { color: var(--c-accent); }

    .filter-badge {
        background: var(--c-primary); color: #fff;
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

    /* Grille sans colonne Direction (chef voit sa direction seulement) */
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto;
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
    .btn-icon {
        width: 28px; height: 28px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.72rem; cursor: pointer; transition: all 0.2s;
        text-decoration: none; border: none; flex-shrink: 0;
    }

    .btn-icon-view { background: var(--c-blue-pale); color: #5B9BF0; border: 1px solid var(--c-blue-border); }
    .btn-icon:hover { transform: scale(1.12); }

    .btn-outline-orange {
        background: transparent; border: 1px solid var(--c-primary-border);
        color: var(--c-accent); font-weight: 600; border-radius: 8px;
        padding: 7px 15px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-outline-orange:hover { background: var(--c-primary-pale); color: var(--c-accent); }

    /* ===== TABLEAU ===== */
    .table-wrapper {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 12px;
        overflow: hidden;
    }

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

    .table-head-bar h6 i { color: var(--c-accent); }

    .emp-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; min-width: 580px; }

    .emp-table thead th {
        padding: 9px 14px; font-size: 0.68rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-accent); background: var(--c-primary-pale);
        border-bottom: 1px solid var(--c-primary-border); white-space: nowrap;
    }

    .emp-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .emp-table tbody tr:last-child td { border-bottom: none; }
    .emp-table tbody tr { transition: background 0.15s; }
    .emp-table tbody tr:hover td { background: rgba(58,123,213,0.03); }
    .emp-table tbody tr.hidden-row { display: none; }

    .emp-identity { display: flex; align-items: center; gap: 9px; }

    .emp-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--c-primary-pale); border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700; color: var(--c-accent);
        flex-shrink: 0; text-transform: uppercase;
    }

    .emp-avatar.female { background: rgba(255,105,180,0.1); border-color: rgba(255,105,180,0.25); color: #ff8fbf; }

    .emp-name  { color: #fff; font-weight: 600; font-size: 0.83rem; margin: 0; line-height: 1.2; }
    .emp-email { color: var(--c-muted); font-size: 0.7rem; margin-top: 1px; }

    .badge-grade, .badge-profil, .badge-dispo {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 20px;
        font-size: 0.68rem; font-weight: 600; white-space: nowrap;
    }

    .badge-grade  { background: var(--c-primary-pale);  border: 1px solid var(--c-primary-border); color: var(--c-accent); }
    .badge-profil { background: rgba(139,92,246,0.10);  border: 1px solid rgba(139,92,246,0.25);  color: #a78bfa; }
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

    /* ===== PAGE HEADER ===== */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    /* Info direction du chef */
    .dir-info-chip {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--c-primary-pale); border: 1px solid var(--c-primary-border);
        color: var(--c-accent); font-size: 0.78rem; font-weight: 600;
        padding: 5px 12px; border-radius: 20px;
    }

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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .stat-strip  { grid-template-columns: repeat(2, 1fr); }
        .filter-grid { grid-template-columns: 1fr 1fr 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; }
    }

    @media (max-width: 768px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
        .table-head-bar { flex-direction: column; align-items: flex-start; }
    }

    @media (max-width: 576px) {
        .stat-strip { grid-template-columns: repeat(2, 1fr); }
        .filter-grid { grid-template-columns: 1fr; }
        .stat-pill-val   { font-size: 1.1rem; }
        .stat-pill-label { font-size: 0.62rem; }
        .stat-pill       { padding: 10px 12px; gap: 8px; }
        .table-foot { flex-direction: column; align-items: flex-start; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$totalEmp    = count($employes);
$disponibles = count(array_filter($employes, fn($e) => (int)$e['Disponibilite_Emp'] === 1));
$absents     = $totalEmp - $disponibles;
$hommes      = count(array_filter($employes, fn($e) => (int)$e['Sexe_Emp'] === 1));
$femmes      = $totalEmp - $hommes;
// Direction unique (tous les employés sont dans la même direction)
$dirNom = !empty($employes[0]['Nom_Dir']) ? $employes[0]['Nom_Dir'] : 'Ma direction';
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-users me-2" style="color:var(--c-accent);"></i>Employés de ma direction</h1>
        <p style="margin-top:4px;">
            <span class="dir-info-chip">
                <i class="fas fa-building" style="font-size:0.65rem;"></i>
                <?= esc($dirNom) ?>
            </span>
            &nbsp;&mdash;&nbsp;<?= date('d/m/Y') ?>
        </p>
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

<!-- Stats -->
<div class="stat-strip">
    <div class="stat-pill">
        <div class="stat-pill-icon sp-orange"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-total">0</div>
            <div class="stat-pill-label">Total employés</div>
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
        <div class="stat-pill-icon sp-blue"><i class="fas fa-venus-mars"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-h">0</div>
            <div class="stat-pill-label">Hommes / <span id="cnt-f-label">0</span> F</div>
        </div>
    </div>
</div>

<!-- Filtres client (sans Direction) -->
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
                    <input type="text" id="f-search" placeholder="Nom, prénom, email..." autocomplete="off">
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-label">Grade</div>
                <select id="f-grd" class="filter-select">
                    <option value="">Tous</option>
                    <?php
                    $gradesUniques = array_unique(array_filter(array_column($employes, 'Libelle_Grd')));
                    sort($gradesUniques);
                    foreach ($gradesUniques as $g):
                    ?>
                    <option value="<?= esc($g) ?>"><?= esc($g) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">Profil</div>
                <select id="f-pfl" class="filter-select">
                    <option value="">Tous</option>
                    <?php
                    $profilsUniques = array_unique(array_filter(array_column($employes, 'Libelle_Pfl')));
                    sort($profilsUniques);
                    foreach ($profilsUniques as $p):
                    ?>
                    <option value="<?= esc($p) ?>"><?= esc($p) ?></option>
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
                <div class="filter-label">Disponibilité</div>
                <select id="f-dispo" class="filter-select">
                    <option value="">Tous</option>
                    <option value="1">Disponible</option>
                    <option value="0">Absent</option>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-label">&nbsp;</div>
                <button type="button" class="btn-reset-all" id="btn-reset" onclick="resetFilters()">
                    <i class="fas fa-times-circle"></i> Annuler
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
            <strong style="color:var(--c-soft);"><?= $totalEmp ?></strong> employé(s)
            &nbsp;|&nbsp;
            <span style="color:#5B9BF0;">H : <?= $hommes ?></span>
            &nbsp;
            <span style="color:#ff8fbf;">F : <?= $femmes ?></span>
        </span>
    </div>

    <div class="table-scroll">
        <table class="emp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employé</th>
                    <th>Grade</th>
                    <th>Profil</th>
                    <th>Disponibilité</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="emp-tbody">
                <?php foreach ($employes as $i => $emp): ?>
                <tr class="emp-row"
                    data-nom="<?= strtolower(esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp'])) ?>"
                    data-email="<?= strtolower(esc($emp['Email_Emp'])) ?>"
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
                        <!-- Chef : consultation uniquement, pas de modifier/supprimer -->
                        <a href="<?= base_url('employe/show/' . $emp['id_Emp']) ?>"
                           class="btn-icon btn-icon-view" title="Voir la fiche">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tr class="no-results-row" id="no-results-row">
                    <td colspan="6">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:30px 0;">
                            <i class="fas fa-search" style="font-size:1.5rem;color:var(--c-muted);opacity:0.4;"></i>
                            <span style="color:var(--c-muted);font-size:0.83rem;">Aucun employé ne correspond aux filtres appliqués.</span>
                            <button onclick="resetFilters()" class="btn-outline-orange" style="font-size:0.75rem;padding:5px 12px;margin-top:4px;">
                                <i class="fas fa-times"></i> Effacer les filtres
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-foot">
        <span class="table-foot-info" id="footer-count"><?= $totalEmp ?> employé(s) affiché(s)</span>
    </div>
</div>

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
    animateCounter('cnt-h',     <?= (int)$hommes ?>);

    // Femmes dans le label du 4e compteur
    const fLabel = document.getElementById('cnt-f-label');
    if (fLabel) fLabel.textContent = <?= (int)$femmes ?>;

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
        const grd    = document.getElementById('f-grd').value;
        const pfl    = document.getElementById('f-pfl').value;
        const sexe   = document.getElementById('f-sexe').value;
        const dispo  = document.getElementById('f-dispo').value;

        let actifs = [search, grd, pfl, sexe, dispo].filter(v => v !== '').length;

        if (actifs > 0) {
            badge.textContent = actifs;
            badge.classList.add('visible');
            btnReset.classList.add('visible');
        } else {
            badge.classList.remove('visible');
            btnReset.classList.remove('visible');
        }

        let visible = 0;
        rows.forEach(function(row) {
            const match =
                (search === '' || row.dataset.nom.includes(search) || row.dataset.email.includes(search)) &&
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
        footCount.textContent = visible + ' employé(s) affiché(s)';
    }

    window.resetFilters = function() {
        ['f-search','f-grd','f-pfl','f-sexe','f-dispo'].forEach(function(id) {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        applyFilters();
    };

    document.getElementById('f-search').addEventListener('input',  applyFilters);
    document.getElementById('f-grd').addEventListener('change',    applyFilters);
    document.getElementById('f-pfl').addEventListener('change',    applyFilters);
    document.getElementById('f-sexe').addEventListener('change',   applyFilters);
    document.getElementById('f-dispo').addEventListener('change',  applyFilters);

})();
</script>
<?= $this->endSection() ?>