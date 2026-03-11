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

    .show-grid { display: grid; grid-template-columns: 340px 1fr; gap: 16px; align-items: start; }

    .info-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden;
    }

    .info-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 10px;
    }

    .info-card-icon {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.82rem; flex-shrink: 0;
    }

    .info-card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }

    .info-card-body { padding: 16px 18px; }

    .info-row {
        display: flex; flex-direction: column; gap: 3px;
        padding: 11px 0; border-bottom: 1px solid var(--c-border);
    }

    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row:first-child { padding-top: 0; }

    .info-label {
        font-size: 0.67rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;
    }

    .info-value { color: var(--c-text); font-size: 0.82rem; font-weight: 500; }

    /* Jauge capacité */
    .cap-gauge { margin-top: 6px; }
    .cap-bar-bg { height: 6px; background: rgba(255,255,255,0.06); border-radius: 3px; overflow: hidden; }
    .cap-bar-fill { height: 100%; border-radius: 3px; transition: width 0.5s ease; }
    .cap-legend { display: flex; justify-content: space-between; margin-top: 4px; font-size: 0.68rem; color: var(--c-muted); }

    /* Badge dispo */
    .badge-dispo {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px; font-size: 0.7rem; font-weight: 700;
    }

    .bd-dispo   { background: var(--c-green-pale);                   border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bd-complet { background: var(--c-red-pale);                     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bd-futur   { background: var(--c-blue-pale);                    border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bd-passe   { background: rgba(255,255,255,0.04);                 border: 1px solid var(--c-border);        color: var(--c-muted); }

    /* Participants */
    .part-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden;
    }

    .part-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;
    }

    .part-card-header-left { display: flex; align-items: center; gap: 10px; }
    .part-card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }

    /* Stats pills participants */
    .part-stats { display: flex; gap: 8px; flex-wrap: wrap; }

    .part-stat {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 5px 12px;
        display: flex; align-items: center; gap: 6px; font-size: 0.75rem;
    }

    .part-stat-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    /* Tab participants */
    .part-tabs { display: flex; gap: 3px; padding: 10px 14px; border-bottom: 1px solid var(--c-border); }

    .part-tab {
        padding: 5px 14px; border-radius: 6px; border: none;
        background: transparent; color: var(--c-muted); font-size: 0.75rem;
        font-weight: 600; cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 6px;
    }

    .part-tab:hover { color: var(--c-soft); background: rgba(255,255,255,0.03); }

    .part-tab.active {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange);
    }

    .part-tab-count {
        background: rgba(255,255,255,0.08); color: var(--c-muted);
        font-size: 0.62rem; font-weight: 700; padding: 1px 6px; border-radius: 8px;
    }

    .part-tab.active .part-tab-count { background: var(--c-orange-border); color: var(--c-orange); }

    .part-tab-panel { display: none; }
    .part-tab-panel.active { display: block; }

    /* Tableau participants */
    .part-table { width: 100%; border-collapse: collapse; font-size: 0.79rem; }

    .part-table thead th {
        padding: 8px 14px; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border);
    }

    .part-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .part-table tbody tr:last-child td { border-bottom: none; }
    .part-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    .emp-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.62rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; flex-shrink: 0; vertical-align: middle;
        margin-right: 8px;
    }

    .badge-ins {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 9px; border-radius: 20px; font-size: 0.66rem; font-weight: 700;
    }

    .bi-valide  { background: var(--c-green-pale);   border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bi-inscrit { background: var(--c-yellow-pale);  border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bi-annule  { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }

    .empty-state {
        padding: 30px; text-align: center;
        color: var(--c-muted); font-size: 0.8rem;
    }

    .empty-state i { font-size: 1.5rem; opacity: 0.3; margin-bottom: 8px; display: block; }

    /* Mon statut banner */
    .mon-statut-banner {
        margin: 0 18px 14px;
        border-radius: 10px; padding: 12px 16px;
        display: flex; align-items: center; gap: 12px;
    }

    .msb-valide  { background: var(--c-green-pale);  border: 1px solid var(--c-green-border); }
    .msb-inscrit { background: var(--c-yellow-pale); border: 1px solid var(--c-yellow-border); }
    .msb-annule  { background: var(--c-red-pale);    border: 1px solid var(--c-red-border); }

    .msb-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0;
    }

    /* Boutons */
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

    .btn-red {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        color: #ff8080; font-weight: 600; border-radius: 8px;
        padding: 8px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-red:hover { background: rgba(224,82,82,0.2); }

    .btn-icon {
        width: 28px; height: 28px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.7rem; cursor: pointer; transition: all 0.2s; border: none;
    }

    .btn-icon-red    { background: var(--c-red-pale);    color: #ff8080; border: 1px solid var(--c-red-border); }
    .btn-icon-green  { background: var(--c-green-pale);  color: #7ab86a; border: 1px solid var(--c-green-border); }
    .btn-icon:hover  { transform: scale(1.1); }

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

    @media (max-width: 900px) { .show-grid { grid-template-columns: 1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$f       = $formation;
$today   = date('Y-m-d');
$debut   = $f['DateDebut_Frm'];
$fin     = $f['DateFin_Frm'];
$cap     = (int)$f['Capacite_Frm'];
$isFutur = $debut > $today;
$isPasse = $fin < $today;
$isComp  = $nbValides >= $cap && $cap > 0;
$pct     = $cap > 0 ? min(100, round(($nbValides / $cap) * 100)) : 0;

if ($isFutur)      [$dKey,$dLabel,$dIcon] = ['futur',   'À venir',    'fa-clock',        '#5B9BF0'];
elseif ($isPasse)  [$dKey,$dLabel,$dIcon] = ['passe',   'Passée',     'fa-history',      'rgba(255,255,255,0.3)'];
elseif ($isComp)   [$dKey,$dLabel,$dIcon] = ['complet', 'Complète',   'fa-users-slash',  '#ff8080'];
else               [$dKey,$dLabel,$dIcon] = ['dispo',   'Disponible', 'fa-check-circle', '#7ab86a'];

$barColor = match($dKey) {
    'dispo'   => 'linear-gradient(90deg,#7ab86a,#4a6741)',
    'complet' => 'linear-gradient(90deg,#ff8080,#c0392b)',
    'futur'   => 'linear-gradient(90deg,#5B9BF0,#2980b9)',
    default   => 'rgba(255,255,255,0.2)',
};

$monIns    = $monInscription;
$insStatut = $monIns ? $monIns['Stt_Ins'] : 'non';

$valides  = array_filter($participants, fn($p) => $p['Stt_Ins'] === 'valide');
$inscrits = array_filter($participants, fn($p) => $p['Stt_Ins'] === 'inscrit');
$annules  = array_filter($participants, fn($p) => $p['Stt_Ins'] === 'annule');
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chalkboard-teacher me-2" style="color:#F5A623;"></i>
            <?= esc(mb_substr($f['Description_Frm'], 0, 50)) ?><?= mb_strlen($f['Description_Frm']) > 50 ? '…' : '' ?>
        </h1>
        <p>Détail de la formation · ID #<?= (int)$f['id_Frm'] ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('formation') ?>" class="btn-ghost">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <?php if ($idPfl == 1): ?>
        <a href="<?= base_url('formation/edit/' . $f['id_Frm']) ?>" class="btn-orange">
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

    <!-- COL GAUCHE — infos -->
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon"><i class="fas fa-info-circle"></i></div>
            <p class="info-card-title">Informations</p>
        </div>
        <div class="info-card-body">

            <div class="info-row">
                <span class="info-label">Description</span>
                <span class="info-value"><?= nl2br(esc($f['Description_Frm'])) ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Lieu</span>
                <span class="info-value">
                    <i class="fas fa-map-marker-alt" style="color:var(--c-orange);margin-right:5px;"></i>
                    <?= esc($f['Lieu_Frm']) ?>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Formateur</span>
                <span class="info-value">
                    <i class="fas fa-user-tie" style="color:var(--c-muted);margin-right:5px;"></i>
                    <?= esc($f['Formateur_Frm']) ?>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Dates</span>
                <span class="info-value">
                    <?= date('d/m/Y', strtotime($debut)) ?>
                    <span style="color:var(--c-muted);margin:0 6px;">→</span>
                    <?= date('d/m/Y', strtotime($fin)) ?>
                </span>
                <?php
                $diffDays = (int)round((strtotime($fin) - strtotime($debut)) / 86400) + 1;
                ?>
                <span class="field-hint" style="margin-top:3px;">
                    <i class="fas fa-clock" style="color:var(--c-orange);"></i>
                    <?= $diffDays ?> jour<?= $diffDays > 1 ? 's' : '' ?>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Disponibilité</span>
                <span class="badge-dispo bd-<?= $dKey ?>" style="margin-top:4px;">
                    <i class="fas <?= $dIcon ?>"></i> <?= $dLabel ?>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Capacité</span>
                <div class="cap-gauge">
                    <span class="info-value"><?= $nbValides ?> / <?= $cap ?> confirmés</span>
                    <div class="cap-bar-bg" style="margin-top:5px;">
                        <div class="cap-bar-fill" style="width:<?= $pct ?>%;background:<?= $barColor ?>;"></div>
                    </div>
                    <div class="cap-legend">
                        <span><?= $nbInscrits ?> en attente</span>
                        <span><?= $pct ?>%</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Mon statut d'inscription -->
        <?php if ($insStatut !== 'non'): ?>
        <?php
        [$msbCls, $msbColor, $msbIcon, $msbLabel] = match($insStatut) {
            'valide'  => ['msb-valide',  '#7ab86a', 'fa-check-circle', 'Vous êtes confirmé(e) pour cette formation'],
            'inscrit' => ['msb-inscrit', '#ffc107', 'fa-clock',        'Votre inscription est en attente de confirmation'],
            'annule'  => ['msb-annule',  '#ff8080', 'fa-times-circle', 'Votre inscription a été annulée'],
            default   => ['msb-inscrit', '#ffc107', 'fa-clock',        ''],
        };
        ?>
        <div class="mon-statut-banner <?= $msbCls ?>">
            <div class="msb-icon" style="background:rgba(0,0,0,0.2);">
                <i class="fas <?= $msbIcon ?>" style="color:<?= $msbColor ?>;"></i>
            </div>
            <div>
                <div style="font-size:0.68rem;color:<?= $msbColor ?>;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Mon statut</div>
                <div style="font-size:0.8rem;color:rgba(255,255,255,0.7);margin-top:2px;"><?= $msbLabel ?></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Lien demande liée -->
        <?php if (!empty($demande)): ?>
        <div style="padding:0 18px 16px;">
            <div style="font-size:0.68rem;color:var(--c-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Demande liée</div>
            <a href="<?= base_url('demande-formation/show/' . $demande['id_DFrm']) ?>"
               style="display:flex;align-items:center;gap:8px;background:#111;border:1px solid var(--c-border);border-radius:8px;padding:9px 12px;text-decoration:none;transition:border-color 0.2s;"
               onmouseover="this.style.borderColor='var(--c-orange-border)'"
               onmouseout="this.style.borderColor='var(--c-border)'">
                <i class="fas fa-file-alt" style="color:var(--c-orange);font-size:0.75rem;"></i>
                <span style="color:var(--c-soft);font-size:0.78rem;">Demande #<?= (int)$demande['id_DFrm'] ?></span>
                <i class="fas fa-chevron-right" style="color:var(--c-muted);font-size:0.65rem;margin-left:auto;"></i>
            </a>
        </div>
        <?php endif; ?>

    </div>

    <!-- COL DROITE — participants -->
    <div class="part-card">
        <div class="part-card-header">
            <div class="part-card-header-left">
                <div class="info-card-icon"><i class="fas fa-users"></i></div>
                <p class="part-card-title">Participants</p>
            </div>
            <div class="part-stats">
                <div class="part-stat">
                    <span class="part-stat-dot" style="background:#7ab86a;"></span>
                    <span style="color:#7ab86a;font-weight:700;"><?= $nbValides ?></span>
                    <span style="color:var(--c-muted);">confirmés</span>
                </div>
                <div class="part-stat">
                    <span class="part-stat-dot" style="background:#ffc107;"></span>
                    <span style="color:#ffc107;font-weight:700;"><?= $nbInscrits ?></span>
                    <span style="color:var(--c-muted);">en attente</span>
                </div>
                <div class="part-stat">
                    <span class="part-stat-dot" style="background:#ff8080;"></span>
                    <span style="color:#ff8080;font-weight:700;"><?= $nbAnnules ?></span>
                    <span style="color:var(--c-muted);">annulés</span>
                </div>
            </div>
        </div>

        <!-- Onglets -->
        <div class="part-tabs">
            <button class="part-tab active" onclick="switchPartTab('valide', this)">
                <i class="fas fa-check-circle"></i> Confirmés
                <span class="part-tab-count"><?= $nbValides ?></span>
            </button>
            <button class="part-tab" onclick="switchPartTab('inscrit', this)">
                <i class="fas fa-clock"></i> En attente
                <span class="part-tab-count"><?= $nbInscrits ?></span>
            </button>
            <button class="part-tab" onclick="switchPartTab('annule', this)">
                <i class="fas fa-times"></i> Annulés
                <span class="part-tab-count"><?= $nbAnnules ?></span>
            </button>
        </div>

        <?php
        function renderPartTable(array $rows, string $panelId, string $statut, int $idPfl, int $isFrm): void
        {
            $emptyMsg = match($statut) {
                'valide'  => 'Aucun participant confirmé.',
                'inscrit' => 'Aucune inscription en attente.',
                'annule'  => 'Aucune inscription annulée.',
                default   => '',
            };
        ?>
        <div class="part-tab-panel <?= $panelId === 'valide' ? 'active' : '' ?>" id="panel-part-<?= $panelId ?>">
            <?php if (empty($rows)): ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <?= $emptyMsg ?>
            </div>
            <?php else: ?>
            <table class="part-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Participant</th>
                        <th>Direction</th>
                        <th>Date inscription</th>
                        <th>Statut</th>
                        <?php if ($idPfl == 1 && $statut === 'inscrit'): ?>
                        <th style="text-align:center;">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_values($rows) as $i => $p):
                        [$biCls, $biLabel] = match($p['Stt_Ins']) {
                            'valide'  => ['bi-valide',  'Confirmé'],
                            'inscrit' => ['bi-inscrit', 'En attente'],
                            'annule'  => ['bi-annule',  'Annulé'],
                            default   => ['bi-inscrit', $p['Stt_Ins']],
                        };
                    ?>
                    <tr>
                        <td style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                        <td>
                            <span class="emp-avatar">
                                <?= mb_substr($p['Nom_Emp'] ?? '?', 0, 1) . mb_substr($p['Prenom_Emp'] ?? '', 0, 1) ?>
                            </span>
                            <span style="color:#fff;font-weight:500;">
                                <?= esc(($p['Nom_Emp'] ?? '') . ' ' . ($p['Prenom_Emp'] ?? '')) ?>
                            </span>
                        </td>
                        <td style="color:var(--c-muted);font-size:0.75rem;">
                            <?= esc($p['Nom_Dir'] ?? '-') ?>
                        </td>
                        <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                            <?= $p['Dte_Ins'] ? date('d/m/Y', strtotime($p['Dte_Ins'])) : '-' ?>
                        </td>
                        <td>
                            <span class="badge-ins <?= $biCls ?>">
                                <?= $biLabel ?>
                            </span>
                        </td>
                        <?php if ($idPfl == 1 && $statut === 'inscrit'): ?>
                        <td style="text-align:center;">
                            <div style="display:inline-flex;gap:5px;">
                                <form method="POST" action="<?= base_url('formation/valider-inscription/' . $p['id_Ins']) ?>">
                                    <?= csrf_field() ?>
                                    <button class="btn-icon btn-icon-green" title="Confirmer">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="<?= base_url('formation/annuler-inscription/' . $p['id_Ins']) ?>">
                                    <?= csrf_field() ?>
                                    <button class="btn-icon btn-icon-red" title="Annuler">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php } ?>

        <?php renderPartTable(array_values($valides),  'valide',  'valide',  $idPfl, (int)$f['id_Frm']); ?>
        <?php renderPartTable(array_values($inscrits), 'inscrit', 'inscrit', $idPfl, (int)$f['id_Frm']); ?>
        <?php renderPartTable(array_values($annules),  'annule',  'annule',  $idPfl, (int)$f['id_Frm']); ?>

    </div><!-- /.part-card -->

</div><!-- /.show-grid -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    window.switchPartTab = function (panel, btn) {
        document.querySelectorAll('.part-tab-panel').forEach(function (p) { p.classList.remove('active'); });
        document.querySelectorAll('.part-tab').forEach(function (b) { b.classList.remove('active'); });
        document.getElementById('panel-part-' + panel).classList.add('active');
        btn.classList.add('active');
    };
})();
</script>
<?= $this->endSection() ?>