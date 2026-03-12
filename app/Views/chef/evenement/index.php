<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58,123,213,0.10);
        --c-primary-border: rgba(58,123,213,0.25);
        --c-accent:         #5B9BF0;
        --c-green-pale:    rgba(74,103,65,0.15);
        --c-green-border:  rgba(74,103,65,0.35);
        --c-red-pale:      rgba(224,82,82,0.10);
        --c-red-border:    rgba(224,82,82,0.25);
        --c-blue-pale:     rgba(58,123,213,0.10);
        --c-blue-border:   rgba(58,123,213,0.25);
        --c-purple-pale:   rgba(155,89,182,0.10);
        --c-purple-border: rgba(155,89,182,0.25);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .stats-row { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; }

    .stat-pill {
        background:var(--c-surface); border:1px solid var(--c-border);
        border-radius:10px; padding:12px 18px;
        display:flex; align-items:center; gap:12px; flex:1; min-width:130px;
    }

    .stat-pill-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        font-size:0.82rem; flex-shrink:0;
    }

    .stat-pill-val { color:#fff; font-size:1.15rem; font-weight:800; line-height:1; }
    .stat-pill-lbl { color:var(--c-muted); font-size:0.7rem; margin-top:2px; }

    .main-grid { display:grid; grid-template-columns:1fr 340px; gap:16px; align-items:start; }

    .card { background:var(--c-surface); border:1px solid var(--c-border); border-radius:14px; overflow:hidden; }

    .card-header {
        padding:14px 18px; border-bottom:1px solid var(--c-border);
        display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
    }

    .card-header-left { display:flex; align-items:center; gap:10px; }

    .card-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-accent); font-size:0.82rem; flex-shrink:0;
    }

    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }

    .card-count {
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border);
        color:var(--c-accent); font-size:0.68rem; font-weight:700;
        padding:2px 9px; border-radius:10px;
    }

    .filter-bar {
        padding:12px 16px; border-bottom:1px solid var(--c-border);
        display:flex; gap:8px; flex-wrap:wrap; align-items:flex-end;
    }

    .filter-group-sm { display:flex; flex-direction:column; gap:4px; }

    .filter-lbl-sm {
        font-size:0.62rem; font-weight:600; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.5px;
    }

    .filter-ctrl-sm {
        background:#111; border:1px solid var(--c-border);
        border-radius:7px; color:var(--c-text); font-size:0.75rem;
        padding:6px 9px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif;
    }

    .filter-ctrl-sm:focus { border-color:var(--c-primary-border); }
    .filter-ctrl-sm option { background:#1a1a1a; }

    .evt-table { width:100%; border-collapse:collapse; font-size:0.8rem; }

    .evt-table thead th {
        padding:8px 14px; font-size:0.65rem; font-weight:700;
        letter-spacing:0.8px; text-transform:uppercase;
        color:var(--c-accent); background:var(--c-primary-pale);
        border-bottom:1px solid var(--c-primary-border);
    }

    .evt-table tbody td {
        padding:10px 14px; color:var(--c-soft);
        border-bottom:1px solid var(--c-border); vertical-align:middle;
    }

    .evt-table tbody tr:last-child td { border-bottom:none; }
    .evt-table tbody tr:hover td { background:rgba(58,123,213,0.02); }

    .badge-type {
        display:inline-flex; align-items:center; gap:4px;
        padding:3px 10px; border-radius:20px; font-size:0.68rem; font-weight:700;
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent);
    }

    .badge-avenir     { background:var(--c-green-pale);  border:1px solid var(--c-green-border);  color:#7ab86a; }
    .badge-passe      { background:rgba(255,255,255,0.05); border:1px solid var(--c-border);       color:var(--c-muted); }
    .badge-aujourd-hui { background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent); }

    .btn-icon {
        width:27px; height:27px; border-radius:6px;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.65rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none;
    }

    .btn-icon-primary { background:var(--c-primary-pale); color:var(--c-accent); border:1px solid var(--c-primary-border); }
    .btn-icon-red     { background:var(--c-red-pale);     color:#ff8080;         border:1px solid var(--c-red-border); }
    .btn-icon:hover   { transform:scale(1.1); }

    .btn-primary {
        background:linear-gradient(135deg, var(--c-primary), #2A5FAA);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:8px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-primary:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(58,123,213,0.35); color:#fff; }

    .btn-ghost {
        background:transparent; border:1px solid var(--c-border);
        color:var(--c-soft); font-weight:600; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--c-text); }

    .btn-danger {
        background:linear-gradient(135deg,#c0392b,#922b21);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }

    .btn-danger:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(192,57,43,0.35); }

    .anniv-list { padding:8px; }

    .anniv-item {
        display:flex; align-items:center; gap:10px;
        padding:9px 12px; border-radius:9px; border:1px solid transparent;
        margin-bottom:4px; transition:all 0.15s;
    }

    .anniv-item:last-child { margin-bottom:0; }

    .anniv-item.today {
        background:var(--c-primary-pale); border-color:var(--c-primary-border);
    }

    .anniv-avatar {
        width:30px; height:30px; border-radius:50%; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        font-size:0.65rem; font-weight:700; text-transform:uppercase;
    }

    .anniv-avatar.today-av {
        background:var(--c-primary-pale); border:2px solid var(--c-primary);
        color:var(--c-accent);
    }

    .anniv-avatar.normal-av {
        background:rgba(255,255,255,0.05); border:1px solid var(--c-border);
        color:var(--c-soft);
    }

    .anniv-name  { color:#fff; font-size:0.8rem; font-weight:600; }
    .anniv-date  { color:var(--c-muted); font-size:0.7rem; }

    .anniv-today-badge {
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border);
        color:var(--c-accent); font-size:0.62rem; font-weight:700;
        padding:1px 7px; border-radius:8px; white-space:nowrap;
    }

    .anniv-empty { padding:24px; text-align:center; color:var(--c-muted); font-size:0.8rem; }
    .anniv-empty i { font-size:1.4rem; opacity:0.2; margin-bottom:8px; display:block; }

    .tabs { display:flex; gap:3px; padding:10px 14px; border-bottom:1px solid var(--c-border); flex-wrap:wrap; }

    .tab-btn {
        padding:5px 14px; border-radius:6px; border:none;
        background:transparent; color:var(--c-muted); font-size:0.75rem;
        font-weight:600; cursor:pointer; transition:all 0.2s;
        display:inline-flex; align-items:center; gap:6px;
    }

    .tab-btn:hover { color:var(--c-soft); background:rgba(255,255,255,0.03); }

    .tab-btn.active {
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border);
        color:var(--c-accent);
    }

    .tab-count {
        background:rgba(255,255,255,0.08); color:var(--c-muted);
        font-size:0.62rem; font-weight:700; padding:1px 6px; border-radius:8px;
    }

    .tab-btn.active .tab-count { background:var(--c-primary-border); color:var(--c-accent); }

    .tab-panel { display:none; }
    .tab-panel.active { display:block; }

    .alert-success-dark {
        background:var(--c-green-pale); border:1px solid var(--c-green-border);
        border-radius:10px; padding:11px 16px; color:#7ab86a;
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    .alert-error-dark {
        background:var(--c-red-pale); border:1px solid var(--c-red-border);
        border-radius:10px; padding:11px 16px; color:#ff8080;
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    .empty-state { padding:36px; text-align:center; color:var(--c-muted); font-size:0.8rem; }
    .empty-state i { font-size:1.6rem; opacity:0.2; margin-bottom:8px; display:block; }

    @media (max-width:960px) { .main-grid { grid-template-columns:1fr; } }
    @media (max-width:560px) { .stats-row { flex-direction:column; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$evtAVenirList  = array_values(array_filter($evenements, fn($e) => $e['Date_Evt'] >= date('Y-m-d')));
$evtPassesList  = array_values(array_filter($evenements, fn($e) => $e['Date_Evt'] < date('Y-m-d')));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-alt me-2" style="color:#3A7BD5;"></i>Événements & Anniversaires</h1>
        <p>Événements internes et anniversaires de votre direction</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark">
    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark">
    <i class="fas fa-exclamation-triangle"></i> <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-primary-pale);border:1px solid var(--c-primary-border);">
            <i class="fas fa-calendar-alt" style="color:var(--c-accent);"></i>
        </div>
        <div>
            <div class="stat-pill-val"><?= $totalEvenements ?></div>
            <div class="stat-pill-lbl">Événements</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-green-pale);border:1px solid var(--c-green-border);">
            <i class="fas fa-calendar-check" style="color:#7ab86a;"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:#7ab86a;"><?= $evtAVenir ?></div>
            <div class="stat-pill-lbl">À venir</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:rgba(255,255,255,0.04);border:1px solid var(--c-border);">
            <i class="fas fa-history" style="color:var(--c-soft);"></i>
        </div>
        <div>
            <div class="stat-pill-val"><?= $evtPasses ?></div>
            <div class="stat-pill-lbl">Passés</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-primary-pale);border:1px solid var(--c-primary-border);">
            <i class="fas fa-users" style="color:var(--c-accent);"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:var(--c-accent);"><?= $totalParticipants ?></div>
            <div class="stat-pill-lbl">Participations</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-purple-pale);border:1px solid var(--c-purple-border);">
            <i class="fas fa-birthday-cake" style="color:#c39bd3;"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:#c39bd3;"><?= $totalAnniv ?></div>
            <div class="stat-pill-lbl">Anniv. <?= esc($moisActuel) ?></div>
        </div>
    </div>
    <?php if ($annivAujourdhui > 0): ?>
    <div class="stat-pill" style="border-color:var(--c-primary-border);background:var(--c-primary-pale);">
        <div class="stat-pill-icon" style="background:var(--c-primary-pale);border:1px solid var(--c-primary-border);">
            <i class="fas fa-gift" style="color:var(--c-accent);"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:var(--c-accent);"><?= $annivAujourdhui ?></div>
            <div class="stat-pill-lbl">Anniv. aujourd'hui</div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Grille principale -->
<div class="main-grid">

    <!-- COL GAUCHE — Événements -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon"><i class="fas fa-calendar-alt"></i></div>
                <p class="card-title">Liste des événements</p>
            </div>
            <span class="card-count" id="evt-count"><?= $totalEvenements ?></span>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('tous', this)">
                <i class="fas fa-list"></i> Tous
                <span class="tab-count"><?= $totalEvenements ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('avenir', this)">
                <i class="fas fa-calendar-check"></i> À venir
                <span class="tab-count"><?= $evtAVenir ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('passes', this)">
                <i class="fas fa-history"></i> Passés
                <span class="tab-count"><?= $evtPasses ?></span>
            </button>
        </div>

        <div class="filter-bar">
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">Recherche</label>
                <input type="text" id="f-search" class="filter-ctrl-sm"
                       placeholder="Description..." style="width:180px;">
            </div>
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">Type</label>
                <select id="f-type" class="filter-ctrl-sm">
                    <option value="">Tous</option>
                    <?php foreach ($typesEvenement as $t): ?>
                    <option value="<?= $t['id_Tev'] ?>"><?= esc($t['Libelle_Tev']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">Date de</label>
                <input type="date" id="f-date-from" class="filter-ctrl-sm">
            </div>
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">Date à</label>
                <input type="date" id="f-date-to" class="filter-ctrl-sm">
            </div>
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">&nbsp;</label>
                <button type="button" class="btn-danger" id="btn-reset"
                        style="display:none;" onclick="resetFilters()">
                    <i class="fas fa-times"></i> Réinitialiser
                </button>
            </div>
        </div>

        <?php if (empty($evenements)): ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            Aucun événement enregistré.
        </div>
        <?php else: ?>

        <?php
        $groupes = [
            'tous'   => $evenements,
            'avenir' => $evtAVenirList,
            'passes' => $evtPassesList,
        ];

        foreach ($groupes as $groupe => $rows):
        ?>
        <div class="tab-panel <?= $groupe === 'tous' ? 'active' : '' ?>" id="panel-<?= $groupe ?>">
            <?php if (empty($rows)): ?>
            <div class="empty-state"><i class="fas fa-calendar"></i> Aucun événement dans cette catégorie.</div>
            <?php else: ?>
            <table class="evt-table" id="table-<?= $groupe ?>">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th style="text-align:center;">Participants</th>
                        <th style="text-align:center;">Ma participation</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $evt):
                        $date   = $evt['Date_Evt'];
                        $today  = date('Y-m-d');
                        $statut = $date > $today ? 'avenir' : ($date === $today ? 'aujourd_hui' : 'passe');
                        $maParticipation = $evt['ma_participation'] ?? null;
                    ?>
                    <tr class="evt-row"
                        data-desc="<?= strtolower(esc($evt['Description_Evt'])) ?>"
                        data-type="<?= $evt['id_Tev'] ?>"
                        data-date="<?= $evt['Date_Evt'] ?>">
                        <td>
                            <a href="<?= base_url('evenement/show/' . $evt['id_Evt']) ?>"
                               style="color:#fff;font-weight:600;text-decoration:none;font-size:0.82rem;">
                                <?= esc($evt['Description_Evt']) ?>
                            </a>
                        </td>
                        <td>
                            <span class="badge-type"><?= esc($evt['Libelle_Tev'] ?? '-') ?></span>
                        </td>
                        <td>
                            <span style="font-size:0.78rem;
                                color:<?= $statut === 'avenir' ? '#7ab86a' : ($statut === 'aujourd_hui' ? 'var(--c-accent)' : 'var(--c-muted)') ?>;">
                                <?= date('d/m/Y', strtotime($evt['Date_Evt'])) ?>
                            </span>
                            <?php if ($statut === 'aujourd_hui'): ?>
                            <span class="badge-aujourd-hui" style="font-size:0.6rem;margin-left:4px;">Aujourd'hui</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <span class="card-count"><?= (int)$evt['nb_participants'] ?></span>
                        </td>
                        <td style="text-align:center;">
                            <?php if ($maParticipation): ?>
                            <span style="color:#7ab86a;font-size:0.72rem;font-weight:600;">
                                <i class="fas fa-check-circle"></i> Inscrit
                            </span>
                            <?php else: ?>
                            <span style="color:var(--c-muted);font-size:0.72rem;">—</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:inline-flex;gap:5px;">
                                <a href="<?= base_url('evenement/show/' . $evt['id_Evt']) ?>"
                                   class="btn-icon btn-icon-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="empty-state" id="no-match-<?= $groupe ?>" style="display:none;">
                <i class="fas fa-search"></i> Aucun événement ne correspond aux filtres.
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <?php endif; ?>
    </div>

    <!-- COL DROITE — Anniversaires du mois -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon" style="background:var(--c-purple-pale);border-color:var(--c-purple-border);">
                    <i class="fas fa-birthday-cake" style="color:#c39bd3;"></i>
                </div>
                <p class="card-title">Anniversaires — <?= esc($moisActuel) ?></p>
            </div>
            <span class="card-count"><?= $totalAnniv ?></span>
        </div>

        <?php if (empty($anniversaires)): ?>
        <div class="anniv-empty">
            <i class="fas fa-birthday-cake"></i>
            Aucun anniversaire ce mois-ci dans votre direction.
        </div>
        <?php else: ?>
        <div class="anniv-list">
            <?php foreach ($anniversaires as $a): ?>
            <div class="anniv-item <?= $a['est_aujourd_hui'] ? 'today' : '' ?>">
                <div class="anniv-avatar <?= $a['est_aujourd_hui'] ? 'today-av' : 'normal-av' ?>">
                    <?= mb_substr($a['Nom_Emp'], 0, 1) . mb_substr($a['Prenom_Emp'], 0, 1) ?>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="anniv-name">
                        <?= esc($a['Prenom_Emp'] . ' ' . $a['Nom_Emp']) ?>
                    </div>
                    <div class="anniv-date">
                        <?= date('d/m', mktime(0,0,0,$a['mois_naissance'],$a['jour_naissance'])) ?>
                        · <?= (int)$a['age'] ?> ans
                    </div>
                </div>
                <?php if ($a['est_aujourd_hui']): ?>
                <span class="anniv-today-badge">🎂 Aujourd'hui</span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

</div><!-- /.main-grid -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    window.switchTab = function (panel, btn) {
        document.querySelectorAll('.tab-panel').forEach(function (p) { p.classList.remove('active'); });
        document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
        document.getElementById('panel-' + panel).classList.add('active');
        btn.classList.add('active');
        applyFilters();
    };

    var filterIds = ['f-search', 'f-type', 'f-date-from', 'f-date-to'];
    var btnReset  = document.getElementById('btn-reset');

    function getActivePanel() {
        var active = document.querySelector('.tab-panel.active');
        return active ? active.id.replace('panel-', '') : 'tous';
    }

    function applyFilters() {
        var search   = document.getElementById('f-search').value.trim().toLowerCase();
        var type     = document.getElementById('f-type').value;
        var dateFrom = document.getElementById('f-date-from').value;
        var dateTo   = document.getElementById('f-date-to').value;

        var actifs = [search, type, dateFrom, dateTo].filter(function (v) { return v !== ''; }).length;
        btnReset.style.display = actifs > 0 ? '' : 'none';

        var panel = getActivePanel();
        var rows  = document.querySelectorAll('#panel-' + panel + ' .evt-row');
        var nb    = 0;

        rows.forEach(function (row) {
            var match =
                (search   === '' || row.dataset.desc.includes(search)) &&
                (type     === '' || row.dataset.type === type) &&
                (dateFrom === '' || row.dataset.date >= dateFrom) &&
                (dateTo   === '' || row.dataset.date <= dateTo);

            row.style.display = match ? '' : 'none';
            if (match) nb++;
        });

        var noMatch = document.getElementById('no-match-' + panel);
        if (noMatch) noMatch.style.display = nb === 0 && rows.length > 0 ? 'block' : 'none';
        document.getElementById('evt-count').textContent = nb;
    }

    window.resetFilters = function () {
        filterIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });
        applyFilters();
    };

    filterIds.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input',  applyFilters);
            el.addEventListener('change', applyFilters);
        }
    });

})();
</script>
<?= $this->endSection() ?>