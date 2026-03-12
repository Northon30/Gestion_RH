<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --e-primary:        #6BAF6B;
        --e-primary-pale:   rgba(107,175,107,0.10);
        --e-primary-border: rgba(107,175,107,0.25);
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

    .show-grid { display: grid; grid-template-columns: 320px 1fr; gap: 16px; align-items: start; }

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
        background: var(--e-primary-pale); border: 1px solid var(--e-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--e-primary); font-size: 0.82rem; flex-shrink: 0;
    }

    .info-card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }
    .info-card-body  { padding: 16px 18px; }

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

    /* Jauge */
    .cap-bar-bg   { height: 6px; background: rgba(255,255,255,0.06); border-radius: 3px; overflow: hidden; margin-top: 5px; }
    .cap-bar-fill { height: 100%; border-radius: 3px; transition: width 0.5s ease; }
    .cap-legend   { display: flex; justify-content: space-between; margin-top: 4px; font-size: 0.68rem; color: var(--c-muted); }

    /* Badges */
    .badge-dispo {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px; font-size: 0.7rem; font-weight: 700;
    }

    .bd-dispo   { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bd-complet { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bd-futur   { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bd-passe   { background: rgba(255,255,255,0.04); border: 1px solid var(--c-border);      color: var(--c-muted); }

    /* Mon statut banner */
    .mon-statut-banner {
        margin: 0 18px 16px;
        border-radius: 10px; padding: 12px 16px;
        display: flex; align-items: center; gap: 12px;
    }

    .msb-valide  { background: var(--c-green-pale);  border: 1px solid var(--c-green-border); }
    .msb-inscrit { background: var(--c-yellow-pale); border: 1px solid var(--c-yellow-border); }
    .msb-annule  { background: var(--c-red-pale);    border: 1px solid var(--c-red-border); }

    .msb-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0; background: rgba(0,0,0,0.2);
    }

    /* Actions inscription */
    .action-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; margin-bottom: 16px;
    }

    .action-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 10px;
    }

    .action-card-body { padding: 16px 18px; display: flex; flex-direction: column; gap: 10px; }

    .btn-primary {
        background: linear-gradient(135deg, var(--e-primary), #4a8a4a);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 10px 20px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none; justify-content: center;
    }

    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(107,175,107,0.3); color: #fff; }

    .btn-red-action {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        color: #ff8080; font-weight: 700; border-radius: 8px;
        padding: 10px 20px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
        width: 100%; justify-content: center;
    }

    .btn-red-action:hover { background: rgba(224,82,82,0.2); }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 8px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    /* Participants publics */
    .part-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden;
    }

    .part-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between;
    }

    .part-card-header-left { display: flex; align-items: center; gap: 10px; }
    .part-card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }

    .part-stats { display: flex; gap: 8px; flex-wrap: wrap; }

    .part-stat {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 5px 12px;
        display: flex; align-items: center; gap: 6px; font-size: 0.75rem;
    }

    .part-stat-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .part-table { width: 100%; border-collapse: collapse; font-size: 0.79rem; }

    .part-table thead th {
        padding: 8px 14px; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--e-primary); background: var(--e-primary-pale);
        border-bottom: 1px solid var(--e-primary-border);
    }

    .part-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .part-table tbody tr:last-child td { border-bottom: none; }
    .part-table tbody tr:hover td { background: rgba(107,175,107,0.02); }

    .emp-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--e-primary-pale); border: 1px solid var(--e-primary-border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.62rem; font-weight: 700; color: var(--e-primary);
        text-transform: uppercase; flex-shrink: 0; vertical-align: middle;
        margin-right: 8px;
    }

    .empty-state { padding: 30px; text-align: center; color: var(--c-muted); font-size: 0.8rem; }
    .empty-state i { font-size: 1.5rem; opacity: 0.3; margin-bottom: 8px; display: block; }

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

    .separator { height: 1px; background: var(--c-border); margin: 4px 0; }

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

if ($isFutur)     [$dKey,$dLabel,$dIcon] = ['futur',   'À venir',    'fa-clock'];
elseif ($isPasse) [$dKey,$dLabel,$dIcon] = ['passe',   'Passée',     'fa-history'];
elseif ($isComp)  [$dKey,$dLabel,$dIcon] = ['complet', 'Complète',   'fa-users-slash'];
else              [$dKey,$dLabel,$dIcon] = ['dispo',   'Disponible', 'fa-check-circle'];

$barColor = match($dKey) {
    'dispo'   => 'linear-gradient(90deg,#7ab86a,#4a6741)',
    'complet' => 'linear-gradient(90deg,#ff8080,#c0392b)',
    'futur'   => 'linear-gradient(90deg,#5B9BF0,#2980b9)',
    default   => 'rgba(255,255,255,0.2)',
};

$monIns    = $monInscription;
$insStatut = $monIns ? $monIns['Stt_Ins'] : 'non';

// Seuls les inscrits validés sont visibles publiquement
$valides = array_filter($participants, fn($p) => $p['Stt_Ins'] === 'valide');

// L'employé peut accepter/refuser uniquement si inscrit en attente
$canAccepter = $insStatut === 'inscrit';
$canRefuser  = $insStatut === 'inscrit';
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chalkboard-teacher me-2" style="color:var(--e-primary);"></i>
            <?= esc(mb_substr($f['Description_Frm'], 0, 50)) ?><?= mb_strlen($f['Description_Frm']) > 50 ? '…' : '' ?>
        </h1>
        <p>Détail de la formation · ID #<?= (int)$f['id_Frm'] ?></p>
    </div>
    <a href="<?= base_url('formation') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
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

