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

    .show-grid { display: grid; grid-template-columns: 320px 1fr; gap: 16px; align-items: start; }

    /* ===== STEPPER ===== */
    .stepper-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; margin-bottom: 16px;
    }

    .stepper-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 10px;
    }

    .stepper-icon {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.82rem; flex-shrink: 0;
    }

    .stepper-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }

    .stepper-body { padding: 18px; }

    .stepper { display: flex; flex-direction: column; gap: 0; }

    .step { display: flex; gap: 14px; }

    .step-left { display: flex; flex-direction: column; align-items: center; }

    .step-circle {
        width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.72rem; font-weight: 700; border: 2px solid;
        transition: all 0.3s;
    }

    .step-circle.done    { background: var(--c-green-pale);   border-color: var(--c-green-border);  color: #7ab86a; }
    .step-circle.active  { background: var(--c-orange-pale);  border-color: var(--c-orange-border); color: var(--c-orange); }
    .step-circle.waiting { background: rgba(255,255,255,0.03); border-color: var(--c-border);       color: var(--c-muted); }
    .step-circle.rejected{ background: var(--c-red-pale);     border-color: var(--c-red-border);    color: #ff8080; }

    .step-line {
        flex: 1; width: 2px; margin: 3px auto;
        min-height: 32px; border-radius: 1px;
    }

    .step-line.done    { background: var(--c-green-border); }
    .step-line.active  { background: var(--c-orange-border); }
    .step-line.waiting { background: var(--c-border); }
    .step-line.rejected{ background: var(--c-red-border); }

    .step:last-child .step-line { display: none; }

    .step-right { padding: 3px 0 28px; flex: 1; }

    .step-label {
        font-size: 0.78rem; font-weight: 700;
        margin-bottom: 3px; line-height: 1.3;
    }

    .step-label.done    { color: #7ab86a; }
    .step-label.active  { color: var(--c-orange); }
    .step-label.waiting { color: var(--c-muted); }
    .step-label.rejected{ color: #ff8080; }

    .step-meta { font-size: 0.7rem; color: var(--c-muted); }
    .step-comment { font-size: 0.72rem; color: var(--c-soft); margin-top: 4px; font-style: italic; }

    /* ===== INFO CARD ===== */
    .info-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; margin-bottom: 16px;
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
        padding: 10px 0; border-bottom: 1px solid var(--c-border);
    }

    .info-row:first-child { padding-top: 0; }
    .info-row:last-child  { border-bottom: none; padding-bottom: 0; }

    .info-label {
        font-size: 0.67rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;
    }

    .info-value { color: var(--c-text); font-size: 0.82rem; }

    /* ===== BADGE STATUT ===== */
    .badge-statut {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px; font-size: 0.7rem; font-weight: 700;
    }

    .bs-attente   { background: var(--c-yellow-pale);  border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bs-approuve  { background: var(--c-blue-pale);    border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bs-rejete    { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-valide    { background: var(--c-green-pale);   border: 1px solid var(--c-green-border);  color: #7ab86a; }

    .badge-type {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;
    }

    .bt-demande    { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .bt-invitation { background: rgba(155,89,182,0.10); border: 1px solid rgba(155,89,182,0.25); color: #bb8fce; }

    /* ===== ACTIONS ===== */
    .actions-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; margin-bottom: 16px;
    }

    .actions-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 10px;
    }

    .actions-card-body { padding: 16px 18px; display: flex; flex-direction: column; gap: 10px; }

    /* ===== SELECTIONNER PARTICIPANTS ===== */
    .sel-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden;
    }

    .sel-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
    }

    .sel-card-header-left { display: flex; align-items: center; gap: 10px; }

    .sel-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .sel-table thead th {
        padding: 8px 14px; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border);
    }

    .sel-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .sel-table tbody tr:last-child td { border-bottom: none; }

    .sel-cb {
        width: 16px; height: 16px; cursor: pointer; accent-color: var(--c-orange);
    }

    .emp-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.62rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; flex-shrink: 0; vertical-align: middle;
        margin-right: 8px;
    }

    .sel-count {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-size: 0.7rem; font-weight: 700;
        padding: 2px 9px; border-radius: 10px;
    }

    /* Boutons inline action */
    .action-form { display: flex; flex-direction: column; gap: 6px; }

    .action-form .form-label-sm {
        font-size: 0.68rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px;
    }

    .action-input {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 7px; color: var(--c-text); font-size: 0.78rem;
        padding: 7px 10px; outline: none; width: 100%;
        transition: border-color 0.2s; resize: none;
        font-family: 'Segoe UI', sans-serif;
    }

    .action-input:focus { border-color: var(--c-orange-border); }

    .btn-green {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        color: #7ab86a; font-weight: 700; border-radius: 8px;
        padding: 9px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
        width: 100%; justify-content: center;
    }

    .btn-green:hover { background: rgba(74,103,65,0.25); }

    .btn-red-action {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        color: #ff8080; font-weight: 700; border-radius: 8px;
        padding: 9px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
        width: 100%; justify-content: center;
    }

    .btn-red-action:hover { background: rgba(224,82,82,0.2); }

    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 9px 20px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 20px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .btn-edit {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-weight: 600; border-radius: 8px;
        padding: 9px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none; width: 100%; justify-content: center;
    }

    .btn-edit:hover { background: rgba(245,166,35,0.2); }

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

    .separator {
        height: 1px; background: var(--c-border); margin: 8px 0;
    }

    @media (max-width: 900px) { .show-grid { grid-template-columns: 1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$d      = $demande;
$statut = $d['Statut_DFrm'];
$desc   = !empty($d['Description_Frm']) ? $d['Description_Frm'] : ($d['Description_Libre'] ?? 'Formation libre');

// Workflow steps
$isChef = $idPfl == 2;
$isRH   = $idPfl == 1;
$isEmp  = $idPfl == 3;

// Propriétaire de la demande
$isOwner = ($d['id_Emp'] == $idEmp);

// Peut-il modifier/supprimer ?
$canEdit   = $isOwner && $statut === 'en_attente';
$canDelete = $isOwner && $statut === 'en_attente';

// Workflow permissions
$canApprouver = $isChef && $statut === 'en_attente';
$canRejeter   = $isChef && $statut === 'en_attente';
$canValiderRH = $isRH   && $statut === 'approuve';
$canRejeterRH = $isRH   && $statut === 'approuve';
$canSelectionner = $isRH && $statut === 'valide_rh' && !empty($d['id_Frm']);

// Statut par étape
function stepState(string $statut, int $step): string {
    return match($step) {
        1 => match($statut) {
            'en_attente'        => 'active',
            'rejete'            => 'rejected',
            default             => 'done',
        },
        2 => match($statut) {
            'en_attente'        => 'waiting',
            'rejete'            => 'rejected',
            'approuve'          => 'active',
            default             => 'done',
        },
        3 => match($statut) {
            'valide_rh','rejete_rh' => ($statut === 'valide_rh' ? 'done' : 'rejected'),
            'approuve'              => 'active',
            default                 => 'waiting',
        },
        default => 'waiting',
    };
}

$s1 = stepState($statut, 1);
$s2 = stepState($statut, 2);
$s3 = stepState($statut, 3);

$stepIcon = fn(string $s) => match($s) {
    'done'     => '<i class="fas fa-check"></i>',
    'active'   => '<i class="fas fa-hourglass-half"></i>',
    'rejected' => '<i class="fas fa-times"></i>',
    default    => '',
};
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-file-alt me-2" style="color:#F5A623;"></i>
            Demande #<?= (int)$d['id_DFrm'] ?>
        </h1>
        <p><?= esc(mb_substr($desc, 0, 55)) ?><?= mb_strlen($desc) > 55 ? '…' : '' ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('demande-formation') ?>" class="btn-ghost">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <?php if ($canEdit): ?>
        <a href="<?= base_url('demande-formation/edit/' . $d['id_DFrm']) ?>" class="btn-orange">
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
    <div>

        <!-- Stepper -->
        <div class="stepper-card">
            <div class="stepper-card-header">
                <div class="stepper-icon"><i class="fas fa-shoe-prints"></i></div>
                <p class="stepper-title">Suivi du workflow</p>
            </div>
            <div class="stepper-body">
                <div class="stepper">

                    <!-- Étape 1 — Soumission -->
                    <div class="step">
                        <div class="step-left">
                            <div class="step-circle done">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="step-line done"></div>
                        </div>
                        <div class="step-right">
                            <div class="step-label done">Demande soumise</div>
                            <div class="step-meta">
                                <?= esc(($d['Prenom_Emp'] ?? '') . ' ' . ($d['Nom_Emp'] ?? '')) ?>
                                <?php if ($d['DateDemande']): ?>
                                · <?= date('d/m/Y', strtotime($d['DateDemande'])) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 2 — Chef -->
                    <div class="step">
                        <div class="step-left">
                            <div class="step-circle <?= $s1 ?>">
                                <?= $stepIcon($s1) ?>
                            </div>
                            <div class="step-line <?= $s1 ?>"></div>
                        </div>
                        <div class="step-right">
                            <div class="step-label <?= $s1 ?>">
                                <?php if ($s1 === 'rejected'): ?>
                                    Refusé par le Chef
                                <?php elseif ($s1 === 'done'): ?>
                                    Approuvé par le Chef
                                <?php else: ?>
                                    En attente Chef
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($d['DateDecisionDir'])): ?>
                            <div class="step-meta"><?= date('d/m/Y', strtotime($d['DateDecisionDir'])) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($d['CommentaireDir'])): ?>
                            <div class="step-comment">"<?= esc($d['CommentaireDir']) ?>"</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Étape 3 — RH -->
                    <div class="step">
                        <div class="step-left">
                            <div class="step-circle <?= $s2 ?>">
                                <?= $stepIcon($s2) ?>
                            </div>
                            <div class="step-line <?= $s2 ?>"></div>
                        </div>
                        <div class="step-right">
                            <div class="step-label <?= $s2 ?>">
                                <?php if ($s2 === 'rejected'): ?>
                                    Rejeté par RH
                                <?php elseif ($s2 === 'done'): ?>
                                    Validé par RH
                                <?php else: ?>
                                    En attente RH
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($d['DateValidRH'])): ?>
                            <div class="step-meta"><?= date('d/m/Y', strtotime($d['DateValidRH'])) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($d['CommentaireRH'])): ?>
                            <div class="step-comment">"<?= esc($d['CommentaireRH']) ?>"</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Étape 4 — Participants (si formation liée) -->
                    <?php if (!empty($d['id_Frm'])): ?>
                    <div class="step">
                        <div class="step-left">
                            <div class="step-circle <?= $s3 ?>">
                                <?= $stepIcon($s3) ?>
                            </div>
                        </div>
                        <div class="step-right">
                            <div class="step-label <?= $s3 ?>">Participants sélectionnés</div>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Actions workflow -->
        <?php if ($canApprouver || $canRejeter || $canValiderRH || $canRejeterRH || $canDelete): ?>
        <div class="actions-card">
            <div class="actions-card-header">
                <div class="stepper-icon"><i class="fas fa-tasks"></i></div>
                <p class="stepper-title">Actions</p>
            </div>
            <div class="actions-card-body">

                <?php if ($canApprouver): ?>
                <form method="POST" action="<?= base_url('demande-formation/approuver/' . $d['id_DFrm']) ?>"
                      class="action-form">
                    <?= csrf_field() ?>
                    <div>
                        <div class="form-label-sm">Commentaire (optionnel)</div>
                        <textarea name="CommentaireDir" class="action-input" rows="2"
                                  placeholder="Motif d'approbation..."></textarea>
                    </div>
                    <button type="submit" class="btn-green">
                        <i class="fas fa-check"></i> Approuver
                    </button>
                </form>
                <?php endif; ?>

                <?php if ($canRejeter): ?>
                <?php if ($canApprouver): ?><div class="separator"></div><?php endif; ?>
                <form method="POST" action="<?= base_url('demande-formation/rejeter/' . $d['id_DFrm']) ?>"
                      class="action-form">
                    <?= csrf_field() ?>
                    <div>
                        <div class="form-label-sm">Motif de refus <span style="color:#ff8080;">*</span></div>
                        <textarea name="CommentaireDir" class="action-input" rows="2"
                                  placeholder="Expliquez le motif du refus..." required></textarea>
                    </div>
                    <button type="submit" class="btn-red-action">
                        <i class="fas fa-times"></i> Refuser
                    </button>
                </form>
                <?php endif; ?>

                <?php if ($canValiderRH): ?>
                <form method="POST" action="<?= base_url('demande-formation/valider-rh/' . $d['id_DFrm']) ?>"
                      class="action-form">
                    <?= csrf_field() ?>
                    <div>
                        <div class="form-label-sm">Commentaire (optionnel)</div>
                        <textarea name="CommentaireRH" class="action-input" rows="2"
                                  placeholder="Remarque RH..."></textarea>
                    </div>
                    <button type="submit" class="btn-green">
                        <i class="fas fa-check-double"></i> Valider (RH)
                    </button>
                </form>
                <?php endif; ?>

                <?php if ($canRejeterRH): ?>
                <?php if ($canValiderRH): ?><div class="separator"></div><?php endif; ?>
                <form method="POST" action="<?= base_url('demande-formation/rejeter-rh/' . $d['id_DFrm']) ?>"
                      class="action-form">
                    <?= csrf_field() ?>
                    <div>
                        <div class="form-label-sm">Motif de rejet <span style="color:#ff8080;">*</span></div>
                        <textarea name="CommentaireRH" class="action-input" rows="2"
                                  placeholder="Expliquez le motif du rejet..." required></textarea>
                    </div>
                    <button type="submit" class="btn-red-action">
                        <i class="fas fa-ban"></i> Rejeter (RH)
                    </button>
                </form>
                <?php endif; ?>

                <?php if ($canDelete): ?>
                <?php if ($canApprouver || $canRejeter || $canValiderRH || $canRejeterRH): ?><div class="separator"></div><?php endif; ?>
                <button class="btn-red-action" onclick="document.getElementById('modal-delete').classList.add('show')">
                    <i class="fas fa-trash-alt"></i> Supprimer la demande
                </button>
                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>

    </div><!-- /COL GAUCHE -->

    <!-- COL DROITE -->
    <div>

        <!-- Infos demande -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon"><i class="fas fa-info-circle"></i></div>
                <p class="info-card-title">Informations de la demande</p>
            </div>
            <div class="info-card-body">

                <div class="info-row">
                    <span class="info-label">Demandeur</span>
                    <span class="info-value" style="font-weight:600;">
                        <?= esc(($d['Prenom_Emp'] ?? '') . ' ' . ($d['Nom_Emp'] ?? '')) ?>
                    </span>
                    <?php if (!empty($d['Nom_Dir'])): ?>
                    <span style="color:var(--c-muted);font-size:0.72rem;">
                        <i class="fas fa-building" style="font-size:0.65rem;margin-right:3px;"></i>
                        <?= esc($d['Nom_Dir']) ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="info-row">
                    <span class="info-label">Type</span>
                    <div style="margin-top:3px;">
                        <?php
                        $typeLbl = $d['Type_DFrm'] === 'invitation' ? 'Invitation' : 'Demande';
                        $typeCls = $d['Type_DFrm'] === 'invitation' ? 'bt-invitation' : 'bt-demande';
                        $typeIco = $d['Type_DFrm'] === 'invitation' ? 'fa-envelope' : 'fa-hand-paper';
                        ?>
                        <span class="badge-type <?= $typeCls ?>">
                            <i class="fas <?= $typeIco ?>"></i> <?= $typeLbl ?>
                        </span>
                    </div>
                </div>

                <div class="info-row">
                    <span class="info-label">Statut</span>
                    <div style="margin-top:3px;">
                        <?php
                        [$bsCls, $bsLabel] = match($statut) {
                            'en_attente' => ['bs-attente',  'En attente'],
                            'approuve'   => ['bs-approuve', 'Approuvé Chef'],
                            'rejete'     => ['bs-rejete',   'Rejeté Chef'],
                            'valide_rh'  => ['bs-valide',   'Validé RH'],
                            'rejete_rh'  => ['bs-rejete',   'Rejeté RH'],
                            default      => ['bs-attente',   $statut],
                        };
                        ?>
                        <span class="badge-statut <?= $bsCls ?>"><?= $bsLabel ?></span>
                    </div>
                </div>

                <div class="info-row">
                    <span class="info-label">Date de demande</span>
                    <span class="info-value">
                        <?= $d['DateDemande'] ? date('d/m/Y', strtotime($d['DateDemande'])) : '-' ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Motif</span>
                    <span class="info-value" style="font-style:italic;color:var(--c-soft);">
                        <?= !empty($d['Motif']) ? esc($d['Motif']) : '<span style="color:var(--c-muted);">-</span>' ?>
                    </span>
                </div>

            </div>
        </div>

        <!-- Infos formation -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon"><i class="fas fa-graduation-cap"></i></div>
                <p class="info-card-title">Formation concernée</p>
            </div>
            <div class="info-card-body">

                <?php if (!empty($d['id_Frm'])): ?>
                <!-- Formation du catalogue -->
                <div class="info-row">
                    <span class="info-label">Description</span>
                    <span class="info-value"><?= esc($d['Description_Frm'] ?? '') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Dates</span>
                    <span class="info-value">
                        <?= $d['DateDebut_Frm'] ? date('d/m/Y', strtotime($d['DateDebut_Frm'])) : '-' ?>
                        <span style="color:var(--c-muted);margin:0 5px;">→</span>
                        <?= $d['DateFin_Frm'] ? date('d/m/Y', strtotime($d['DateFin_Frm'])) : '-' ?>
                    </span>
                </div>
                <div style="margin-top:10px;">
                    <a href="<?= base_url('formation/show/' . $d['id_Frm']) ?>"
                       style="display:flex;align-items:center;gap:8px;background:#111;border:1px solid var(--c-border);border-radius:8px;padding:9px 12px;text-decoration:none;"
                       onmouseover="this.style.borderColor='var(--c-orange-border)'"
                       onmouseout="this.style.borderColor='var(--c-border)'">
                        <i class="fas fa-external-link-alt" style="color:var(--c-orange);font-size:0.72rem;"></i>
                        <span style="color:var(--c-soft);font-size:0.78rem;">Voir la formation dans le catalogue</span>
                        <i class="fas fa-chevron-right" style="color:var(--c-muted);font-size:0.65rem;margin-left:auto;"></i>
                    </a>
                </div>
                <?php else: ?>
                <!-- Formation libre -->
                <div class="info-row">
                    <span class="info-label">Intitulé</span>
                    <span class="info-value"><?= esc($d['Description_Libre'] ?? '-') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Dates prévues</span>
                    <span class="info-value">
                        <?= !empty($d['DateDebut_Libre']) ? date('d/m/Y', strtotime($d['DateDebut_Libre'])) : '-' ?>
                        <?php if (!empty($d['DateFin_Libre'])): ?>
                        <span style="color:var(--c-muted);margin:0 5px;">→</span>
                        <?= date('d/m/Y', strtotime($d['DateFin_Libre'])) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <?php if (!empty($d['Lieu_Libre'])): ?>
                <div class="info-row">
                    <span class="info-label">Lieu</span>
                    <span class="info-value"><?= esc($d['Lieu_Libre']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($d['Formateur_Libre'])): ?>
                <div class="info-row">
                    <span class="info-label">Formateur / Organisme</span>
                    <span class="info-value"><?= esc($d['Formateur_Libre']) ?></span>
                </div>
                <?php endif; ?>
                <div class="info-row" style="border:none;padding-bottom:0;">
                    <span class="info-label">Source</span>
                    <span style="color:var(--c-muted);font-size:0.75rem;font-style:italic;">Formation libre — sera créée dans le catalogue après validation RH</span>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Sélection participants (RH + statut valide_rh + formation liée) -->
        <?php if ($canSelectionner && !empty($employes_direction)): ?>
        <div class="sel-card">
            <div class="sel-card-header">
                <div class="sel-card-header-left">
                    <div class="info-card-icon"><i class="fas fa-users-cog"></i></div>
                    <p class="info-card-title">Sélectionner les participants</p>
                </div>
                <span class="sel-count" id="sel-count">0 sélectionné(s)</span>
            </div>
            <form method="POST" action="<?= base_url('demande-formation/selectionner/' . $d['id_DFrm']) ?>">
                <?= csrf_field() ?>
                <table class="sel-table">
                    <thead>
                        <tr>
                            <th style="width:36px;">
                                <input type="checkbox" class="sel-cb" id="sel-all" onchange="toggleAll()">
                            </th>
                            <th>Employé</th>
                            <th>Direction</th>
                            <th>Disponible</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employes_direction as $emp): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="employes[]" class="sel-cb sel-item"
                                       value="<?= (int)$emp['id_Emp'] ?>"
                                       onchange="updateCount()">
                            </td>
                            <td>
                                <span class="emp-avatar">
                                    <?= mb_substr($emp['Nom_Emp'], 0, 1) . mb_substr($emp['Prenom_Emp'] ?? '', 0, 1) ?>
                                </span>
                                <span style="color:#fff;font-weight:500;">
                                    <?= esc($emp['Nom_Emp'] . ' ' . ($emp['Prenom_Emp'] ?? '')) ?>
                                </span>
                            </td>
                            <td style="color:var(--c-muted);font-size:0.75rem;">
                                <?= esc($emp['Nom_Dir'] ?? '-') ?>
                            </td>
                            <td>
                                <?php if ($emp['Disponibilite_Emp'] === 'disponible'): ?>
                                <span style="color:#7ab86a;font-size:0.72rem;">
                                    <i class="fas fa-check-circle"></i> Disponible
                                </span>
                                <?php else: ?>
                                <span style="color:#ff8080;font-size:0.72rem;">
                                    <i class="fas fa-times-circle"></i> Indisponible
                                </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="padding:14px 18px;border-top:1px solid var(--c-border);display:flex;justify-content:flex-end;gap:10px;">
                    <button type="submit" class="btn-orange">
                        <i class="fas fa-users-cog"></i> Valider la sélection
                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>

    </div><!-- /COL DROITE -->

