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

    .stat-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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

    .sp-orange { background: var(--c-orange-pale);  color: var(--c-orange); }
    .sp-green  { background: var(--c-green-pale);   color: #7ab86a; }
    .sp-red    { background: var(--c-red-pale);     color: #ff8080; }
    .sp-blue   { background: var(--c-blue-pale);    color: #5B9BF0; }

    .stat-pill-val   { font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
    .stat-pill-label { font-size: 0.68rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

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
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
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

    .frm-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .frm-table thead th {
        padding: 8px 14px; font-size: 0.67rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border); white-space: nowrap;
    }

    .frm-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .frm-table tbody tr:last-child td { border-bottom: none; }
    .frm-table tbody tr { transition: background 0.15s; }
    .frm-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    /* ===== CAPACITE BAR ===== */
    .capacite-wrap { min-width: 100px; }

    .capacite-bar-bg {
        height: 5px; background: rgba(255,255,255,0.06);
        border-radius: 3px; overflow: hidden; margin-top: 4px;
    }

    .capacite-bar-fill {
        height: 100%; border-radius: 3px;
        transition: width 0.4s ease;
    }

    .capacite-label { font-size: 0.7rem; color: var(--c-muted); white-space: nowrap; }

    /* ===== BADGES ===== */
    .badge-dispo {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.67rem; font-weight: 700; white-space: nowrap;
    }

    .bd-dispo   { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bd-complet { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bd-futur   { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bd-passe   { background: rgba(255,255,255,0.04); border: 1px solid var(--c-border);      color: var(--c-muted); }

    .badge-inscrit {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 20px; font-size: 0.65rem; font-weight: 700;
    }

    .bi-valide  { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bi-inscrit { background: var(--c-yellow-pale); border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bi-annule  { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }

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
        to   { opacity: 1; transform: scale(1)    translateY(0); }
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

    @media (max-width: 992px) {
        .stat-strip   { grid-template-columns: repeat(2, 1fr); }
        .filter-row   { grid-template-columns: 1fr 1fr; }
        .filter-row-2 { grid-template-columns: 1fr 1fr; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$idPfl = $idPfl ?? session()->get('id_Pfl');
$idEmp = $idEmp ?? session()->get('id_Emp');
$today = date('Y-m-d');

$total    = count($formations);
$dispo    = count(array_filter($formations, fn($f) => $f['nb_valides'] < $f['Capacite_Frm'] && $f['DateFin_Frm'] >= $today));
$complet  = count(array_filter($formations, fn($f) => $f['nb_valides'] >= $f['Capacite_Frm']));
$passe    = count(array_filter($formations, fn($f) => $f['DateFin_Frm'] < $today));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chalkboard-teacher me-2" style="color:#F5A623;"></i>Formations</h1>
        <p><?= date('d/m/Y') ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('demande-formation') ?>" class="btn-orange" style="background:rgba(91,155,240,0.15);border:1px solid rgba(91,155,240,0.3);color:#5B9BF0;">
            <i class="fas fa-file-alt"></i> Demandes
        </a>
        <?php if ($idPfl == 1): ?>
        <a href="<?= base_url('formation/create') ?>" class="btn-orange">
            <i class="fas fa-plus"></i> Nouvelle formation
        </a>
        <?php endif; ?>
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
        <div class="stat-pill-icon sp-orange"><i class="fas fa-list"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-total">0</div>
            <div class="stat-pill-label">Total</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-green"><i class="fas fa-door-open"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-dispo">0</div>
            <div class="stat-pill-label">Disponibles</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-red"><i class="fas fa-users-slash"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-complet">0</div>
            <div class="stat-pill-label">Complètes</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon sp-blue"><i class="fas fa-history"></i></div>
        <div>
            <div class="stat-pill-val" id="cnt-passe">0</div>
            <div class="stat-pill-label">Passées</div>
        </div>
    </div>
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
                    <input type="text" class="filter-input" id="f-search"
                           placeholder="Description, lieu, formateur...">
                </div>
            </div>
            <div class="filter-group">
                <div class="filter-label">Disponibilité</div>
                <select class="filter-select" id="f-dispo">
                    <option value="">Toutes</option>
                    <option value="dispo">Disponible</option>
                    <option value="complet">Complète</option>
                    <option value="futur">À venir</option>
                    <option value="passe">Passée</option>
                </select>
            </div>
            <?php if ($idPfl != 3): ?>
            <div class="filter-group">
                <div class="filter-label">Mon inscription</div>
                <select class="filter-select" id="f-inscrit">
                    <option value="">Toutes</option>
                    <option value="valide">Confirmée</option>
                    <option value="inscrit">En attente</option>
                    <option value="annule">Annulée</option>
                    <option value="non">Non inscrit</option>
                </select>
            </div>
            <?php else: ?>
            <div class="filter-group">
                <div class="filter-label">Mon inscription</div>
                <select class="filter-select" id="f-inscrit">
                    <option value="">Toutes</option>
                    <option value="valide">Confirmée</option>
                    <option value="inscrit">En attente</option>
                    <option value="annule">Annulée</option>
                    <option value="non">Non inscrit</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="filter-group">
                <div class="filter-label">Année</div>
                <select class="filter-select" id="f-annee">
                    <option value="">Toutes</option>
                    <?php
                    $annees = array_unique(array_map(fn($f) => date('Y', strtotime($f['DateDebut_Frm'])), $formations));
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
                <div class="filter-label">Début — du</div>
                <input type="date" class="filter-input" id="f-debut-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Début — au</div>
                <input type="date" class="filter-input" id="f-debut-to">
            </div>
            <div class="filter-group">
                <div class="filter-label">Fin — du</div>
                <input type="date" class="filter-input" id="f-fin-from">
            </div>
            <div class="filter-group">
                <div class="filter-label">Fin — au</div>
                <input type="date" class="filter-input" id="f-fin-to">
            </div>
            <div class="filter-group">
                <div class="filter-label">Capacité min</div>
                <input type="number" class="filter-input" id="f-cap-min"
                       placeholder="Ex : 10" min="1" style="padding:0 10px;">
            </div>
        </div>
    </div>
</div>

<!-- Tableau -->
<div class="table-wrapper">
    <div class="table-head-bar">
        <h6><i class="fas fa-table"></i> Catalogue des formations</h6>
        <span class="table-foot-info" id="count-label">
            <strong style="color:var(--c-soft);"><?= $total ?></strong> formation(s)
        </span>
    </div>
    <table class="frm-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Lieu</th>
                <th>Formateur</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Capacité</th>
                <th>Mon statut</th>
                <th>Disponibilité</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody id="frm-tbody">
            <?php foreach ($formations as $i => $f):
                $debut     = $f['DateDebut_Frm'];
                $fin       = $f['DateFin_Frm'];
                $cap       = (int)$f['Capacite_Frm'];
                $nbValides = (int)$f['nb_valides'];
                $pct       = $cap > 0 ? min(100, round(($nbValides / $cap) * 100)) : 0;
                $isFutur   = $debut > $today;
                $isPasse   = $fin < $today;
                $isComplet = $nbValides >= $cap && $cap > 0;

                if ($isFutur)       $dispoKey = 'futur';
                elseif ($isPasse)   $dispoKey = 'passe';
                elseif ($isComplet) $dispoKey = 'complet';
                else                $dispoKey = 'dispo';

                [$bdCls, $bdLabel, $bdIcon] = match($dispoKey) {
                    'dispo'   => ['bd-dispo',   'Disponible', 'fa-check-circle'],
                    'complet' => ['bd-complet', 'Complète',   'fa-users-slash'],
                    'futur'   => ['bd-futur',   'À venir',    'fa-clock'],
                    'passe'   => ['bd-passe',   'Passée',     'fa-history'],
                };

                $barColor = match($dispoKey) {
                    'dispo'   => 'linear-gradient(90deg,#7ab86a,#4a6741)',
                    'complet' => 'linear-gradient(90deg,#ff8080,#c0392b)',
                    'futur'   => 'linear-gradient(90deg,#5B9BF0,#2980b9)',
                    'passe'   => 'rgba(255,255,255,0.2)',
                };

                $monIns    = $f['mon_inscription'];
                $insStatut = $monIns ? $monIns['Stt_Ins'] : 'non';

                [$biCls, $biLabel, $biIcon] = match($insStatut) {
                    'valide'  => ['bi-valide',  'Confirmée',   'fa-check'],
                    'inscrit' => ['bi-inscrit', 'En attente',  'fa-clock'],
                    'annule'  => ['bi-annule',  'Annulée',     'fa-times'],
                    default   => ['',           '—',           ''],
                };
            ?>
            <tr class="frm-row"
                data-search="<?= strtolower(esc($f['Description_Frm'] . ' ' . $f['Lieu_Frm'] . ' ' . $f['Formateur_Frm'])) ?>"
                data-dispo="<?= $dispoKey ?>"
                data-inscrit="<?= $insStatut ?>"
                data-annee="<?= date('Y', strtotime($debut)) ?>"
                data-debut="<?= $debut ?>"
                data-fin="<?= $fin ?>"
                data-cap="<?= $cap ?>"
            >
                <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;width:32px;"><?= $i + 1 ?></td>

                <td style="max-width:200px;">
                    <div style="color:#fff;font-weight:600;font-size:0.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        <?= esc($f['Description_Frm']) ?>
                    </div>
                </td>

                <td style="white-space:nowrap;">
                    <i class="fas fa-map-marker-alt" style="color:var(--c-orange);font-size:0.7rem;margin-right:4px;"></i>
                    <?= esc($f['Lieu_Frm']) ?>
                </td>

                <td style="white-space:nowrap;">
                    <i class="fas fa-user-tie" style="color:var(--c-muted);font-size:0.7rem;margin-right:4px;"></i>
                    <?= esc($f['Formateur_Frm']) ?>
                </td>

                <td style="white-space:nowrap;"><?= date('d/m/Y', strtotime($debut)) ?></td>
                <td style="white-space:nowrap;"><?= date('d/m/Y', strtotime($fin)) ?></td>

                <td>
                    <div class="capacite-wrap">
                        <div class="capacite-label"><?= $nbValides ?> / <?= $cap ?></div>
                        <div class="capacite-bar-bg">
                            <div class="capacite-bar-fill" style="width:<?= $pct ?>%;background:<?= $barColor ?>;"></div>
                        </div>
                    </div>
                </td>

                <td>
                    <?php if ($insStatut !== 'non'): ?>
                    <span class="badge-inscrit <?= $biCls ?>">
                        <i class="fas <?= $biIcon ?>"></i> <?= $biLabel ?>
                    </span>
                    <?php else: ?>
                    <span style="color:var(--c-muted);font-size:0.72rem;">—</span>
                    <?php endif; ?>
                </td>

                <td>
                    <span class="badge-dispo <?= $bdCls ?>">
                        <i class="fas <?= $bdIcon ?>"></i> <?= $bdLabel ?>
                    </span>
                </td>

                <td style="text-align:center;">
                    <div style="display:inline-flex;align-items:center;gap:5px;">
                        <a href="<?= base_url('formation/show/' . $f['id_Frm']) ?>"
                           class="btn-icon btn-icon-view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if ($idPfl == 1): ?>
                        <a href="<?= base_url('formation/edit/' . $f['id_Frm']) ?>"
                           class="btn-icon btn-icon-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="btn-icon btn-icon-delete" title="Supprimer"
                                onclick="confirmDelete(<?= (int)$f['id_Frm'] ?>, '<?= esc($f['Description_Frm'], 'js') ?>')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>

            <tr class="no-results" id="no-results">
                <td colspan="10">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:28px 0;">
                        <i class="fas fa-search" style="font-size:1.4rem;color:var(--c-muted);opacity:0.4;"></i>
                        <span style="color:var(--c-muted);font-size:0.82rem;">Aucune formation ne correspond aux filtres.</span>
                        <button onclick="resetFilters()"
                                style="background:transparent;border:1px solid var(--c-orange-border);color:var(--c-orange);border-radius:7px;padding:5px 12px;font-size:0.75rem;cursor:pointer;">
                            <i class="fas fa-times"></i> Effacer les filtres
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="table-foot">
        <span class="table-foot-info" id="footer-count"><?= $total ?> formation(s) affichée(s)</span>
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
            Vous allez supprimer la formation :<br>
            <strong id="modal-frm-label" style="color:var(--c-soft);"></strong>
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

    // ===== COMPTEURS ANIMÉS =====
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
    animCount('cnt-dispo',   <?= (int)$dispo ?>);
    animCount('cnt-complet', <?= (int)$complet ?>);
    animCount('cnt-passe',   <?= (int)$passe ?>);

    // ===== TOGGLE FILTRES =====
    window.toggleFilters = function () {
        document.getElementById('filter-body').classList.toggle('open');
        document.getElementById('filter-chevron').classList.toggle('open');
    };

    // ===== FILTRES CLIENT =====
    var rows      = document.querySelectorAll('.frm-row');
    var noResult  = document.getElementById('no-results');
    var badge     = document.getElementById('filter-badge');
    var btnReset  = document.getElementById('btn-reset');
    var footCount = document.getElementById('footer-count');
    var countLbl  = document.getElementById('count-label');

    function getVal(id) {
        var el = document.getElementById(id);
        return el ? el.value : '';
    }

    function applyFilters() {
        var search    = getVal('f-search').trim().toLowerCase();
        var dispo     = getVal('f-dispo');
        var inscrit   = getVal('f-inscrit');
        var annee     = getVal('f-annee');
        var debutFrom = getVal('f-debut-from');
        var debutTo   = getVal('f-debut-to');
        var finFrom   = getVal('f-fin-from');
        var finTo     = getVal('f-fin-to');
        var capMin    = parseInt(getVal('f-cap-min')) || 0;

        var actifs = [search, dispo, inscrit, annee, debutFrom, debutTo, finFrom, finTo]
            .filter(function (v) { return v !== ''; }).length + (capMin > 0 ? 1 : 0);

        badge.textContent = actifs;
        actifs > 0 ? badge.classList.add('visible')    : badge.classList.remove('visible');
        actifs > 0 ? btnReset.classList.add('visible') : btnReset.classList.remove('visible');

        var visible = 0;

        rows.forEach(function (row) {
            var match =
                (search    === '' || row.dataset.search.includes(search)) &&
                (dispo     === '' || row.dataset.dispo   === dispo) &&
                (inscrit   === '' || row.dataset.inscrit === inscrit) &&
                (annee     === '' || row.dataset.annee   === annee) &&
                (debutFrom === '' || row.dataset.debut   >= debutFrom) &&
                (debutTo   === '' || row.dataset.debut   <= debutTo) &&
                (finFrom   === '' || row.dataset.fin     >= finFrom) &&
                (finTo     === '' || row.dataset.fin     <= finTo) &&
                (capMin    === 0  || parseInt(row.dataset.cap) >= capMin);

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
        footCount.textContent = visible + ' formation(s) affichée(s)';
        countLbl.innerHTML    = '<strong style="color:rgba(255,255,255,0.55);">' + visible + '</strong> formation(s)';
    }

    window.resetFilters = function () {
        ['f-search','f-dispo','f-inscrit','f-annee',
         'f-debut-from','f-debut-to','f-fin-from','f-fin-to','f-cap-min']
        .forEach(function (id) { var el = document.getElementById(id); if (el) el.value = ''; });
        applyFilters();
    };

    ['f-search','f-dispo','f-inscrit','f-annee',
     'f-debut-from','f-debut-to','f-fin-from','f-fin-to','f-cap-min']
    .forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input',  applyFilters);
            el.addEventListener('change', applyFilters);
        }
    });

    // ===== MODAL SUPPRESSION =====
    var deleteUrl = '';

    window.confirmDelete = function (id, label) {
        document.getElementById('modal-frm-label').textContent = label;
        deleteUrl = '<?= base_url('formation/delete/') ?>' + id;
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
        document.body.appendChild(document.getElementById('modal-delete'));
        document.body.appendChild(document.getElementById('form-delete'));
    });

})();
</script>
<?= $this->endSection() ?>