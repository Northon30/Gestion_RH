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

    .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; }
    .info-item { display:flex; flex-direction:column; gap:4px; }
    .info-label { color:var(--c-muted); font-size:0.72rem; text-transform:uppercase; letter-spacing:0.6px; }
    .info-value { color:rgba(255,255,255,0.85); font-size:0.87rem; font-weight:500; }

    .capacity-block {
        background: linear-gradient(135deg, rgba(58,123,213,0.1), rgba(58,123,213,0.05));
        border: 1px solid var(--c-primary-border);
        border-radius: 12px;
        padding: 18px;
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 16px;
    }
    .cap-icon { width:46px; height:46px; border-radius:12px; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:1.1rem; flex-shrink:0; }
    .cap-val  { color:#fff; font-size:1.8rem; font-weight:800; line-height:1; }
    .cap-label { color:var(--c-muted); font-size:0.75rem; text-transform:uppercase; letter-spacing:0.6px; margin-top:3px; }
    .cap-bar  { flex:1; }
    .cap-bar-track { height:6px; background:rgba(255,255,255,0.06); border-radius:6px; overflow:hidden; margin-top:8px; }
    .cap-bar-fill  { height:100%; border-radius:6px; transition:width 0.5s; }

    .table-c { width:100%; border-collapse:collapse; font-size:0.83rem; }
    .table-c thead th { padding:10px 16px; font-size:0.72rem; font-weight:600; letter-spacing:0.7px; text-transform:uppercase; color:var(--c-accent); background:var(--c-primary-pale); border-bottom:1px solid rgba(255,255,255,0.05); }
    .table-c tbody td { padding:12px 16px; color:var(--c-soft); border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
    .table-c tbody tr:last-child td { border-bottom:none; }
    .table-c tbody tr:hover td { background:rgba(255,255,255,0.02); }

    .emp-cell { display:flex; align-items:center; gap:9px; }
    .emp-av { width:30px; height:30px; border-radius:50%; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:0.72rem; font-weight:700; flex-shrink:0; }

    .badge-ins { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-ins.inscrit { background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent); }
    .badge-ins.valide  { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); }
    .badge-ins.annule  { background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:var(--c-red); }

    .mon-statut-block {
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex; align-items: center; gap: 14px;
    }
    .mon-statut-block i { color:var(--c-accent); font-size:1.1rem; }

    .badge-period { display:inline-flex; align-items:center; padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; }
    .badge-period.avenir  { background:rgba(58,123,213,0.15); border:1px solid var(--c-primary-border); color:var(--c-accent); }
    .badge-period.encours { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); }
    .badge-period.passe   { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--c-muted); }

    .btn-back { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:var(--c-soft); border-radius:8px; padding:8px 16px; font-size:0.83rem; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-back:hover { background:rgba(255,255,255,0.1); color:#fff; }

    .alert-success-dark { background:rgba(144,201,127,0.1); border:1px solid rgba(144,201,127,0.25); color:var(--c-green); border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .alert-error-dark   { background:rgba(220,53,69,0.1);   border:1px solid rgba(220,53,69,0.25);   color:var(--c-red);   border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }

    .empty-state { padding:30px 20px; text-align:center; color:var(--c-muted); font-size:0.82rem; }
    .empty-state i { font-size:1.5rem; display:block; margin-bottom:8px; opacity:0.3; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$today   = date('Y-m-d');
$pct     = $formation['Capacite_Frm'] > 0
    ? round($nbInscrits / $formation['Capacite_Frm'] * 100) : 0;
$fillCol = $pct >= 100 ? '#ff6b7a' : ($pct >= 75 ? '#F5A623' : '#90c97f');

if ($formation['DateDebut_Frm'] > $today)      { $periode = 'avenir';  $periodeLabel = 'À venir'; }
elseif ($formation['DateFin_Frm'] >= $today)   { $periode = 'encours'; $periodeLabel = 'En cours'; }
else                                            { $periode = 'passe';   $periodeLabel = 'Terminée'; }
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-graduation-cap me-2" style="color:var(--c-primary);"></i>Détail de la Formation</h1>
        <p>Référence #<?= $formation['id_Frm'] ?></p>
    </div>
    <a href="<?= base_url('formation') ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="row g-3">

    <div class="col-xl-8">

        <!-- Infos formation -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-info-circle"></i> Informations</h5>
                <span class="badge-period <?= $periode ?>"><?= $periodeLabel ?></span>
            </div>
            <div class="detail-body">
                <div style="margin-bottom:18px;">
                    <div style="color:#fff;font-size:1rem;font-weight:700;margin-bottom:10px;">
                        <?= esc($formation['Description_Frm']) ?>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Date début</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($formation['DateDebut_Frm'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date fin</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($formation['DateFin_Frm'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lieu</span>
                        <span class="info-value"><?= esc($formation['Lieu_Frm']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Formateur</span>
                        <span class="info-value"><?= esc($formation['Formateur_Frm']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-users"></i> Participants</h5>
                <span style="color:var(--c-muted);font-size:0.78rem;"><?= $nbValides ?> confirmé(s) · <?= $nbInscrits ?> inscrit(s) · <?= $nbAnnules ?> annulé(s)</span>
            </div>
            <?php if (!empty($participants)): ?>
            <table class="table-c">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Direction</th>
                        <th>Inscrit le</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $p): ?>
                    <?php $ini = strtoupper(mb_substr($p['Prenom_Emp'],0,1).mb_substr($p['Nom_Emp'],0,1)); ?>
                    <tr>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-av"><?= $ini ?></div>
                                <div>
                                    <div style="color:rgba(255,255,255,0.8);font-weight:500;"><?= esc($p['Prenom_Emp'].' '.$p['Nom_Emp']) ?></div>
                                    <div style="color:var(--c-muted);font-size:0.72rem;"><?= esc($p['Email_Emp']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--c-muted);font-size:0.8rem;"><?= esc($p['Nom_Dir'] ?? '—') ?></td>
                        <td><?= date('d/m/Y', strtotime($p['Dte_Ins'])) ?></td>
                        <td><span class="badge-ins <?= $p['Stt_Ins'] ?>"><?= ucfirst($p['Stt_Ins']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                Aucun participant pour le moment
            </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="col-xl-4">

        <!-- Capacité -->
        <div class="detail-card mb-3">
            <div class="detail-head">
                <h5><i class="fas fa-chart-bar"></i> Capacité</h5>
            </div>
            <div class="detail-body">
                <div class="capacity-block">
                    <div class="cap-icon"><i class="fas fa-users"></i></div>
                    <div style="flex:1;">
                        <div class="cap-val"><?= $nbInscrits ?> <span style="font-size:1rem;font-weight:400;color:var(--c-muted);">/ <?= $formation['Capacite_Frm'] ?></span></div>
                        <div class="cap-label">Inscrits</div>
                        <div class="cap-bar-track">
                            <div class="cap-bar-fill" style="width:<?= min($pct,100) ?>%;background:<?= $fillCol ?>;"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-4" style="text-align:center;">
                        <div style="color:var(--c-green);font-size:1.3rem;font-weight:700;"><?= $nbValides ?></div>
                        <div style="color:var(--c-muted);font-size:0.72rem;">Confirmés</div>
                    </div>
                    <div class="col-4" style="text-align:center;">
                        <div style="color:var(--c-accent);font-size:1.3rem;font-weight:700;"><?= $nbInscrits ?></div>
                        <div style="color:var(--c-muted);font-size:0.72rem;">En attente</div>
                    </div>
                    <div class="col-4" style="text-align:center;">
                        <div style="color:var(--c-red);font-size:1.3rem;font-weight:700;"><?= $nbAnnules ?></div>
                        <div style="color:var(--c-muted);font-size:0.72rem;">Annulés</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mon statut -->
        <?php if ($monInscription): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-user-check"></i> Mon inscription</h5>
            </div>
            <div class="detail-body">
                <div class="mon-statut-block">
                    <i class="fas fa-graduation-cap"></i>
                    <div style="flex:1;">
                        <div style="color:#fff;font-size:0.85rem;font-weight:600;">
                            <?php
                            $labIns = ['inscrit'=>'Inscrit — en attente','valide'=>'Inscription confirmée','annule'=>'Annulée'];
                            echo $labIns[$monInscription['Stt_Ins']] ?? $monInscription['Stt_Ins'];
                            ?>
                        </div>
                        <div style="color:var(--c-muted);font-size:0.73rem;margin-top:2px;">
                            Inscrit le <?= date('d/m/Y', strtotime($monInscription['Dte_Ins'])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-info-circle"></i> Mon statut</h5>
            </div>
            <div class="detail-body">
                <p style="color:var(--c-muted);font-size:0.83rem;margin:0;">
                    Vous n'êtes pas inscrit à cette formation.
                    <?php if ($periode !== 'passe'): ?>
                    <br><br>Pour vous inscrire, soumettez une demande via le module
                    <a href="<?= base_url('demande-formation') ?>" style="color:var(--c-accent);">Demandes de formation</a>.
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>