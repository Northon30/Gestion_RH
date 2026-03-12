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

    .detail-card { background:#1a1a1a; border:1px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; margin-bottom:16px; }
    .detail-head { padding:16px 22px; border-bottom:1px solid rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:space-between; }
    .detail-head h5 { color:#fff; font-size:0.92rem; font-weight:600; margin:0; display:flex; align-items:center; gap:9px; }
    .detail-head h5 i { color:var(--c-primary); }
    .detail-body { padding:22px; }

    .emp-header { display:flex; align-items:center; gap:14px; padding:16px 22px; background:rgba(255,255,255,0.02); border-bottom:1px solid rgba(255,255,255,0.04); }
    .emp-av-lg { width:46px; height:46px; border-radius:50%; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:1rem; font-weight:700; }

    .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; }
    .info-item { display:flex; flex-direction:column; gap:4px; }
    .info-label { color:var(--c-muted); font-size:0.72rem; text-transform:uppercase; letter-spacing:0.6px; }
    .info-value { color:rgba(255,255,255,0.85); font-size:0.87rem; font-weight:500; }

    .badge-status { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .badge-status.en_attente { background:rgba(245,166,35,0.12); border:1px solid rgba(245,166,35,0.3); color:var(--c-orange); }
    .badge-status.approuve   { background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent); }
    .badge-status.rejete     { background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:var(--c-red); }
    .badge-status.valide_rh  { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); }
    .badge-status.rejete_rh  { background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:var(--c-red); }

    .badge-type { display:inline-flex; padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; }
    .badge-type.demande    { background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent); }
    .badge-type.invitation { background:rgba(245,166,35,0.1); border:1px solid rgba(245,166,35,0.25); color:var(--c-orange); }

    .formation-ref-block {
        background: linear-gradient(135deg, rgba(58,123,213,0.08), rgba(58,123,213,0.04));
        border: 1px solid var(--c-primary-border);
        border-radius: 12px;
        padding: 16px;
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 16px;
    }
    .formation-ref-icon { width:42px; height:42px; border-radius:10px; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:1rem; flex-shrink:0; }

    .timeline { position:relative; padding-left:24px; }
    .timeline::before { content:''; position:absolute; left:7px; top:8px; bottom:8px; width:2px; background:rgba(255,255,255,0.06); }
    .tl-item { position:relative; margin-bottom:20px; }
    .tl-item:last-child { margin-bottom:0; }
    .tl-dot { position:absolute; left:-20px; top:4px; width:14px; height:14px; border-radius:50%; border:2px solid rgba(255,255,255,0.1); background:#1a1a1a; }
    .tl-dot.done   { background:var(--c-green); border-color:var(--c-green); }
    .tl-dot.active { background:var(--c-accent); border-color:var(--c-accent); box-shadow:0 0 8px rgba(91,155,240,0.4); }
    .tl-dot.reject { background:var(--c-red); border-color:var(--c-red); }
    .tl-label { color:rgba(255,255,255,0.7); font-size:0.83rem; font-weight:600; }
    .tl-date  { color:var(--c-muted); font-size:0.73rem; margin-top:2px; }

    .commentaire-box { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:10px; padding:12px 16px; color:var(--c-soft); font-size:0.84rem; font-style:italic; margin-top:8px; }

    .action-zone { background:#1a1a1a; border:1px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; margin-bottom:16px; }
    .action-head { padding:14px 20px; border-bottom:1px solid rgba(255,255,255,0.05); color:#fff; font-size:0.88rem; font-weight:600; display:flex; align-items:center; gap:8px; }
    .action-head i { color:var(--c-orange); }
    .action-body { padding:18px 20px; }

    .form-control-dark { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fff; border-radius:8px; padding:10px 14px; font-size:0.87rem; width:100%; outline:none; transition:border-color 0.2s; resize:vertical; }
    .form-control-dark:focus { border-color:var(--c-primary); }
    .form-label-dark { color:var(--c-muted); font-size:0.82rem; margin-bottom:6px; display:block; }

    .btn-approve { background:linear-gradient(135deg,#2D6A4F,#1e4d38); border:none; color:#fff; font-weight:600; border-radius:8px; padding:9px 20px; font-size:0.85rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; width:100%; justify-content:center; }
    .btn-approve:hover { box-shadow:0 4px 14px rgba(45,106,79,0.4); }
    .btn-reject  { background:linear-gradient(135deg,#dc3545,#a71d2a); border:none; color:#fff; font-weight:600; border-radius:8px; padding:9px 20px; font-size:0.85rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; width:100%; justify-content:center; }
    .btn-reject:hover  { box-shadow:0 4px 14px rgba(220,53,69,0.4); }

    .sep { border:none; border-top:1px solid rgba(255,255,255,0.05); margin:16px 0; }
    .btn-back { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:var(--c-soft); border-radius:8px; padding:8px 16px; font-size:0.83rem; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-back:hover { background:rgba(255,255,255,0.1); color:#fff; }

    .alert-success-dark { background:rgba(144,201,127,0.1); border:1px solid rgba(144,201,127,0.25); color:var(--c-green); border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .alert-error-dark   { background:rgba(220,53,69,0.1);   border:1px solid rgba(220,53,69,0.25);   color:var(--c-red);   border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }

    .mine-badge { background:rgba(245,166,35,0.1); border:1px solid rgba(245,166,35,0.2); color:var(--c-orange); padding:3px 9px; border-radius:10px; font-size:0.72rem; font-weight:600; }

    .table-c { width:100%; border-collapse:collapse; font-size:0.83rem; }
    .table-c thead th { padding:10px 16px; font-size:0.72rem; font-weight:600; letter-spacing:0.7px; text-transform:uppercase; color:var(--c-accent); background:var(--c-primary-pale); border-bottom:1px solid rgba(255,255,255,0.05); }
    .table-c tbody td { padding:12px 16px; color:var(--c-soft); border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
    .table-c tbody tr:last-child td { border-bottom:none; }
    .badge-ins { display:inline-flex; padding:4px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-ins.inscrit { background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent); }
    .badge-ins.valide  { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); }
    .badge-ins.annule  { background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:var(--c-red); }

    .empty-state { padding:30px 20px; text-align:center; color:var(--c-muted); font-size:0.82rem; }
    .empty-state i { font-size:1.5rem; display:block; margin-bottom:8px; opacity:0.3; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$labStatut = [
    'en_attente' => 'En attente',
    'approuve'   => 'Approuvé',
    'rejete'     => 'Refusé',
    'valide_rh'  => 'Validé RH',
    'rejete_rh'  => 'Rejeté RH',
];

$estMaDemande = ($demande['id_Emp'] == $idEmp);
$peutAgir     = !$estMaDemande && ($demande['Statut_DFrm'] == 'en_attente');
$initiales    = strtoupper(mb_substr($demande['Prenom_Emp'],0,1).mb_substr($demande['Nom_Emp'],0,1));
$titreFrm     = $demande['Description_Frm'] ?: $demande['Description_Libre'] ?: '—';
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chalkboard-teacher me-2" style="color:var(--c-primary);"></i>Détail de la Demande</h1>
        <p>Référence #<?= $demande['id_DFrm'] ?></p>
    </div>
    <a href="<?= base_url('demande-formation') ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="row g-3">

    <div class="col-xl-8">

        <!-- En-tête demandeur -->
        <div class="detail-card">
            <div class="emp-header">
                <div class="emp-av-lg"><?= $initiales ?></div>
                <div style="flex:1;">
                    <div style="color:#fff;font-size:0.95rem;font-weight:600;">
                        <?= esc($demande['Prenom_Emp'].' '.$demande['Nom_Emp']) ?>
                        <?php if ($estMaDemande): ?><span class="mine-badge ms-2">Moi</span><?php endif; ?>
                    </div>
                    <div style="color:var(--c-muted);font-size:0.78rem;margin-top:2px;"><?= esc($demande['Nom_Dir'] ?? '—') ?></div>
                </div>
                <div style="text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
                    <span class="badge-status <?= $demande['Statut_DFrm'] ?>">
                        <?= $labStatut[$demande['Statut_DFrm']] ?? $demande['Statut_DFrm'] ?>
                    </span>
                    <span class="badge-type <?= strtolower($demande['Type_DFrm']) ?>"><?= ucfirst($demande['Type_DFrm']) ?></span>
                </div>
            </div>
            <div class="detail-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Date de demande</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($demande['DateDemande'])) ?></span>
                    </div>
                    <?php if ($demande['Motif']): ?>
                    <div class="info-item" style="grid-column:1/-1;">
                        <span class="info-label">Motif</span>
                        <span class="info-value"><?= esc($demande['Motif']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Formation concernée -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-graduation-cap"></i> Formation concernée</h5>
                <?php if (!empty($demande['id_Frm'])): ?>
                <a href="<?= base_url('formation/show/'.$demande['id_Frm']) ?>"
                   style="color:var(--c-accent);font-size:0.78rem;text-decoration:none;">
                    <i class="fas fa-external-link-alt me-1"></i> Voir la formation
                </a>
                <?php endif; ?>
            </div>
            <div class="detail-body">
                <?php if (!empty($demande['id_Frm'])): ?>
                <div class="formation-ref-block">
                    <div class="formation-ref-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div>
                        <div style="color:#fff;font-weight:600;font-size:0.9rem;"><?= esc($demande['Description_Frm']) ?></div>
                        <div style="color:var(--c-muted);font-size:0.78rem;margin-top:4px;">
                            <?php if ($demande['DateDebut_Frm']): ?>
                            <i class="fas fa-calendar me-1"></i>
                            <?= date('d/m/Y', strtotime($demande['DateDebut_Frm'])) ?>
                            <?php if ($demande['DateFin_Frm'] && $demande['DateFin_Frm'] != $demande['DateDebut_Frm']): ?>
                            — <?= date('d/m/Y', strtotime($demande['DateFin_Frm'])) ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Intitulé</span>
                        <span class="info-value"><?= esc($demande['Description_Libre'] ?? '—') ?></span>
                    </div>
                    <?php if ($demande['DateDebut_Libre']): ?>
                    <div class="info-item">
                        <span class="info-label">Début</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($demande['DateDebut_Libre'])) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($demande['DateFin_Libre']): ?>
                    <div class="info-item">
                        <span class="info-label">Fin</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($demande['DateFin_Libre'])) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($demande['Lieu_Libre']): ?>
                    <div class="info-item">
                        <span class="info-label">Lieu</span>
                        <span class="info-value"><?= esc($demande['Lieu_Libre']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($demande['Formateur_Libre']): ?>
                    <div class="info-item">
                        <span class="info-label">Formateur</span>
                        <span class="info-value"><?= esc($demande['Formateur_Libre']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <div style="margin-top:12px;padding:8px 12px;background:rgba(245,166,35,0.07);border:1px solid rgba(245,166,35,0.15);border-radius:8px;color:var(--c-orange);font-size:0.78rem;">
                    <i class="fas fa-info-circle me-1"></i> Formation libre — sera créée dans le catalogue si validée par le RH.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Participants (si formation liée et validée) -->
        <?php if (!empty($participants)): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-users"></i> Participants inscrits</h5>
                <span style="color:var(--c-muted);font-size:0.78rem;"><?= $nbInscrits ?> confirmé(s)</span>
            </div>
            <table class="table-c">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Direction</th>
                        <th>Date inscription</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $p): ?>
                    <tr>
                        <td style="color:rgba(255,255,255,0.8);"><?= esc($p['Prenom_Emp'].' '.$p['Nom_Emp']) ?></td>
                        <td style="color:var(--c-muted);font-size:0.8rem;"><?= esc($p['Nom_Dir'] ?? '—') ?></td>
                        <td><?= date('d/m/Y', strtotime($p['Dte_Ins'])) ?></td>
                        <td><span class="badge-ins <?= $p['Stt_Ins'] ?>"><?= ucfirst($p['Stt_Ins']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- Commentaires -->
        <?php if ($demande['CommentaireDir'] || $demande['CommentaireRH']): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-comments"></i> Commentaires</h5>
            </div>
            <div class="detail-body">
                <?php if ($demande['CommentaireDir']): ?>
                <div class="mb-3">
                    <div class="form-label-dark">
                        <i class="fas fa-user-tie me-1"></i> Chef de Direction
                        <?php if ($demande['NomValidDir']): ?>
                        — <?= esc($demande['PrenomValidDir'].' '.$demande['NomValidDir']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="commentaire-box"><?= esc($demande['CommentaireDir']) ?></div>
                </div>
                <?php endif; ?>
                <?php if ($demande['CommentaireRH']): ?>
                <div>
                    <div class="form-label-dark">
                        <i class="fas fa-shield-alt me-1"></i> RH
                        <?php if ($demande['NomValidRH']): ?>
                        — <?= esc($demande['PrenomValidRH'].' '.$demande['NomValidRH']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="commentaire-box"><?= esc($demande['CommentaireRH']) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <div class="col-xl-4">

        <!-- Timeline -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-stream"></i> Suivi</h5>
            </div>
            <div class="detail-body">
                <div class="timeline">
                    <div class="tl-item">
                        <div class="tl-dot done"></div>
                        <div class="tl-label">Demande soumise</div>
                        <div class="tl-date"><?= date('d/m/Y', strtotime($demande['DateDemande'])) ?></div>
                    </div>

                    <?php if (in_array($demande['Statut_DFrm'], ['approuve','rejete','valide_rh','rejete_rh'])): ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $demande['Statut_DFrm'] == 'rejete' ? 'reject' : 'done' ?>"></div>
                        <div class="tl-label"><?= $demande['Statut_DFrm'] == 'rejete' ? 'Refusée par Chef' : 'Approuvée par Chef' ?></div>
                        <?php if ($demande['DateDecisionDir']): ?>
                        <div class="tl-date"><?= date('d/m/Y', strtotime($demande['DateDecisionDir'])) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $demande['Statut_DFrm'] == 'en_attente' ? 'active' : '' ?>"></div>
                        <div class="tl-label" style="color:var(--c-muted);">Décision Chef</div>
                    </div>
                    <?php endif; ?>

                    <?php if (in_array($demande['Statut_DFrm'], ['valide_rh','rejete_rh'])): ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $demande['Statut_DFrm'] == 'rejete_rh' ? 'reject' : 'done' ?>"></div>
                        <div class="tl-label"><?= $demande['Statut_DFrm'] == 'rejete_rh' ? 'Rejetée par RH' : 'Validée par RH' ?></div>
                        <?php if ($demande['DateValidRH']): ?>
                        <div class="tl-date"><?= date('d/m/Y', strtotime($demande['DateValidRH'])) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $demande['Statut_DFrm'] == 'approuve' ? 'active' : '' ?>"></div>
                        <div class="tl-label" style="color:var(--c-muted);">Validation RH</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Zone action chef -->
        <?php if ($peutAgir): ?>
        <div class="action-zone">
            <div class="action-head"><i class="fas fa-gavel"></i> Votre décision</div>
            <div class="action-body">
                <p style="color:var(--c-muted);font-size:0.82rem;margin-bottom:14px;">
                    Cette demande attend votre approbation avant transmission au RH.
                </p>
                <form method="post" action="<?= base_url('demande-formation/approuver/'.$demande['id_DFrm']) ?>" class="mb-3">
                    <?= csrf_field() ?>
                    <label class="form-label-dark">Commentaire (optionnel)</label>
                    <textarea name="CommentaireDir" class="form-control-dark mb-3" rows="2" placeholder="Commentaire..."></textarea>
                    <button type="submit" class="btn-approve"><i class="fas fa-check"></i> Approuver</button>
                </form>
                <hr class="sep">
                <form method="post" action="<?= base_url('demande-formation/rejeter/'.$demande['id_DFrm']) ?>">
                    <?= csrf_field() ?>
                    <label class="form-label-dark">Motif de refus <span style="color:var(--c-red);">*</span></label>
                    <textarea name="CommentaireDir" class="form-control-dark mb-3" rows="2" placeholder="Motif obligatoire..." required></textarea>
                    <button type="submit" class="btn-reject"><i class="fas fa-times"></i> Refuser</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>