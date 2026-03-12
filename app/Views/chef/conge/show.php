<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58,123,213,0.12);
        --c-primary-border: rgba(58,123,213,0.25);
        --c-accent:         #5B9BF0;
        --c-green:          #90c97f;
        --c-red:            #ff6b7a;
        --c-orange:         #F5A623;
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.6);
    }

    .detail-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 14px;
        overflow: hidden;
    }

    .detail-head {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .detail-head h5 {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .detail-head h5 i { color: var(--c-primary); }

    .detail-body { padding: 24px; }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .info-item { display: flex; flex-direction: column; gap: 4px; }
    .info-label { color: var(--c-muted); font-size: 0.73rem; text-transform: uppercase; letter-spacing: 0.6px; }
    .info-value { color: rgba(255,255,255,0.85); font-size: 0.88rem; font-weight: 500; }

    .emp-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: rgba(255,255,255,0.02);
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }

    .emp-av-lg {
        width: 46px; height: 46px; border-radius: 50%;
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-accent); font-size: 1rem; font-weight: 700;
    }

    .emp-name-lg { color: #fff; font-size: 0.95rem; font-weight: 600; }
    .emp-dir-lg  { color: var(--c-muted); font-size: 0.78rem; margin-top: 2px; }

    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600;
    }
    .badge-status.en_attente    { background: rgba(245,166,35,0.12); border: 1px solid rgba(245,166,35,0.3); color: var(--c-orange); }
    .badge-status.approuve_chef { background: var(--c-primary-pale); border: 1px solid var(--c-primary-border); color: var(--c-accent); }
    .badge-status.rejete_chef   { background: rgba(220,53,69,0.12);  border: 1px solid rgba(220,53,69,0.3); color: var(--c-red); }
    .badge-status.valide_rh     { background: rgba(144,201,127,0.12); border: 1px solid rgba(144,201,127,0.3); color: var(--c-green); }
    .badge-status.rejete_rh     { background: rgba(220,53,69,0.12);  border: 1px solid rgba(220,53,69,0.3); color: var(--c-red); }

    .timeline {
        position: relative;
        padding-left: 24px;
        margin-top: 8px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 7px; top: 8px; bottom: 8px;
        width: 2px;
        background: rgba(255,255,255,0.06);
    }

    .tl-item {
        position: relative;
        margin-bottom: 20px;
    }

    .tl-item:last-child { margin-bottom: 0; }

    .tl-dot {
        position: absolute;
        left: -20px; top: 4px;
        width: 14px; height: 14px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.1);
        background: #1a1a1a;
    }

    .tl-dot.done   { background: var(--c-green); border-color: var(--c-green); }
    .tl-dot.active { background: var(--c-orange); border-color: var(--c-orange); box-shadow: 0 0 8px rgba(245,166,35,0.4); }
    .tl-dot.reject { background: var(--c-red); border-color: var(--c-red); }

    .tl-label { color: rgba(255,255,255,0.7); font-size: 0.83rem; font-weight: 600; }
    .tl-date  { color: var(--c-muted); font-size: 0.73rem; margin-top: 2px; }
    .tl-note  { color: rgba(255,100,100,0.7); font-size: 0.75rem; margin-top: 3px; font-style: italic; }

    .commentaire-box {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 10px;
        padding: 14px 16px;
        color: var(--c-soft);
        font-size: 0.85rem;
        font-style: italic;
        margin-top: 10px;
    }

    .section-sep {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.05);
        margin: 20px 0;
    }

    .action-zone {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 14px;
        overflow: hidden;
    }

    .action-head {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        color: #fff;
        font-size: 0.88rem;
        font-weight: 600;
        display: flex; align-items: center; gap: 8px;
    }

    .action-head i { color: var(--c-orange); }

    .action-body { padding: 20px; }

    .form-control-dark {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.88rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
        resize: vertical;
    }
    .form-control-dark:focus { border-color: var(--c-primary); background: rgba(255,255,255,0.07); }
    .form-label-dark { color: var(--c-muted); font-size: 0.82rem; margin-bottom: 6px; display: block; }

    .btn-approve { background: linear-gradient(135deg, #2D6A4F, #1e4d38); border: none; color: #fff; font-weight: 600; border-radius: 8px; padding: 9px 20px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .btn-approve:hover { box-shadow: 0 4px 14px rgba(45,106,79,0.4); }
    .btn-reject  { background: linear-gradient(135deg, #dc3545, #a71d2a); border: none; color: #fff; font-weight: 600; border-radius: 8px; padding: 9px 20px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .btn-reject:hover  { box-shadow: 0 4px 14px rgba(220,53,69,0.4); }

    .btn-back {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--c-soft);
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.83rem;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-back:hover { background: rgba(255,255,255,0.1); color: #fff; }

    .alert-success-dark { background: rgba(144,201,127,0.1); border: 1px solid rgba(144,201,127,0.25); color: var(--c-green); border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .alert-error-dark   { background: rgba(220,53,69,0.1);   border: 1px solid rgba(220,53,69,0.25);   color: var(--c-red);   border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

    .mine-badge { background: rgba(245,166,35,0.1); border: 1px solid rgba(245,166,35,0.2); color: var(--c-orange); padding: 3px 9px; border-radius: 10px; font-size: 0.72rem; font-weight: 600; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$labStatut = [
    'en_attente'    => 'En attente',
    'approuve_chef' => 'Approuvé Chef',
    'rejete_chef'   => 'Refusé Chef',
    'valide_rh'     => 'Validé RH',
    'rejete_rh'     => 'Rejeté RH',
];

$estLeChef   = ($idPfl == 2);
$estMaConge  = ($conge['id_Emp'] == $idEmp);
$peutAgir    = $estLeChef && !$estMaConge && $conge['Statut_Cge'] == 'en_attente';

$debut = new DateTime($conge['DateDebut_Cge']);
$fin   = new DateTime($conge['DateFin_Cge']);
$duree = $debut->diff($fin)->days + 1;
$initiales = strtoupper(mb_substr($conge['Prenom_Emp'], 0, 1) . mb_substr($conge['Nom_Emp'], 0, 1));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-check me-2" style="color:var(--c-primary);"></i>Détail du Congé</h1>
        <p>Référence #<?= $conge['id_Cge'] ?></p>
    </div>
    <a href="<?= base_url('conge') ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="row g-3">

    <div class="col-xl-8">
        <div class="detail-card mb-3">

            <!-- Employé -->
            <div class="emp-header">
                <div class="emp-av-lg"><?= $initiales ?></div>
                <div style="flex:1;">
                    <div class="emp-name-lg">
                        <?= esc($conge['Prenom_Emp'] . ' ' . $conge['Nom_Emp']) ?>
                        <?php if ($estMaConge): ?><span class="mine-badge ms-2">Moi</span><?php endif; ?>
                    </div>
                    <div class="emp-dir-lg"><?= esc($conge['Nom_Dir'] ?? '—') ?></div>
                </div>
                <span class="badge-status <?= $conge['Statut_Cge'] ?>">
                    <?= $labStatut[$conge['Statut_Cge']] ?? $conge['Statut_Cge'] ?>
                </span>
            </div>

            <div class="detail-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Type de congé</span>
                        <span class="info-value"><?= esc($conge['Libelle_Tcg']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Libellé</span>
                        <span class="info-value"><?= esc($conge['Libelle_Cge']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date début</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($conge['DateDebut_Cge'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date fin</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($conge['DateFin_Cge'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Durée</span>
                        <span class="info-value"><?= $duree ?> jour(s)</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de demande</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($conge['DateDemande_Cge'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commentaires -->
        <?php if (!empty($conge['CommentaireDir_Cge']) || !empty($conge['CommentaireRH_Cge'])): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-comments"></i> Commentaires</h5>
            </div>
            <div class="detail-body">
                <?php if (!empty($conge['CommentaireDir_Cge'])): ?>
                <div class="mb-3">
                    <div class="form-label-dark">
                        <i class="fas fa-user-tie me-1"></i> Chef de Direction
                        <?php if ($conge['NomValidChef']): ?>
                        — <?= esc($conge['PrenomValidChef'] . ' ' . $conge['NomValidChef']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="commentaire-box"><?= esc($conge['CommentaireDir_Cge']) ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($conge['CommentaireRH_Cge'])): ?>
                <div>
                    <div class="form-label-dark">
                        <i class="fas fa-shield-alt me-1"></i> RH
                        <?php if ($conge['NomValidRH']): ?>
                        — <?= esc($conge['PrenomValidRH'] . ' ' . $conge['NomValidRH']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="commentaire-box"><?= esc($conge['CommentaireRH_Cge']) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-xl-4">

        <!-- Timeline -->
        <div class="detail-card mb-3">
            <div class="detail-head">
                <h5><i class="fas fa-stream"></i> Suivi de la demande</h5>
            </div>
            <div class="detail-body">
                <div class="timeline">

                    <!-- Étape 1 : Soumission -->
                    <div class="tl-item">
                        <div class="tl-dot done"></div>
                        <div class="tl-label">Demande soumise</div>
                        <div class="tl-date"><?= date('d/m/Y', strtotime($conge['DateDemande_Cge'])) ?></div>
                    </div>

                    <!-- Étape 2 : Chef -->
                    <?php if (in_array($conge['Statut_Cge'], ['approuve_chef', 'rejete_chef', 'valide_rh', 'rejete_rh'])): ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= in_array($conge['Statut_Cge'], ['rejete_chef']) ? 'reject' : 'done' ?>"></div>
                        <div class="tl-label">
                            <?= $conge['Statut_Cge'] == 'rejete_chef' ? 'Refusée par le Chef' : 'Approuvée par le Chef' ?>
                        </div>
                        <?php if ($conge['DateDecisionDir_Cge']): ?>
                        <div class="tl-date"><?= date('d/m/Y H:i', strtotime($conge['DateDecisionDir_Cge'])) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $conge['Statut_Cge'] == 'en_attente' ? 'active' : '' ?>"></div>
                        <div class="tl-label" style="color:var(--c-muted);">En attente Chef</div>
                    </div>
                    <?php endif; ?>

                    <!-- Étape 3 : RH -->
                    <?php if (in_array($conge['Statut_Cge'], ['valide_rh', 'rejete_rh'])): ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $conge['Statut_Cge'] == 'rejete_rh' ? 'reject' : 'done' ?>"></div>
                        <div class="tl-label">
                            <?= $conge['Statut_Cge'] == 'rejete_rh' ? 'Rejetée par le RH' : 'Validée définitivement' ?>
                        </div>
                        <?php if ($conge['DateValidationRH_Cge']): ?>
                        <div class="tl-date"><?= date('d/m/Y H:i', strtotime($conge['DateValidationRH_Cge'])) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $conge['Statut_Cge'] == 'approuve_chef' ? 'active' : '' ?>"></div>
                        <div class="tl-label" style="color:var(--c-muted);">Validation RH</div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Zone action chef -->
        <?php if ($peutAgir): ?>
        <div class="action-zone">
            <div class="action-head">
                <i class="fas fa-gavel"></i> Votre décision
            </div>
            <div class="action-body">
                <p style="color:var(--c-muted);font-size:0.82rem;margin-bottom:14px;">
                    Cette demande attend votre approbation. Elle sera transmise au RH pour validation finale.
                </p>

                <!-- Formulaire approuver -->
                <form method="post" action="<?= base_url('conge/approuver/' . $conge['id_Cge']) ?>" class="mb-3">
                    <?= csrf_field() ?>
                    <label class="form-label-dark">Commentaire (optionnel)</label>
                    <textarea name="commentaire" class="form-control-dark mb-3" rows="2" placeholder="Commentaire..."></textarea>
                    <button type="submit" class="btn-approve w-100">
                        <i class="fas fa-check"></i> Approuver
                    </button>
                </form>

                <hr class="section-sep">

                <!-- Formulaire refuser -->
                <form method="post" action="<?= base_url('conge/refuser/' . $conge['id_Cge']) ?>">
                    <?= csrf_field() ?>
                    <label class="form-label-dark">Motif de refus <span style="color:var(--c-red);">*</span></label>
                    <textarea name="commentaire" class="form-control-dark mb-3" rows="2" placeholder="Motif obligatoire..." required></textarea>
                    <button type="submit" class="btn-reject w-100">
                        <i class="fas fa-times"></i> Refuser
                    </button>
                </form>
            </div>
        </div>
        <?php elseif ($estMaConge && $conge['Statut_Cge'] == 'en_attente'): ?>
        <div class="action-zone">
            <div class="action-head"><i class="fas fa-pen"></i> Ma demande</div>
            <div class="action-body">
                <a href="<?= base_url('conge/edit/' . $conge['id_Cge']) ?>"
                   style="display:flex;align-items:center;gap:6px;justify-content:center;background:var(--c-primary-pale);border:1px solid var(--c-primary-border);color:var(--c-accent);border-radius:8px;padding:9px;font-size:0.85rem;text-decoration:none;font-weight:600;">
                    <i class="fas fa-pen"></i> Modifier ma demande
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>