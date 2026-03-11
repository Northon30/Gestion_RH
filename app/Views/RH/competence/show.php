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

    .show-grid { display: grid; grid-template-columns: 300px 1fr; gap: 16px; align-items: start; }

    /* ===== CARD GÉNÉRIQUE ===== */
    .card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden;
    }

    .card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        flex-wrap: wrap;
    }

    .card-header-left { display: flex; align-items: center; gap: 10px; }

    .card-icon {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.82rem; flex-shrink: 0;
    }

    .card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }

    /* ===== INFO CARD ===== */
    .info-body { padding: 16px 18px; }

    .info-row {
        display: flex; flex-direction: column; gap: 3px;
        padding: 10px 0; border-bottom: 1px solid var(--c-border);
    }

    .info-row:first-child { padding-top: 0; }
    .info-row:last-child  { border-bottom: none; padding-bottom: 0; }

    .info-label {
        font-size: 0.67rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;
    }

    .info-value { color: var(--c-text); font-size: 0.82rem; }

    /* ===== STATS NIVEAUX ===== */
    .niveau-bars { display: flex; flex-direction: column; gap: 8px; margin-top: 4px; }

    .niveau-bar-row { display: flex; align-items: center; gap: 8px; }

    .niveau-bar-label {
        font-size: 0.68rem; font-weight: 700; width: 90px; flex-shrink: 0;
    }

    .niveau-bar-bg {
        flex: 1; height: 6px; background: rgba(255,255,255,0.06);
        border-radius: 3px; overflow: hidden;
    }

    .niveau-bar-fill { height: 100%; border-radius: 3px; transition: width 0.6s ease; }
    .niveau-bar-count { font-size: 0.68rem; color: var(--c-muted); width: 20px; text-align: right; flex-shrink: 0; }

    /* ===== ATTRIBUTION FORM ===== */
    .attr-form { padding: 16px 18px; }

    .attr-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }

    .form-group-sm { display: flex; flex-direction: column; gap: 5px; }

    .form-label-sm {
        font-size: 0.68rem; font-weight: 600; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
    }

    .form-control-sm {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.78rem;
        padding: 8px 10px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }

    .form-control-sm:focus { border-color: var(--c-orange-border); }
    .form-control-sm option { background: #1a1a1a; }

    /* ===== TABS ===== */
    .tabs { display: flex; gap: 3px; padding: 10px 14px; border-bottom: 1px solid var(--c-border); flex-wrap: wrap; }

    .tab-btn {
        padding: 5px 14px; border-radius: 6px; border: none;
        background: transparent; color: var(--c-muted); font-size: 0.75rem;
        font-weight: 600; cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 6px;
    }

    .tab-btn:hover { color: var(--c-soft); background: rgba(255,255,255,0.03); }

    .tab-btn.active {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange);
    }

    .tab-count {
        background: rgba(255,255,255,0.08); color: var(--c-muted);
        font-size: 0.62rem; font-weight: 700; padding: 1px 6px; border-radius: 8px;
    }

    .tab-btn.active .tab-count { background: var(--c-orange-border); color: var(--c-orange); }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ===== FILTERS ===== */
    .filter-bar {
        display: flex; gap: 8px; padding: 10px 14px;
        border-bottom: 1px solid var(--c-border); flex-wrap: wrap; align-items: flex-end;
    }

    .filter-group-sm { display: flex; flex-direction: column; gap: 4px; }

    .filter-lbl-sm {
        font-size: 0.62rem; font-weight: 600; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
    }

    .filter-ctrl-sm {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 7px; color: var(--c-text); font-size: 0.75rem;
        padding: 6px 9px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif;
    }

    .filter-ctrl-sm:focus { border-color: var(--c-orange-border); }
    .filter-ctrl-sm option { background: #1a1a1a; }

    /* ===== TABLE ===== */
    .emp-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .emp-table thead th {
        padding: 8px 14px; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border);
    }

    .emp-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .emp-table tbody tr:last-child td { border-bottom: none; }
    .emp-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    .emp-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.62rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; flex-shrink: 0; vertical-align: middle;
        margin-right: 8px;
    }

    .badge-niveau {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700;
    }

    .bn-debutant      { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);  color: #5B9BF0; }
    .bn-intermediaire { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .bn-avance        { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }

    /* ===== BOUTONS ACTIONS ===== */
    .btn-icon {
        width: 27px; height: 27px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.65rem; cursor: pointer; transition: all 0.15s; border: none;
        text-decoration: none;
    }

    .btn-icon-orange { background: var(--c-orange-pale); color: var(--c-orange); border: 1px solid var(--c-orange-border); }
    .btn-icon-red    { background: var(--c-red-pale);    color: #ff8080;          border: 1px solid var(--c-red-border); }
    .btn-icon-green  { background: var(--c-green-pale);  color: #7ab86a;          border: 1px solid var(--c-green-border); }
    .btn-icon:hover  { transform: scale(1.1); }

    /* ===== BOUTONS PRINCIPAUX ===== */
    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 8px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 8px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .btn-submit-sm {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 8px 16px; font-size: 0.78rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
        white-space: nowrap;
    }

    .btn-submit-sm:hover { transform: translateY(-1px); }

    /* Alerts */
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

    .empty-state {
        padding: 36px; text-align: center; color: var(--c-muted); font-size: 0.8rem;
    }

    .empty-state i { font-size: 1.6rem; opacity: 0.2; margin-bottom: 8px; display: block; }

    /* Modal modifier niveau */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.65); z-index: 1040;
        backdrop-filter: blur(3px); align-items: center; justify-content: center;
    }

    .modal-box {
        background: #1e1e1e; border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px; padding: 24px; width: 100%; max-width: 400px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .modal-title {
        color: #fff; font-size: 0.88rem; font-weight: 700; margin-bottom: 4px;
    }

    .modal-sub { color: var(--c-muted); font-size: 0.75rem; margin-bottom: 18px; }

    @media (max-width: 900px) { .show-grid { grid-template-columns: 1fr; } }
    @media (max-width: 560px) { .attr-form-grid { grid-template-columns: 1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$c       = $competence;
$total   = count($employes);
$idCmp   = (int)$c['id_Cmp'];

$valides  = array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'debutant');
$inters   = array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'intermediaire');
$avances  = array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'avance');
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-star me-2" style="color:#F5A623;"></i><?= esc($c['Libelle_Cmp']) ?></h1>
        <p>Détail de la compétence · <?= $total ?> employé(s)</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('competence') ?>" class="btn-ghost">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <?php if ($idPfl == 1): ?>
        <a href="<?= base_url('competence/edit/' . $idCmp) ?>" class="btn-orange">
            <i class="fas fa-pen"></i> Modifier
        </a>
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

    <!-- COL GAUCHE -->
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
                    <span class="info-label">Libellé</span>
                    <span class="info-value" style="font-weight:700;"><?= esc($c['Libelle_Cmp']) ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Employés concernés</span>
                    <span class="info-value" style="font-size:1.1rem;font-weight:800;color:var(--c-orange);">
                        <?= $total ?>
                    </span>
                </div>

                <div class="info-row" style="border:none;padding-bottom:0;">
                    <span class="info-label">Répartition par niveau</span>
                    <div class="niveau-bars" style="margin-top:8px;">
                        <?php
                        $niveaux = [
                            ['label' => 'Débutant',      'count' => $nbDebutant, 'color' => '#5B9BF0'],
                            ['label' => 'Intermédiaire', 'count' => $nbInter,    'color' => '#F5A623'],
                            ['label' => 'Avancé',        'count' => $nbAvance,   'color' => '#7ab86a'],
                        ];
                        foreach ($niveaux as $n):
                            $pct = $total > 0 ? round(($n['count'] / $total) * 100) : 0;
                        ?>
                        <div class="niveau-bar-row">
                            <span class="niveau-bar-label" style="color:<?= $n['color'] ?>;">
                                <?= $n['label'] ?>
                            </span>
                            <div class="niveau-bar-bg">
                                <div class="niveau-bar-fill"
                                     style="width:<?= $pct ?>%;background:<?= $n['color'] ?>;"></div>
                            </div>
                            <span class="niveau-bar-count"><?= $n['count'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Attribution (RH uniquement) -->
        <?php if ($idPfl == 1): ?>
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon"><i class="fas fa-user-plus"></i></div>
                    <p class="card-title">Attribuer à un employé</p>
                </div>
                <?php if (!empty($employesSans)): ?>
                <span style="background:rgba(255,255,255,0.05);border:1px solid var(--c-border);
                             color:var(--c-muted);font-size:0.68rem;font-weight:700;
                             padding:2px 9px;border-radius:10px;">
                    <?= count($employesSans) ?> dispo.
                </span>
                <?php endif; ?>
            </div>

            <?php if (empty($employesSans)): ?>
            <div class="empty-state" style="padding:20px;">
                <i class="fas fa-check-circle" style="color:var(--c-orange);opacity:0.6;"></i>
                Tous les employés possèdent déjà cette compétence.
            </div>
            <?php else: ?>
            <form action="<?= base_url('competence/attribuer/' . $idCmp) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="attr-form">
                    <div class="attr-form-grid">
                        <div class="form-group-sm" style="grid-column:1/-1;">
                            <label class="form-label-sm">Employé <span style="color:var(--c-orange);">*</span></label>
                            <select name="id_Emp" class="form-control-sm" required>
                                <option value="">— Choisir un employé —</option>
                                <?php foreach ($employesSans as $emp): ?>
                                <option value="<?= $emp['id_Emp'] ?>">
                                    <?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>
                                    <?php if (!empty($emp['Nom_Dir'])): ?>
                                    — <?= esc($emp['Nom_Dir']) ?>
                                    <?php endif; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group-sm">
                            <label class="form-label-sm">Niveau <span style="color:var(--c-orange);">*</span></label>
                            <select name="Niveau_Obt" class="form-control-sm" required>
                                <option value="debutant">Débutant</option>
                                <option value="intermediaire">Intermédiaire</option>
                                <option value="avance">Avancé</option>
                            </select>
                        </div>
                        <div class="form-group-sm">
                            <label class="form-label-sm">Date obtention</label>
                            <input type="date" name="Dte_Obt" class="form-control-sm"
                                   value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn-submit-sm">
                        <i class="fas fa-user-plus"></i> Attribuer
                    </button>
                </div>
            </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div><!-- /COL GAUCHE -->

    <!-- COL DROITE — Employés -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <p class="card-title">Employés avec cette compétence</p>
            </div>
            <span style="background:var(--c-orange-pale);border:1px solid var(--c-orange-border);
                         color:var(--c-orange);font-size:0.68rem;font-weight:700;
                         padding:2px 9px;border-radius:10px;">
                <?= $total ?> employé(s)
            </span>
        </div>

        <!-- Onglets -->
        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('tous', this)">
                <i class="fas fa-users"></i> Tous
                <span class="tab-count"><?= $total ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('debutant', this)">
                <i class="fas fa-seedling"></i> Débutant
                <span class="tab-count"><?= $nbDebutant ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('intermediaire', this)">
                <i class="fas fa-layer-group"></i> Intermédiaire
                <span class="tab-count"><?= $nbInter ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('avance', this)">
                <i class="fas fa-trophy"></i> Avancé
                <span class="tab-count"><?= $nbAvance ?></span>
            </button>
        </div>

        <!-- Filtres -->
        <form method="GET" action="<?= base_url('competence/show/' . $idCmp) ?>">
            <div class="filter-bar">
                <div class="filter-group-sm">
                    <label class="filter-lbl-sm">Recherche</label>
                    <input type="text" name="recherche" class="filter-ctrl-sm"
                           placeholder="Nom ou prénom..."
                           value="<?= esc($filtreRecherche) ?>" style="width:160px;">
                </div>
                <?php if ($idPfl == 1): ?>
                <div class="filter-group-sm">
                    <label class="filter-lbl-sm">Direction</label>
                    <select name="id_Dir" class="filter-ctrl-sm">
                        <option value="">Toutes</option>
                        <?php foreach ($directions as $dir): ?>
                        <option value="<?= $dir['id_Dir'] ?>"
                                <?= $filtreIdDir == $dir['id_Dir'] ? 'selected' : '' ?>>
                            <?= esc($dir['Nom_Dir']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <div class="filter-group-sm">
                    <label class="filter-lbl-sm">Date de</label>
                    <input type="date" name="date_from" class="filter-ctrl-sm"
                           value="<?= esc($filtreDateFrom) ?>">
                </div>
                <div class="filter-group-sm">
                    <label class="filter-lbl-sm">Date à</label>
                    <input type="date" name="date_to" class="filter-ctrl-sm"
                           value="<?= esc($filtreDateTo) ?>">
                </div>
                <div class="filter-group-sm" style="justify-content:flex-end;">
                    <label class="filter-lbl-sm">&nbsp;</label>
                    <div style="display:flex;gap:6px;">
                        <button type="submit" class="btn-submit-sm">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if ($filtreRecherche || $filtreIdDir || $filtreDateFrom || $filtreDateTo): ?>
                        <a href="<?= base_url('competence/show/' . $idCmp) ?>" class="btn-ghost" style="padding:7px 10px;">
                            <i class="fas fa-times"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>

        <!-- Panneaux par onglet -->
        <?php
        $groupes = [
            'tous'         => $employes,
            'debutant'     => array_values(array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'debutant')),
            'intermediaire'=> array_values(array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'intermediaire')),
            'avance'       => array_values(array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'avance')),
        ];

        foreach ($groupes as $groupe => $rows):
        ?>
        <div class="tab-panel <?= $groupe === 'tous' ? 'active' : '' ?>" id="panel-<?= $groupe ?>">
            <?php if (empty($rows)): ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                Aucun employé dans cette catégorie.
            </div>
            <?php else: ?>
            <table class="emp-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employé</th>
                        <?php if ($idPfl == 1): ?><th>Direction</th><?php endif; ?>
                        <th>Niveau</th>
                        <th>Date obtention</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $i => $emp):
                        [$bnCls, $bnLabel] = match($emp['Niveau_Obt']) {
                            'debutant'      => ['bn-debutant',      'Débutant'],
                            'intermediaire' => ['bn-intermediaire', 'Intermédiaire'],
                            'avance'        => ['bn-avance',        'Avancé'],
                            default         => ['bn-debutant',       $emp['Niveau_Obt']],
                        };
                    ?>
                    <tr>
                        <td style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                        <td>
                            <a href="<?= base_url('employe/show/' . $emp['id_Emp']) ?>"
                               style="text-decoration:none;display:inline-flex;align-items:center;">
                                <span class="emp-avatar">
                                    <?= mb_substr($emp['Nom_Emp'] ?? '?', 0, 1) . mb_substr($emp['Prenom_Emp'] ?? '', 0, 1) ?>
                                </span>
                                <span style="color:#fff;font-weight:500;">
                                    <?= esc(($emp['Nom_Emp'] ?? '') . ' ' . ($emp['Prenom_Emp'] ?? '')) ?>
                                </span>
                            </a>
                        </td>
                        <?php if ($idPfl == 1): ?>
                        <td style="color:var(--c-muted);font-size:0.75rem;">
                            <?= esc($emp['Nom_Dir'] ?? '-') ?>
                        </td>
                        <?php endif; ?>
                        <td>
                            <span class="badge-niveau <?= $bnCls ?>"><?= $bnLabel ?></span>
                        </td>
                        <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                            <?= $emp['Dte_Obt'] ? date('d/m/Y', strtotime($emp['Dte_Obt'])) : '-' ?>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:inline-flex;gap:5px;">
                                <a href="<?= base_url('employe/show/' . $emp['id_Emp']) ?>"
                                   class="btn-icon btn-icon-orange" title="Voir l'employé">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($idPfl == 1): ?>
                                <button class="btn-icon btn-icon-green" title="Modifier le niveau"
                                        onclick="openEditNiveau(<?= $emp['id_Obt'] ?>, '<?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp'], 'js') ?>', '<?= $emp['Niveau_Obt'] ?>', '<?= $emp['Dte_Obt'] ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-icon-red" title="Retirer la compétence"
                                        onclick="confirmRetirer(<?= $emp['id_Obt'] ?>, '<?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp'], 'js') ?>')">
                                    <i class="fas fa-times"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

    </div><!-- /.card -->

