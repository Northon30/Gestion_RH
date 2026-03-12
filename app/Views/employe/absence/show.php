<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --e-primary:        #6BAF6B;
        --e-primary-pale:   rgba(107,175,107,0.12);
        --e-primary-border: rgba(107,175,107,0.25);
        --e-accent:         #8FCC8F;
        --e-orange:         #F5A623;
        --e-orange-pale:    rgba(245,166,35,0.10);
        --e-orange-border:  rgba(245,166,35,0.25);
        --e-red:            #ff6b7a;
        --e-red-pale:       rgba(255,107,122,0.10);
        --e-red-border:     rgba(255,107,122,0.25);
        --e-blue-pale:      rgba(110,168,254,0.10);
        --e-blue-border:    rgba(110,168,254,0.25);
        --e-surface:        #1a1a1a;
        --e-border:         rgba(255,255,255,0.06);
        --e-text:           rgba(255,255,255,0.85);
        --e-muted:          rgba(255,255,255,0.35);
        --e-soft:           rgba(255,255,255,0.55);
    }

    .detail-grid { display:grid; grid-template-columns:1fr 340px; gap:16px; align-items:start; }

    .card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; }

    .card-header {
        padding:14px 18px; border-bottom:1px solid var(--e-border);
        display:flex; align-items:center; gap:10px;
    }
    .card-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--e-primary-pale); border:1px solid var(--e-primary-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--e-primary); font-size:0.82rem; flex-shrink:0;
    }
    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }

    .info-block { padding:18px; display:flex; flex-direction:column; gap:14px; }
    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .info-item { display:flex; flex-direction:column; gap:3px; }
    .info-label {
        font-size:0.67rem; color:var(--e-muted);
        text-transform:uppercase; letter-spacing:0.6px; font-weight:600;
    }
    .info-value { color:var(--e-text); font-size:0.83rem; }

    .badge {
        display:inline-flex; align-items:center; gap:5px;
        padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; border:1px solid;
    }
    .badge-en_attente { background:var(--e-orange-pale); border-color:var(--e-orange-border); color:var(--e-orange); }
    .badge-valide_rh  { background:var(--e-blue-pale);   border-color:var(--e-blue-border);   color:#6ea8fe; }
    .badge-rejete_rh  { background:var(--e-red-pale);    border-color:var(--e-red-border);     color:var(--e-red); }
    .badge-approuve   { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }
    .badge-rejete     { background:var(--e-red-pale);    border-color:var(--e-red-border);     color:var(--e-red); }

    /* Stepper workflow */
    .stepper { padding:18px; display:flex; flex-direction:column; gap:0; }
    .step { display:flex; gap:14px; position:relative; }
    .step:not(:last-child)::before {
        content:''; position:absolute; left:15px; top:32px;
        width:2px; height:calc(100% - 6px);
        background:var(--e-border);
    }
    .step.done::before  { background:var(--e-primary); }
    .step.active::before { background:var(--e-orange); }

    .step-dot {
        width:30px; height:30px; border-radius:50%; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        font-size:0.75rem; border:2px solid; margin-top:2px;
        background:var(--e-surface);
    }
    .step-dot.done   { background:var(--e-primary-pale); border-color:var(--e-primary); color:var(--e-accent); }
    .step-dot.active { background:var(--e-orange-pale);  border-color:var(--e-orange);  color:var(--e-orange); }
    .step-dot.wait   { background:rgba(255,255,255,0.03); border-color:var(--e-border);  color:var(--e-muted); }
    .step-dot.reject { background:var(--e-red-pale);     border-color:var(--e-red);     color:var(--e-red); }

    .step-body { padding-bottom:18px; flex:1; }
    .step-title { color:#fff; font-size:0.82rem; font-weight:700; }
    .step-sub   { color:var(--e-muted); font-size:0.72rem; margin-top:3px; }
    .step-comment {
        background:#111; border:1px solid var(--e-border); border-radius:8px;
        padding:8px 12px; margin-top:8px; font-size:0.77rem; color:var(--e-soft);
        font-style:italic;
    }

    /* PJ */
    .pj-item {
        padding:12px 18px; border-bottom:1px solid var(--e-border);
        display:flex; align-items:center; gap:12px;
    }
    .pj-item:last-child { border-bottom:none; }
    .pj-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--e-primary-pale); border:1px solid var(--e-primary-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--e-primary); font-size:0.82rem; flex-shrink:0;
    }
    .pj-name  { color:var(--e-text); font-size:0.82rem; font-weight:600; }
    .pj-meta  { color:var(--e-muted); font-size:0.72rem; margin-top:2px; }

    .badge-pj-validee   { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }
    .badge-pj-en_attente{ background:var(--e-orange-pale);  border-color:var(--e-orange-border);  color:var(--e-orange); }
    .badge-pj-rejetee   { background:var(--e-red-pale);     border-color:var(--e-red-border);     color:var(--e-red); }

    /* Upload PJ */
    .upload-zone {
        padding:18px; border-top:1px solid var(--e-border);
    }
    .upload-label {
        font-size:0.72rem; font-weight:600; color:var(--e-soft);
        text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; display:block;
    }
    .upload-input {
        background:#111; border:1px dashed rgba(107,175,107,0.3);
        border-radius:8px; padding:12px; color:var(--e-text); font-size:0.82rem;
        width:100%; cursor:pointer; transition:border-color 0.2s;
    }
    .upload-input:focus { outline:none; border-color:var(--e-primary-border); }

    .btn-green {
        background:linear-gradient(135deg,var(--e-primary),#4A8A4A);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:9px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-green:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(107,175,107,0.3); color:#fff; }

    .btn-orange {
        background:linear-gradient(135deg,var(--e-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:9px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-orange:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(245,166,35,0.3); color:#111; }

    .btn-ghost {
        background:transparent; border:1px solid var(--e-border);
        color:var(--e-soft); font-weight:600; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }

    .btn-danger {
        background:linear-gradient(135deg,#c0392b,#922b21);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:9px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }
    .btn-danger:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(192,57,43,0.35); }

    .alert-success {
        background:var(--e-primary-pale); border:1px solid var(--e-primary-border);
        border-radius:10px; padding:11px 16px; color:var(--e-accent);
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }
    .alert-error {
        background:var(--e-red-pale); border:1px solid var(--e-red-border);
        border-radius:10px; padding:11px 16px; color:var(--e-red);
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    .right-col { display:flex; flex-direction:column; gap:16px; }

    .modal-overlay {
        position:fixed; inset:0; background:rgba(0,0,0,0.7);
        display:none; align-items:center; justify-content:center; z-index:1000;
    }
    .modal-overlay.is-open { display:flex; }
    .modal-box {
        background:#1f1f1f; border:1px solid var(--e-border); border-radius:14px;
        padding:28px; max-width:400px; width:90%; text-align:center;
    }
    .modal-icon  { font-size:2rem; color:var(--e-red); margin-bottom:12px; }
    .modal-title { color:#fff; font-size:0.95rem; font-weight:700; margin-bottom:8px; }
    .modal-msg   { color:var(--e-muted); font-size:0.82rem; margin-bottom:20px; }
    .modal-actions { display:flex; gap:10px; justify-content:center; }

    @media (max-width:900px) { .detail-grid { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$statutLabels = [
    'en_attente' => 'En attente',
    'valide_rh'  => 'Validé RH',
    'rejete_rh'  => 'Rejeté RH',
    'approuve'   => 'Approuvé',
    'rejete'     => 'Rejeté',
];
$pjLabels = ['en_attente' => 'En attente', 'validee' => 'Validée', 'rejetee' => 'Rejetée'];
$statut   = $absence['Statut_Abs'];
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-clock me-2" style="color:var(--e-primary);"></i>Détail absence</h1>
        <p><?= esc($absence['Libelle_TAbs']) ?> — du <?= date('d/m/Y', strtotime($absence['DateDebut_Abs'])) ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <?php if ($statut === 'en_attente'): ?>
        <a href="<?= base_url('absence/edit/' . $absence['id_Abs']) ?>" class="btn-orange">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <button type="button" class="btn-danger" onclick="openDelete()">
            <i class="fas fa-trash"></i> Supprimer
        </button>
        <?php endif; ?>
        <a href="<?= base_url('absence') ?>" class="btn-ghost">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success"><i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="detail-grid">

    <!-- COL GAUCHE -->
    <div style="display:flex;flex-direction:column;gap:16px;">

        <!-- Infos principales -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-info-circle"></i></div>
                <p class="card-title">Informations</p>
                <span class="badge badge-<?= $statut ?>" style="margin-left:auto;">
                    <?= $statutLabels[$statut] ?? $statut ?>
                </span>
            </div>
            <div class="info-block">
                <div class="two-col">
                    <div class="info-item">
                        <span class="info-label">Type d'absence</span>
                        <span class="info-value" style="font-weight:600;"><?= esc($absence['Libelle_TAbs']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de déclaration</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($absence['DateDemande_Abs'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de début</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($absence['DateDebut_Abs'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de fin</span>
                        <span class="info-value">
                            <?= $absence['DateFin_Abs'] ? date('d/m/Y', strtotime($absence['DateFin_Abs'])) : '—' ?>
                        </span>
                    </div>
                </div>
                <?php if ($absence['Motif_Abs']): ?>
                <div class="info-item">
                    <span class="info-label">Motif</span>
                    <span class="info-value"><?= esc($absence['Motif_Abs']) ?></span>
                </div>
                <?php endif; ?>
                <?php if ($absence['Rapport_Abs']): ?>
                <div class="info-item">
                    <span class="info-label">Rapport</span>
                    <span class="info-value"><?= esc($absence['Rapport_Abs']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pièces justificatives -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-paperclip"></i></div>
                <p class="card-title">Pièces justificatives</p>
                <?php if ($estJustifiee): ?>
                <span class="badge badge-approuve" style="margin-left:auto;">
                    <i class="fas fa-check"></i> Justifiée
                </span>
                <?php endif; ?>
            </div>

            <?php if (!empty($pieces)): ?>
                <?php foreach ($pieces as $pj): ?>
                <div class="pj-item">
                    <div class="pj-icon"><i class="fas fa-file-alt"></i></div>
                    <div style="flex:1;">
                        <div class="pj-name">
                            <?= esc(basename($pj['CheminFichier_PJ'])) ?>
                        </div>
                        <div class="pj-meta">
                            Déposé le <?= date('d/m/Y', strtotime($pj['DateDepot_PJ'])) ?>
                            <?php if ($pj['NomValidPJ']): ?>
                            — Traité par <?= esc($pj['PrenomValidPJ'] . ' ' . $pj['NomValidPJ']) ?>
                            <?php endif; ?>
                        </div>
                        <?php if ($pj['Statut_PJ'] === 'rejetee' && $pj['CommentaireRejet_PJ']): ?>
                        <div style="color:var(--e-red);font-size:0.72rem;margin-top:3px;">
                            <i class="fas fa-times-circle me-1"></i><?= esc($pj['CommentaireRejet_PJ']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="badge badge-pj-<?= $pj['Statut_PJ'] ?>">
                            <?= $pjLabels[$pj['Statut_PJ']] ?? $pj['Statut_PJ'] ?>
                        </span>
                        <a href="<?= base_url($pj['CheminFichier_PJ']) ?>" target="_blank"
                           class="btn-ghost" style="padding:4px 10px;font-size:0.72rem;">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div style="padding:24px;text-align:center;color:var(--e-muted);font-size:0.82rem;">
                <i class="fas fa-paperclip" style="font-size:1.5rem;opacity:0.2;display:block;margin-bottom:8px;"></i>
                Aucune pièce justificative déposée
            </div>
            <?php endif; ?>

            <!-- Upload PJ -->
            <div class="upload-zone">
                <label class="upload-label">
                    <i class="fas fa-upload me-1"></i> Ajouter une pièce justificative
                </label>
                <form action="<?= base_url('absence/ajouter-pj/' . $absence['id_Abs']) ?>"
                      method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                        <input type="file" name="piece_justificative"
                               class="upload-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <button type="submit" class="btn-green">
                            <i class="fas fa-upload"></i> Envoyer
                        </button>
                    </div>
                    <span class="form-hint" style="font-size:0.7rem;color:var(--e-muted);margin-top:6px;display:block;">
                        PDF, JPG ou PNG — max 5 Mo
                    </span>
                </form>
            </div>
        </div>

    </div>

    <!-- COL DROITE -->
    <div class="right-col">

        <!-- Stepper workflow -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-route"></i></div>
                <p class="card-title">Suivi de la demande</p>
            </div>
            <div class="stepper">

                <!-- Étape 1 : Déclaration -->
                <div class="step done">
                    <div class="step-dot done"><i class="fas fa-check"></i></div>
                    <div class="step-body">
                        <div class="step-title">Déclaration soumise</div>
                        <div class="step-sub"><?= date('d/m/Y', strtotime($absence['DateDemande_Abs'])) ?></div>
                    </div>
                </div>

                <!-- Étape 2 : Validation RH -->
                <?php
                $rhDone   = in_array($statut, ['valide_rh','approuve','rejete_rh','rejete']);
                $rhRejet  = $statut === 'rejete_rh';
                $rhActive = $statut === 'en_attente';
                ?>
                <div class="step <?= $rhDone ? ($rhRejet ? 'reject' : 'done') : ($rhActive ? 'active' : '') ?>">
                    <div class="step-dot <?= $rhDone ? ($rhRejet ? 'reject' : 'done') : ($rhActive ? 'active' : 'wait') ?>">
                        <i class="fas <?= $rhRejet ? 'fa-times' : ($rhDone ? 'fa-check' : 'fa-clock') ?>"></i>
                    </div>
                    <div class="step-body">
                        <div class="step-title">Validation RH</div>
                        <div class="step-sub">
                            <?php if ($rhDone && $absence['DateValidationRH_Abs']): ?>
                            <?= date('d/m/Y', strtotime($absence['DateValidationRH_Abs'])) ?>
                            <?php if ($absence['NomValidRH']): ?>
                            — <?= esc($absence['PrenomValidRH'] . ' ' . $absence['NomValidRH']) ?>
                            <?php endif; ?>
                            <?php elseif ($rhActive): ?>
                            En attente de traitement
                            <?php else: ?>
                            En attente
                            <?php endif; ?>
                        </div>
                        <?php if ($absence['CommentaireRH_Abs']): ?>
                        <div class="step-comment">
                            <i class="fas fa-comment-dots me-1"></i><?= esc($absence['CommentaireRH_Abs']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Étape 3 : Approbation Chef -->
                <?php
                $chefDone   = in_array($statut, ['approuve','rejete']);
                $chefRejet  = $statut === 'rejete';
                $chefActive = $statut === 'valide_rh';
                ?>
                <div class="step <?= $chefDone ? ($chefRejet ? 'reject' : 'done') : ($chefActive ? 'active' : '') ?>">
                    <div class="step-dot <?= $chefDone ? ($chefRejet ? 'reject' : 'done') : ($chefActive ? 'active' : 'wait') ?>">
                        <i class="fas <?= $chefRejet ? 'fa-times' : ($chefDone ? 'fa-check' : 'fa-clock') ?>"></i>
                    </div>
                    <div class="step-body">
                        <div class="step-title">Approbation Chef de Direction</div>
                        <div class="step-sub">
                            <?php if ($chefDone && $absence['DateDecisionDir_Abs']): ?>
                            <?= date('d/m/Y', strtotime($absence['DateDecisionDir_Abs'])) ?>
                            <?php if ($absence['NomValidDir']): ?>
                            — <?= esc($absence['PrenomValidDir'] . ' ' . $absence['NomValidDir']) ?>
                            <?php endif; ?>
                            <?php elseif ($chefActive): ?>
                            En attente de votre Chef de Direction
                            <?php else: ?>
                            En attente
                            <?php endif; ?>
                        </div>
                        <?php if ($absence['CommentaireDir_Abs']): ?>
                        <div class="step-comment">
                            <i class="fas fa-comment-dots me-1"></i><?= esc($absence['CommentaireDir_Abs']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Modal suppression -->
<div class="modal-overlay" id="modal-delete">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <div class="modal-title">Supprimer cette absence ?</div>
        <div class="modal-msg">Cette action est irréversible.</div>
        <div class="modal-actions">
            <button type="button" class="btn-ghost" onclick="closeDelete()">
                <i class="fas fa-times"></i> Annuler
            </button>
            <form method="POST" action="<?= base_url('absence/delete/' . $absence['id_Abs']) ?>">
                <?= csrf_field() ?>
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    window.openDelete  = function () { document.getElementById('modal-delete').classList.add('is-open'); };
    window.closeDelete = function () { document.getElementById('modal-delete').classList.remove('is-open'); };
})();
</script>
<?= $this->endSection() ?>