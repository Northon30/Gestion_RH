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

    .stats-row { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; }
    .stat-pill { background:var(--e-surface); border:1px solid var(--e-border); border-radius:10px; padding:12px 18px; display:flex; align-items:center; gap:12px; flex:1; min-width:130px; }
    .stat-pill-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:0.82rem; flex-shrink:0; }
    .stat-pill-val  { color:#fff; font-size:1.15rem; font-weight:800; line-height:1; }
    .stat-pill-lbl  { color:var(--e-muted); font-size:0.7rem; margin-top:2px; }

    .two-col { display:grid; grid-template-columns:1fr 320px; gap:16px; align-items:start; }

    .card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; }
    .card-header { padding:14px 18px; border-bottom:1px solid var(--e-border); display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
    .card-icon { width:34px; height:34px; border-radius:8px; background:var(--e-primary-pale); border:1px solid var(--e-primary-border); display:flex; align-items:center; justify-content:center; color:var(--e-primary); font-size:0.82rem; flex-shrink:0; }
    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }

    .filter-bar { padding:10px 14px; border-bottom:1px solid var(--e-border); display:flex; gap:8px; flex-wrap:wrap; align-items:flex-end; }
    .filter-group { display:flex; flex-direction:column; gap:4px; }
    .filter-lbl { font-size:0.62rem; font-weight:600; color:var(--e-muted); text-transform:uppercase; letter-spacing:0.5px; }
    .filter-ctrl { background:#111; border:1px solid var(--e-border); border-radius:7px; color:var(--e-text); font-size:0.75rem; padding:6px 9px; outline:none; transition:border-color 0.2s; }
    .filter-ctrl:focus { border-color:var(--e-primary-border); }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.82rem; }
    thead th { padding:10px 14px; font-size:0.7rem; font-weight:600; letter-spacing:0.7px; text-transform:uppercase; color:var(--e-accent); background:var(--e-primary-pale); border-bottom:1px solid var(--e-border); white-space:nowrap; }
    tbody td { padding:11px 14px; color:var(--e-soft); border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:rgba(255,255,255,0.02); }

    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:0.7rem; font-weight:600; border:1px solid; white-space:nowrap; }
    .badge-avenir  { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }
    .badge-passe   { background:rgba(255,255,255,0.05); border-color:var(--e-border); color:var(--e-muted); }
    .badge-inscrit { background:var(--e-blue-pale); border-color:var(--e-blue-border); color:#6ea8fe; }

    .anniv-list { display:flex; flex-direction:column; gap:0; }
    .anniv-item { padding:10px 14px; border-bottom:1px solid rgba(255,255,255,0.03); display:flex; align-items:center; gap:10px; }
    .anniv-item:last-child { border-bottom:none; }
    .anniv-avatar { width:32px; height:32px; border-radius:50%; background:var(--e-primary-pale); border:1px solid var(--e-primary-border); display:flex; align-items:center; justify-content:center; font-size:0.72rem; font-weight:700; color:var(--e-accent); flex-shrink:0; }
    .anniv-avatar.today { background:var(--e-orange-pale); border-color:var(--e-orange-border); color:var(--e-orange); }
    .anniv-name { color:var(--e-text); font-size:0.8rem; font-weight:600; }
    .anniv-sub  { color:var(--e-muted); font-size:0.7rem; margin-top:1px; }

    .btn-green { background:linear-gradient(135deg,var(--e-primary),#4A8A4A); border:none; color:#fff; font-weight:700; border-radius:8px; padding:8px 16px; font-size:0.8rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; }
    .btn-green:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(107,175,107,0.3); color:#fff; }
    .btn-ghost { background:transparent; border:1px solid var(--e-border); color:var(--e-soft); font-weight:600; border-radius:8px; padding:7px 14px; font-size:0.78rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }
    .btn-icon { width:28px; height:28px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center; font-size:0.68rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none; }
    .btn-icon-green { background:var(--e-primary-pale); color:var(--e-primary); border:1px solid var(--e-primary-border); }
    .btn-icon:hover { transform:scale(1.1); }

    .alert-success { background:var(--e-primary-pale); border:1px solid var(--e-primary-border); border-radius:10px; padding:11px 16px; color:var(--e-accent); font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }
    .alert-error   { background:var(--e-red-pale); border:1px solid var(--e-red-border); border-radius:10px; padding:11px 16px; color:var(--e-red); font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }

    .empty-state { padding:40px; text-align:center; color:var(--e-muted); font-size:0.82rem; }
    .empty-state i { font-size:2rem; opacity:0.2; display:block; margin-bottom:10px; }
    .table-footer { padding:10px 14px; border-top:1px solid var(--e-border); font-size:0.73rem; color:var(--e-muted); }

    @media (max-width:900px) { .two-col { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-star me-2" style="color:var(--e-primary);"></i>Événements</h1>
        <p>Événements de l'entreprise et anniversaires du mois</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success"><i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-primary-pale);border:1px solid var(--e-primary-border);"><i class="fas fa-calendar" style="color:var(--e-primary);"></i></div>
        <div><div class="stat-pill-val"><?= $totalEvenements ?></div><div class="stat-pill-lbl">Total</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-blue-pale);border:1px solid var(--e-blue-border);"><i class="fas fa-clock" style="color:#6ea8fe;"></i></div>
        <div><div class="stat-pill-val" style="color:#6ea8fe;"><?= $evtAVenir ?></div><div class="stat-pill-lbl">À venir</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:rgba(255,255,255,0.05);border:1px solid var(--e-border);"><i class="fas fa-history" style="color:var(--e-muted);"></i></div>
        <div><div class="stat-pill-val" style="color:var(--e-muted);"><?= $evtPasses ?></div><div class="stat-pill-lbl">Passés</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-orange-pale);border:1px solid var(--e-orange-border);"><i class="fas fa-birthday-cake" style="color:var(--e-orange);"></i></div>
        <div><div class="stat-pill-val" style="color:var(--e-orange);"><?= $annivAujourdhui ?></div><div class="stat-pill-lbl">Anniv. aujourd'hui</div></div>
    </div>
</div>

<div class="two-col">

    <!-- COL GAUCHE — liste événements -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-calendar"></i></div>
            <p class="card-title">Liste des événements</p>
        </div>

        <div class="filter-bar">
            <div class="filter-group">
                <label class="filter-lbl">Recherche</label>
                <input type="text" id="f-search" class="filter-ctrl"
                       placeholder="Description..." style="width:180px;" oninput="filterRows()">
            </div>
            <div class="filter-group">
                <label class="filter-lbl">Type</label>
                <select id="f-type" class="filter-ctrl" onchange="filterRows()">
                    <option value="">Tous</option>
                    <?php foreach ($typesEvenement as $t): ?>
                    <option value="<?= strtolower(esc($t['Libelle_Tev'])) ?>"><?= esc($t['Libelle_Tev']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-lbl">Période</label>
                <select id="f-periode" class="filter-ctrl" onchange="filterRows()">
                    <option value="">Tous</option>
                    <option value="avenir">À venir</option>
                    <option value="passe">Passés</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-lbl">&nbsp;</label>
                <button type="button" class="btn-ghost" id="btn-reset"
                        style="display:none;" onclick="resetFilters()">
                    <i class="fas fa-times"></i> Réinitialiser
                </button>
            </div>
        </div>

        <?php if (empty($evenements)): ?>
        <div class="empty-state">
            <i class="fas fa-calendar"></i>
            Aucun événement pour le moment.
        </div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Participants</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php foreach ($evenements as $e): ?>
                    <?php
                    $avenir     = $e['Date_Evt'] >= date('Y-m-d');
                    $inscrit    = !empty($e['ma_participation']);
                    ?>
                    <tr data-search="<?= strtolower(esc($e['Description_Evt'])) ?>"
                        data-type="<?= strtolower(esc($e['Libelle_Tev'])) ?>"
                        data-periode="<?= $avenir ? 'avenir' : 'passe' ?>">
                        <td style="font-weight:600;color:var(--e-text);max-width:200px;">
                            <?= esc($e['Description_Evt']) ?>
                            <?php if ($inscrit): ?>
                            <span class="badge badge-inscrit ms-1"><i class="fas fa-check"></i> Inscrit</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge" style="background:var(--e-primary-pale);border-color:var(--e-primary-border);color:var(--e-accent);">
                                <?= esc($e['Libelle_Tev']) ?>
                            </span>
                        </td>
                        <td style="white-space:nowrap;"><?= date('d/m/Y', strtotime($e['Date_Evt'])) ?></td>
                        <td style="color:var(--e-orange);font-weight:700;"><?= $e['nb_participants'] ?></td>
                        <td>
                            <span class="badge badge-<?= $avenir ? 'avenir' : 'passe' ?>">
                                <?= $avenir ? 'À venir' : 'Passé' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('evenement/show/' . $e['id_Evt']) ?>"
                               class="btn-icon btn-icon-green" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="table-footer" id="table-footer"><?= $totalEvenements ?> événement(s)</div>
        <?php endif; ?>
    </div>

    <!-- COL DROITE — anniversaires -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon" style="background:var(--e-orange-pale);border-color:var(--e-orange-border);color:var(--e-orange);">
                <i class="fas fa-birthday-cake"></i>
            </div>
            <p class="card-title">Anniversaires — <?= esc($moisActuel) ?></p>
            <?php if ($annivAujourdhui > 0): ?>
            <span class="badge" style="margin-left:auto;background:var(--e-orange-pale);border-color:var(--e-orange-border);color:var(--e-orange);">
                🎂 <?= $annivAujourdhui ?> aujourd'hui
            </span>
            <?php endif; ?>
        </div>

        <?php if (empty($anniversaires)): ?>
        <div class="empty-state">
            <i class="fas fa-birthday-cake"></i>
            Aucun anniversaire ce mois-ci.
        </div>
        <?php else: ?>
        <div class="anniv-list">
            <?php foreach ($anniversaires as $a): ?>
            <div class="anniv-item">
                <div class="anniv-avatar <?= $a['est_aujourd_hui'] ? 'today' : '' ?>">
                    <?= strtoupper(mb_substr($a['Prenom_Emp'], 0, 1) . mb_substr($a['Nom_Emp'], 0, 1)) ?>
                </div>
                <div style="flex:1;">
                    <div class="anniv-name">
                        <?= esc($a['Prenom_Emp'] . ' ' . $a['Nom_Emp']) ?>
                        <?php if ($a['est_aujourd_hui']): ?>
                        <span style="color:var(--e-orange);font-size:0.72rem;"> 🎂</span>
                        <?php endif; ?>
                    </div>
                    <div class="anniv-sub">
                        <?= date('d', strtotime($a['DateNaissance_Emp'])) ?> <?= esc($moisActuel) ?>
                        · <?= $a['age'] ?> ans
                        <?php if ($a['Nom_Dir']): ?> · <?= esc($a['Nom_Dir']) ?><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var btnReset = document.getElementById('btn-reset');

    window.filterRows = function () {
        var search  = document.getElementById('f-search').value.trim().toLowerCase();
        var type    = document.getElementById('f-type').value.toLowerCase();
        var periode = document.getElementById('f-periode').value;
        btnReset.style.display = (search || type || periode) ? '' : 'none';
        var rows = document.querySelectorAll('#table-body tr');
        var visible = 0;
        rows.forEach(function (row) {
            var match =
                (search  === '' || row.dataset.search.includes(search))  &&
                (type    === '' || row.dataset.type    === type)          &&
                (periode === '' || row.dataset.periode === periode);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        var footer = document.getElementById('table-footer');
        if (footer) footer.textContent = visible + ' événement(s)';
    };

    window.resetFilters = function () {
        document.getElementById('f-search').value  = '';
        document.getElementById('f-type').value    = '';
        document.getElementById('f-periode').value = '';
        filterRows();
    };
})();
</script>
<?= $this->endSection() ?>