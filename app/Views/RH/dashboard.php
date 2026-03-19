<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    /* Empêcher le scroll horizontal global */
    .page-content { overflow-x: hidden; }

    .stat-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.4); border-color: rgba(245,166,35,0.2); }
    .stat-card:hover::after { opacity: 1; }
    .stat-card.c-orange::after { background: linear-gradient(90deg, #F5A623, transparent); }
    .stat-card.c-green::after  { background: linear-gradient(90deg, #4A6741, transparent); }
    .stat-card.c-red::after    { background: linear-gradient(90deg, #dc3545, transparent); }
    .stat-card.c-blue::after   { background: linear-gradient(90deg, #0d6efd, transparent); }
    .stat-card.c-purple::after { background: linear-gradient(90deg, #6f42c1, transparent); }

    .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0; }
    .stat-icon.orange { background: rgba(245,166,35,0.12); color: #F5A623; }
    .stat-icon.green  { background: rgba(74,103,65,0.2);   color: #90c97f; }
    .stat-icon.red    { background: rgba(220,53,69,0.12);  color: #ff6b7a; }
    .stat-icon.blue   { background: rgba(13,110,253,0.12); color: #6ea8fe; }
    .stat-icon.purple { background: rgba(111,66,193,0.12); color: #c29ffa; }

    .stat-info { flex: 1; min-width: 0; }
    .stat-number { color: #fff; font-size: 1.9rem; font-weight: 800; line-height: 1; }
    .stat-label  { color: rgba(255,255,255,0.45); font-size: 0.75rem; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.6px; }
    .stat-sub    { font-size: 0.72rem; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
    .stat-sub.up    { color: #90c97f; }
    .stat-sub.down  { color: #ff6b7a; }
    .stat-sub.muted { color: rgba(255,255,255,0.3); }

    .section-block { background: #1a1a1a; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; overflow: hidden; }
    .section-head  { padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; }
    .section-head h6 { color: #fff; font-size: 0.88rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 8px; }
    .section-head h6 i { color: #F5A623; }
    .section-head .sh-right { color: rgba(255,255,255,0.35); font-size: 0.75rem; }

    .direction-tile { background: #1f1f1f; border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 15px; transition: transform 0.2s ease, border-color 0.2s ease; }
    .direction-tile:hover { transform: translateY(-2px); border-color: rgba(245,166,35,0.18); }
    .dir-top  { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
    .dir-icon { width: 38px; height: 38px; background: rgba(74,103,65,0.2); border: 1px solid rgba(74,103,65,0.25); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #90c97f; font-size: 0.85rem; flex-shrink: 0; }
    .dir-name  { color: rgba(255,255,255,0.75); font-size: 0.8rem; font-weight: 500; line-height: 1.3; }
    .dir-count { color: #F5A623; font-size: 1.35rem; font-weight: 800; line-height: 1; }
    .dir-count small { color: rgba(255,255,255,0.3); font-size: 0.7rem; font-weight: 400; margin-left: 2px; }
    .pct-row   { display: flex; justify-content: space-between; margin-bottom: 5px; }
    .pct-row span { font-size: 0.72rem; color: rgba(255,255,255,0.35); }
    .pct-row .val { color: #F5A623; font-weight: 600; }
    .prog-track { background: rgba(255,255,255,0.05); border-radius: 10px; height: 4px; }
    .prog-fill  { height: 4px; border-radius: 10px; background: linear-gradient(90deg, #F5A623, #d4891a); }

    .dash-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
    .dash-table thead th { padding: 10px 16px; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.7px; text-transform: uppercase; color: rgba(245,166,35,0.8); background: rgba(245,166,35,0.06); border-bottom: 1px solid rgba(255,255,255,0.05); }
    .dash-table tbody td { padding: 11px 16px; color: rgba(255,255,255,0.65); border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
    .dash-table tbody tr:last-child td { border-bottom: none; }
    .dash-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .emp-cell { display: flex; align-items: center; gap: 9px; }
    .emp-av   { width: 28px; height: 28px; border-radius: 50%; background: rgba(245,166,35,0.12); border: 1px solid rgba(245,166,35,0.2); display: flex; align-items: center; justify-content: center; color: #F5A623; font-size: 0.7rem; flex-shrink: 0; }

    .bday-row { display: flex; align-items: center; gap: 12px; padding: 11px 20px; border-bottom: 1px solid rgba(255,255,255,0.03); transition: background 0.2s; }
    .bday-row:last-child { border-bottom: none; }
    .bday-row:hover { background: rgba(255,255,255,0.02); }
    .bday-av   { width: 34px; height: 34px; border-radius: 50%; background: rgba(245,166,35,0.12); border: 1px solid rgba(245,166,35,0.2); display: flex; align-items: center; justify-content: center; color: #F5A623; font-size: 0.75rem; flex-shrink: 0; }
    .bday-name { color: rgba(255,255,255,0.75); font-size: 0.83rem; font-weight: 500; margin: 0; }
    .bday-date { color: rgba(255,255,255,0.35); font-size: 0.73rem; margin-top: 1px; }

    .alert-item { background: rgba(220,53,69,0.07); border: 1px solid rgba(220,53,69,0.2); border-radius: 10px; padding: 13px 15px; display: flex; align-items: center; gap: 12px; margin-bottom: 10px; animation: pulse-alert 2.5s ease-in-out infinite; }
    .alert-item:last-child { margin-bottom: 0; }
    @keyframes pulse-alert {
        0%,100% { border-color: rgba(220,53,69,0.2); }
        50%      { border-color: rgba(220,53,69,0.45); box-shadow: 0 0 10px rgba(220,53,69,0.1); }
    }
    .alert-ic  { width: 34px; height: 34px; border-radius: 8px; background: rgba(220,53,69,0.15); display: flex; align-items: center; justify-content: center; color: #ff6b7a; font-size: 0.82rem; flex-shrink: 0; }
    .alert-txt p     { color: #ff6b7a; font-size: 0.82rem; font-weight: 600; margin: 0; }
    .alert-txt small { color: rgba(255,100,100,0.45); font-size: 0.72rem; }

    .empty-box { padding: 28px 20px; text-align: center; color: rgba(255,255,255,0.25); font-size: 0.82rem; }
    .empty-box i { font-size: 1.5rem; display: block; margin-bottom: 8px; opacity: 0.4; }

    .chart-wrap { padding: 20px; }
    .chart-wrap canvas { max-height: 220px; }

    .my-space-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 14px; display: flex; align-items: center; gap: 10px; }
    .my-space-label::before { content: ''; width: 24px; height: 1px; background: rgba(245,166,35,0.4); }
    .my-space-label::after  { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.04); }

    .solde-block { background: #1f1f1f; border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 16px; text-align: center; }
    .solde-block .solde-val   { font-size: 2rem; font-weight: 800; color: #F5A623; line-height: 1; }
    .solde-block .solde-label { color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 5px; }
    .solde-block .solde-sub   { color: rgba(255,255,255,0.2); font-size: 0.72rem; margin-top: 3px; }

    .status-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 5px; vertical-align: middle; }
    .status-dot.en_attente    { background: #F5A623; }
    .status-dot.approuve_chef { background: #6ea8fe; }
    .status-dot.rejete_chef   { background: #ff6b7a; }
    .status-dot.valide_rh     { background: #90c97f; }
    .status-dot.rejete_rh     { background: #ff6b7a; }

    .nav-tabs-dark .nav-link {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.45);
        border-radius: 8px 8px 0 0;
        font-size: 0.8rem;
        padding: 6px 14px;
        margin-right: 4px;
    }
    .nav-tabs-dark .nav-link.active {
        background: rgba(245,166,35,0.1);
        border-color: rgba(245,166,35,0.3);
        color: #F5A623;
        font-weight: 600;
    }
    .tab-content-dark { border: 1px solid rgba(255,255,255,0.05); border-radius: 0 8px 8px 8px; }

    .page-content { overflow-x: hidden; }
    .container-fluid, .row { max-width: 100%; }

    @media (max-width: 991px) {
        .stat-icon   { width: 40px; height: 40px; font-size: 1rem; }
        .stat-number { font-size: 1.5rem; }
        .stat-label  { font-size: 0.7rem; }
        .stat-sub    { display: none; }
        .stat-card   { padding: 13px 10px; gap: 8px; }
    }

    @media (max-width: 575px) {
        .stat-icon   { width: 34px; height: 34px; font-size: 0.88rem; border-radius: 9px; }
        .stat-number { font-size: 1.2rem; }
        .stat-label  { font-size: 0.62rem; letter-spacing: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .stat-sub    { display: none; }
        .stat-card   { padding: 10px 8px; gap: 7px; border-radius: 10px; }
        .page-header h1 { font-size: 1.1rem; }
        .page-header p  { font-size: 0.75rem; }
        .direction-tile  { padding: 10px; }
        .dir-icon        { width: 30px; height: 30px; font-size: 0.75rem; }
        .dir-name        { font-size: 0.72rem; }
        .dir-count       { font-size: 1.1rem; }
        .pct-row span    { font-size: 0.65rem; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chart-line me-2" style="color:#F5A623;"></i>Dashboard</h1>
        <p>Bienvenue <?= esc(session()->get('prenom') . ' ' . session()->get('nom')) ?> &mdash; <?= date('d/m/Y') ?></p>
    </div>
    <div>
        <span class="badge-orange">
            <i class="fas fa-clock me-1"></i>
            <span id="live-time"><?= date('H:i') ?></span>
        </span>
    </div>
</div>

<!-- ══════════════════════════ STATS GLOBALES ══════════════════════════ -->
<div class="row g-2 mb-4">
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card c-orange">
            <div class="stat-icon orange"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-emp">0</div>
                <div class="stat-label">Employés</div>
                <div class="stat-sub up"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Effectif total</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card c-green">
            <div class="stat-icon green"><i class="fas fa-building"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-dir">0</div>
                <div class="stat-label">Directions</div>
                <div class="stat-sub muted"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Actives</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card c-red">
            <div class="stat-icon red"><i class="fas fa-calendar-times"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-cge">0</div>
                <div class="stat-label">Congés à valider</div>
                <div class="stat-sub down"><i class="fas fa-clock" style="font-size:0.6rem;"></i> Approuvés Chef</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card c-blue">
            <div class="stat-icon blue"><i class="fas fa-user-clock"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-abs">0</div>
                <div class="stat-label">Absences à valider</div>
                <div class="stat-sub muted"><i class="fas fa-clock" style="font-size:0.6rem;"></i> Approuvées Chef</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card c-purple">
            <div class="stat-icon purple"><i class="fas fa-graduation-cap"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-frm">0</div>
                <div class="stat-label">Formations à venir</div>
                <div class="stat-sub up"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Planifiées</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card c-orange">
            <div class="stat-icon orange"><i class="fas fa-birthday-cake"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-bday">0</div>
                <div class="stat-label">Anniversaires</div>
                <div class="stat-sub muted"><i class="fas fa-calendar" style="font-size:0.6rem;"></i> Ce mois</div>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════ EFFECTIFS ══════════════════════════ -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-building"></i> Effectifs par Direction</h6>
                <span class="sh-right">Total : <?= (int) $totalEmployes ?> employé(s)</span>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <?php foreach ($effectifParDirection as $dir):
                        $pct = $totalEmployes > 0 ? round(($dir['nb_employes'] / $totalEmployes) * 100) : 0;
                    ?>
                    <div class="col-xl-3 col-md-4 col-sm-6 col-6">
                        <div class="direction-tile">
                            <div class="dir-top">
                                <div class="dir-icon"><i class="fas fa-building"></i></div>
                                <div>
                                    <div class="dir-name"><?= esc($dir['Nom_Dir']) ?></div>
                                    <div class="dir-count"><?= (int) $dir['nb_employes'] ?> <small>emp.</small></div>
                                </div>
                            </div>
                            <div class="pct-row">
                                <span>Représentation</span>
                                <span class="val"><?= $pct ?>%</span>
                            </div>
                            <div class="prog-track">
                                <div class="prog-fill" style="width:<?= $pct ?>%;"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════ GRAPHIQUES ══════════════════════════ -->
<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-star"></i> Compétences par Direction</h6>
                <span class="sh-right">Répartition</span>
            </div>
            <div class="chart-wrap">
                <canvas id="chart-competences"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-graduation-cap"></i> Participation aux Formations</h6>
                <span class="sh-right">Inscrits par formation</span>
            </div>
            <div class="chart-wrap">
                <canvas id="chart-formations"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════ CONGÉS + ABSENCES ══════════════════════════ -->
<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-calendar-alt"></i> Congés</h6>
                <a href="<?= base_url('conge') ?>" class="btn-outline-orange" style="padding:4px 12px;font-size:0.75rem;">Voir tout</a>
            </div>
            <div class="p-3 pb-0">
                <ul class="nav nav-tabs-dark mb-0" id="tabConge">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-valider">
                            À valider
                            <?php if (!empty($congesAValider)): ?>
                            <span class="badge-red ms-1" style="font-size:0.65rem;padding:2px 6px;"><?= count($congesAValider) ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-attente">
                            En attente Chef
                            <?php if (!empty($congesEnAttente)): ?>
                            <span class="badge-orange ms-1" style="font-size:0.65rem;padding:2px 6px;"><?= count($congesEnAttente) ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content tab-content-dark">
                <div class="tab-pane fade show active" id="tab-valider">
                    <?php if (!empty($congesAValider)): ?>
                    <table class="dash-table">
                        <thead><tr><th>Employé</th><th>Direction</th><th>Période</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php foreach (array_slice($congesAValider, 0, 5) as $c): ?>
                            <tr>
                                <td>
                                    <div class="emp-cell">
                                        <div class="emp-av"><i class="fas fa-user"></i></div>
                                        <?= esc($c['Nom_Emp'] . ' ' . $c['Prenom_Emp']) ?>
                                    </div>
                                </td>
                                <td><span class="badge-gray"><?= esc($c['Nom_Dir'] ?? '-') ?></span></td>
                                <td style="font-size:0.78rem;">
                                    <?= date('d/m/Y', strtotime($c['DateDebut_Cge'])) ?> →
                                    <?= date('d/m/Y', strtotime($c['DateFin_Cge'])) ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('conge/show/' . $c['id_Cge']) ?>" class="btn-orange" style="padding:3px 10px;font-size:0.72rem;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="empty-box"><i class="fas fa-check-circle" style="color:#90c97f;opacity:1;"></i>Aucun congé à valider</div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="tab-attente">
                    <?php if (!empty($congesEnAttente)): ?>
                    <table class="dash-table">
                        <thead><tr><th>Employé</th><th>Direction</th><th>Type</th><th>Début</th></tr></thead>
                        <tbody>
                            <?php foreach (array_slice($congesEnAttente, 0, 5) as $c): ?>
                            <tr>
                                <td>
                                    <div class="emp-cell">
                                        <div class="emp-av"><i class="fas fa-user"></i></div>
                                        <?= esc($c['Nom_Emp'] . ' ' . $c['Prenom_Emp']) ?>
                                    </div>
                                </td>
                                <td><span class="badge-gray"><?= esc($c['Nom_Dir'] ?? '-') ?></span></td>
                                <td><span class="badge-orange"><?= esc($c['Libelle_Tcg']) ?></span></td>
                                <td><?= date('d/m/Y', strtotime($c['DateDebut_Cge'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="empty-box"><i class="fas fa-clock"></i>Aucun congé en attente Chef</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-user-clock"></i> Absences à valider</h6>
                <a href="<?= base_url('absence') ?>" class="btn-outline-orange" style="padding:4px 12px;font-size:0.75rem;">Voir tout</a>
            </div>
            <?php if (!empty($absencesAValider)): ?>
            <table class="dash-table">
                <thead><tr><th>Employé</th><th>Direction</th><th>Type</th><th>Début</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach (array_slice($absencesAValider, 0, 5) as $a): ?>
                    <tr>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-av"><i class="fas fa-user"></i></div>
                                <?= esc($a['Nom_Emp'] . ' ' . $a['Prenom_Emp']) ?>
                            </div>
                        </td>
                        <td><span class="badge-gray"><?= esc($a['Nom_Dir'] ?? '-') ?></span></td>
                        <td><span class="badge-orange"><?= esc($a['Libelle_TAbs']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($a['DateDebut_Abs'])) ?></td>
                        <td>
                            <a href="<?= base_url('absence/show/' . $a['id_Abs']) ?>" class="btn-orange" style="padding:3px 10px;font-size:0.72rem;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-box"><i class="fas fa-check-circle" style="color:#90c97f;opacity:1;"></i>Aucune absence à valider</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ══════════════════════════ FORMATIONS + ANNIVERSAIRES + ALERTES ══════════════════════════ -->
<div class="row g-3 mb-4">

    <!-- Formations à venir -->
    <div class="col-xl-5">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-graduation-cap"></i> Formations à venir</h6>
                <a href="<?= base_url('formation') ?>" class="btn-outline-orange" style="padding:4px 12px;font-size:0.75rem;">Voir tout</a>
            </div>
            <?php if (!empty($formationsAVenir)): ?>
            <table class="dash-table">
                <thead><tr><th>Titre</th><th>Début</th><th>Fin</th><th>Inscrits</th></tr></thead>
                <tbody>
                    <?php foreach (array_slice($formationsAVenir, 0, 5) as $f): ?>
                    <tr>
                        <td style="color:rgba(255,255,255,0.8);font-weight:500;">
                            <a href="<?= base_url('formation/show/'.$f['id_Frm']) ?>"
                               style="color:rgba(255,255,255,0.8);text-decoration:none;">
                                <?= esc(mb_strlen($f['Titre_Frm']) > 30 ? mb_substr($f['Titre_Frm'],0,30).'…' : $f['Titre_Frm']) ?>
                            </a>
                        </td>
                        <td><?= date('d/m/Y', strtotime($f['DateDebut_Frm'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($f['DateFin_Frm'])) ?></td>
                        <td>
                            <span class="badge-orange"><?= (int)($f['nb_valides'] ?? 0) ?> / <?= (int)$f['Capacite_Frm'] ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-box"><i class="fas fa-graduation-cap"></i>Aucune formation à venir</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Anniversaires -->
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
                    <?php if (!empty($emp['est_aujourd_hui'])): ?>
                    <span class="badge-orange"><i class="fas fa-gift"></i> Aujourd'hui !</span>
                    <?php else: ?>
                    <span class="badge-orange"><i class="fas fa-gift"></i></span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="empty-box"><i class="fas fa-calendar-times"></i>Aucun anniversaire ce mois</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Alertes -->
    <div class="col-xl-3">
        <div class="section-block">
            <div class="section-head"><h6><i class="fas fa-bell"></i> Alertes</h6></div>
            <div class="p-3">
                <?php
                $hasAlerts = !empty($congesAValider)
                          || !empty($absencesAValider)
                          || !empty($formationsAVenir)
                          || !empty($anniversaires);
                ?>
                <?php if ($hasAlerts): ?>
                    <?php if (!empty($congesAValider)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-calendar-alt"></i></div>
                        <div class="alert-txt">
                            <p><?= count($congesAValider) ?> congé(s) à valider</p>
                            <small>Approuvés par le Chef</small>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($absencesAValider)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-user-clock"></i></div>
                        <div class="alert-txt">
                            <p><?= count($absencesAValider) ?> absence(s) à valider</p>
                            <small>Approuvées par le Chef</small>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($formationsAVenir)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-graduation-cap"></i></div>
                        <div class="alert-txt">
                            <p><?= count($formationsAVenir) ?> formation(s) à venir</p>
                            <small>Planifiées</small>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($anniversaires)): ?>
                    <div class="alert-item">
                        <div class="alert-ic"><i class="fas fa-birthday-cake"></i></div>
                        <div class="alert-txt">
                            <p><?= count($anniversaires) ?> anniversaire(s)</p>
                            <small>Ce mois de <?= date('F') ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                <div class="empty-box"><i class="fas fa-check-circle" style="color:#90c97f;opacity:1;"></i>Aucune alerte active</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- ══════════════════════════ MON ESPACE PERSONNEL ══════════════════════════ -->
<div class="my-space-label">Mon espace personnel</div>

<div class="row g-3">

    <div class="col-xl-3 col-md-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-umbrella-beach"></i> Mon solde congés</h6>
                <span class="sh-right"><?= date('Y') ?></span>
            </div>
            <div class="p-3">
                <?php
                $droit   = (int) ($monSolde['NbJoursDroit_Sld'] ?? 30);
                $pris    = (int) ($monSolde['NbJoursPris_Sld']  ?? 0);
                $restant = $droit - $pris;
                $pctPris = $droit > 0 ? round(($pris / $droit) * 100) : 0;
                ?>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="solde-block">
                            <div class="solde-val"><?= $droit ?></div>
                            <div class="solde-label">Acquis</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="solde-block">
                            <div class="solde-val" style="color:#ff6b7a;"><?= $pris ?></div>
                            <div class="solde-label">Pris</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="solde-block">
                            <div class="solde-val" style="color:#90c97f;"><?= $restant ?></div>
                            <div class="solde-label">Restants</div>
                            <div class="solde-sub">
                                <div class="prog-track mt-2">
                                    <div class="prog-fill" style="width:<?= $pctPris ?>%;background:linear-gradient(90deg,#ff6b7a,#dc3545);"></div>
                                </div>
                                <?= $pctPris ?>% utilisé
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <a href="<?= base_url('conge/create') ?>" class="btn-orange w-100" style="padding:7px;font-size:0.78rem;display:block;border-radius:8px;text-align:center;text-decoration:none;">
                        <i class="fas fa-plus me-1"></i> Nouvelle demande
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-md-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-calendar-check"></i> Mes demandes de congé</h6>
            </div>
            <?php if (!empty($mesConges)): ?>
            <table class="dash-table">
                <thead><tr><th>Type</th><th>Début</th><th>Fin</th><th>Statut</th></tr></thead>
                <tbody>
                    <?php
                    $labCge = [
                        'en_attente'    => 'En attente',
                        'approuve_chef' => 'Approuvé Chef',
                        'rejete_chef'   => 'Refusé Chef',
                        'valide_rh'     => 'Validé RH',
                        'rejete_rh'     => 'Rejeté RH',
                    ];
                    foreach (array_slice($mesConges, 0, 5) as $mc):
                    ?>
                    <tr>
                        <td><span class="badge-orange"><?= esc($mc['Libelle_Tcg']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($mc['DateDebut_Cge'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($mc['DateFin_Cge'])) ?></td>
                        <td>
                            <span class="status-dot <?= $mc['Statut_Cge'] ?>"></span>
                            <?= $labCge[$mc['Statut_Cge']] ?? $mc['Statut_Cge'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-box"><i class="fas fa-calendar-plus"></i>Aucune demande de congé</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-user-clock"></i> Mes absences récentes</h6>
                <a href="<?= base_url('absence/create') ?>" class="btn-outline-orange" style="padding:4px 12px;font-size:0.75rem;">Déclarer</a>
            </div>
            <?php if (!empty($mesAbsences)): ?>
            <table class="dash-table">
                <thead><tr><th>Type</th><th>Début</th><th>Statut</th></tr></thead>
                <tbody>
                    <?php
                    $labAbs = [
                        'en_attente'    => 'En attente',
                        'approuve_chef' => 'Approuvé Chef',
                        'rejete_chef'   => 'Refusé Chef',
                        'valide_rh'     => 'Validé RH',
                        'rejete_rh'     => 'Rejeté RH',
                    ];
                    foreach (array_slice($mesAbsences, 0, 5) as $ma):
                    ?>
                    <tr>
                        <td><span class="badge-gray"><?= esc($ma['Libelle_TAbs']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($ma['DateDebut_Abs'])) ?></td>
                        <td>
                            <span class="status-dot <?= $ma['Statut_Abs'] ?>"></span>
                            <?= $labAbs[$ma['Statut_Abs']] ?? $ma['Statut_Abs'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-box"><i class="fas fa-user-check"></i>Aucune absence déclarée</div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function animateCounter(id, target) {
    const el = document.getElementById(id);
    if (!el || !target) return;
    let current = 0;
    const step  = target / (1400 / 16);
    const timer = setInterval(function() {
        current += step;
        if (current >= target) { el.textContent = target; clearInterval(timer); }
        else el.textContent = Math.floor(current);
    }, 16);
}

animateCounter('cnt-emp',  <?= (int) $totalEmployes ?>);
animateCounter('cnt-dir',  <?= (int) count($effectifParDirection) ?>);
animateCounter('cnt-cge',  <?= (int) count($congesAValider) ?>);
animateCounter('cnt-abs',  <?= (int) count($absencesAValider) ?>);
animateCounter('cnt-frm',  <?= (int) count($formationsAVenir) ?>);
animateCounter('cnt-bday', <?= (int) count($anniversaires) ?>);

setInterval(function() {
    const el  = document.getElementById('live-time');
    if (!el) return;
    const now = new Date();
    el.textContent = String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
}, 1000);

const orange  = '#F5A623';
const green   = '#4A6741';
const softW   = 'rgba(255,255,255,0.5)';
const gridCol = 'rgba(255,255,255,0.05)';
const baseScale = {
    x: { ticks: { color: softW, font: { size: 10 } }, grid: { color: gridCol } },
    y: { ticks: { color: softW, font: { size: 10 } }, grid: { color: gridCol }, beginAtZero: true }
};

new Chart(document.getElementById('chart-competences'), {
    type: 'bar',
    data: {
        labels:   <?= json_encode(array_column($competencesParDirection, 'Nom_Dir')) ?>,
        datasets: [{ data: <?= json_encode(array_column($competencesParDirection, 'nb_competences')) ?>, backgroundColor: orange, borderRadius: 6, borderSkipped: false }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: baseScale }
});

new Chart(document.getElementById('chart-formations'), {
    type: 'bar',
    data: {
        labels:   <?= json_encode(array_column($participationFormations, 'titre_court')) ?>,
        datasets: [{ data: <?= json_encode(array_column($participationFormations, 'nb_inscrits')) ?>, backgroundColor: green, borderRadius: 6, borderSkipped: false }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: baseScale }
});
</script>
<?= $this->endSection() ?>