</div><!-- /.show-grid -->

<!-- Modal modifier niveau -->
<div class="modal-overlay" id="modal-niveau">
    <div class="modal-box">
        <p class="modal-title">Modifier le niveau</p>
        <p class="modal-sub" id="modal-niveau-emp"></p>
        <form method="POST" id="form-niveau">
            <?= csrf_field() ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;">
                <div class="form-group-sm">
                    <label class="form-label-sm">Nouveau niveau <span style="color:var(--c-orange);">*</span></label>
                    <select name="Niveau_Obt" class="form-control-sm" id="modal-niveau-select">
                        <option value="debutant">Débutant</option>
                        <option value="intermediaire">Intermédiaire</option>
                        <option value="avance">Avancé</option>
                    </select>
                </div>
                <div class="form-group-sm">
                    <label class="form-label-sm">Date obtention</label>
                    <input type="date" name="Dte_Obt" class="form-control-sm" id="modal-niveau-date">
                </div>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" onclick="closeModal('modal-niveau')"
                        style="flex:1;background:transparent;border:1px solid var(--c-border);
                               color:var(--c-soft);font-weight:600;border-radius:8px;
                               padding:9px;font-size:0.8rem;cursor:pointer;">
                    <i class="fas fa-times"></i> Annuler
                </button>
                <button type="submit"
                        style="flex:1;background:linear-gradient(135deg,var(--c-orange),#d4891a);
                               border:none;color:#111;font-weight:700;border-radius:8px;
                               padding:9px;font-size:0.8rem;cursor:pointer;">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal retirer -->
