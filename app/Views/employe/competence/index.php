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
        --e-blue-pale:      rgba(110,168,254,0.10);
        --e-blue-border:    rgba(110,168,254,0.25);
        --e-red:            #ff6b7a;
        --e-red-pale:       rgba(255,107,122,0.10);
        --e-red-border:     rgba(255,107,122,0.25);
        --e-surface:        #1a1a1a;
        --e-border:         rgba(255,255,255,0.06);
        --e-text:           rgba(255,255,255,0.85);
        --e-muted:          rgba(255,255,255,0.35);
        --e-soft:           rgba(255,255,255,0.55);
    }

    .stats-row { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; }
    .stat-pill {
        background:var(--e-surface); border:1px solid var(--e-border);
        border-radius:10px; padding:12px 18px;
        display:flex; align-items:center; gap:12px; flex:1; min-width:130px;
    }
    .stat-pill-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:0.82rem; flex-shrink:0; }
    .stat-pill-val  { color:#fff; font-size:1.15rem; font-weight:800; line-height:1; }
    .stat-pill-lbl  { color:var(--e-muted); font-size:0.7rem; margin-top:2px; }

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

    .badge-niveau { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:0.7rem; font-weight:700; border:1px solid; white-space:nowrap; }
    .badge-debutant      { background:var(--e-blue-pale);    border-color:var(--e-blue-border);    color:#6ea8fe; }
    .badge-intermediaire { background:var(--e-orange-pale);  border-color:var(--e-orange-border);  color:var(--e-orange); }
    .badge-avance        { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }

    .alert-success { background:var(--e-primary-pale); border:1px solid var(--e-primary-border); border-radius:10px; padding:11px 16px; color:var(--e-accent); font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }
    .alert-error   { background:var(--e-red-pale);    border:1px solid var(--e-red-border);     border-radius:10px; padding:11px 16px; color:var(--e-red);    font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }

    .empty-state { padding:40px; text-align:center; color:var(--e-muted); font-size:0.82rem; }
    .empty-state i { font-size:2rem; opacity:0.2; display:block; margin-bottom:10px; }

    .table-footer { padding:10px 14px; border-top:1px solid var(--e-border); font-size:0.73rem; color:var(--e-muted); }

    .btn-ghost { background:transparent; border:1px solid var(--e-border); color:var(--e-soft); font-weight:600; border-radius:8px; padding:7px 14px; font-size:0.78rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$niveauLabels = [
    'debutant'      => 'Débutant',
    'intermediaire' => 'Intermédiaire',
    'avance'        => 'Avancé',
];
$total = count($competences);
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-star me-2" style="color:var(--e-primary);"></i>Mes Compétences</h1>
        <p>Vos compétences enregistrées dans le système</p>
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
        <div class="stat-pill-icon" style="background:var(--e-primary-pale);border:1px solid var(--e-primary-border);"><i class="fas fa-star" style="color:var(--e-primary);"></i></div>
        <div><div class="stat-pill-val"><?= $total ?></div><div class="stat-pill-lbl">Total</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-blue-pale);border:1px solid var(--e-blue-border);"><i class="fas fa-seedling" style="color:#6ea8fe;"></i></div>
        <div><div class="stat-pill-val" style="color:#6ea8fe;"><?= $nbDebutant ?></div><div class="stat-pill-lbl">Débutant</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-orange-pale);border:1px solid var(--e-orange-border);"><i class="fas fa-bolt" style="color:var(--e-orange);"></i></div>
        <div><div class="stat-pill-val" style="color:var(--e-orange);"><?= $nbInter ?></div><div class="stat-pill-lbl">Intermédiaire</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-primary-pale);border:1px solid var(--e-primary-border);"><i class="fas fa-trophy" style="color:var(--e-accent);"></i></div>
        <div><div class="stat-pill-val" style="color:var(--e-accent);"><?= $nbAvance ?></div><div class="stat-pill-lbl">Avancé</div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-icon"><i class="fas fa-star"></i></div>
        <p class="card-title">Liste de mes compétences</p>
    </div>

    <?php if (empty($competences)): ?>
    <div class="empty-state">
        <i class="fas fa-star"></i>
        Aucune compétence enregistrée pour vous.<br>
        <span style="font-size:0.75rem;margin-top:6px;display:block;">Le RH peut vous en attribuer depuis le référentiel.</span>
    </div>
    <?php else: ?>

    <div class="filter-bar">
        <div class="filter-group">
            <label class="filter-lbl">Recherche</label>
            <input type="text" id="f-search" class="filter-ctrl"
                   placeholder="Nom de compétence..." style="width:200px;" oninput="filterRows()">
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Niveau</label>
            <select id="f-niveau" class="filter-ctrl" onchange="filterRows()">
                <option value="">Tous</option>
                <option value="debutant">Débutant</option>
                <option value="intermediaire">Intermédiaire</option>
                <option value="avance">Avancé</option>
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

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Compétence</th>
                    <th>Niveau</th>
                    <th>Date d'obtention</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($competences as $c): ?>
                <tr data-search="<?= strtolower(esc($c['Libelle_Cmp'])) ?>"
                    data-niveau="<?= esc($c['Niveau_Obt']) ?>">
                    <td style="font-weight:600;color:var(--e-text);">
                        <i class="fas fa-star me-2" style="color:var(--e-primary);font-size:0.7rem;"></i>
                        <?= esc($c['Libelle_Cmp']) ?>
                    </td>
                    <td>
                        <span class="badge-niveau badge-<?= $c['Niveau_Obt'] ?>">
                            <?php if ($c['Niveau_Obt'] === 'debutant'): ?>
                                <i class="fas fa-seedling"></i>
                            <?php elseif ($c['Niveau_Obt'] === 'intermediaire'): ?>
                                <i class="fas fa-bolt"></i>
                            <?php else: ?>
                                <i class="fas fa-trophy"></i>
                            <?php endif; ?>
                            <?= $niveauLabels[$c['Niveau_Obt']] ?? $c['Niveau_Obt'] ?>
                        </span>
                    </td>
                    <td><?= $c['Dte_Obt'] ? date('d/m/Y', strtotime($c['Dte_Obt'])) : '—' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer" id="table-footer"><?= $total ?> compétence(s)</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var btnReset = document.getElementById('btn-reset');

    window.filterRows = function () {
        var search = document.getElementById('f-search').value.trim().toLowerCase();
        var niveau = document.getElementById('f-niveau').value;
        btnReset.style.display = (search || niveau) ? '' : 'none';
        var rows = document.querySelectorAll('#table-body tr');
        var visible = 0;
        rows.forEach(function (row) {
            var match =
                (search === '' || row.dataset.search.includes(search)) &&
                (niveau === '' || row.dataset.niveau === niveau);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        var footer = document.getElementById('table-footer');
        if (footer) footer.textContent = visible + ' compétence(s)';
    };

    window.resetFilters = function () {
        document.getElementById('f-search').value = '';
        document.getElementById('f-niveau').value = '';
        filterRows();
    };
})();
</script>
<?= $this->endSection() ?>