</div><!-- /.show-grid -->

<!-- Modal suppression -->
<div class="modal-overlay" id="modal-delete" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.65);z-index:1040;backdrop-filter:blur(3px);align-items:center;justify-content:center;">
    <div style="background:#1e1e1e;border:1px solid rgba(255,255,255,0.08);border-radius:14px;padding:26px;width:100%;max-width:380px;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <div style="width:46px;height:46px;border-radius:12px;background:var(--c-red-pale);border:1px solid var(--c-red-border);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 style="color:#fff;font-size:0.9rem;font-weight:700;text-align:center;margin-bottom:8px;">Confirmer la suppression</h5>
        <p style="color:var(--c-muted);font-size:0.8rem;text-align:center;line-height:1.5;margin:0;">
            Vous allez supprimer la demande #<?= (int)$d['id_DFrm'] ?> de façon définitive.
        </p>
        <div style="display:flex;gap:10px;margin-top:20px;">
            <button onclick="document.getElementById('modal-delete').style.display='none'"
                    style="flex:1;background:transparent;border:1px solid var(--c-border);color:var(--c-soft);font-weight:600;border-radius:8px;padding:9px 16px;font-size:0.82rem;cursor:pointer;">
                <i class="fas fa-times"></i> Annuler
            </button>
            <form method="POST" action="<?= base_url('demande-formation/delete/' . $d['id_DFrm']) ?>" style="flex:1;">
                <?= csrf_field() ?>
                <button type="submit"
                        style="width:100%;background:linear-gradient(135deg,#c0392b,#922b21);border:none;color:#fff;font-weight:700;border-radius:8px;padding:9px 16px;font-size:0.82rem;cursor:pointer;">
                    <i class="fas fa-trash-alt"></i> Confirmer
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    // Modal overlay click
    document.getElementById('modal-delete').addEventListener('click', function (e) {
        if (e.target === this) this.style.display = 'none';
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') document.getElementById('modal-delete').style.display = 'none';
    });

    // Afficher modal comme flex
    var origShow = document.getElementById('modal-delete').style.display;
    document.querySelectorAll('[onclick*="modal-delete"]').forEach(function (el) {
        el.addEventListener('click', function () {
            document.getElementById('modal-delete').style.display = 'flex';
        });
    });

    // Sélection participants
    window.toggleAll = function () {
        var master = document.getElementById('sel-all');
        document.querySelectorAll('.sel-item').forEach(function (cb) { cb.checked = master.checked; });
        updateCount();
    };

    window.updateCount = function () {
        var n = document.querySelectorAll('.sel-item:checked').length;
        var el = document.getElementById('sel-count');
        if (el) el.textContent = n + ' sélectionné(s)';
        var master = document.getElementById('sel-all');
        if (master) {
            var total = document.querySelectorAll('.sel-item').length;
            master.checked = n === total && total > 0;
            master.indeterminate = n > 0 && n < total;
        }
    };

})();
</script>
<?= $this->endSection() ?>