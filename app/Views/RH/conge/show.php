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

    .page-content { overflow-x: hidden; }

    /* ===== HEADER FICHE ===== */
    .fiche-header {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; padding: 20px 22px;
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 18px; position: relative; overflow: hidden;
        flex-wrap: wrap;
    }
    .fiche-header::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--c-orange), #d4891a);
    }
    .fiche-icon {
        width: 54px; height: 54px; border-radius: 14px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
    .fiche-identity h2 { color: #fff; font-size: 1.05rem; font-weight: 800; margin: 0 0 4px; }
    .fiche-identity p  { color: var(--c-muted); font-size: 0.78rem; margin: 0 0 8px; }
    .fiche-meta { display: flex; flex-wrap: wrap; gap: 7px; }
    .meta-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;
    }
    .mc-type  { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .mc-dir   { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .mc-duree { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);   color: #5B9BF0; }

    /* ===== SOLDE CARD ===== */
    .solde-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; padding: 16px 18px; margin-bottom: 18px;
        display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
    }
    .solde-card-title {
        font-size: 0.7rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.7px;
        display: flex; align-items: center; gap: 7px;
        margin-right: 10px; white-space: nowrap;
    }
    .solde-bloc {
        display: flex; flex-direction: column; align-items: center;
        background: #111; border: 1px solid var(--c-border);
        border-radius: 10px; padding: 10px 16px; min-width: 80px;
    }
    .solde-val   { font-size: 1.6rem; font-weight: 800; line-height: 1; }
    .solde-lbl   { font-size: 0.65rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px; }
    .solde-prog  { flex: 1; min-width: 160px; }
    .prog-track  { background: rgba(255,255,255,0.05); border-radius: 10px; height: 6px; margin-top: 6px; }
    .prog-fill   { height: 6px; border-radius: 10px; }
    .solde-warn  {
        background: rgba(255,193,7,0.08); border: 1px solid rgba(255,193,7,0.25);
        border-radius: 8px; padding: 7px 12px; font-size: 0.75rem; color: #ffc107;
        display: flex; align-items: center; gap: 6px;
    }

    /* ===== STEPPER ===== */
    .stepper {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; padding: 18px 22px; margin-bottom: 18px;
        display: flex; align-items: center;
    }
    .step { display: flex; flex-direction: column; align-items: center; gap: 5px; flex: 1; position: relative; }
    .step:not(:last-child)::after {
        content: ''; position: absolute; top: 15px; left: 50%; width: 100%; height: 2px;
        background: var(--c-border); z-index: 0;
    }
    .step.done:not(:last-child)::after  { background: #7ab86a; }
    .step-dot {
        width: 30px; height: 30px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 800; z-index: 1; flex-shrink: 0;
        border: 2px solid var(--c-border); background: #111; color: var(--c-muted);
        transition: all 0.3s;
    }
    .step.done   .step-dot { background: var(--c-green-pale);  border-color: var(--c-green-border); color: #7ab86a; }
    .step.active .step-dot { background: var(--c-orange-pale); border-color: var(--c-orange-border); color: var(--c-orange); }
    .step.error  .step-dot { background: var(--c-red-pale);    border-color: var(--c-red-border);    color: #ff8080; }
    .step-label { font-size: 0.65rem; color: var(--c-muted); text-align: center; font-weight: 600; }
    .step.done   .step-label { color: #7ab86a; }
    .step.active .step-label { color: var(--c-orange); }
    .step.error  .step-label { color: #ff8080; }


    /* ===== CARDS ===== */
    .card-dark {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; padding: 18px 20px; margin-bottom: 16px;
    }
    .card-dark-title {
        font-size: 0.72rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.7px;
        margin-bottom: 14px; padding-bottom: 10px;
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
    }
    .info-grid   { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    .info-grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .info-item   { display: flex; flex-direction: column; gap: 3px; }
    .info-label  { font-size: 0.66rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.6px; }
    .info-value  { font-size: 0.84rem; color: var(--c-text); font-weight: 500; }
    .info-value.orange { color: var(--c-orange); font-weight: 700; }
    .info-value.green  { color: #7ab86a; font-weight: 600; }
    .info-value.red    { color: #ff8080; font-weight: 600; }
    .info-value.blue   { color: #5B9BF0; font-weight: 600; }

    /* ===== BADGE STATUT ===== */
    .badge-statut {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 700;
    }
    .bs-attente       { background: var(--c-yellow-pale);  border: 1px solid var(--c-yellow-border); color: #ffc107; }
    .bs-approuve-chef { background: var(--c-blue-pale);    border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .bs-rejete-chef   { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-valide-rh     { background: var(--c-green-pale);   border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .bs-rejete-rh     { background: var(--c-red-pale);     border: 1px solid var(--c-red-border);    color: #ff8080; }
    .bs-expire        { background: rgba(150,150,150,0.10); border: 1px solid rgba(150,150,150,0.25); color: #888; }

    /* ===== COMMENTAIRE ===== */
    .comment-box {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 12px 14px;
        font-size: 0.82rem; color: var(--c-soft); line-height: 1.6; font-style: italic;
    }

    /* ===== WORKFLOW ZONE ===== */
    .workflow-zone {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; padding: 18px 20px; margin-bottom: 16px;
    }
    .workflow-zone-title {
        font-size: 0.72rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.7px;
        margin-bottom: 14px; padding-bottom: 10px;
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
    }
    .workflow-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-approve {
        background: linear-gradient(135deg, #27ae60, #1e8449);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 9px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
    }
    .btn-approve:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(39,174,96,0.35); }

    .btn-reject {
        background: transparent; border: 1px solid var(--c-red-border);
        color: #ff8080; font-weight: 700; border-radius: 8px;
        padding: 8px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
    }
    .btn-reject:hover { background: var(--c-red-pale); }

    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 9px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }
    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-outline {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }
    .btn-outline:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    /* ===== MODAL ===== */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.65); z-index: 1050;
        backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: #1e1e1e; border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px; padding: 26px; width: 100%; max-width: 420px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: modal-in 0.2s ease; margin: 16px;
    }
    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .modal-box h5 { color: #fff; font-size: 0.9rem; font-weight: 700; margin: 0 0 6px; }
    .modal-box p  { color: var(--c-muted); font-size: 0.8rem; margin: 0 0 14px; line-height: 1.5; }
    .modal-textarea {
        width: 100%; background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.82rem;
        padding: 10px 12px; outline: none; resize: vertical;
        font-family: 'Segoe UI', sans-serif; min-height: 80px; transition: border-color 0.2s;
    }
    .modal-textarea:focus { border-color: var(--c-orange-border); }
    .modal-textarea::placeholder { color: var(--c-muted); }
    .modal-btns { display: flex; gap: 10px; margin-top: 16px; }
    .modal-btns > * { flex: 1; justify-content: center; }
    .btn-cancel-modal {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; justify-content: center;
    }
    .btn-cancel-modal:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .info-grid   { grid-template-columns: 1fr 1fr; }
        .info-grid-2 { grid-template-columns: 1fr; }
        .step-label  { font-size: 0.55rem; }
        .step-dot    { width: 24px; height: 24px; font-size: 0.6rem; }
        .stepper     { padding: 14px 12px; }
        .step:not(:last-child)::after { top: 12px; }
        .solde-card  { gap: 10px; }
        .solde-bloc  { padding: 8px 12px; min-width: 65px; }
        .solde-val   { font-size: 1.3rem; }
        .fiche-header { padding: 15px; gap: 12px; }
        .fiche-icon  { width: 42px; height: 42px; font-size: 1rem; }
        .fiche-identity h2 { font-size: 0.95rem; }
    }

    @media (max-width: 480px) {
        .info-grid   { grid-template-columns: 1fr; }
        .step-label  { display: none; }
        .workflow-actions { flex-direction: column; }
        .workflow-actions button { width: 100%; justify-content: center; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .page-header > div:last-child { display: flex; gap: 8px; flex-wrap: wrap; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$statut       = $conge['Statut_Cge'];
$pflDemandeur = (int) ($conge['Pfl_Demandeur'] ?? 3);
$estRH        = $pflDemandeur === 1;   // Le demandeur est RH → workflow court (Chef = valideur final)

$nbJours = (new \DateTime($conge['DateDebut_Cge']))->diff(new \DateTime($conge['DateFin_Cge']))->days + 1;

[$bsCls, $bsLabel] = match($statut) {
    'en_attente'    => ['bs-attente',       'En attente'],
    'approuve_chef' => ['bs-approuve-chef', 'Approuvé Chef'],
    'rejete_chef'   => ['bs-rejete-chef',   'Refusé Chef'],
    'valide_rh'     => ['bs-valide-rh',     'Validé'],
    'rejete_rh'     => ['bs-rejete-rh',     'Rejeté RH'],
    'expire'        => ['bs-expire',        'Expiré'],
    default         => ['bs-attente',        $statut],
};

// ── Stepper adapté selon le workflow ──
// Workflow normal (Employé) : Soumis → Chef → RH → Validé  (4 étapes)
// Workflow court  (RH)      : Soumis → Chef → Validé        (3 étapes)

if ($estRH) {
    // 3 étapes
    $steps = [
        'soumis' => 'done',
        'chef'   => match($statut) {
            'en_attente'               => 'active',
            'valide_rh'                => 'done',
            'rejete_chef', 'expire'    => 'error',
            default                    => 'pending',
        },
        'final'  => match($statut) {
            'valide_rh'                => 'done',
            'rejete_chef', 'expire'    => 'error',
            default                    => 'pending',
        },
    ];
} else {
    // 4 étapes
    $steps = [
        'soumis' => 'done',
        'chef'   => match($statut) {
            'en_attente'                              => 'active',
            'approuve_chef', 'valide_rh'              => 'done',
            'rejete_chef', 'rejete_rh', 'expire'      => 'error',
            default                                   => 'pending',
        },
        'rh'     => match($statut) {
            'approuve_chef'                           => 'active',
            'valide_rh'                               => 'done',
            'rejete_rh'                               => 'error',
            default                                   => 'pending',
        },
        'final'  => match($statut) {
            'valide_rh'                               => 'done',
            'rejete_chef', 'rejete_rh', 'expire'      => 'error',
            default                                   => 'pending',
        },
    ];
}

// Calcul solde
$droit     = (int) ($solde['NbJoursDroit_Sld'] ?? 30);
$pris      = (int) ($solde['NbJoursPris_Sld']  ?? 0);
$restant   = $droit - $pris;
$pctPris   = $droit > 0 ? round(($pris / $droit) * 100) : 0;
$suffisant = $restant >= $nbJours;
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1><i class="fas fa-umbrella-beach me-2" style="color:#F5A623;"></i>Détail du congé</h1>
        <p>Demande #<?= $conge['id_Cge'] ?> &mdash; <?= esc(($conge['Nom_Emp'] ?? '') . ' ' . ($conge['Prenom_Emp'] ?? '')) ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <?php if (($peutModifier ?? false) && $conge['id_Emp'] == $idEmp): ?>
        <a href="<?= base_url('conge/edit/' . $conge['id_Cge']) ?>" class="btn-orange">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <?php endif; ?>
        <a href="<?= base_url('conge') ?>" class="btn-outline">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<!-- FLASH MESSAGES -->
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

<?php if ($statut === 'expire'): ?>
<div style="background:rgba(150,150,150,0.08);border:1px solid rgba(150,150,150,0.2);border-radius:10px;padding:11px 16px;color:#888;font-size:0.82rem;display:flex;align-items:center;gap:10px;margin-bottom:14px;">
    <i class="fas fa-clock"></i>
    Cette demande a expiré automatiquement — la date de début était dépassée sans qu'une décision ait été prise.
</div>
<?php endif; ?>

<!-- ===== HEADER FICHE ===== -->
<div class="fiche-header">
    <div class="fiche-icon" style="background:var(--c-orange-pale);border:1px solid var(--c-orange-border);color:var(--c-orange);">
        <i class="fas fa-umbrella-beach"></i>
    </div>
    <div class="fiche-identity">
        <h2><?= esc(($conge['Nom_Emp'] ?? '') . ' ' . ($conge['Prenom_Emp'] ?? '')) ?></h2>
        <p><?= esc($conge['Email_Emp'] ?? '') ?></p>
        <div class="fiche-meta">
            <?php if (!empty($conge['Libelle_Tcg'])): ?>
            <span class="meta-chip mc-type"><i class="fas fa-tag" style="font-size:0.6rem;"></i> <?= esc($conge['Libelle_Tcg']) ?></span>
            <?php endif; ?>
            <?php if (!empty($conge['Nom_Dir'])): ?>
            <span class="meta-chip mc-dir"><i class="fas fa-building" style="font-size:0.6rem;"></i> <?= esc($conge['Nom_Dir']) ?></span>
            <?php endif; ?>
            <span class="meta-chip mc-duree"><i class="fas fa-calendar-alt" style="font-size:0.6rem;"></i> <?= $nbJours ?> jour<?= $nbJours > 1 ? 's' : '' ?></span>
            <span class="badge-statut <?= $bsCls ?>">
                <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                <?= $bsLabel ?>
            </span>
        </div>
    </div>
</div>

<!-- ===== SOLDE DE CONGÉS ===== -->
<?php if ($solde): ?>
<div class="solde-card">
    <div class="solde-card-title">
        <i class="fas fa-umbrella-beach"></i> Solde <?= date('Y') ?>
    </div>
    <div class="solde-bloc">
        <div class="solde-val" style="color:#F5A623;"><?= $droit ?></div>
        <div class="solde-lbl">Acquis</div>
    </div>
    <div class="solde-bloc">
        <div class="solde-val" style="color:#ff6b7a;"><?= $pris ?></div>
        <div class="solde-lbl">Pris</div>
    </div>
    <div class="solde-bloc">
        <div class="solde-val" style="color:<?= $restant < $nbJours ? '#ff6b7a' : '#7ab86a' ?>;"><?= $restant ?></div>
        <div class="solde-lbl">Restants</div>
    </div>
    <div class="solde-prog">
        <div style="display:flex;justify-content:space-between;font-size:0.68rem;color:var(--c-muted);margin-bottom:4px;">
            <span>Utilisation</span>
            <span style="color:var(--c-orange);"><?= $pctPris ?>%</span>
        </div>
        <div class="prog-track">
            <div class="prog-fill" style="width:<?= $pctPris ?>%;background:linear-gradient(90deg,<?= $pctPris > 80 ? '#ff6b7a,#dc3545' : '#F5A623,#d4891a' ?>);"></div>
        </div>
        <div style="font-size:0.7rem;color:var(--c-muted);margin-top:4px;">
            Cette demande : <strong style="color:<?= $suffisant ? '#7ab86a' : '#ff6b7a' ?>;"><?= $nbJours ?> jour<?= $nbJours > 1 ? 's' : '' ?></strong>
        </div>
    </div>
    <?php if (!$suffisant): ?>
    <div class="solde-warn">
        <i class="fas fa-exclamation-triangle"></i>
        Solde insuffisant — il manque <?= $nbJours - $restant ?> jour<?= ($nbJours - $restant) > 1 ? 's' : '' ?>
    </div>
    <?php elseif ($statut == 'en_attente' || $statut == 'approuve_chef'): ?>
    <div style="background:rgba(74,103,65,0.12);border:1px solid rgba(74,103,65,0.25);border-radius:8px;padding:7px 12px;font-size:0.75rem;color:#7ab86a;display:flex;align-items:center;gap:6px;">
        <i class="fas fa-check-circle"></i> Solde suffisant
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- ===== STEPPER ===== -->
<div class="stepper">
    <!-- Étape 1 — Soumis (toujours présente) -->
    <div class="step done">
        <div class="step-dot"><i class="fas fa-check"></i></div>
        <div class="step-label">Soumis</div>
    </div>

    <!-- Étape 2 — Chef Direction (toujours présente) -->
    <div class="step <?= $steps['chef'] ?>">
        <div class="step-dot">
            <?php if ($steps['chef'] === 'done'): ?><i class="fas fa-check"></i>
            <?php elseif ($steps['chef'] === 'error'): ?><i class="fas fa-times"></i>
            <?php else: ?>2<?php endif; ?>
        </div>
        <div class="step-label">Chef Direction</div>
    </div>

    <?php if (!$estRH): ?>
    <!-- Étape 3 — Validation RH (workflow normal uniquement) -->
    <div class="step <?= $steps['rh'] ?>">
        <div class="step-dot">
            <?php if ($steps['rh'] === 'done'): ?><i class="fas fa-check"></i>
            <?php elseif ($steps['rh'] === 'error'): ?><i class="fas fa-times"></i>
            <?php else: ?>3<?php endif; ?>
        </div>
        <div class="step-label">Validation RH</div>
    </div>
    <?php endif; ?>

    <!-- Dernière étape — Validé -->
    <div class="step <?= $steps['final'] ?>">
        <div class="step-dot">
            <?php if ($steps['final'] === 'done'): ?><i class="fas fa-check"></i>
            <?php elseif ($steps['final'] === 'error'): ?><i class="fas fa-times"></i>
            <?php else: ?><?= $estRH ? '3' : '4' ?><?php endif; ?>
        </div>
        <div class="step-label">Validé</div>
    </div>
</div>

<!-- ===== INFOS DEMANDE ===== -->
<div class="card-dark">
    <div class="card-dark-title"><i class="fas fa-info-circle"></i> Informations de la demande</div>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Libellé</span>
            <span class="info-value"><?= esc($conge['Libelle_Cge']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Type de congé</span>
            <span class="info-value orange"><?= esc($conge['Libelle_Tcg'] ?? '-') ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Statut</span>
            <span class="info-value"><span class="badge-statut <?= $bsCls ?>"><?= $bsLabel ?></span></span>
        </div>
        <div class="info-item">
            <span class="info-label">Date de début</span>
            <span class="info-value"><?= date('d/m/Y', strtotime($conge['DateDebut_Cge'])) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Date de fin</span>
            <span class="info-value"><?= date('d/m/Y', strtotime($conge['DateFin_Cge'])) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Durée</span>
            <span class="info-value blue"><?= $nbJours ?> jour<?= $nbJours > 1 ? 's' : '' ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Date de la demande</span>
            <span class="info-value"><?= date('d/m/Y', strtotime($conge['DateDemande_Cge'])) ?></span>
        </div>
    </div>
</div>

<!-- ===== DÉCISION CHEF ===== -->
<?php if (!empty($conge['DateDecisionDir_Cge'])): ?>
<div class="card-dark">
    <div class="card-dark-title">
        <i class="fas fa-user-tie"></i>
        <?= $estRH ? 'Décision du Chef de Direction (validation finale)' : 'Décision du Chef de Direction' ?>
    </div>
    <div class="info-grid-2" style="margin-bottom:<?= !empty($conge['CommentaireDir_Cge']) ? '12px' : '0' ?>;">
        <div class="info-item">
            <span class="info-label">Décision par</span>
            <span class="info-value">
                <?= !empty($conge['NomValidChef'])
                    ? esc($conge['NomValidChef'] . ' ' . $conge['PrenomValidChef'])
                    : '<span style="color:var(--c-muted)">-</span>' ?>
            </span>
        </div>
        <div class="info-item">
            <span class="info-label">Date de décision</span>
            <span class="info-value"><?= date('d/m/Y H:i', strtotime($conge['DateDecisionDir_Cge'])) ?></span>
        </div>
    </div>
    <?php if (!empty($conge['CommentaireDir_Cge'])): ?>
    <div class="info-label" style="margin-bottom:6px;">Motif de refus</div>
    <div class="comment-box"><?= esc($conge['CommentaireDir_Cge']) ?></div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- ===== DÉCISION RH (workflow normal uniquement) ===== -->
<?php if (!$estRH && !empty($conge['DateValidationRH_Cge'])): ?>
<div class="card-dark">
    <div class="card-dark-title"><i class="fas fa-user-check"></i> Décision RH</div>
    <div class="info-grid-2" style="margin-bottom:<?= !empty($conge['CommentaireRH_Cge']) ? '12px' : '0' ?>;">
        <div class="info-item">
            <span class="info-label">Validé par</span>
            <span class="info-value">
                <?= !empty($conge['NomValidRH'])
                    ? esc($conge['NomValidRH'] . ' ' . $conge['PrenomValidRH'])
                    : '<span style="color:var(--c-muted)">-</span>' ?>
            </span>
        </div>
        <div class="info-item">
            <span class="info-label">Date de validation</span>
            <span class="info-value"><?= date('d/m/Y H:i', strtotime($conge['DateValidationRH_Cge'])) ?></span>
        </div>
    </div>
    <?php if (!empty($conge['CommentaireRH_Cge'])): ?>
    <div class="info-label" style="margin-bottom:6px;">Motif de rejet</div>
    <div class="comment-box"><?= esc($conge['CommentaireRH_Cge']) ?></div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- ===== WORKFLOW CHEF ===== -->
<?php if ($idPfl == 2 && $statut == 'en_attente' && $conge['id_Emp'] != $idEmp): ?>
<div class="workflow-zone">
    <div class="workflow-zone-title">
        <i class="fas fa-gavel"></i>
        <?= $estRH ? 'Votre décision (validation finale)' : 'Votre décision' ?>
    </div>
    <?php if ($estRH): ?>
    <p style="font-size:0.78rem;color:var(--c-muted);margin:0 0 14px;">
        <i class="fas fa-info-circle" style="color:var(--c-orange);margin-right:5px;"></i>
        Il s'agit d'une demande du RH. Votre approbation est définitive — aucune validation RH supplémentaire ne sera requise.
    </p>
    <?php endif; ?>
    <div class="workflow-actions">
        <button class="btn-approve" onclick="openModal('approuver')">
            <i class="fas fa-<?= $estRH ? 'check-double' : 'check' ?>"></i>
            <?= $estRH ? 'Valider définitivement' : 'Approuver' ?>
        </button>
        <button class="btn-reject" onclick="openModal('refuser')">
            <i class="fas fa-times"></i> Refuser
        </button>
    </div>
</div>
<?php endif; ?>

<!-- ===== WORKFLOW RH (workflow normal uniquement) ===== -->
<?php if ($idPfl == 1 && $statut == 'approuve_chef' && $conge['id_Emp'] != $idEmp): ?>
<div class="workflow-zone">
    <div class="workflow-zone-title"><i class="fas fa-gavel"></i> Validation finale RH</div>
    <div class="workflow-actions">
        <button class="btn-approve" onclick="openModal('valider')">
            <i class="fas fa-check-double"></i> Valider définitivement
        </button>
        <button class="btn-reject" onclick="openModal('rejeter')">
            <i class="fas fa-times"></i> Rejeter
        </button>
    </div>
</div>
<?php endif; ?>

<!-- ===== MODAL ===== -->
<div class="modal-overlay" id="modal-action">
    <div class="modal-box">
        <div id="modal-icon" style="width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 12px;"></div>
        <h5 id="modal-title" style="text-align:center;"></h5>
        <p  id="modal-desc"  style="text-align:center;"></p>
        <div id="comment-wrap">
            <label style="font-size:0.68rem;color:var(--c-muted);text-transform:uppercase;letter-spacing:0.6px;display:block;margin-bottom:5px;">
                Motif <span id="comment-required" style="color:#ff8080;"></span>
            </label>
            <textarea class="modal-textarea" id="modal-comment" placeholder="Votre motif..."></textarea>
        </div>
        <div class="modal-btns">
            <button class="btn-cancel-modal" onclick="closeModal()"><i class="fas fa-times"></i> Annuler</button>
            <button id="modal-confirm-btn" class="btn-approve" onclick="submitAction()"><i class="fas fa-check"></i> Confirmer</button>
        </div>
    </div>
</div>

<!-- Forms cachés -->
<form id="form-approuver" method="POST" action="<?= base_url('conge/approuver/' . $conge['id_Cge']) ?>" style="display:none;">
    <?= csrf_field() ?><input type="hidden" name="commentaire" id="c-approuver">
</form>
<form id="form-refuser" method="POST" action="<?= base_url('conge/refuser/' . $conge['id_Cge']) ?>" style="display:none;">
    <?= csrf_field() ?><input type="hidden" name="commentaire" id="c-refuser">
</form>
<form id="form-valider" method="POST" action="<?= base_url('conge/valider/' . $conge['id_Cge']) ?>" style="display:none;">
    <?= csrf_field() ?><input type="hidden" name="commentaire" id="c-valider">
</form>
<form id="form-rejeter" method="POST" action="<?= base_url('conge/rejeter/' . $conge['id_Cge']) ?>" style="display:none;">
    <?= csrf_field() ?><input type="hidden" name="commentaire" id="c-rejeter">
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function() {
    var currentAction  = null;
    var requireComment = { refuser: true, rejeter: true, approuver: false, valider: false };
    var isRHDemandeur  = <?= $estRH ? 'true' : 'false' ?>;

    var configs = {
        approuver: {
            icon: '<i class="fas fa-' + (isRHDemandeur ? 'check-double' : 'check') + '"></i>',
            iconStyle: 'background:rgba(39,174,96,0.15);border:1px solid rgba(39,174,96,0.3);color:#27ae60;',
            title: isRHDemandeur ? 'Valider définitivement ce congé ?' : 'Approuver cette demande ?',
            desc:  isRHDemandeur
                ? 'Votre validation est définitive. Le solde sera mis à jour immédiatement.'
                : 'La demande sera transmise au RH pour validation finale.',
            btnClass: 'btn-approve',
            btnLabel: '<i class="fas fa-' + (isRHDemandeur ? 'check-double' : 'check') + '"></i> ' + (isRHDemandeur ? 'Valider' : 'Approuver'),
        },
        refuser: {
            icon: '<i class="fas fa-times"></i>',
            iconStyle: 'background:var(--c-red-pale);border:1px solid var(--c-red-border);color:#ff8080;',
            title: 'Refuser cette demande ?',
            desc: 'Un motif de refus est obligatoire.',
            btnClass: 'btn-reject',
            btnLabel: '<i class="fas fa-times"></i> Refuser',
        },
        valider: {
            icon: '<i class="fas fa-check-double"></i>',
            iconStyle: 'background:rgba(39,174,96,0.15);border:1px solid rgba(39,174,96,0.3);color:#27ae60;',
            title: 'Valider définitivement ?',
            desc: 'Le solde de congé sera automatiquement mis à jour.',
            btnClass: 'btn-approve',
            btnLabel: '<i class="fas fa-check-double"></i> Valider',
        },
        rejeter: {
            icon: '<i class="fas fa-ban"></i>',
            iconStyle: 'background:var(--c-red-pale);border:1px solid var(--c-red-border);color:#ff8080;',
            title: 'Rejeter cette demande ?',
            desc: 'Un motif de rejet est obligatoire. L\'employé sera notifié.',
            btnClass: 'btn-reject',
            btnLabel: '<i class="fas fa-ban"></i> Rejeter',
        },
    };

    window.openModal = function(action) {
        currentAction = action;
        var cfg = configs[action];
        document.getElementById('modal-icon').innerHTML     = cfg.icon;
        document.getElementById('modal-icon').style.cssText += ';' + cfg.iconStyle;
        document.getElementById('modal-title').textContent  = cfg.title;
        document.getElementById('modal-desc').textContent   = cfg.desc;
        document.getElementById('modal-comment').value      = '';
        document.getElementById('comment-required').textContent = requireComment[action] ? '*' : '';
        document.getElementById('comment-wrap').style.display  = requireComment[action] ? 'block' : 'none';

        var btn = document.getElementById('modal-confirm-btn');
        btn.className = cfg.btnClass;
        btn.innerHTML = cfg.btnLabel;

        document.getElementById('modal-action').classList.add('show');
        if (requireComment[action]) {
            setTimeout(function() { document.getElementById('modal-comment').focus(); }, 200);
        }
    };

    window.closeModal = function() {
        document.getElementById('modal-action').classList.remove('show');
        currentAction = null;
    };

    window.submitAction = function() {
        if (!currentAction) return;
        var comment = document.getElementById('modal-comment').value.trim();
        if (requireComment[currentAction] && !comment) {
            document.getElementById('modal-comment').style.borderColor = 'rgba(224,82,82,0.5)';
            document.getElementById('modal-comment').focus();
            return;
        }
        document.getElementById('c-' + currentAction).value = comment;
        document.getElementById('form-' + currentAction).submit();
    };

    document.getElementById('modal-action').addEventListener('click', function(e) {
        if (e.target === this) window.closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') window.closeModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.body.appendChild(document.getElementById('modal-action'));
        ['form-approuver','form-refuser','form-valider','form-rejeter'].forEach(function(id) {
            var f = document.getElementById(id);
            if (f) document.body.appendChild(f);
        });
    });
})();
</script>
<?= $this->endSection() ?>