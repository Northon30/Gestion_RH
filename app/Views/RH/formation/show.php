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
        --c-purple-pale:   rgba(139,92,246,0.10);
        --c-purple-border: rgba(139,92,246,0.25);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .show-grid {
        display: grid; grid-template-columns: 320px 1fr;
        gap: 16px; align-items: start;
    }

    .card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; margin-bottom: 16px;
    }

    .card:last-child { margin-bottom: 0; }

    .card-header {
        padding: 13px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 8px;
    }

    .card-header-left { display: flex; align-items: center; gap: 10px; }

    .card-icon {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.82rem; flex-shrink: 0;
    }

    .card-icon-green  { background: var(--c-green-pale);  border-color: var(--c-green-border);  color: #7ab86a; }
    .card-icon-blue   { background: var(--c-blue-pale);   border-color: var(--c-blue-border);   color: #5B9BF0; }
    .card-icon-purple { background: var(--c-purple-pale); border-color: var(--c-purple-border); color: #8b5cf6; }
    .card-icon-red    { background: var(--c-red-pale);    border-color: var(--c-red-border);    color: #ff8080; }

    .card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }
    .card-body  { padding: 16px 18px; }

    .info-row {
        display: flex; flex-direction: column; gap: 3px;
        padding: 11px 0; border-bottom: 1px solid var(--c-border);
    }

    .info-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .info-row:first-child { padding-top: 0; }

    .info-label {
        font-size: 0.67rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;
    }

    .info-value { color: var(--c-text); font-size: 0.82rem; font-weight: 500; }

    .cap-bar-bg {
        height: 6px; background: rgba(255,255,255,0.06);
        border-radius: 3px; overflow: hidden; margin-top: 5px;
    }

    .cap-bar-fill { height: 100%; border-radius: 3px; transition: width 0.5s ease; }
    .cap-legend   { display: flex; justify-content: space-between; margin-top: 4px; font-size: 0.68rem; color: var(--c-muted); }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.67rem; font-weight: 700; white-space: nowrap;
    }

    .badge-orange  { background: var(--c-orange-pale);   border: 1px solid var(--c-orange-border);  color: var(--c-orange); }
    .badge-green   { background: var(--c-green-pale);    border: 1px solid var(--c-green-border);   color: #7ab86a; }
    .badge-red     { background: var(--c-red-pale);      border: 1px solid var(--c-red-border);     color: #ff8080; }
    .badge-blue    { background: var(--c-blue-pale);     border: 1px solid var(--c-blue-border);    color: #5B9BF0; }
    .badge-yellow  { background: var(--c-yellow-pale);   border: 1px solid var(--c-yellow-border);  color: #ffc107; }
    .badge-purple  { background: var(--c-purple-pale);   border: 1px solid var(--c-purple-border);  color: #8b5cf6; }
    .badge-muted   { background: rgba(255,255,255,0.04); border: 1px solid var(--c-border);         color: var(--c-muted); }

    .tabs { display: flex; gap: 3px; padding: 10px 14px; border-bottom: 1px solid var(--c-border); flex-wrap: wrap; }

    .tab {
        padding: 5px 14px; border-radius: 6px; border: none;
        background: transparent; color: var(--c-muted); font-size: 0.75rem;
        font-weight: 600; cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 6px;
    }

    .tab:hover { color: var(--c-soft); background: rgba(255,255,255,0.03); }

    .tab.active {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange);
    }

    .tab-count {
        background: rgba(255,255,255,0.08); color: var(--c-muted);
        font-size: 0.62rem; font-weight: 700; padding: 1px 6px; border-radius: 8px;
    }

    .tab.active .tab-count { background: var(--c-orange-border); color: var(--c-orange); }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    .data-table { width: 100%; border-collapse: collapse; font-size: 0.79rem; }

    .data-table thead th {
        padding: 8px 14px; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border);
    }

    .data-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    .avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.62rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; flex-shrink: 0;
        vertical-align: middle; margin-right: 8px;
    }

    .stats-row { display: flex; gap: 8px; flex-wrap: wrap; }

    .stat-pill {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 5px 12px;
        display: flex; align-items: center; gap: 6px; font-size: 0.75rem;
    }

    .stat-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .my-status-banner {
        margin: 0 18px 14px; border-radius: 10px;
        padding: 12px 16px; display: flex; align-items: center; gap: 12px;
    }

    .msb-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0; background: rgba(0,0,0,0.2);
    }

    .competence-form { padding: 16px 18px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }

    .form-label {
        font-size: 0.68rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;
    }

    .form-select, .form-input {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 7px; color: var(--c-text); font-size: 0.8rem;
        padding: 8px 12px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }

    .form-select:focus, .form-input:focus { border-color: var(--c-orange-border); }
    .form-select option { background: #1a1a1a; }

    .emp-select-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 8px; margin-top: 10px; max-height: 220px;
        overflow-y: auto; padding: 4px;
    }

    .emp-select-item {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 8px 12px;
        display: flex; align-items: center; gap: 8px;
        cursor: pointer; transition: all 0.15s;
    }

    .emp-select-item:hover { border-color: var(--c-orange-border); }
    .emp-select-item.selected { background: var(--c-orange-pale); border-color: var(--c-orange-border); }

    .emp-select-item input[type="checkbox"] {
        accent-color: var(--c-orange); width: 14px; height: 14px; flex-shrink: 0;
    }

    .emp-select-name { font-size: 0.78rem; color: var(--c-text); font-weight: 500; }
    .emp-select-dir  { font-size: 0.68rem; color: var(--c-muted); }

    .mode-toggle { display: flex; gap: 6px; margin-bottom: 12px; }

    .mode-btn {
        padding: 5px 12px; border-radius: 6px; border: 1px solid var(--c-border);
        background: transparent; color: var(--c-muted); font-size: 0.73rem;
        font-weight: 600; cursor: pointer; transition: all 0.2s;
    }

    .mode-btn.active {
        background: var(--c-orange-pale); border-color: var(--c-orange-border);
        color: var(--c-orange);
    }

    .competence-chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--c-purple-pale); border: 1px solid var(--c-purple-border);
        border-radius: 20px; padding: 3px 10px; font-size: 0.7rem;
        color: #8b5cf6; font-weight: 600; margin: 3px;
    }

    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none; white-space: nowrap;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .btn-green {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        color: #7ab86a; font-weight: 600; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-green:hover { background: rgba(74,103,65,0.3); }

    .btn-red {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        color: #ff8080; font-weight: 600; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-red:hover { background: rgba(224,82,82,0.2); }

    .btn-purple {
        background: var(--c-purple-pale); border: 1px solid var(--c-purple-border);
        color: #8b5cf6; font-weight: 700; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; white-space: nowrap;
    }

    .btn-purple:hover { background: rgba(139,92,246,0.2); }

    .alert-success {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        border-radius: 10px; padding: 11px 16px; color: #7ab86a;
        font-size: 0.82rem; display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
    }

    .alert-error {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
    }

    .empty-state {
        padding: 28px; text-align: center;
        color: var(--c-muted); font-size: 0.8rem;
    }

    .empty-state i { font-size: 1.4rem; opacity: 0.3; margin-bottom: 8px; display: block; }

    .invite-form {
        padding: 14px 18px; border-top: 1px solid var(--c-border);
        display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap;
    }

    .invite-form .form-group { flex: 1; min-width: 200px; }

    @media (max-width: 900px) { .show-grid { grid-template-columns: 1fr; } }
    @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$f       = $formation;
$today   = date('Y-m-d');
$debut   = $f['DateDebut_Frm'];
$fin     = $f['DateFin_Frm'];
$cap     = (int) $f['Capacite_Frm'];
$statut  = $f['Statut_Frm'] ?? 'planifiee';
$isTermi = $statut === 'terminee' || $fin < $today;
$isFutur = $debut > $today;
$isComp  = $nbValides >= $cap && $cap > 0;
$pct     = $cap > 0 ? min(100, round(($nbValides / $cap) * 100)) : 0;
$titre   = $f['Titre_Frm'] ?? $f['Description_Frm'];

if ($isFutur)                                 [$dKey, $dLabel, $dIcon] = ['futur',   'À venir',    'fa-clock'];
elseif ($isComp)                              [$dKey, $dLabel, $dIcon] = ['complet', 'Complète',   'fa-users-slash'];
elseif ($statut === 'terminee'||$fin < $today)[$dKey, $dLabel, $dIcon] = ['passe',   'Passée',     'fa-history'];
else                                          [$dKey, $dLabel, $dIcon] = ['dispo',   'Disponible', 'fa-check-circle'];

$barColor = match($dKey) {
    'dispo'   => 'linear-gradient(90deg,#7ab86a,#4a6741)',
    'complet' => 'linear-gradient(90deg,#ff8080,#c0392b)',
    'futur'   => 'linear-gradient(90deg,#5B9BF0,#2980b9)',
    default   => 'rgba(255,255,255,0.2)',
};

[$sCls, $sLabel, $sIcon] = match($statut) {
    'planifiee' => ['badge-blue',   'Planifiée', 'fa-calendar'],
    'en_cours'  => ['badge-yellow', 'En cours',  'fa-play-circle'],
    'terminee'  => ['badge-green',  'Terminée',  'fa-check-double'],
    'annulee'   => ['badge-red',    'Annulée',   'fa-ban'],
    default     => ['badge-muted',  'Inconnu',   'fa-question'],
};

$monIns    = $monInscription;
$insStatut = $monIns ? $monIns['Stt_Ins'] : 'non';

$valides = array_values(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'valide'));
$invites = array_values(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'invite'));
$annules = array_values(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'annule'));

