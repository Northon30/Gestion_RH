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
        --c-purple:         #c084fc;
        --c-purple-pale:    rgba(192,132,252,0.10);
        --c-purple-border:  rgba(192,132,252,0.25);
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.6);
    }

    .detail-card { background:#1a1a1a; border:1px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; margin-bottom:16px; }
    .detail-head { padding:16px 22px; border-bottom:1px solid rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:space-between; }
    .detail-head h5 { color:#fff; font-size:0.92rem; font-weight:600; margin:0; display:flex; align-items:center; gap:9px; }
    .detail-head h5 i { color:var(--c-primary); }
    .detail-body { padding:22px; }

    .emp-header { display:flex; align-items:center; gap:14px; padding:16px 22px; background:rgba(255,255,255,0.02); border-bottom:1px solid rgba(255,255,255,0.04); }
    .emp-av-lg { width:46px; height:46px; border-radius:50%; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:1rem; font-weight:700; flex-shrink:0; }
    .emp-name-lg { color:#fff; font-size:0.95rem; font-weight:600; }
    .emp-dir-lg  { color:var(--c-muted); font-size:0.78rem; margin-top:2px; }

    .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; margin-bottom:4px; }
    .info-item { display:flex; flex-direction:column; gap:4px; }
    .info-label { color:var(--c-muted); font-size:0.72rem; text-transform:uppercase; letter-spacing:0.6px; }
    .info-value { color:rgba(255,255,255,0.85); font-size:0.87rem; font-weight:500; }

    /* ── Badges statut — alignés controller ── */
    .badge-status { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:0.78rem; font-weight:600; border:1px solid; }
    .badge-status.en_attente    { background:rgba(245,166,35,0.12);   border-color:rgba(245,166,35,0.3);   color:var(--c-orange); }
    .badge-status.approuve_chef { background:var(--c-purple-pale);    border-color:var(--c-purple-border); color:var(--c-purple); }
    .badge-status.rejete_chef   { background:rgba(220,53,69,0.12);    border-color:rgba(220,53,69,0.3);    color:var(--c-red); }
    .badge-status.valide_rh     { background:var(--c-primary-pale);   border-color:var(--c-primary-border); color:var(--c-accent); }
    .badge-status.rejete_rh     { background:rgba(220,53,69,0.12);    border-color:rgba(220,53,69,0.3);    color:var(--c-red); }
    .badge-status.expire        { background:rgba(255,255,255,0.04);  border-color:rgba(255,255,255,0.12); color:var(--c-muted); }

    .badge-pj { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-pj.en_attente { background:rgba(245,166,35,0.12); border:1px solid rgba(245,166,35,0.3); color:var(--c-orange); }
    .badge-pj.validee    { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); }
    .badge-pj.rejetee    { background:rgba(220,53,69,0.12);   border:1px solid rgba(220,53,69,0.3);   color:var(--c-red); }

    .pj-item { display:flex; align-items:center; gap:12px; padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.03); }
    .pj-item:last-child { border-bottom:none; }
    .pj-icon { width:36px; height:36px; border-radius:8px; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:0.9rem; flex-shrink:0; }
    .pj-name { color:rgba(255,255,255,0.75); font-size:0.82rem; }
    .pj-date { color:var(--c-muted); font-size:0.72rem; margin-top:2px; }

    /* ── Timeline — ordre réel : Déclaration → Chef → RH ── */
    .timeline { position:relative; padding-left:24px; }
    .timeline::before { content:''; position:absolute; left:7px; top:8px; bottom:8px; width:2px; background:rgba(255,255,255,0.06); }
    .tl-item { position:relative; margin-bottom:20px; }
    .tl-item:last-child { margin-bottom:0; }
    .tl-dot { position:absolute; left:-20px; top:4px; width:14px; height:14px; border-radius:50%; border:2px solid rgba(255,255,255,0.1); background:#1a1a1a; }
    .tl-dot.done   { background:var(--c-green);  border-color:var(--c-green); }
    .tl-dot.active { background:var(--c-accent); border-color:var(--c-accent); box-shadow:0 0 8px rgba(91,155,240,0.4); }
    .tl-dot.reject { background:var(--c-red);    border-color:var(--c-red); }
    .tl-dot.wait   { background:#1a1a1a;          border-color:rgba(255,255,255,0.1); }
    .tl-label { color:rgba(255,255,255,0.7); font-size:0.83rem; font-weight:600; }
    .tl-label.muted { color:var(--c-muted); font-weight:400; }
    .tl-date  { color:var(--c-muted); font-size:0.73rem; margin-top:2px; }

    .commentaire-box { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:10px; padding:12px 16px; color:var(--c-soft); font-size:0.84rem; font-style:italic; margin-top:8px; }

    .action-zone { background:#1a1a1a; border:1px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; margin-bottom:16px; }
    .action-head { padding:14px 20px; border-bottom:1px solid rgba(255,255,255,0.05); color:#fff; font-size:0.88rem; font-weight:600; display:flex; align-items:center; gap:8px; }
    .action-head i { color:var(--c-orange); }
    .action-body { padding:18px 20px; }

    .form-control-dark { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fff; border-radius:8px; padding:10px 14px; font-size:0.87rem; width:100%; outline:none; transition:border-color 0.2s; resize:vertical; }
    .form-control-dark:focus { border-color:var(--c-primary); background:rgba(255,255,255,0.07); }
    .form-label-dark { color:var(--c-muted); font-size:0.82rem; margin-bottom:6px; display:block; }

    .btn-approve { background:linear-gradient(135deg,#2D6A4F,#1e4d38); border:none; color:#fff; font-weight:600; border-radius:8px; padding:9px 20px; font-size:0.85rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; width:100%; justify-content:center; }
    .btn-approve:hover { box-shadow:0 4px 14px rgba(45,106,79,0.4); }
    .btn-reject  { background:linear-gradient(135deg,#dc3545,#a71d2a); border:none; color:#fff; font-weight:600; border-radius:8px; padding:9px 20px; font-size:0.85rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; width:100%; justify-content:center; }
    .btn-reject:hover  { box-shadow:0 4px 14px rgba(220,53,69,0.4); }

    .btn-back { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:var(--c-soft); border-radius:8px; padding:8px 16px; font-size:0.83rem; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-back:hover { background:rgba(255,255,255,0.1); color:#fff; }

    .btn-upload { background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent); border-radius:8px; padding:8px 16px; font-size:0.82rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; }
    .btn-upload:hover { background:rgba(58,123,213,0.2); }

    .sep { border:none; border-top:1px solid rgba(255,255,255,0.05); margin:16px 0; }

    .alert-success-dark { background:rgba(144,201,127,0.1); border:1px solid rgba(144,201,127,0.25); color:var(--c-green); border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .alert-error-dark   { background:rgba(220,53,69,0.1);   border:1px solid rgba(220,53,69,0.25);   color:var(--c-red);   border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .alert-expire-dark  { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.10); color:var(--c-muted); border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }

    .mine-badge { background:rgba(245,166,35,0.1); border:1px solid rgba(245,166,35,0.2); color:var(--c-orange); padding:3px 9px; border-radius:10px; font-size:0.72rem; font-weight:600; }
    .justified-badge { background:rgba(144,201,127,0.1); border:1px solid rgba(144,201,127,0.25); color:var(--c-green); padding:4px 10px; border-radius:8px; font-size:0.78rem; font-weight:600; display:inline-flex; align-items:center; gap:5px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// ── Libellés statuts alignés sur le controller ──
$labStatut = [
    'en_attente'    => 'En attente Chef',
    'approuve_chef' => 'Approuvé Chef',
    'rejete_chef'   => 'Refusé Chef',
    'valide_rh'     => 'Validé RH',
    'rejete_rh'     => 'Rejeté RH',
    'expire'        => 'Expiré',
];

$statut       = $absence['Statut_Abs'];
$estMaAbsence = ($absence['id_Emp'] == $idEmp);

// Le chef peut agir (approuver/refuser) si :
// - c'est pas sa propre absence
// - le statut est en_attente (étape 1 chef dans le workflow réel)
$peutAgir = ($idPfl == 2) && !$estMaAbsence && ($statut === 'en_attente');

$initiales = strtoupper(mb_substr($absence['Prenom_Emp'], 0, 1) . mb_substr($absence['Nom_Emp'], 0, 1));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-clock me-2" style="color:var(--c-primary);"></i>Détail de l'Absence</h1>
        <p>Référence #<?= $absence['id_Abs'] ?></p>
    </div>
    <a href="<?= base_url('absence') ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>
<?php if ($statut === 'expire'): ?>
<div class="alert-expire-dark"><i class="fas fa-clock"></i> Cette demande a expiré automatiquement car la date de début est dépassée.</div>
<?php endif; ?>

<div class="row g-3">

    <div class="col-xl-8">

        <!-- Infos principales -->
        <div class="detail-card">
            <div class="emp-header">
                <div class="emp-av-lg"><?= $initiales ?></div>
                <div style="flex:1;">
                    <div class="emp-name-lg">
                        <?= esc($absence['Prenom_Emp'] . ' ' . $absence['Nom_Emp']) ?>
                        <?php if ($estMaAbsence): ?><span class="mine-badge ms-2">Moi</span><?php endif; ?>
                    </div>
                    <div class="emp-dir-lg"><?= esc($absence['Nom_Dir'] ?? '—') ?></div>
                </div>
                <div style="text-align:right;">
                    <span class="badge-status <?= esc($statut) ?>">
                        <?= $labStatut[$statut] ?? esc($statut) ?>
                    </span>
                    <?php if ($estJustifiee): ?>
                    <div class="justified-badge mt-2"><i class="fas fa-shield-check"></i> Justifiée</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="detail-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Type</span>
                        <span class="info-value"><?= esc($absence['Libelle_TAbs']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date début</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($absence['DateDebut_Abs'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date fin</span>
                        <span class="info-value"><?= $absence['DateFin_Abs'] ? date('d/m/Y', strtotime($absence['DateFin_Abs'])) : '—' ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date déclaration</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($absence['DateDemande_Abs'])) ?></span>
                    </div>
                    <?php if ($absence['Motif_Abs']): ?>
                    <div class="info-item" style="grid-column:1/-1;">
                        <span class="info-label">Motif</span>
                        <span class="info-value"><?= esc($absence['Motif_Abs']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($absence['Rapport_Abs']): ?>
                    <div class="info-item" style="grid-column:1/-1;">
                        <span class="info-label">Rapport</span>
                        <span class="info-value"><?= esc($absence['Rapport_Abs']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Commentaires (si existants) -->
        <?php if ($absence['CommentaireRH_Abs'] || $absence['CommentaireDir_Abs']): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-comments"></i> Commentaires</h5>
            </div>
            <div class="detail-body">
                <?php if ($absence['CommentaireDir_Abs']): ?>
                <div class="mb-3">
                    <div class="form-label-dark">
                        <i class="fas fa-user-tie me-1"></i> Chef de Direction
                        <?php if ($absence['NomValidDir']): ?>
                        — <?= esc($absence['PrenomValidDir'] . ' ' . $absence['NomValidDir']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="commentaire-box"><?= esc($absence['CommentaireDir_Abs']) ?></div>
                </div>
                <?php endif; ?>
                <?php if ($absence['CommentaireRH_Abs']): ?>
                <div>
                    <div class="form-label-dark">
                        <i class="fas fa-shield-alt me-1"></i> RH
                        <?php if ($absence['NomValidRH']): ?>
                        — <?= esc($absence['PrenomValidRH'] . ' ' . $absence['NomValidRH']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="commentaire-box"><?= esc($absence['CommentaireRH_Abs']) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Pièces justificatives -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-paperclip"></i> Pièces justificatives</h5>
                <?php if ($estJustifiee): ?>
                <span class="justified-badge"><i class="fas fa-check"></i> Absence justifiée</span>
                <?php endif; ?>
            </div>

            <?php if (!empty($pieces)): ?>
                <?php foreach ($pieces as $pj): ?>
                <div class="pj-item">
                    <div class="pj-icon">
                        <?php
                        $ext = strtolower(pathinfo($pj['CheminFichier_PJ'], PATHINFO_EXTENSION));
                        $ico = match($ext) { 'pdf' => 'fa-file-pdf', 'jpg', 'jpeg', 'png' => 'fa-file-image', default => 'fa-file' };
                        ?>
                        <i class="fas <?= $ico ?>"></i>
                    </div>
                    <div style="flex:1;">
                        <div class="pj-name"><?= esc(basename($pj['CheminFichier_PJ'])) ?></div>
                        <div class="pj-date">Déposée le <?= date('d/m/Y', strtotime($pj['DateDepot_PJ'])) ?>
                            <?php if ($pj['NomValidPJ']): ?>
                            — Traité par <?= esc($pj['PrenomValidPJ'] . ' ' . $pj['NomValidPJ']) ?>
                            <?php endif; ?>
                        </div>
                        <?php if ($pj['Statut_PJ'] === 'rejetee' && $pj['CommentaireRejet_PJ']): ?>
                        <div style="color:var(--c-red);font-size:0.72rem;margin-top:3px;">
                            <i class="fas fa-times-circle me-1"></i><?= esc($pj['CommentaireRejet_PJ']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <span class="badge-pj <?= esc($pj['Statut_PJ']) ?>">
                        <?= ['en_attente' => 'En attente', 'validee' => 'Validée', 'rejetee' => 'Rejetée'][$pj['Statut_PJ']] ?? esc($pj['Statut_PJ']) ?>
                    </span>
                    <a href="<?= base_url($pj['CheminFichier_PJ']) ?>" target="_blank"
                       style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:var(--c-muted);width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:0.78rem;transition:all 0.2s;"
                       onmouseover="this.style.color='var(--c-accent)'" onmouseout="this.style.color='var(--c-muted)'">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div style="padding:24px;text-align:center;color:var(--c-muted);font-size:0.82rem;">
                <i class="fas fa-paperclip" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;"></i>
                Aucune pièce justificative
            </div>
            <?php endif; ?>

            <!-- Upload PJ — masqué si expiré ou rejeté définitivement -->
            <?php if (!in_array($statut, ['expire', 'rejete_chef', 'rejete_rh'])): ?>
            <div style="padding:16px 20px;border-top:1px solid rgba(255,255,255,0.04);">
                <form method="post" action="<?= base_url('absence/ajouter-pj/' . $absence['id_Abs']) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                        <input type="file" name="piece_justificative" accept=".pdf,.jpg,.jpeg,.png"
                               style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:var(--c-soft);border-radius:8px;padding:7px 12px;font-size:0.8rem;flex:1;min-width:200px;"
                               required>
                        <button type="submit" class="btn-upload">
                            <i class="fas fa-upload"></i> Déposer une PJ
                        </button>
                    </div>
                    <div style="color:var(--c-muted);font-size:0.72rem;margin-top:6px;">
                        Formats acceptés : PDF, JPG, PNG — Max 5 Mo
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="col-xl-4">

        <!-- Timeline — ordre réel : Déclaration → Chef → RH -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-stream"></i> Suivi</h5>
            </div>
            <div class="detail-body">
                <?php
                // États chef
                $chefDone  = in_array($statut, ['approuve_chef', 'rejete_chef', 'valide_rh', 'rejete_rh']);
                $chefRejet = $statut === 'rejete_chef';
                $chefActif = $statut === 'en_attente';

                // États RH
                $rhDone    = in_array($statut, ['valide_rh', 'rejete_rh']);
                $rhRejet   = $statut === 'rejete_rh';
                $rhActif   = $statut === 'approuve_chef';
                ?>
                <div class="timeline">

                    <!-- Étape 1 : Déclaration -->
                    <div class="tl-item">
                        <div class="tl-dot done"></div>
                        <div class="tl-label">Absence déclarée</div>
                        <div class="tl-date"><?= date('d/m/Y', strtotime($absence['DateDemande_Abs'])) ?></div>
                    </div>

                    <!-- Étape 2 : Chef de Direction -->
                    <div class="tl-item">
                        <div class="tl-dot <?= $chefRejet ? 'reject' : ($chefDone ? 'done' : ($chefActif ? 'active' : 'wait')) ?>"></div>
                        <div class="tl-label <?= (!$chefDone && !$chefActif) ? 'muted' : '' ?>">
                            <?php if ($chefRejet): ?>
                                Refusée par Chef de Direction
                            <?php elseif ($chefDone): ?>
                                Approuvée par Chef de Direction
                            <?php elseif ($chefActif): ?>
                                En attente Chef de Direction
                            <?php else: ?>
                                Approbation Chef de Direction
                            <?php endif; ?>
                        </div>
                        <?php if ($chefDone && $absence['DateDecisionDir_Abs']): ?>
                        <div class="tl-date">
                            <?= date('d/m/Y H:i', strtotime($absence['DateDecisionDir_Abs'])) ?>
                            <?php if ($absence['NomValidDir']): ?>
                            — <?= esc($absence['PrenomValidDir'] . ' ' . $absence['NomValidDir']) ?>
                            <?php endif; ?>
                        </div>
                        <?php elseif ($statut === 'expire'): ?>
                        <div class="tl-date">Expirée avant décision</div>
                        <?php endif; ?>
                    </div>

                    <!-- Étape 3 : RH -->
                    <div class="tl-item">
                        <div class="tl-dot <?= $rhRejet ? 'reject' : ($rhDone ? 'done' : ($rhActif ? 'active' : 'wait')) ?>"></div>
                        <div class="tl-label <?= (!$rhDone && !$rhActif) ? 'muted' : '' ?>">
                            <?php if ($rhRejet): ?>
                                Rejetée par le RH
                            <?php elseif ($rhDone): ?>
                                Validée par le RH
                            <?php elseif ($rhActif): ?>
                                En attente validation RH
                            <?php else: ?>
                                Validation RH
                            <?php endif; ?>
                        </div>
                        <?php if ($rhDone && $absence['DateValidationRH_Abs']): ?>
                        <div class="tl-date">
                            <?= date('d/m/Y H:i', strtotime($absence['DateValidationRH_Abs'])) ?>
                            <?php if ($absence['NomValidRH']): ?>
                            — <?= esc($absence['PrenomValidRH'] . ' ' . $absence['NomValidRH']) ?>
                            <?php endif; ?>
                        </div>
                        <?php elseif ($statut === 'expire'): ?>
                        <div class="tl-date">Non atteinte</div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- Zone action chef : approuver/refuser l'absence d'un employé -->
        <?php if ($peutAgir): ?>
        <div class="action-zone">
            <div class="action-head"><i class="fas fa-gavel"></i> Votre décision</div>
            <div class="action-body">
                <p style="color:var(--c-muted);font-size:0.82rem;margin-bottom:14px;">
                    Cette demande est en attente de votre décision.
                </p>
                <form method="post" action="<?= base_url('absence/approuver/' . $absence['id_Abs']) ?>" class="mb-3">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-approve"><i class="fas fa-check"></i> Approuver</button>
                </form>
                <hr class="sep">
                <form method="post" action="<?= base_url('absence/refuser/' . $absence['id_Abs']) ?>">
                    <?= csrf_field() ?>
                    <label class="form-label-dark">Motif de refus <span style="color:var(--c-red);">*</span></label>
                    <textarea name="commentaire" class="form-control-dark mb-3" rows="2"
                              placeholder="Motif obligatoire..." required></textarea>
                    <button type="submit" class="btn-reject"><i class="fas fa-times"></i> Refuser</button>
                </form>
            </div>
        </div>

        <!-- Zone action : ma propre absence (chef pour lui-même) -->
        <?php elseif ($estMaAbsence && $peutModifier): ?>
        <div class="action-zone">
            <div class="action-head"><i class="fas fa-pen"></i> Ma déclaration</div>
            <div class="action-body">
                <a href="<?= base_url('absence/edit/' . $absence['id_Abs']) ?>"
                   style="display:flex;align-items:center;gap:6px;justify-content:center;background:var(--c-primary-pale);border:1px solid var(--c-primary-border);color:var(--c-accent);border-radius:8px;padding:9px;font-size:0.85rem;text-decoration:none;font-weight:600;margin-bottom:10px;">
                    <i class="fas fa-pen"></i> Modifier
                </a>
                <form method="post" action="<?= base_url('absence/delete/' . $absence['id_Abs']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" onclick="return confirm('Supprimer cette déclaration ?')"
                       style="display:flex;align-items:center;gap:6px;justify-content:center;background:rgba(220,53,69,0.1);border:1px solid rgba(220,53,69,0.25);color:var(--c-red);border-radius:8px;padding:9px;font-size:0.85rem;font-weight:600;width:100%;cursor:pointer;">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>