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

    .detail-grid { display:grid; grid-template-columns:1fr 300px; gap:16px; align-items:start; }

    .card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; }
    .card-header { padding:14px 18px; border-bottom:1px solid var(--e-border); display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
    .card-icon { width:34px; height:34px; border-radius:8px; background:var(--e-primary-pale); border:1px solid var(--e-primary-border); display:flex; align-items:center; justify-content:center; color:var(--e-primary); font-size:0.82rem; flex-shrink:0; }
    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }

    .info-block { padding:18px; display:flex; flex-direction:column; gap:14px; }
    .two-col-info { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .info-item { display:flex; flex-direction:column; gap:3px; }
    .info-label { font-size:0.67rem; color:var(--e-muted); text-transform:uppercase; letter-spacing:0.6px; font-weight:600; }
    .info-value { color:var(--e-text); font-size:0.83rem; }

    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; border:1px solid; }
    .badge-avenir { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }
    .badge-passe  { background:rgba(255,255,255,0.05); border-color:var(--e-border); color:var(--e-muted); }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.82rem; }
    thead th { padding:10px 14px; font-size:0.7rem; font-weight:600; letter-spacing:0.7px; text-transform:uppercase; color:var(--e-accent); background:var(--e-primary-pale); border-bottom:1px solid var(--e-border); white-space:nowrap; }
    tbody td { padding:11px 14px; color:var(--e-soft); border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }

    .empty-state { padding:30px; text-align:center; color:var(--e-muted); font-size:0.82rem; }
    .empty-state i { font-size:1.5rem; opacity:0.2; display:block; margin-bottom:8px; }

    .action-card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; }
    .action-body { padding:18px; display:flex; flex-direction:column; gap:12px; }

    .btn-green  { background:linear-gradient(135deg,var(--e-primary),#4A8A4A); border:none; color:#fff; font-weight:700; border-radius:8px; padding:10px 18px; font-size:0.82rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; width:100%; justify-content:center; }
    .btn-green:hover  { transform:translateY(-1px); box-shadow:0 5px 16px rgba(107,175,107,0.3); color:#fff; }
    .btn-danger { background:linear-gradient(135deg,#c0392b,#922b21); border:none; color:#fff; font-weight:700; border-radius:8px; padding:10px 18px; font-size:0.82rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; width:100%; justify-content:center; }
    .btn-danger:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(192,57,43,0.35); }
    .btn-ghost  { background:transparent; border:1px solid var(--e-border); color:var(--e-soft); font-weight:600; border-radius:8px; padding:8px 16px; font-size:0.8rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; }
    .btn-ghost:hover  { background:rgba(255,255,255,0.04); color:var(--e-text); }

    .alert-success { background:var(--e-primary-pale); border:1px solid var(--e-primary-border); border-radius:10px; padding:11px 16px; color:var(--e-accent); font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }
    .alert-error   { background:var(--e-red-pale); border:1px solid var(--e-red-border); border-radius:10px; padding:11px 16px; color:var(--e-red); font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }

    .table-footer { padding:10px 14px; border-top:1px solid var(--e-border); font-size:0.73rem; color:var(--e-muted); }

    .participation-banner {
        margin:14px; padding:12px 16px; border-radius:10px;
        background:var(--e-blue-pale); border:1px solid var(--e-blue-border);
        color:#6ea8fe; font-size:0.82rem; display:flex; align-items:center; gap:10px;
    }

    @media (max-width:900px) { .detail-grid { grid-template-columns:1fr; } .two-col-info { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $avenir = $evenement['Date_Evt'] >= date('Y-m-d'); ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-star me-2" style="color:var(--e-primary);"></i>Détail événement</h1>
        <p><?= esc($evenement['Description_Evt']) ?></p>
    </div>
    <a href="<?= base_url('evenement') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
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

        <!-- Infos -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-info-circle"></i></div>
                <p class="card-title">Informations</p>
                <span class="badge badge-<?= $avenir ? 'avenir' : 'passe' ?>" style="margin-left:auto;">
                    <?= $avenir ? 'À venir' : 'Passé' ?>
                </span>
            </div>
            <div class="info-block">
                <div class="info-item">
                    <span class="info-label">Description</span>
                    <span class="info-value" style="font-size:0.9rem;font-weight:600;"><?= esc($evenement['Description_Evt']) ?></span>
                </div>
                <div class="two-col-info">
                    <div class="info-item">
                        <span class="info-label">Type</span>
                        <span class="info-value"><?= esc($evenement['Libelle_Tev']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date</span>
                        <span class="info-value" style="color:var(--e-orange);font-weight:700;">
                            <?= date('d/m/Y', strtotime($evenement['Date_Evt'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <p class="card-title">Participants</p>
                <span style="margin-left:auto;color:var(--e-orange);font-weight:700;font-size:0.82rem;">
                    <?= count($participants) ?> inscrit(s)
                </span>
            </div>

            <?php if (!empty($maParticipation)): ?>
            <div class="participation-banner">
                <i class="fas fa-check-circle"></i>
                Vous êtes inscrit à cet événement.
            </div>
            <?php endif; ?>

            <?php if (empty($participants)): ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                Aucun participant pour le moment.
            </div>
            <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Direction</th>
                            <th>Date inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $p): ?>
                        <tr>
                            <td style="font-weight:600;color:var(--e-text);">
                                <?= esc($p['Prenom_Emp'] . ' ' . $p['Nom_Emp']) ?>
                                <?php if ($p['id_Emp'] == $idEmp): ?>
                                <span class="badge" style="background:var(--e-blue-pale);border-color:var(--e-blue-border);color:#6ea8fe;font-size:0.65rem;margin-left:4px;">Vous</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($p['Nom_Dir'] ?? '—') ?></td>
                            <td><?= $p['Dte_Sig'] ? date('d/m/Y', strtotime($p['Dte_Sig'])) : '—' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer"><?= count($participants) ?> participant(s)</div>
            <?php endif; ?>
        </div>

    </div>

    <!-- COL DROITE — Actions -->
    <div class="action-card">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-bolt"></i></div>
            <p class="card-title">Actions</p>
        </div>
        <div class="action-body">

            <?php if ($avenir): ?>
                <?php if (empty($maParticipation)): ?>
                <!-- Pas encore inscrit → bouton participer -->
                <form method="POST" action="<?= base_url('evenement/participer/' . $evenement['id_Evt']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-green">
                        <i class="fas fa-user-plus"></i> Participer
                    </button>
                </form>
                <?php else: ?>
                <!-- Déjà inscrit → bouton se retirer -->
                <form method="POST" action="<?= base_url('evenement/se-retirer/' . $evenement['id_Evt']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-user-minus"></i> Se retirer
                    </button>
                </form>
                <?php endif; ?>
            <?php else: ?>
                <div style="text-align:center;color:var(--e-muted);font-size:0.78rem;padding:8px;">
                    <i class="fas fa-lock" style="display:block;margin-bottom:6px;opacity:0.3;"></i>
                    Événement passé — participation fermée.
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<?= $this->endSection() ?>