$cmpGroupes = [];
foreach ($competencesObtenues as $co) {
    $cmpGroupes[$co['id_Cmp']]['libelle']    = $co['Libelle_Cmp'];
    $cmpGroupes[$co['id_Cmp']]['employes'][] = $co;
}

$diffDays = (int) round((strtotime($fin) - strtotime($debut)) / 86400) + 1;
?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div>
        <h1>
            <i class="fas fa-chalkboard-teacher me-2" style="color:#F5A623;"></i>
            <?= esc(mb_strlen($titre) > 55 ? mb_substr($titre, 0, 55) . '…' : $titre) ?>
        </h1>
        <p>Détail de la formation · ID #<?= (int) $f['id_Frm'] ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('formation') ?>" class="btn-ghost">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <?php
        // ── CORRECTION 1 : Modifier visible pour le Chef uniquement (profil 2)
        // Le RH ne modifie plus les formations
        if ($idPfl == 2): ?>
        <a href="<?= base_url('formation/edit/' . $f['id_Frm']) ?>" class="btn-orange">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <?php endif; ?>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success">
    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error">
    <i class="fas fa-exclamation-triangle"></i> <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<div class="show-grid">

    <!-- ═══════════════════════════════
         COL GAUCHE
    ════════════════════════════════ -->
    <div>

        <!-- Infos formation -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon"><i class="fas fa-info-circle"></i></div>
                    <p class="card-title">Informations</p>
                </div>
                <span class="badge <?= $sCls ?>">
                    <i class="fas <?= $sIcon ?>"></i> <?= $sLabel ?>
                </span>
            </div>
            <div class="card-body">

                <div class="info-row">
                    <span class="info-label">Titre</span>
                    <span class="info-value" style="color:#fff;font-weight:600;">
                        <?= esc($titre) ?>
                    </span>
                </div>

                <?php if (!empty($f['Description_Frm']) && $f['Description_Frm'] !== $titre): ?>
                <div class="info-row">
                    <span class="info-label">Description</span>
                    <span class="info-value"><?= nl2br(esc($f['Description_Frm'])) ?></span>
                </div>
                <?php endif; ?>

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
                        <span style="color:var(--c-muted);font-size:0.75rem;margin-left:6px;">
                            (<?= $diffDays ?> jour<?= $diffDays > 1 ? 's' : '' ?>)
                        </span>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Disponibilité</span>
                    <span class="badge badge-<?= $dKey === 'dispo' ? 'green' : ($dKey === 'complet' ? 'red' : ($dKey === 'futur' ? 'blue' : 'muted')) ?>"
                          style="margin-top:4px;">
                        <i class="fas <?= $dIcon ?>"></i> <?= $dLabel ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Capacité</span>
                    <div>
                        <span class="info-value"><?= $nbValides ?> / <?= $cap ?> confirmés</span>
                        <div class="cap-bar-bg">
                            <div class="cap-bar-fill"
                                 style="width:<?= $pct ?>%;background:<?= $barColor ?>;"></div>
                        </div>
                        <div class="cap-legend">
                            <span><?= $nbInvites ?> invitation(s) en attente</span>
                            <span><?= $pct ?>%</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Mon statut (employé connecté) -->
            <?php if ($insStatut !== 'non'): ?>
            <?php
            [$msbBorder, $msbColor, $msbIcon, $msbLabel] = match($insStatut) {
                'valide' => ['var(--c-green-border)',  '#7ab86a', 'fa-check-circle', 'Vous êtes confirmé(e) pour cette formation'],
                'invite' => ['var(--c-yellow-border)', '#ffc107', 'fa-envelope',     'Vous avez une invitation en attente'],
                'annule' => ['var(--c-red-border)',    '#ff8080', 'fa-times-circle', 'Votre inscription a été annulée'],
                default  => ['var(--c-border)',        'var(--c-muted)', 'fa-question', ''],
            };
            ?>
            <div class="my-status-banner" style="border:1px solid <?= $msbBorder ?>;">
                <div class="msb-icon">
                    <i class="fas <?= $msbIcon ?>" style="color:<?= $msbColor ?>;"></i>
                </div>
                <div>
                    <div style="font-size:0.68rem;color:<?= $msbColor ?>;font-weight:700;
                                text-transform:uppercase;letter-spacing:0.5px;">Mon statut</div>
                    <div style="font-size:0.8rem;color:rgba(255,255,255,0.7);margin-top:2px;">
                        <?= $msbLabel ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div><!-- /.card infos -->

        <!-- Actions employé (profil 3) -->
        <?php if ($idPfl == 3): ?>
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon card-icon-blue"><i class="fas fa-hand-pointer"></i></div>
                    <p class="card-title">Actions</p>
                </div>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">

                <?php if ($insStatut === 'non' && !$isTermi && !$isComp): ?>
                <form method="POST"
                      action="<?= base_url('formation/s-inscrire/' . $f['id_Frm']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-green"
                            style="width:100%;justify-content:center;">
                        <i class="fas fa-user-plus"></i> S'inscrire à cette formation
                    </button>
                </form>
                <?php endif; ?>

                <?php if ($insStatut === 'invite'): ?>
                <form method="POST"
                      action="<?= base_url('formation/accepter-invitation/' . $f['id_Frm']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-green"
                            style="width:100%;justify-content:center;">
                        <i class="fas fa-check"></i> Accepter l'invitation
                    </button>
                </form>
                <form method="POST"
                      action="<?= base_url('formation/refuser-invitation/' . $f['id_Frm']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-red"
                            style="width:100%;justify-content:center;">
                        <i class="fas fa-times"></i> Refuser l'invitation
                    </button>
                </form>
                <?php endif; ?>

                <?php if ($insStatut === 'valide' && !$isTermi): ?>
                <form method="POST"
                      action="<?= base_url('formation/se-desinscrire/' . $f['id_Frm']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-red"
                            style="width:100%;justify-content:center;"
                            onclick="return confirm('Confirmer la désinscription ?')">
                        <i class="fas fa-user-minus"></i> Se désinscrire
                    </button>
                </form>
                <?php endif; ?>

                <?php if ($insStatut === 'non' && ($isTermi || $isComp)): ?>
                <div style="text-align:center;color:var(--c-muted);font-size:0.8rem;padding:8px 0;">
                    <i class="fas fa-lock" style="margin-right:6px;"></i>
                    <?= $isTermi ? 'Formation terminée' : 'Formation complète' ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>

    </div><!-- /.col-gauche -->

    <!-- ═══════════════════════════════
         COL DROITE
    ════════════════════════════════ -->
    <div>

        <!-- Participants -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon card-icon-blue"><i class="fas fa-users"></i></div>
                    <p class="card-title">Participants</p>
                </div>
                <div class="stats-row">
                    <div class="stat-pill">
                        <span class="stat-dot" style="background:#7ab86a;"></span>
                        <span style="color:#7ab86a;font-weight:700;"><?= $nbValides ?></span>
                        <span style="color:var(--c-muted);">confirmés</span>
                    </div>
                    <div class="stat-pill">
                        <span class="stat-dot" style="background:#ffc107;"></span>
                        <span style="color:#ffc107;font-weight:700;"><?= $nbInvites ?></span>
                        <span style="color:var(--c-muted);">invités</span>
                    </div>
                    <div class="stat-pill">
                        <span class="stat-dot" style="background:#ff8080;"></span>
                        <span style="color:#ff8080;font-weight:700;"><?= $nbAnnules ?></span>
                        <span style="color:var(--c-muted);">annulés</span>
                    </div>
                </div>
            </div>

            <div class="tabs">
                <button class="tab active" onclick="switchTab('valide', this)">
                    <i class="fas fa-check-circle"></i> Confirmés
                    <span class="tab-count"><?= $nbValides ?></span>
                </button>
                <button class="tab" onclick="switchTab('invite', this)">
                    <i class="fas fa-envelope"></i> Invités
                    <span class="tab-count"><?= $nbInvites ?></span>
                </button>
                <button class="tab" onclick="switchTab('annule', this)">
                    <i class="fas fa-times"></i> Annulés
                    <span class="tab-count"><?= $nbAnnules ?></span>
                </button>
            </div>

            <!-- Panel Confirmés -->
            <div class="tab-panel active" id="panel-valide">
                <?php if (empty($valides)): ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i> Aucun participant confirmé.
                </div>
                <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th><th>Participant</th><th>Direction</th><th>Date inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($valides as $i => $p): ?>
                        <tr>
                            <td style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                            <td>
                                <span class="avatar">
                                    <?= mb_substr($p['Nom_Emp']??'?',0,1).mb_substr($p['Prenom_Emp']??'',0,1) ?>
                                </span>
                                <span style="color:#fff;font-weight:500;">
                                    <?= esc(($p['Nom_Emp']??'').' '.($p['Prenom_Emp']??'')) ?>
                                </span>
                            </td>
                            <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($p['Nom_Dir']??'-') ?></td>
                            <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                                <?= $p['Dte_Ins'] ? date('d/m/Y', strtotime($p['Dte_Ins'])) : '-' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <!-- Panel Invités -->
            <div class="tab-panel" id="panel-invite">
                <?php if (empty($invites)): ?>
                <div class="empty-state">
                    <i class="fas fa-envelope"></i> Aucune invitation en attente.
                </div>
                <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th><th>Employé</th><th>Direction</th><th>Invité le</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invites as $i => $p): ?>
                        <tr>
                            <td style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                            <td>
                                <span class="avatar" style="background:var(--c-yellow-pale);border-color:var(--c-yellow-border);color:#ffc107;">
                                    <?= mb_substr($p['Nom_Emp']??'?',0,1).mb_substr($p['Prenom_Emp']??'',0,1) ?>
                                </span>
                                <span style="color:#fff;font-weight:500;">
                                    <?= esc(($p['Nom_Emp']??'').' '.($p['Prenom_Emp']??'')) ?>
                                </span>
                            </td>
                            <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($p['Nom_Dir']??'-') ?></td>
                            <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                                <?= $p['Dte_Ins'] ? date('d/m/Y', strtotime($p['Dte_Ins'])) : '-' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <!-- Panel Annulés -->
            <div class="tab-panel" id="panel-annule">
                <?php if (empty($annules)): ?>
                <div class="empty-state">
                    <i class="fas fa-times-circle"></i> Aucune inscription annulée.
                </div>
                <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th><th>Employé</th><th>Direction</th><th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($annules as $i => $p): ?>
                        <tr>
                            <td style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                            <td>
                                <span class="avatar" style="background:var(--c-red-pale);border-color:var(--c-red-border);color:#ff8080;">
                                    <?= mb_substr($p['Nom_Emp']??'?',0,1).mb_substr($p['Prenom_Emp']??'',0,1) ?>
                                </span>
                                <span style="color:var(--c-soft);font-weight:500;">
                                    <?= esc(($p['Nom_Emp']??'').' '.($p['Prenom_Emp']??'')) ?>
                                </span>
                            </td>
                            <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($p['Nom_Dir']??'-') ?></td>
                            <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                                <?= $p['Dte_Ins'] ? date('d/m/Y', strtotime($p['Dte_Ins'])) : '-' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <!-- ═══════════════════════════════
                 CORRECTION 2 : Invitation
                 RH (profil 1) ET Chef (profil 2)
                 peuvent inviter
            ════════════════════════════════ -->
            <?php if (in_array($idPfl, [1, 2]) && !$isTermi && !empty($employesDisponibles)): ?>
            <div class="invite-form">
                <form method="POST"
                      action="<?= base_url('formation/inviter/' . $f['id_Frm']) ?>"
                      style="display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap;width:100%;">
                    <?= csrf_field() ?>
                    <div class="form-group" style="flex:1;min-width:200px;">
                        <label class="form-label">
                            <?= $idPfl == 2 ? 'Inviter un employé de votre direction' : 'Inviter un employé' ?>
                        </label>
                        <select name="id_Emp" class="form-select" required>
                            <option value="">Sélectionner un employé...</option>
                            <?php foreach ($employesDisponibles as $emp): ?>
                            <option value="<?= (int) $emp['id_Emp'] ?>">
                                <?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>
                                <?= !empty($emp['Nom_Dir']) ? '— ' . esc($emp['Nom_Dir']) : '' ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-orange">
                        <i class="fas fa-paper-plane"></i> Inviter
                    </button>
                </form>
            </div>
            <?php endif; ?>

        </div><!-- /.card participants -->

        <!-- Compétences attribuées (relation tertiaire) -->
        <?php if (!empty($competencesObtenues)): ?>
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon card-icon-purple"><i class="fas fa-award"></i></div>
                    <p class="card-title">Compétences attribuées</p>
                </div>
                <span class="badge badge-purple">
                    <i class="fas fa-link"></i> Formation · Compétence · Employé
                </span>
            </div>
            <div style="padding:14px 18px;">
                <?php foreach ($cmpGroupes as $idCmp => $groupe): ?>
                <div style="margin-bottom:16px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                        <span class="badge badge-purple">
                            <i class="fas fa-star"></i> <?= esc($groupe['libelle']) ?>
                        </span>
                        <span style="font-size:0.7rem;color:var(--c-muted);">
                            <?= count($groupe['employes']) ?> employé(s)
                        </span>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Direction</th>
                                <th>Niveau</th>
                                <th>Date obtention</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($groupe['employes'] as $co): ?>
                            <?php if (empty($co['Nom_Emp'])) continue; // skip id_Emp = NULL ?>
                            <tr>
                                <td>
                                    <span class="avatar" style="background:var(--c-purple-pale);border-color:var(--c-purple-border);color:#8b5cf6;">
                                        <?= mb_substr($co['Nom_Emp']??'?',0,1).mb_substr($co['Prenom_Emp']??'',0,1) ?>
                                    </span>
                                    <span style="color:#fff;font-weight:500;">
                                        <?= esc($co['Nom_Emp'].' '.$co['Prenom_Emp']) ?>
                                    </span>
                                </td>
                                <td style="color:var(--c-muted);font-size:0.75rem;">
                                    <?= esc($co['Nom_Dir']??'-') ?>
                                </td>
                                <td>
                                    <?php
                                    [$nCls, $nLabel] = match($co['Niveau_Obt'] ?? '') {
                                        'avance'        => ['badge-green',  'Avancé'],
                                        'intermediaire' => ['badge-yellow', 'Intermédiaire'],
                                        default         => ['badge-muted',  'Débutant'],
                                    };
                                    ?>
                                    <span class="badge <?= $nCls ?>"><?= $nLabel ?></span>
                                </td>
                                <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                                    <?= $co['Dte_Obt'] ? date('d/m/Y', strtotime($co['Dte_Obt'])) : '-' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Formulaire confirmation compétences — Chef uniquement -->
        <?php if ($idPfl == 2 && !empty($participantsDirChef)): ?>
        <?php $peutConfirmer = $statut === 'terminee' || $fin < $today; ?>
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon card-icon-purple"><i class="fas fa-certificate"></i></div>
                    <p class="card-title">Confirmer les compétences</p>
                </div>
                <?php if (!$peutConfirmer): ?>
                <span class="badge badge-yellow">
                    <i class="fas fa-clock"></i> Formation pas encore terminée
                </span>
                <?php else: ?>
                <span class="badge badge-purple">
                    <i class="fas fa-users"></i>
                    <?= count($participantsDirChef) ?> participant(s) de votre direction
                </span>
                <?php endif; ?>
            </div>

            <?php if (!$peutConfirmer): ?>
            <div class="empty-state">
                <i class="fas fa-hourglass-half"></i>
                La confirmation des compétences sera disponible après la fin de la formation
                (<?= date('d/m/Y', strtotime($fin)) ?>).
            </div>
            <?php else: ?>
            <form method="POST"
                  action="<?= base_url('formation/confirmer-competences/' . $f['id_Frm']) ?>">
                <?= csrf_field() ?>
                <div class="competence-form">

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Compétence acquise <span style="color:#ff8080;">*</span>
                            </label>
                            <select name="id_Cmp" class="form-select" required>
                                <option value="">Sélectionner une compétence...</option>
                                <?php foreach ($competences as $cmp): ?>
                                <option value="<?= (int) $cmp['id_Cmp'] ?>">
                                    <?= esc($cmp['Libelle_Cmp']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Niveau</label>
                            <select name="niveau" class="form-select">
                                <option value="debutant">Débutant</option>
                                <option value="intermediaire">Intermédiaire</option>
                                <option value="avance">Avancé</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:12px;">
                        <label class="form-label">Mode de sélection</label>
                        <div class="mode-toggle">
                            <button type="button" class="mode-btn active" id="mode-btn-ont"
                                    onclick="setMode('ont_obtenu')">
                                <i class="fas fa-check"></i> Sélectionner qui a obtenu
                            </button>
                            <button type="button" class="mode-btn" id="mode-btn-nont"
                                    onclick="setMode('nont_pas_obtenu')">
                                <i class="fas fa-times"></i> Sélectionner qui n'a PAS obtenu
                            </button>
                        </div>
                        <input type="hidden" name="mode_selection" id="mode_selection"
                               value="ont_obtenu">
                        <div style="font-size:0.72rem;color:var(--c-muted);margin-top:4px;"
                             id="mode-hint">
                            Les employés cochés recevront la compétence.
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:14px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <label class="form-label">
                                Participants de votre direction (<?= count($participantsDirChef) ?>)
                            </label>
                            <div style="display:flex;gap:6px;">
                                <button type="button" class="mode-btn"
                                        style="font-size:0.68rem;padding:3px 8px;"
                                        onclick="selectAll(true)">
                                    Tout cocher
                                </button>
                                <button type="button" class="mode-btn"
                                        style="font-size:0.68rem;padding:3px 8px;"
                                        onclick="selectAll(false)">
                                    Tout décocher
                                </button>
                            </div>
                        </div>
                        <div class="emp-select-grid" id="emp-select-grid">
                            <?php foreach ($participantsDirChef as $p): ?>
                            <label class="emp-select-item" id="item-<?= (int) $p['id_Emp'] ?>">
                                <input type="checkbox"
                                       name="employes_selectionnes[]"
                                       value="<?= (int) $p['id_Emp'] ?>"
                                       onchange="toggleItem(this)">
                                <div>
                                    <div class="emp-select-name">
                                        <?= esc($p['Nom_Emp'] . ' ' . $p['Prenom_Emp']) ?>
                                    </div>
                                    <div class="emp-select-dir"><?= esc($p['Nom_Dir'] ?? '') ?></div>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn-purple"
                            style="width:100%;justify-content:center;"
                            onclick="return confirm('Confirmer l\'attribution de cette compétence ?')">
                        <i class="fas fa-certificate"></i> Valider l'attribution des compétences
                    </button>

                </div>
            </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Chef sans participants dans sa direction -->
        <?php if ($idPfl == 2 && empty($participantsDirChef) && $isTermi): ?>
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon card-icon-purple"><i class="fas fa-certificate"></i></div>
                    <p class="card-title">Confirmer les compétences</p>
                </div>
            </div>
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                Aucun employé de votre direction n'a participé à cette formation.
            </div>
        </div>
        <?php endif; ?>

    </div><!-- /.col-droite -->

</div><!-- /.show-grid -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    window.switchTab = function (panel, btn) {
        document.querySelectorAll('.tab-panel').forEach(function (p) { p.classList.remove('active'); });
        document.querySelectorAll('.tab').forEach(function (b) { b.classList.remove('active'); });
        var target = document.getElementById('panel-' + panel);
        if (target) target.classList.add('active');
        btn.classList.add('active');
    };

    window.setMode = function (mode) {
        document.getElementById('mode_selection').value = mode;
        var btnOnt  = document.getElementById('mode-btn-ont');
        var btnNont = document.getElementById('mode-btn-nont');
        var hint    = document.getElementById('mode-hint');
        if (!btnOnt || !btnNont) return;
        if (mode === 'ont_obtenu') {
            btnOnt.classList.add('active');
            btnNont.classList.remove('active');
            if (hint) hint.textContent = 'Les employés cochés recevront la compétence.';
        } else {
            btnNont.classList.add('active');
            btnOnt.classList.remove('active');
            if (hint) hint.textContent = 'Les employés cochés ne recevront PAS la compétence (les autres oui).';
        }
    };

    window.toggleItem = function (checkbox) {
        var item = document.getElementById('item-' + checkbox.value);
        if (item) item.classList.toggle('selected', checkbox.checked);
    };

    window.selectAll = function (checked) {
        document.querySelectorAll('#emp-select-grid input[type="checkbox"]').forEach(function (cb) {
            cb.checked = checked;
            var item = document.getElementById('item-' + cb.value);
            if (item) item.classList.toggle('selected', checked);
        });
    };

})();
</script>
<?= $this->endSection() ?>