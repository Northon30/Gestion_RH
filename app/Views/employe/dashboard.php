<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
    --e-primary:       #6BAF6B;
    --e-primary-pale:  rgba(107, 175, 107, 0.12);
    --e-primary-border: rgba(107, 175, 107, 0.25);
    --e-dark:          #2A3D2A;
    --e-accent:        #8FCC8F;
    --e-red:           #ff6b7a;
    --e-orange:        #F5A623;
    --e-muted:         rgba(255,255,255,0.35);
    --e-soft:          rgba(255,255,255,0.6);
}

.stat-card {
    background: #1a1a1a;
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
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

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.4);
    border-color: var(--e-primary-border);
}

.stat-card:hover::after  { opacity: 1; }
.stat-card.c-green::after  { background: linear-gradient(90deg, var(--e-primary), transparent); }
.stat-card.c-orange::after { background: linear-gradient(90deg, var(--e-orange), transparent); }
.stat-card.c-red::after    { background: linear-gradient(90deg, #dc3545, transparent); }
.stat-card.c-purple::after { background: linear-gradient(90deg, #6f42c1, transparent); }

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}

.stat-icon.green  { background: var(--e-primary-pale); color: var(--e-accent); }
.stat-icon.orange { background: rgba(245,166,35,0.12);  color: var(--e-orange); }
.stat-icon.red    { background: rgba(220,53,69,0.12);   color: var(--e-red); }
.stat-icon.purple { background: rgba(111,66,193,0.12);  color: #c29ffa; }

.stat-info { flex: 1; min-width: 0; }

.stat-number {
    color: #fff;
    font-size: 1.9rem;
    font-weight: 800;
    line-height: 1;
}

.stat-label {
    color: var(--e-muted);
    font-size: 0.75rem;
    margin-top: 4px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
}

.stat-sub {
    font-size: 0.72rem;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.stat-sub.up    { color: var(--e-accent); }
.stat-sub.down  { color: var(--e-red); }
.stat-sub.muted { color: var(--e-muted); }

.section-block {
    background: #1a1a1a;
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 12px;
    overflow: hidden;
}

.section-head {
    padding: 15px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.section-head h6 {
    color: #fff;
    font-size: 0.88rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-head h6 i { color: var(--e-primary); }
.section-head .sh-right { color: var(--e-muted); font-size: 0.75rem; }

.dash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.83rem;
}

.dash-table thead th {
    padding: 10px 16px;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    color: var(--e-accent);
    background: var(--e-primary-pale);
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.dash-table tbody td {
    padding: 11px 16px;
    color: var(--e-soft);
    border-bottom: 1px solid rgba(255,255,255,0.03);
    vertical-align: middle;
}

.dash-table tbody tr:last-child td { border-bottom: none; }
.dash-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

.badge-green {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: var(--e-primary-pale);
    border: 1px solid var(--e-primary-border);
    color: var(--e-accent);
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 500;
    white-space: nowrap;
}

.bday-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.03);
    transition: background 0.2s;
}

.bday-row:last-child { border-bottom: none; }
.bday-row:hover { background: rgba(255,255,255,0.02); }

.bday-av {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--e-primary-pale);
    border: 1px solid var(--e-primary-border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-accent);
    font-size: 0.75rem;
    flex-shrink: 0;
}

.bday-name {
    color: var(--e-soft);
    font-size: 0.83rem;
    font-weight: 500;
    margin: 0;
}

.bday-date {
    color: var(--e-muted);
    font-size: 0.73rem;
    margin-top: 1px;
}

.empty-box {
    padding: 28px 20px;
    text-align: center;
    color: var(--e-muted);
    font-size: 0.82rem;
}

.empty-box i {
    font-size: 1.5rem;
    display: block;
    margin-bottom: 8px;
    opacity: 0.4;
}

.solde-block {
    background: #1f1f1f;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 10px;
    padding: 16px;
    text-align: center;
}

.solde-block .solde-val {
    font-size: 2rem;
    font-weight: 800;
    color: var(--e-primary);
    line-height: 1;
}

.solde-block .solde-label {
    color: var(--e-muted);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-top: 5px;
}

.solde-block .solde-sub {
    color: rgba(255,255,255,0.2);
    font-size: 0.72rem;
    margin-top: 3px;
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
    vertical-align: middle;
}

.status-dot.en_attente { background: var(--e-orange); }
.status-dot.approuve   { background: var(--e-accent); }
.status-dot.rejete     { background: var(--e-red); }
.status-dot.valide_rh  { background: #6ea8fe; }
.status-dot.rejete_rh  { background: var(--e-red); }
.status-dot.inscrit    { background: var(--e-primary); }
.status-dot.valide     { background: var(--e-accent); }
.status-dot.annule     { background: var(--e-red); }

.btn-green {
    background: linear-gradient(135deg, var(--e-primary), #4A8A4A);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 5px 12px;
    font-size: 0.75rem;
    transition: all 0.25s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-green:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(107,175,107,0.3);
    color: #fff;
}

.btn-outline-green {
    background: transparent;
    border: 1px solid var(--e-primary-border);
    color: var(--e-accent);
    font-weight: 600;
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 0.75rem;
    transition: all 0.25s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-outline-green:hover {
    background: var(--e-primary-pale);
    color: var(--e-accent);
}

.competence-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--e-primary-pale);
    border: 1px solid var(--e-primary-border);
    color: var(--e-accent);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    margin: 3px;
}

.competence-tag .niveau {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 1px 6px;
    font-size: 0.68rem;
    color: var(--e-muted);
}

.formation-item {
    padding: 12px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.03);
    transition: background 0.2s;
}

.formation-item:last-child { border-bottom: none; }
.formation-item:hover { background: rgba(255,255,255,0.02); }

.formation-title {
    color: var(--e-soft);
    font-size: 0.83rem;
    font-weight: 500;
    margin-bottom: 4px;
}

.formation-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.formation-meta span {
    color: var(--e-muted);
    font-size: 0.73rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.formation-meta span i { font-size: 0.68rem; }

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 768px) {

    .col-xl-3 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .stat-card {
        padding: 14px;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .dash-table {
        font-size: 0.75rem;
    }

    .dash-table thead th,
    .dash-table tbody td {
        padding: 8px 10px;
    }

    .formation-meta {
        gap: 6px;
    }
}

</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-home me-2" style="color:var(--e-primary, #6BAF6B);"></i>Mon Espace</h1>
        <p>Bienvenue <?= esc(session()->get('prenom') . ' ' . session()->get('nom')) ?> &mdash; <?= date('d/m/Y') ?></p>
    </div>
    <div>
        <span class="badge-gray">
            <i class="fas fa-clock me-1"></i>
            <span id="live-time"><?= date('H:i') ?></span>
        </span>
    </div>
</div>

<!-- Stats personnelles -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-green">
            <div class="stat-icon green"><i class="fas fa-umbrella-beach"></i></div>
            <div class="stat-info">
                <?php $restant = ($monSolde['NbJoursDroit_Sld'] ?? 30) - ($monSolde['NbJoursPris_Sld'] ?? 0); ?>
                <div class="stat-number" id="cnt-solde">0</div>
                <div class="stat-label">Jours de congé restants</div>
                <div class="stat-sub muted">
                    <i class="fas fa-circle" style="font-size:0.45rem;"></i>
                    <?= (int) ($monSolde['NbJoursPris_Sld'] ?? 0) ?> pris sur <?= (int) ($monSolde['NbJoursDroit_Sld'] ?? 30) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-orange">
            <div class="stat-icon orange"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-cge">0</div>
                <div class="stat-label">Demandes de congé</div>
                <div class="stat-sub muted"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Total</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-red">
            <div class="stat-icon red"><i class="fas fa-user-clock"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-abs">0</div>
                <div class="stat-label">Absences déclarées</div>
                <div class="stat-sub muted"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Total</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card c-purple">
            <div class="stat-icon purple"><i class="fas fa-graduation-cap"></i></div>
            <div class="stat-info">
                <div class="stat-number" id="cnt-frm">0</div>
                <div class="stat-label">Formations suivies</div>
                <div class="stat-sub up"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Inscriptions</div>
            </div>
        </div>
    </div>
</div>

<!-- Congés + Absences -->
<div class="row g-3 mb-4">

    <div class="col-xl-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-calendar-check"></i> Mes demandes de congé</h6>
                <a href="<?= base_url('conge/create') ?>" class="btn-green">
                    <i class="fas fa-plus"></i> Nouvelle demande
                </a>
            </div>
            <?php if (!empty($mesConges)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mesConges as $mc): ?>
                    <tr>
                        <td><span class="badge-green"><?= esc($mc['Libelle_Tcg']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($mc['DateDebut_Cge'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($mc['DateFin_Cge'])) ?></td>
                        <td>
                            <span class="status-dot <?= $mc['Statut_Cge'] ?>"></span>
                            <?php
                            $labCge = ['en_attente' => 'En attente', 'approuve' => 'Approuvé', 'rejete' => 'Rejeté'];
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
                Aucune demande de congé
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-user-clock"></i> Mes absences déclarées</h6>
                <a href="<?= base_url('absence/create') ?>" class="btn-outline-green">
                    Déclarer
                </a>
            </div>
            <?php if (!empty($mesAbsences)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mesAbsences as $ma): ?>
                    <tr>
                        <td><span class="badge-gray"><?= esc($ma['Libelle_TAbs']) ?></span></td>
                        <td><?= date('d/m/Y', strtotime($ma['DateDebut_Abs'])) ?></td>
                        <td><?= $ma['DateFin_Abs'] ? date('d/m/Y', strtotime($ma['DateFin_Abs'])) : '—' ?></td>
                        <td>
                            <span class="status-dot <?= $ma['Statut_Abs'] ?>"></span>
                            <?php
                            $labAbs = [
                                'en_attente' => 'En attente',
                                'valide_rh'  => 'Validé RH',
                                'rejete_rh'  => 'Rejeté',
                                'approuve'   => 'Approuvé',
                                'rejete'     => 'Rejeté',
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
                Aucune absence déclarée
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Formations + Compétences + Anniversaires -->
<div class="row g-3">

    <div class="col-xl-4">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-graduation-cap"></i> Mes formations</h6>
                <a href="<?= base_url('formation') ?>" class="sh-right" style="text-decoration:none;color:var(--e-primary);">
                    Voir tout
                </a>
            </div>
            <?php if (!empty($mesFormations)): ?>
                <?php foreach ($mesFormations as $mf): ?>
                <div class="formation-item">
                    <div class="formation-title"><?= esc($mf['Titre_Frm']) ?></div>
                    <div class="formation-meta">
                        <span><i class="fas fa-calendar"></i><?= date('d/m/Y', strtotime($mf['DateDebut_Frm'])) ?></span>
                        <span><i class="fas fa-map-marker-alt"></i><?= esc($mf['Lieu_Frm']) ?></span>
                        <span>
                            <span class="status-dot <?= $mf['Stt_Ins'] ?>"></span>
                            <?php
                            $labIns = ['inscrit' => 'Inscrit', 'valide' => 'Validé', 'annule' => 'Annulé'];
                            echo $labIns[$mf['Stt_Ins']] ?? $mf['Stt_Ins'];
                            ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="empty-box">
                <i class="fas fa-graduation-cap"></i>
                Aucune formation suivie
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="section-block">
            <div class="section-head">
                <h6><i class="fas fa-star"></i> Mes compétences</h6>
                <span class="sh-right"><?= count($mesCompetences) ?> compétence(s)</span>
            </div>
            <?php if (!empty($mesCompetences)): ?>
            <div style="padding:16px;">
                <?php foreach ($mesCompetences as $mc): ?>
                <span class="competence-tag">
                    <i class="fas fa-check-circle" style="font-size:0.65rem;"></i>
                    <?= esc($mc['Libelle_Cmp']) ?>
                    <span class="niveau"><?= esc($mc['Niveau_Obt']) ?></span>
                </span>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="empty-box">
                <i class="fas fa-star"></i>
                Aucune compétence enregistrée
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
                    <span class="badge-green"><i class="fas fa-gift"></i></span>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="empty-box">
                <i class="fas fa-calendar-times"></i>
                Aucun anniversaire ce mois
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

    animateCounter('cnt-solde', <?= (int) $restant ?>);
    animateCounter('cnt-cge',   <?= (int) count($mesConges) ?>);
    animateCounter('cnt-abs',   <?= (int) count($mesAbsences) ?>);
    animateCounter('cnt-frm',   <?= (int) count($mesFormations) ?>);

    setInterval(function() {
        const el = document.getElementById('live-time');
        if (!el) return;
        const now = new Date();
        el.textContent = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
    }, 1000);
</script>
<?= $this->endSection() ?>