<div class="show-grid">

    <!-- COL GAUCHE -->
    <div>

        <!-- Mon statut d'inscription -->
        <?php if ($insStatut !== 'non'): ?>
        <?php
        [$msbCls, $msbColor, $msbIcon, $msbLabel] = match($insStatut) {
            'valide'  => ['msb-valide',  '#7ab86a', 'fa-check-circle', 'Vous êtes confirmé(e) pour cette formation'],
            'inscrit' => ['msb-inscrit', '#ffc107', 'fa-clock',        'Vous avez été sélectionné(e) — veuillez confirmer votre participation'],
            'annule'  => ['msb-annule',  '#ff8080', 'fa-times-circle', 'Votre participation a été annulée'],
            default   => ['msb-inscrit', '#ffc107', 'fa-clock',        ''],
        };
        ?>
        <div class="action-card">
            <div class="action-card-header">
                <div class="info-card-icon"><i class="fas fa-user-check"></i></div>
                <p class="info-card-title">Ma participation</p>
            </div>
            <div style="padding:14px 18px;">
                <div class="mon-statut-banner <?= $msbCls ?>" style="margin:0 0 12px;">
                    <div class="msb-icon">
                        <i class="fas <?= $msbIcon ?>" style="color:<?= $msbColor ?>;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.68rem;color:<?= $msbColor ?>;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Mon statut</div>
                        <div style="font-size:0.8rem;color:rgba(255,255,255,0.7);margin-top:2px;"><?= $msbLabel ?></div>
                    </div>
                </div>

                <?php if ($canAccepter): ?>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <form method="POST" action="<?= base_url('demande-formation/accepter/' . $monIns['id_Ins']) ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-primary" style="width:100%;">
                            <i class="fas fa-check"></i> Confirmer ma participation
                        </button>
                    </form>
                    <div class="separator"></div>
                    <form method="POST" action="<?= base_url('demande-formation/refuser/' . $monIns['id_Ins']) ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-red-action">
                            <i class="fas fa-times"></i> Décliner l'invitation
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Infos formation -->
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
                        <i class="fas fa-map-marker-alt" style="color:var(--e-primary);margin-right:5px;"></i>
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
                    <?php $diffDays = (int)round((strtotime($fin) - strtotime($debut)) / 86400) + 1; ?>
                    <span style="font-size:0.7rem;color:var(--c-muted);margin-top:2px;">
                        <i class="fas fa-clock" style="color:var(--e-primary);"></i>
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
                    <span class="info-value"><?= $nbValides ?> / <?= $cap ?> confirmés</span>
                    <div class="cap-bar-bg">
                        <div class="cap-bar-fill" style="width:<?= $pct ?>%;background:<?= $barColor ?>;"></div>
                    </div>
                    <div class="cap-legend">
                        <span><?= $nbInscrits ?> en attente</span>
                        <span><?= $pct ?>%</span>
                    </div>
                </div>

            </div>

            <!-- Lien demande liée -->
            <?php if (!empty($demande)): ?>
            <div style="padding:0 18px 16px;">
                <div style="font-size:0.68rem;color:var(--c-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Demande liée</div>
                <a href="<?= base_url('demande-formation/show/' . $demande['id_DFrm']) ?>"
                   style="display:flex;align-items:center;gap:8px;background:#111;border:1px solid var(--c-border);border-radius:8px;padding:9px 12px;text-decoration:none;transition:border-color 0.2s;"
                   onmouseover="this.style.borderColor='var(--e-primary-border)'"
                   onmouseout="this.style.borderColor='var(--c-border)'">
                    <i class="fas fa-file-alt" style="color:var(--e-primary);font-size:0.75rem;"></i>
                    <span style="color:var(--c-soft);font-size:0.78rem;">Demande #<?= (int)$demande['id_DFrm'] ?></span>
                    <i class="fas fa-chevron-right" style="color:var(--c-muted);font-size:0.65rem;margin-left:auto;"></i>
                </a>
            </div>
            <?php endif; ?>

        </div>

    </div><!-- /COL GAUCHE -->

    <!-- COL DROITE — participants confirmés (lecture seule) -->
    <div class="part-card">
        <div class="part-card-header">
            <div class="part-card-header-left">
                <div class="info-card-icon"><i class="fas fa-users"></i></div>
                <p class="part-card-title">Participants confirmés</p>
            </div>
            <div class="part-stats">
                <div class="part-stat">
                    <span class="part-stat-dot" style="background:#7ab86a;"></span>
                    <span style="color:#7ab86a;font-weight:700;"><?= $nbValides ?></span>
                    <span style="color:var(--c-muted);">confirmés</span>
                </div>
                <div class="part-stat">
                    <span class="part-stat-dot" style="background:rgba(255,255,255,0.2);"></span>
                    <span style="color:var(--c-muted);font-weight:700;"><?= $cap - $nbValides > 0 ? $cap - $nbValides : 0 ?></span>
                    <span style="color:var(--c-muted);">places restantes</span>
                </div>
            </div>
        </div>

        <?php if (empty($valides)): ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            Aucun participant confirmé pour le moment.
        </div>
        <?php else: ?>
        <table class="part-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Participant</th>
                    <th>Direction</th>
                    <th>Date inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_values($valides) as $i => $p): ?>
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
                    <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($p['Nom_Dir'] ?? '-') ?></td>
                    <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                        <?= $p['Dte_Ins'] ? date('d/m/Y', strtotime($p['Dte_Ins'])) : '-' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

</div><!-- /.show-grid -->

<?= $this->endSection() ?>