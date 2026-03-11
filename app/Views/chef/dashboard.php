<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58, 123, 213, 0.12);
        --c-primary-border: rgba(58, 123, 213, 0.25);
        --c-accent:         #5B9BF0;
        --c-green:          #90c97f;
        --c-red:            #ff6b7a;
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.6);
    }

    .stat-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        opacity: 0;
        transition: opacity 0.25s;
    }

    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.4); border-color: var(--c-primary-border); }
    .stat-card:hover::after { opacity: 1; }
    .stat-card.c-blue::after   { background: linear-gradient(90deg, var(--c-primary), transparent); }
    .stat-card.c-green::after  { background: linear-gradient(90deg, #2D6A4F, transparent); }
    .stat-card.c-red::after    { background: linear-gradient(90deg, #dc3545, transparent); }
    .stat-card.c-purple::after { background: linear-gradient(90deg, #6f42c1, transparent); }

    .stat-icon {
        width: 50px; height: 50px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem; flex-shrink: 0;
    }

    .stat-icon.blue   { background: var(--c-primary-pale); color: var(--c-accent); }
    .stat-icon.green  { background: rgba(45,106,79,0.2);   color: var(--c-green); }
    .stat-icon.red    { background: rgba(220,53,69,0.12);  color: var(--c-red); }
    .stat-icon.purple { background: rgba(111,66,193,0.12); color: #c29ffa; }

    .stat-info { flex: 1; min-width: 0; }
    .stat-number { color: #fff; font-size: 1.9rem; font-weight: 800; line-height: 1; }
    .stat-label  { color: var(--c-muted); font-size: 0.75rem; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.6px; }
    .stat-sub    { font-size: 0.72rem; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
    .stat-sub.up    { color: var(--c-green); }
    .stat-sub.down  { color: var(--c-red); }
    .stat-sub.muted { color: var(--c-muted); }

    .section-block {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        overflow: hidden;
    }

    .section-head {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex; align-items: center; justify-content: space-between;
    }

    .section-head h6 {
        color: #fff; font-size: 0.88rem; font-weight: 600; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }

    .section-head h6 i { color: var(--c-primary); }
    .section-head .sh-right { color: var(--c-muted); font-size: 0.75rem; }

    .dash-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }

    .dash-table thead th {
        padding: 10px 16px;
        font-size: 0.72rem; font-weight: 600; letter-spacing: 0.7px; text-transform: uppercase;
        color: var(--c-accent);
        background: var(--c-primary-pale);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .dash-table tbody td {
        padding: 11px 16px;
        color: var(--c-soft);
        border-bottom: 1px solid rgba(255,255,255,0.03);
        vertical-align: middle;
    }

    .dash-table tbody tr:last-child td { border-bottom: none; }
    .dash-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .emp-cell { display: flex; align-items: center; gap: 9px; }

    .emp-av {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-accent); font-size: 0.7rem; flex-shrink: 0;
    }

    .badge-blue {
        display: inline-flex; align-items: center; gap: 4px;
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        color: var(--c-accent);
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 500; white-space: nowrap;
    }

    .bday-row {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        transition: background 0.2s;
    }

    .bday-row:last-child { border-bottom: none; }
    .bday-row:hover { background: rgba(255,255,255,0.02); }

    .bday-av {
        width: 34px; height: 34px; border-radius: 50%;
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-accent); font-size: 0.75rem; flex-shrink: 0;
    }

    .bday-name  { color: var(--c-soft); font-size: 0.83rem; font-weight: 500; margin: 0; }
    .bday-date  { color: var(--c-muted); font-size: 0.73rem; margin-top: 1px; }

    .alert-item {
        background: rgba(220,53,69,0.07);
        border: 1px solid rgba(220,53,69,0.2);
        border-radius: 10px; padding: 13px 15px;
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 10px;
        animation: pulse-alert 2.5s ease-in-out infinite;
    }

    .alert-item:last-child { margin-bottom: 0; }

    @keyframes pulse-alert {
        0%, 100% { border-color: rgba(220,53,69,0.2); }
        50%       { border-color: rgba(220,53,69,0.45); box-shadow: 0 0 10px rgba(220,53,69,0.1); }
    }

    .alert-ic {
        width: 34px; height: 34px; border-radius: 8px;
        background: rgba(220,53,69,0.15);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-red); font-size: 0.82rem; flex-shrink: 0;
    }

    .alert-txt p     { color: var(--c-red); font-size: 0.82rem; font-weight: 600; margin: 0; }
    .alert-txt small { color: rgba(255,100,100,0.45); font-size: 0.72rem; }

    .empty-box { padding: 28px 20px; text-align: center; color: var(--c-muted); font-size: 0.82rem; }
    .empty-box i { font-size: 1.5rem; display: block; margin-bottom: 8px; opacity: 0.4; }

    .my-space-label {
        font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: var(--c-muted);
        margin-bottom: 14px;
        display: flex; align-items: center; gap: 10px;
    }

    .my-space-label::before { content: ''; width: 24px; height: 1px; background: var(--c-primary); opacity: 0.5; }
    .my-space-label::after  { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.04); }

    .solde-block {
        background: #1f1f1f;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 10px; padding: 16px; text-align: center;
    }

    .solde-block .solde-val   { font-size: 2rem; font-weight: 800; color: var(--c-primary); line-height: 1; }
    .solde-block .solde-label { color: var(--c-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 5px; }
    .solde-block .solde-sub   { color: rgba(255,255,255,0.2); font-size: 0.72rem; margin-top: 3px; }

    .status-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 5px; vertical-align: middle; }
    .status-dot.en_attente { background: #F5A623; }
    .status-dot.approuve   { background: var(--c-green); }
    .status-dot.rejete     { background: var(--c-red); }
    .status-dot.valide_rh  { background: var(--c-accent); }
    .status-dot.rejete_rh  { background: var(--c-red); }

    .link-see-all {
        font-size: 0.78rem; color: var(--c-primary); text-decoration: none;
        font-weight: 500; opacity: 0.85; transition: opacity 0.2s;
        display: inline-flex; align-items: center; gap: 4px;
    }

    .link-see-all:hover { opacity: 1; color: var(--c-accent); }

    .btn-blue {
        background: linear-gradient(135deg, var(--c-primary), #2A5FAA);
        border: none; color: #fff; font-weight: 600; border-radius: 8px;
        padding: 5px 12px; font-size: 0.75rem; transition: all 0.25s;
        display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
    }

    .btn-blue:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(58,123,213,0.3); color: #fff; }

    .btn-outline-blue {
        background: transparent;
        border: 1px solid var(--c-primary-border);
        color: var(--c-accent); font-weight: 600; border-radius: 8px;
        padding: 4px 12px; font-size: 0.75rem; transition: all 0.25s;
        display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
    }

    .btn-outline-blue:hover { background: var(--c-primary-pale); color: var(--c-accent); }

    .dir-info-block {
        background: linear-gradient(135deg, #1A2E4A 0%, #0f1f36 100%);
        border: 1px solid var(--c-primary-border);
        border-radius: 12px; padding: 20px;
        display: flex; align-items: center; gap: 16px;
    }

    .dir-info-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-accent); font-size: 1.3rem; flex-shrink: 0;
    }

    .dir-info-name  { color: #fff; font-size: 1rem; font-weight: 700; margin-bottom: 2px; }
    .dir-info-sub   { color: var(--c-muted); font-size: 0.78rem; }

    .dir-info-count { margin-left: auto; text-align: right; }
    .dir-info-count .count-val   { color: var(--c-accent); font-size: 2rem; font-weight: 800; line-height: 1; }
    .dir-info-count .count-label { color: var(--c-muted); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.6px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chart-line me-2" style="color:#3A7BD5;"></i>Dashboard</h1>
        <p>Bienvenue <?= esc(session()->get('prenom') . ' ' . session()->get('nom')) ?> &mdash; <?= date('d/m/Y') ?></p>
    </div>
    <div>
        <span class="badge-gray">
            <i class="fas fa-clock me-1"></i>
            <span id="live-time"><?= date('H:i') ?></span>
        </span>
    </div>
</div>

<div class="mb-4">
    <div class="dir-info-block">
        <div class="dir-info-icon"><i class="fas fa-building"></i></div>
        <div>
            <div class="dir-info-name"><?= esc($nomDirection) ?></div>
            <div class="dir-info-sub">Vous gerez cette direction</div>
        </div>
        <div class="dir-info-count">
            <div class="count-val" id="cnt-eff">0</div>
            <div class="count-label">Employe(s)</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-blue">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-emp2">0</div>
                <div class="stat-label">Effectif direction</div>
                <div class="stat-sub muted"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Ma direction</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-red">
            <div class="stat-icon red"><i class="fas fa-calendar-times"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-cge">0</div>
                <div class="stat-label">Conges en attente</div>
                <div class="stat-sub down"><i class="fas fa-clock" style="font-size:0.6rem;"></i> A valider</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-green">
            <div class="stat-icon green"><i class="fas fa-user-clock"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-abs">0</div>
                <div class="stat-label">Absences en cours</div>
                <div class="stat-sub muted"><i class="fas fa-clock" style="font-size:0.6rem;"></i> En cours</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-purple">
            <div class="stat-icon purple"><i class="fas fa-graduation-cap"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-frm">0</div>
                <div class="stat-label">Formations a venir</div>
                <div class="stat-sub up"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Planifiees</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">

    <div class="col-xl-5">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-calendar-alt"></i> Conges en attente</h6>
                <a href="<?= base_url('conge') ?>" class="link-see-all">
                    Voir tout <i class="fas fa-arrow-right" style="font-size:0.6rem;"></i>
                </a>
            </div>
            <?php if (!empty($congesEnAttente)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Employe</th>
                        <th>Type</th>
                        <th>Debut</th>
                        <th>Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($congesEnAttente as $c): ?>
                    <tr>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-av"><i class="fas fa-user"></i></div>
                                <?= esc($c['Nom_Emp'] . ' ' . $c['Prenom_Emp']) ?>
                            </div>
                        </td>
                        <td><span class="badge-blue"><?= esc($c['Libelle_Tcg']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($c['DateDebut_Cge'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($c['DateFin_Cge'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-box">
                <i class="fas fa-check-circle" style="color:#90c97f;opacity:1;"></i>
                Aucun conge en attente dans votre direction
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-birthday-cake"></i> Anniversaires du mois</h6>
                <span class="sh-right"><?= date('F Y') ?></span>
            </div>
            <?php if (!empty($anniversaires)): ?>
                <?php foreach ($anniversaires as $emp): ?>
                <div class="bday-row">
                    <div class="bday-av"><i class="fas fa-user"></i></div>
                    <div style="flex:1;">
                        <p class="bday-name"><?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?></p>
                        <div class="bday-date">
                            <i class="fas fa-calendar-day" style="margin-right:4px;"></i>
                            <?= date('d/m', strtotime($emp['DateNaissance_Emp'])) ?>
                        </div>
                    </div>
                    <span class="badge-blue"><i class="fas fa-gift"></i></span>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="empty-box">
                <i class="fas fa-calendar-times"></i>
                Aucun anniversaire ce mois dans votre direction
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-bell"></i> Alertes direction</h6>
            </div>
            <div class="p-3">
                <?php $hasAlerts = !empty($congesEnAttente) || !empty($absencesEnCours) || !empty($formationsAVenir) || !empty($anniversaires); ?>
                <?php if ($hasAlerts): ?>
                    <?php if (!empty($congesEnAttente)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-calendar-alt"></i></div>
                        <div class="alert-txt">
                            <p><?= count($congesEnAttente) ?> conge(s) en attente</p>
                            <small>Dans votre direction</small>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($absencesEnCours)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-user-clock"></i></div>
                        <div class="alert-txt">
                            <p><?= count($absencesEnCours) ?> absence(s) en cours</p>
                            <small>Dans votre direction</small>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($formationsAVenir)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-graduation-cap"></i></div>
                        <div class="alert-txt">
                            <p><?= count($formationsAVenir) ?> formation(s) a venir</p>
                            <small>Planifiees</small>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($anniversaires)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-birthday-cake"></i></div>
                        <div class="alert-txt">
                            <p><?= count($anniversaires) ?> anniversaire(s)</p>
                            <small>Ce mois dans votre direction</small>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                <div class="empty-box">
                    <i class="fas fa-check-circle" style="color:#90c97f;opacity:1;"></i>
                    Aucune alerte active
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<div class="my-space-label">Mon espace personnel</div>

<div class="row g-3">

    <div class="col-xl-3 col-md-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-umbrella-beach"></i> Mon solde conges</h6>
                <span class="sh-right"><?= date('Y') ?></span>
            </div>
            <div class="p-3">
                <div class="row g-2">
                    <div class="col-6">
                        <div class="solde-block">
                            <div class="solde-val"><?= (int) ($monSolde['NbJoursDroit_Sld'] ?? 30) ?></div>
                            <div class="solde-label">Acquis</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="solde-block">
                            <div class="solde-val" style="color:#ff6b7a;"><?= (int) ($monSolde['NbJoursPris_Sld'] ?? 0) ?></div>
                            <div class="solde-label">Pris</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <?php $restant = ($monSolde['NbJoursDroit_Sld'] ?? 30) - ($monSolde['NbJoursPris_Sld'] ?? 0); ?>
                        <div class="solde-block">
                            <div class="solde-val" style="color:#90c97f;"><?= (int) $restant ?></div>
                            <div class="solde-label">Restants</div>
                            <div class="solde-sub">Solde <?= date('Y') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-md-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-calendar-check"></i> Mes demandes de conge</h6>
                <a href="<?= base_url('conge/create') ?>" class="btn-blue">
                    <i class="fas fa-plus"></i> Nouvelle demande
                </a>
            </div>
            <?php if (!empty($mesConges)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Debut</th>
                        <th>Fin</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($mesConges, 0, 5) as $mc): ?>
                    <tr>
                        <td><span class="badge-blue"><?= esc($mc['Libelle_Tcg']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($mc['DateDebut_Cge'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($mc['DateFin_Cge'])) ?></td>
                        <td>
                            <span class="status-dot <?= $mc['Statut_Cge'] ?>"></span>
                            <?php
                            $labCge = ['en_attente' => 'En attente', 'approuve' => 'Approuve', 'rejete' => 'Rejete'];
                            echo $labCge[$mc['Statut_Cge']] ?? $mc['Statut_Cge'];
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-box">
                <i class="fas fa-calendar-plus"></i>
                Aucune demande de conge
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-user-clock"></i> Mes absences recentes</h6>
                <a href="<?= base_url('absence/create') ?>" class="btn-outline-blue">Declarer</a>
            </div>
            <?php if (!empty($mesAbsences)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Debut</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($mesAbsences, 0, 5) as $ma): ?>
                    <tr>
                        <td><span class="badge-gray"><?= esc($ma['Libelle_TAbs']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($ma['DateDebut_Abs'])) ?></td>
                        <td>
                            <span class="status-dot <?= $ma['Statut_Abs'] ?>"></span>
                            <?php
                            $labAbs = [
                                'en_attente' => 'En attente',
                                'valide_rh'  => 'Valide RH',
                                'rejete_rh'  => 'Rejete',
                                'approuve'   => 'Approuve',
                                'rejete'     => 'Rejete',
                            ];
                            echo $labAbs[$ma['Statut_Abs']] ?? $ma['Statut_Abs'];
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-box">
                <i class="fas fa-user-check"></i>
                Aucune absence declaree
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    function animateCounter(id, target) {
        const el = document.getElementById(id);
        if (!el || !target) return;
        let current = 0;
        const step = target / (1400 / 16);
        const timer = setInterval(function() {
            current += step;
            if (current >= target) {
                el.textContent = target;
                clearInterval(timer);
            } else {
                el.textContent = Math.floor(current);
            }
        }, 16);
    }

    animateCounter('cnt-eff',  <?= (int) $effectifDirection ?>);
    animateCounter('cnt-emp2', <?= (int) $effectifDirection ?>);
    animateCounter('cnt-cge',  <?= (int) count($congesEnAttente) ?>);
    animateCounter('cnt-abs',  <?= (int) count($absencesEnCours) ?>);
    animateCounter('cnt-frm',  <?= (int) count($formationsAVenir) ?>);

    setInterval(function() {
        const el = document.getElementById('live-time');
        if (!el) return;
        const now = new Date();
        el.textContent = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
    }, 1000);
</script>
<?= $this->endSection() ?>