<div class="modal-overlay" id="modal-retirer">
    <div class="modal-box">
        <div style="width:44px;height:44px;border-radius:11px;background:var(--c-red-pale);
                    border:1px solid var(--c-red-border);display:flex;align-items:center;
                    justify-content:center;font-size:1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-times"></i>
        </div>
        <p class="modal-title" style="text-align:center;">Retirer la compétence</p>
        <p class="modal-sub" style="text-align:center;" id="modal-retirer-msg"></p>
        <div style="display:flex;gap:10px;margin-top:16px;">
            <button type="button" onclick="closeModal('modal-retirer')"
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
                    <i class="fas fa-trash-alt"></i> Retirer
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    // ===== TABS =====
    window.switchTab = function (panel, btn) {
        document.querySelectorAll('.tab-panel').forEach(function (p) { p.classList.remove('active'); });
        document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
        document.getElementById('panel-' + panel).classList.add('active');
        btn.classList.add('active');
    };

    // ===== MODAL HELPER =====
    window.closeModal = function (id) {
        document.getElementById(id).style.display = 'none';
    };

    ['modal-niveau', 'modal-retirer'].forEach(function (id) {
        document.getElementById(id).addEventListener('click', function (e) {
            if (e.target === this) closeModal(id);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal('modal-niveau');
            closeModal('modal-retirer');
        }
    });

    // ===== MODAL MODIFIER NIVEAU =====
    window.openEditNiveau = function (idObt, nom, niveauActuel, dateActuelle) {
        document.getElementById('modal-niveau-emp').textContent = nom;
        document.getElementById('modal-niveau-select').value = niveauActuel;
        document.getElementById('modal-niveau-date').value   = dateActuelle || '';
        document.getElementById('form-niveau').action =
            '<?= base_url('competence/modifier-niveau/') ?>' + idObt;
        document.getElementById('modal-niveau').style.display = 'flex';
    };

    // ===== MODAL RETIRER =====
    window.confirmRetirer = function (idObt, nom) {
        document.getElementById('modal-retirer-msg').innerHTML =
            'Vous allez retirer la compétence <strong style="color:#fff;"><?= esc($c['Libelle_Cmp'], 'js') ?></strong>'
            + ' du profil de <strong style="color:#fff;">' + nom + '</strong>.';
        document.getElementById('form-retirer').action =
            '<?= base_url('competence/retirer/') ?>' + idObt;
        document.getElementById('modal-retirer').style.display = 'flex';
    };

    // Déplacer modals au body
    document.addEventListener('DOMContentLoaded', function () {
        ['modal-niveau', 'modal-retirer'].forEach(function (id) {
            document.body.appendChild(document.getElementById(id));
        });
    });

})();
</script>
<?= $this->endSection() ?>