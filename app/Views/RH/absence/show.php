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

    /* ===== LAYOUT ===== */
    .show-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 16px;
        align-items: start;
    }

    .show-col-left  { display: flex; flex-direction: column; gap: 16px; }
    .show-col-right { display: flex; flex-direction: column; gap: 16px; }

    /* ===== CARTES ===== */
    .info-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden;
    }

    .info-card-head {
        padding: 13px 18px;
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 9px;
        font-size: 0.78rem; font-weight: 700;
        color: var(--c-orange); text-transform: uppercase; letter-spacing: 0.7px;
    }

    .info-card-body { padding: 18px; }

    /* ===== GRILLE DÉTAILS ===== */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .detail-item { display: flex; flex-direction: column; gap: 4px; }

    .detail-label {
        font-size: 0.67rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px;
    }

    .detail-value { font-size: 0.83rem; color: var(--c-text); font-weight: 500; }
    .detail-value.muted { color: var(--c-muted); font-style: italic; }

    .detail-sep {
        grid-column: 1 / -1;
        height: 1px; background: var(--c-border); margin: 2px 0;
    }

    /* ===== BADGES ===== */
    .badge-statut {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700; white-space: nowrap;
    }

    .bs-attente    { background: var(--c-yellow-pale);  border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bs-valide-rh  { background: var(--c-blue-pale);    border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bs-rejete-rh  { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-approuve   { background: var(--c-green-pale);   border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bs-rejete     { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }

    .statut-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }

    .badge-type {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-size: 0.72rem; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
    }

    .badge-justif-oui {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        color: #7ab86a; font-size: 0.72rem; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 5px;
    }

    .badge-justif-non {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        color: #ff8080; font-size: 0.72rem; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 5px;
    }

    /* ===== IDENTITÉ EMPLOYÉ ===== */
    .emp-block {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--c-border);
    }

    .emp-avatar-lg {
        width: 46px; height: 46px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; font-weight: 700; color: var(--c-orange);
        flex-shrink: 0; text-transform: uppercase;
    }

    .emp-nom  { color: #fff; font-weight: 700; font-size: 0.9rem; line-height: 1.2; }
    .emp-meta { color: var(--c-muted); font-size: 0.72rem; margin-top: 3px; }

    /* ===== TIMELINE WORKFLOW ===== */
    .timeline { padding: 16px 18px; display: flex; flex-direction: column; gap: 0; }

    .tl-item {
        display: flex; gap: 12px; position: relative;
    }

    .tl-item:not(:last-child)::after {
        content: '';
        position: absolute; left: 14px; top: 30px;
        width: 1px; height: calc(100% - 12px);
        background: var(--c-border);
    }

    .tl-icon {
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem; flex-shrink: 0; position: relative; z-index: 1;
        margin-top: 2px;
    }

    .tl-done    { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .tl-active  { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .tl-pending { background: rgba(255,255,255,0.04); border: 1px solid var(--c-border);       color: var(--c-muted); }
    .tl-reject  { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }

    .tl-body  { flex: 1; padding-bottom: 18px; }
    .tl-title { font-size: 0.8rem; font-weight: 600; color: var(--c-text); line-height: 1.3; }
    .tl-sub   { font-size: 0.7rem; color: var(--c-muted); margin-top: 3px; }
    .tl-date  { font-size: 0.68rem; color: var(--c-muted); margin-top: 4px; }

    .tl-comment {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 7px; padding: 8px 12px;
        font-size: 0.75rem; color: var(--c-soft);
        margin-top: 7px; line-height: 1.5;
    }

    /* ===== PIECES JUSTIFICATIVES ===== */
    .pj-list { display: flex; flex-direction: column; gap: 8px; }

    .pj-item {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 9px; padding: 10px 14px;
        display: flex; align-items: center; gap: 10px;
    }

    .pj-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.75rem; flex-shrink: 0;
    }

    .pj-name  { color: var(--c-text); font-size: 0.78rem; font-weight: 600; }
    .pj-meta  { color: var(--c-muted); font-size: 0.68rem; margin-top: 2px; }

    .pj-badge {
        font-size: 0.65rem; font-weight: 700; padding: 2px 8px;
        border-radius: 10px; white-space: nowrap; margin-left: auto;
    }

    .pj-validee   { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .pj-attente   { background: var(--c-yellow-pale); border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .pj-rejetee   { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }

    /* ===== BOUTONS ACTION ===== */
    .action-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; padding: 18px;
    }

    .action-card-title {
        font-size: 0.72rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.7px;
        margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
    }

    .btn-action {
        width: 100%; padding: 10px 14px; border-radius: 8px;
        font-size: 0.8rem; font-weight: 700; cursor: pointer;
        transition: all 0.2s; display: flex; align-items: center;
        gap: 8px; margin-bottom: 8px; border: none; text-align: left;
    }

    .btn-action:last-child { margin-bottom: 0; }

    .btn-validate  { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .btn-reject    { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }
    .btn-approve   { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .btn-refuse    { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }
    .btn-orange-sm { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .btn-edit-sm   { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);   color: #5B9BF0; }

    .btn-action:hover { filter: brightness(1.15); transform: translateX(2px); }

    .btn-back {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-back:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

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

    /* ===== MODAL COMMENTAIRE ===== */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.7); z-index: 1040;
        backdrop-filter: blur(4px);
        align-items: center; justify-content: center;
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #1e1e1e; border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px; padding: 26px; width: 100%; max-width: 440px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: modal-in 0.2s ease;
    }

    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-title {
        font-size: 0.88rem; font-weight: 700; color: #fff;
        margin-bottom: 14px; display: flex; align-items: center; gap: 9px;
    }

    .modal-textarea {
        width: 100%; background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.82rem;
        padding: 10px 12px; resize: vertical; min-height: 90px;
        outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif;
    }

    .modal-textarea:focus { border-color: var(--c-orange-border); }
    .modal-textarea::placeholder { color: var(--c-muted); }

    .modal-hint { font-size: 0.7rem; color: var(--c-muted); margin-top: 5px; }

    .modal-btns { display: flex; gap: 10px; margin-top: 16px; }
    .modal-btns > * { flex: 1; justify-content: center; }

    .btn-modal-cancel {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }

    .btn-modal-cancel:hover { background: rgba(255,255,255,0.04); }

    .btn-modal-confirm {
        border: none; font-weight: 700; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }

    .btn-modal-confirm.green { background: linear-gradient(135deg, #4A6741, #3d5636); color: #fff; }
    .btn-modal-confirm.red   { background: linear-gradient(135deg, #c0392b, #922b21); color: #fff; }
    .btn-modal-confirm:hover { transform: translateY(-1px); }

    @media (max-width: 900px) {
        .show-grid { grid-template-columns: 1fr; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$a      = $absence;
$idPfl  = $idPfl  ?? session()->get('id_Pfl');
$idEmp  = $idEmp  ?? session()->get('id_Emp');
$statut = $a['Statut_Abs'] ?? 'en_attente';

[$bsCls, $bsLabel, $bsDot] = match($statut) {
    'en_attente' => ['bs-attente',   'En attente', '#ffc107'],
    'valide_rh'  => ['bs-valide-rh', 'Validé RH',  '#5B9BF0'],
    'rejete_rh'  => ['bs-rejete-rh', 'Rejeté RH',  '#ff8080'],
    'approuve'   => ['bs-approuve',  'Approuvé',   '#7ab86a'],
    'rejete'     => ['bs-rejete',    'Rejeté',     '#ff8080'],
    default      => ['bs-attente',    $statut,      '#ffc107'],
};

$debut   = $a['DateDebut_Abs'];
$fin     = $a['DateFin_Abs'];
$nbJours = ($debut && $fin) ? (new \DateTime($debut))->diff(new \DateTime($fin))->days + 1 : null;

$canEditDelete = ($a['id_Emp'] == $idEmp && $statut === 'en_attente');
$canValiderRH  = ($idPfl == 1 && $statut === 'en_attente' && $a['id_Emp'] != $idEmp);
$canRejeterRH  = ($idPfl == 1 && $statut === 'en_attente' && $a['id_Emp'] != $idEmp);
$canApprouver  = ($idPfl == 2 && $statut === 'valide_rh'  && $a['id_Emp'] != $idEmp);
$canRefuser    = ($idPfl == 2 && $statut === 'valide_rh'  && $a['id_Emp'] != $idEmp);
$canAjouterPJ  = ($a['id_Emp'] == $idEmp || $idPfl == 1);
$canValiderPJ  = ($idPfl == 1);
?>

<div class="page-header">
    <div>
        <h1>
            <i class="fas fa-calendar-times me-2" style="color:#F5A623;"></i>
            Détail de l'absence
            <span class="badge-statut <?= $bsCls ?>" style="margin-left:10px;vertical-align:middle;">
                <span class="statut-dot" style="background:<?= $bsDot ?>;"></span>
                <?= $bsLabel ?>
            </span>
        </h1>
        <p>Absence #<?= $a['id_Abs'] ?> &mdash; déclarée le <?= date('d/m/Y', strtotime($a['DateDemande_Abs'])) ?></p>
    </div>
    <a href="<?= base_url('absence') ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Retour
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

<div class="show-grid">

    <!-- ===== COLONNE GAUCHE ===== -->
    <div class="show-col-left">

        <!-- Identité -->
        <div class="info-card">
            <div class="emp-block">
                <div class="emp-avatar-lg">
                    <?= mb_substr($a['Nom_Emp'] ?? '?', 0, 1) . mb_substr($a['Prenom_Emp'] ?? '', 0, 1) ?>
                </div>
                <div>
                    <div class="emp-nom"><?= esc(($a['Nom_Emp'] ?? '') . ' ' . ($a['Prenom_Emp'] ?? '')) ?></div>
                    <div class="emp-meta">
                        <?= esc($a['Nom_Dir'] ?? '') ?>
                        <?php if (!empty($a['Email_Emp'])): ?>
                        &nbsp;&bull;&nbsp; <?= esc($a['Email_Emp']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="info-card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Type d'absence</div>
                        <div class="detail-value">
                            <span class="badge-type"><?= esc($a['Libelle_TAbs'] ?? '-') ?></span>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Justifiée</div>
                        <div class="detail-value">
                            <?php if ($statut === 'approuve'): ?>
                                <?php if ($estJustifiee): ?>
                                <span class="badge-justif-oui"><i class="fas fa-check"></i> Oui</span>
                                <?php else: ?>
                                <span class="badge-justif-non"><i class="fas fa-times"></i> Non</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="color:var(--c-muted);font-size:0.78rem;">—</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="detail-sep"></div>

                    <div class="detail-item">
                        <div class="detail-label">Date de début</div>
                        <div class="detail-value"><?= $debut ? date('d/m/Y', strtotime($debut)) : '—' ?></div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Date de fin</div>
                        <div class="detail-value">
                            <?= $fin ? date('d/m/Y', strtotime($fin)) : '<span class="muted">Non définie</span>' ?>
                        </div>
                    </div>

                    <?php if ($nbJours): ?>
                    <div class="detail-item">
                        <div class="detail-label">Durée</div>
                        <div class="detail-value"><?= $nbJours ?> jour<?= $nbJours > 1 ? 's' : '' ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="detail-item">
                        <div class="detail-label">Date de déclaration</div>
                        <div class="detail-value">
                            <?= $a['DateDemande_Abs'] && $a['DateDemande_Abs'] !== '0000-00-00'
                                ? date('d/m/Y', strtotime($a['DateDemande_Abs']))
                                : '—' ?>
                        </div>
                    </div>

                    <?php if (!empty($a['Motif_Abs'])): ?>
                    <div class="detail-item" style="grid-column:1/-1;">
                        <div class="detail-label">Motif</div>
                        <div class="detail-value"><?= esc($a['Motif_Abs']) ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($a['Rapport_Abs'])): ?>
                    <div class="detail-item" style="grid-column:1/-1;">
                        <div class="detail-label">Rapport</div>
                        <div class="detail-value" style="line-height:1.6;color:var(--c-soft);"><?= nl2br(esc($a['Rapport_Abs'])) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Pièces justificatives -->
        <div class="info-card">
            <div class="info-card-head">
                <i class="fas fa-paperclip"></i> Pièces justificatives
                <span style="margin-left:auto;font-size:0.72rem;color:var(--c-muted);text-transform:none;font-weight:400;">
                    <?= count($pieces) ?> fichier(s)
                </span>
            </div>
            <div class="info-card-body">
                <?php if (empty($pieces)): ?>
                <div style="text-align:center;padding:18px 0;color:var(--c-muted);font-size:0.8rem;">
                    <i class="fas fa-folder-open" style="font-size:1.4rem;opacity:0.3;display:block;margin-bottom:8px;"></i>
                    Aucune pièce justificative déposée.
                </div>
                <?php else: ?>
                <div class="pj-list">
                    <?php foreach ($pieces as $pj):
                        $ext      = strtolower(pathinfo($pj['CheminFichier_PJ'], PATHINFO_EXTENSION));
                        $iconCls  = in_array($ext, ['jpg','jpeg','png']) ? 'fa-image' : 'fa-file-pdf';
                        $filename = basename($pj['CheminFichier_PJ']);
                    ?>
                    <div class="pj-item">
                        <div class="pj-icon"><i class="fas <?= $iconCls ?>"></i></div>
                        <div style="flex:1;min-width:0;">
                            <div class="pj-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                <?= esc($filename) ?>
                            </div>
                            <div class="pj-meta">
                                Déposé le <?= date('d/m/Y', strtotime($pj['DateDepot_PJ'])) ?>
                                <?php if (!empty($pj['NomValidPJ'])): ?>
                                &nbsp;&bull;&nbsp; par <?= esc($pj['NomValidPJ'] . ' ' . $pj['PrenomValidPJ']) ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($pj['Statut_PJ'] === 'rejetee' && !empty($pj['CommentaireRejet_PJ'])): ?>
                            <div style="font-size:0.68rem;color:#ff8080;margin-top:4px;">
                                Motif rejet : <?= esc($pj['CommentaireRejet_PJ']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0;">
                            <span class="pj-badge <?= 'pj-' . $pj['Statut_PJ'] ?>">
                                <?= match($pj['Statut_PJ']) {
                                    'validee'   => 'Validée',
                                    'rejetee'   => 'Rejetée',
                                    default     => 'En attente',
                                } ?>
                            </span>
                            <div style="display:flex;gap:5px;">
                                <a href="<?= base_url($pj['CheminFichier_PJ']) ?>" target="_blank"
                                   style="font-size:0.68rem;color:#5B9BF0;text-decoration:none;display:inline-flex;align-items:center;gap:3px;">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <?php if ($canValiderPJ && $pj['Statut_PJ'] === 'en_attente'): ?>
                                &nbsp;
                                <button class="btn-action btn-validate"
                                        style="width:auto;padding:3px 8px;font-size:0.68rem;margin:0;"
                                        onclick="openModal('valider-pj', <?= $pj['id_PJ'] ?>, false)">
                                    <i class="fas fa-check"></i> Valider
                                </button>
                                <button class="btn-action btn-reject"
                                        style="width:auto;padding:3px 8px;font-size:0.68rem;margin:0;"
                                        onclick="openModal('rejeter-pj', <?= $pj['id_PJ'] ?>, true)">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ($canAjouterPJ): ?>
                <form action="<?= base_url('absence/ajouter-pj/' . $a['id_Abs']) ?>"
                      method="POST" enctype="multipart/form-data"
                      style="margin-top:14px;padding-top:14px;border-top:1px solid var(--c-border);">
                    <?= csrf_field() ?>
                    <div style="display:flex;gap:10px;align-items:center;">
                        <input type="file" name="piece_justificative"
                               class="form-control-dark"
                               accept=".pdf,.jpg,.jpeg,.png"
                               style="background:#111;border:1px solid var(--c-border);border-radius:8px;color:var(--c-text);font-size:0.78rem;padding:7px 12px;height:auto;flex:1;">
                        <button type="submit"
                                style="background:var(--c-orange-pale);border:1px solid var(--c-orange-border);color:var(--c-orange);font-weight:700;border-radius:8px;padding:8px 14px;font-size:0.78rem;cursor:pointer;white-space:nowrap;transition:all 0.2s;">
                            <i class="fas fa-upload"></i> Déposer
                        </button>
                    </div>
                    <div style="font-size:0.67rem;color:var(--c-muted);margin-top:5px;">
                        PDF, JPG ou PNG — 5 Mo max.
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- ===== COLONNE DROITE ===== -->
    <div class="show-col-right">

        <!-- Workflow Timeline -->
        <div class="info-card">
            <div class="info-card-head">
                <i class="fas fa-route"></i> Workflow
            </div>
            <div class="timeline">

                <!-- Étape 1 : Déclaration -->
                <div class="tl-item">
                    <div class="tl-icon tl-done"><i class="fas fa-check"></i></div>
                    <div class="tl-body">
                        <div class="tl-title">Déclaration soumise</div>
                        <div class="tl-sub">
                            <?= esc(($a['Nom_Emp'] ?? '') . ' ' . ($a['Prenom_Emp'] ?? '')) ?>
                        </div>
                        <div class="tl-date">
                            <?= $a['DateDemande_Abs'] && $a['DateDemande_Abs'] !== '0000-00-00'
                                ? date('d/m/Y', strtotime($a['DateDemande_Abs']))
                                : '—' ?>
                        </div>
                    </div>
                </div>

                <!-- Étape 2 : Validation RH -->
                <?php
                $rhDone   = in_array($statut, ['valide_rh', 'rejete_rh', 'approuve', 'rejete']);
                $rhActive = ($statut === 'en_attente');
                $rhReject = ($statut === 'rejete_rh');
                $rhCls    = $rhReject ? 'tl-reject' : ($rhDone ? 'tl-done' : ($rhActive ? 'tl-active' : 'tl-pending'));
                $rhIcon   = $rhReject ? 'fa-times' : ($rhDone ? 'fa-check' : ($rhActive ? 'fa-hourglass-half' : 'fa-lock'));
                ?>
                <div class="tl-item">
                    <div class="tl-icon <?= $rhCls ?>"><i class="fas <?= $rhIcon ?>"></i></div>
                    <div class="tl-body">
                        <div class="tl-title">
                            <?= $rhReject ? 'Rejetée par le RH' : ($rhDone ? 'Validée par le RH' : ($rhActive ? 'En attente RH' : 'Validation RH')) ?>
                        </div>
                        <?php if (!empty($a['NomValidRH'])): ?>
                        <div class="tl-sub"><?= esc($a['NomValidRH'] . ' ' . $a['PrenomValidRH']) ?></div>
                        <?php endif; ?>
                        <?php if ($a['DateValidationRH_Abs']): ?>
                        <div class="tl-date"><?= date('d/m/Y H:i', strtotime($a['DateValidationRH_Abs'])) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($a['CommentaireRH_Abs'])): ?>
                        <div class="tl-comment"><?= nl2br(esc($a['CommentaireRH_Abs'])) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Étape 3 : Approbation Chef -->
                <?php
                $chefDone   = in_array($statut, ['approuve', 'rejete']);
                $chefActive = ($statut === 'valide_rh');
                $chefReject = ($statut === 'rejete');
                $chefCls    = $chefReject ? 'tl-reject' : ($chefDone ? 'tl-done' : ($chefActive ? 'tl-active' : 'tl-pending'));
                $chefIcon   = $chefReject ? 'fa-times' : ($chefDone ? 'fa-check' : ($chefActive ? 'fa-hourglass-half' : 'fa-lock'));
                ?>
                <div class="tl-item">
                    <div class="tl-icon <?= $chefCls ?>"><i class="fas <?= $chefIcon ?>"></i></div>
                    <div class="tl-body">
                        <div class="tl-title">
                            <?= $chefReject ? 'Refusée par le Chef' : ($chefDone ? 'Approuvée par le Chef' : ($chefActive ? 'En attente Chef' : 'Approbation Chef')) ?>
                        </div>
                        <?php if (!empty($a['NomValidDir'])): ?>
                        <div class="tl-sub"><?= esc($a['NomValidDir'] . ' ' . $a['PrenomValidDir']) ?></div>
                        <?php endif; ?>
                        <?php if ($a['DateDecisionDir_Abs']): ?>
                        <div class="tl-date"><?= date('d/m/Y H:i', strtotime($a['DateDecisionDir_Abs'])) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($a['CommentaireDir_Abs'])): ?>
                        <div class="tl-comment"><?= nl2br(esc($a['CommentaireDir_Abs'])) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Actions -->
        <?php if ($canValiderRH || $canRejeterRH || $canApprouver || $canRefuser || $canEditDelete): ?>
        <div class="action-card">
            <div class="action-card-title">
                <i class="fas fa-bolt"></i> Actions
            </div>

            <?php if ($canValiderRH): ?>
            <button class="btn-action btn-validate" onclick="openModal('valider-rh', <?= $a['id_Abs'] ?>, false)">
                <i class="fas fa-check-circle"></i> Valider (RH)
            </button>
            <?php endif; ?>

            <?php if ($canRejeterRH): ?>
            <button class="btn-action btn-reject" onclick="openModal('rejeter-rh', <?= $a['id_Abs'] ?>, true)">
                <i class="fas fa-times-circle"></i> Rejeter (RH)
            </button>
            <?php endif; ?>

            <?php if ($canApprouver): ?>
            <button class="btn-action btn-approve" onclick="openModal('approuver', <?= $a['id_Abs'] ?>, false)">
                <i class="fas fa-thumbs-up"></i> Approuver
            </button>
            <?php endif; ?>

            <?php if ($canRefuser): ?>
            <button class="btn-action btn-refuse" onclick="openModal('refuser', <?= $a['id_Abs'] ?>, true)">
                <i class="fas fa-thumbs-down"></i> Refuser
            </button>
            <?php endif; ?>

            <?php if ($canEditDelete): ?>
            <a href="<?= base_url('absence/edit/' . $a['id_Abs']) ?>" class="btn-action btn-edit-sm"
               style="text-decoration:none;">
                <i class="fas fa-pen"></i> Modifier
            </a>
            <button class="btn-action btn-reject" onclick="openModal('delete', <?= $a['id_Abs'] ?>, false)">
                <i class="fas fa-trash-alt"></i> Supprimer
            </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</div>

<!-- Modal commentaire / confirmation -->
<div class="modal-overlay" id="modal-action">
    <div class="modal-box">
        <div class="modal-title" id="modal-title"></div>
        <textarea class="modal-textarea" id="modal-commentaire"
                  placeholder="Commentaire..."></textarea>
        <div class="modal-hint" id="modal-hint"></div>
        <div class="modal-btns">
            <button class="btn-modal-cancel" onclick="closeModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
            <button class="btn-modal-confirm" id="btn-modal-confirm">
                <i class="fas fa-check"></i> Confirmer
            </button>
        </div>
    </div>
</div>

<form id="form-action" method="POST" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="commentaire" id="form-commentaire">
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    var urls = {
        'valider-rh':  '<?= base_url('absence/valider-rh/') ?>',
        'rejeter-rh':  '<?= base_url('absence/rejeter-rh/') ?>',
        'approuver':   '<?= base_url('absence/approuver/') ?>',
        'refuser':     '<?= base_url('absence/refuser/') ?>',
        'delete':      '<?= base_url('absence/delete/') ?>',
        'valider-pj':  '<?= base_url('absence/valider-pj/') ?>',
        'rejeter-pj':  '<?= base_url('absence/rejeter-pj/') ?>',
    };

    var labels = {
        'valider-rh': { title: '<i class="fas fa-check-circle" style="color:#7ab86a;"></i> Valider l\'absence (RH)', confirm: 'green', req: false },
        'rejeter-rh': { title: '<i class="fas fa-times-circle" style="color:#ff8080;"></i> Rejeter l\'absence (RH)', confirm: 'red',   req: true  },
        'approuver':  { title: '<i class="fas fa-thumbs-up"    style="color:#7ab86a;"></i> Approuver l\'absence',   confirm: 'green', req: false },
        'refuser':    { title: '<i class="fas fa-thumbs-down"  style="color:#ff8080;"></i> Refuser l\'absence',     confirm: 'red',   req: true  },
        'delete':     { title: '<i class="fas fa-trash-alt"    style="color:#ff8080;"></i> Supprimer l\'absence',   confirm: 'red',   req: false },
        'valider-pj': { title: '<i class="fas fa-check"        style="color:#7ab86a;"></i> Valider la PJ',          confirm: 'green', req: false },
        'rejeter-pj': { title: '<i class="fas fa-times"        style="color:#ff8080;"></i> Rejeter la PJ',          confirm: 'red',   req: true  },
    };

    var currentAction = null;
    var currentId     = null;
    var commentReq    = false;

    window.openModal = function (action, id, requireComment) {
        currentAction = action;
        currentId     = id;
        commentReq    = requireComment;

        var cfg = labels[action];
        document.getElementById('modal-title').innerHTML = cfg.title;
        document.getElementById('btn-modal-confirm').className = 'btn-modal-confirm ' + cfg.confirm;
        document.getElementById('modal-commentaire').value = '';

        var commentEl = document.getElementById('modal-commentaire');
        var hintEl    = document.getElementById('modal-hint');

        if (action === 'delete') {
            commentEl.style.display = 'none';
            hintEl.textContent      = 'Cette action est irréversible.';
        } else {
            commentEl.style.display = 'block';
            hintEl.textContent      = requireComment ? 'Un commentaire est obligatoire.' : 'Commentaire optionnel.';
        }

        document.getElementById('modal-action').classList.add('show');
    };

    window.closeModal = function () {
        document.getElementById('modal-action').classList.remove('show');
        currentAction = null;
        currentId     = null;
    };

    document.getElementById('btn-modal-confirm').addEventListener('click', function () {
        if (!currentAction || !currentId) return;

        var commentaire = document.getElementById('modal-commentaire').value.trim();

        if (commentReq && !commentaire) {
            document.getElementById('modal-commentaire').style.borderColor = 'rgba(224,82,82,0.6)';
            document.getElementById('modal-hint').style.color = '#ff8080';
            return;
        }

        document.getElementById('form-commentaire').value = commentaire;
        document.getElementById('form-action').action     = urls[currentAction] + currentId;
        document.getElementById('form-action').submit();
    });

    document.getElementById('modal-action').addEventListener('click', function (e) {
        if (e.target === this) window.closeModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') window.closeModal();
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.body.appendChild(document.getElementById('modal-action'));
        document.body.appendChild(document.getElementById('form-action'));
    });

})();
</script>
<?= $this->endSection() ?>