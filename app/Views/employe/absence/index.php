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
    .stat-pill {
        background:var(--e-surface); border:1px solid var(--e-border);
        border-radius:10px; padding:12px 18px;
        display:flex; align-items:center; gap:12px; flex:1; min-width:130px;
    }
    .stat-pill-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        font-size:0.82rem; flex-shrink:0;
    }
    .stat-pill-val { color:#fff; font-size:1.15rem; font-weight:800; line-height:1; }
    .stat-pill-lbl { color:var(--e-muted); font-size:0.7rem; margin-top:2px; }

    .card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; }

    .card-header {
        padding:14px 18px; border-bottom:1px solid var(--e-border);
        display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
    }
    .card-header-left { display:flex; align-items:center; gap:10px; }
    .card-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--e-primary-pale); border:1px solid var(--e-primary-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--e-primary); font-size:0.82rem; flex-shrink:0;
    }
    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }

    .filter-bar {
        padding:10px 14px; border-bottom:1px solid var(--e-border);
        display:flex; gap:8px; flex-wrap:wrap; align-items:flex-end;
    }
    .filter-group { display:flex; flex-direction:column; gap:4px; }
    .filter-lbl { font-size:0.62rem; font-weight:600; color:var(--e-muted); text-transform:uppercase; letter-spacing:0.5px; }
    .filter-ctrl {
        background:#111; border:1px solid var(--e-border);
        border-radius:7px; color:var(--e-text); font-size:0.75rem;
        padding:6px 9px; outline:none; transition:border-color 0.2s;
    }
    .filter-ctrl:focus { border-color:var(--e-primary-border); }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.82rem; }
    thead th {
        padding:10px 14px; font-size:0.7rem; font-weight:600;
        letter-spacing:0.7px; text-transform:uppercase;
        color:var(--e-accent); background:var(--e-primary-pale);
        border-bottom:1px solid var(--e-border); white-space:nowrap;
    }
    tbody td {
        padding:11px 14px; color:var(--e-soft);
        border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle;
    }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:rgba(255,255,255,0.02); }

    .badge {
        display:inline-flex; align-items:center; gap:4px;
        padding:3px 9px; border-radius:20px; font-size:0.7rem;
        font-weight:600; border:1px solid; white-space:nowrap;
    }
    .badge-en_attente  { background:var(--e-orange-pale); border-color:var(--e-orange-border); color:var(--e-orange); }
    .badge-valide_rh   { background:var(--e-blue-pale);   border-color:var(--e-blue-border);   color:#6ea8fe; }
    .badge-rejete_rh   { background:var(--e-red-pale);    border-color:var(--e-red-border);     color:var(--e-red); }
    .badge-approuve    { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }
    .badge-rejete      { background:var(--e-red-pale);    border-color:var(--e-red-border);     color:var(--e-red); }

    .badge-pj-oui { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }
    .badge-pj-non { background:rgba(255,255,255,0.04); border-color:var(--e-border); color:var(--e-muted); }

    .btn-green {
        background:linear-gradient(135deg,var(--e-primary),#4A8A4A);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-green:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(107,175,107,0.3); color:#fff; }

    .btn-ghost {
        background:transparent; border:1px solid var(--e-border);
        color:var(--e-soft); font-weight:600; border-radius:8px;
        padding:7px 14px; font-size:0.78rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; text-decoration:none;
    }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }

    .btn-icon {
        width:28px; height:28px; border-radius:6px;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.68rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none;
    }
    .btn-icon-green { background:var(--e-primary-pale); color:var(--e-primary); border:1px solid var(--e-primary-border); }
    .btn-icon-red   { background:var(--e-red-pale);    color:var(--e-red);     border:1px solid var(--e-red-border); }
    .btn-icon:hover { transform:scale(1.1); }

    .alert-success {
        background:var(--e-primary-pale); border:1px solid var(--e-primary-border);
        border-radius:10px; padding:11px 16px; color:var(--e-accent);
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }
    .alert-error {
        background:var(--e-red-pale); border:1px solid var(--e-red-border);
        border-radius:10px; padding:11px 16px; color:var(--e-red);
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    .empty-state { padding:40px; text-align:center; color:var(--e-muted); font-size:0.82rem; }
    .empty-state i { font-size:2rem; opacity:0.2; display:block; margin-bottom:10px; }

    .table-footer { padding:10px 14px; border-top:1px solid var(--e-border); font-size:0.73rem; color:var(--e-muted); }

    /* Modal suppression */
    .modal-overlay {
        position:fixed; inset:0; background:rgba(0,0,0,0.7);
        display:none; align-items:center; justify-content:center; z-index:1000;
    }
    .modal-overlay.is-open { display:flex; }
    .modal-box {
        background:#1f1f1f; border:1px solid var(--e-border); border-radius:14px;
        padding:28px; max-width:400px; width:90%; text-align:center;
    }
    .modal-icon { font-size:2rem; color:var(--e-red); margin-bottom:12px; }
    .modal-title { color:#fff; font-size:0.95rem; font-weight:700; margin-bottom:8px; }
    .modal-msg { color:var(--e-muted); font-size:0.82rem; margin-bottom:20px; }
    .modal-actions { display:flex; gap:10px; justify-content:center; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$statutLabels = [
    'en_attente' => 'En attente',
    'valide_rh'  => 'Validé RH',
    'rejete_rh'  => 'Rejeté RH',
    'approuve'   => 'Approuvé',
    'rejete'     => 'Rejeté',
];
$total      = count($absences);
$enAttente  = count(array_filter($absences, fn($a) => $a['Statut_Abs'] === 'en_attente'));
$approuves  = count(array_filter($absences, fn($a) => $a['Statut_Abs'] === 'approuve'));
$rejetes    = count(array_filter($absences, fn($a) => in_array($a['Statut_Abs'], ['rejete_rh','rejete'])));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-clock me-2" style="color:var(--e-primary);"></i>Mes Absences</h1>
        <p>Gérez vos déclarations d'absence</p>
    </div>
    <a href="<?= base_url('absence/create') ?>" class="btn-green">
        <i class="fas fa-plus"></i> Déclarer une absence
    </a>
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
        <div class="stat-pill-icon" style="background:var(--e-primary-pale);border:1px solid var(--e-primary-border);">
            <i class="fas fa-list" style="color:var(--e-primary);"></i>
        </div>
        <div><div class="stat-pill-val"><?= $total ?></div><div class="stat-pill-lbl">Total</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-orange-pale);border:1px solid var(--e-orange-border);">
            <i class="fas fa-clock" style="color:var(--e-orange);"></i>
        </div>
        <div><div class="stat-pill-val" style="color:var(--e-orange);"><?= $enAttente ?></div><div class="stat-pill-lbl">En attente</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-primary-pale);border:1px solid var(--e-primary-border);">
            <i class="fas fa-check-double" style="color:var(--e-accent);"></i>
        </div>
        <div><div class="stat-pill-val" style="color:var(--e-accent);"><?= $approuves ?></div><div class="stat-pill-lbl">Approuvées</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-red-pale);border:1px solid var(--e-red-border);">
            <i class="fas fa-times-circle" style="color:var(--e-red);"></i>
        </div>
        <div><div class="stat-pill-val" style="color:var(--e-red);"><?= $rejetes ?></div><div class="stat-pill-lbl">Rejetées</div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-icon"><i class="fas fa-user-clock"></i></div>
            <p class="card-title">Mes déclarations</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filter-bar">
        <div class="filter-group">
            <label class="filter-lbl">Recherche</label>
            <input type="text" id="f-search" class="filter-ctrl"
                   placeholder="Type, motif..." style="width:200px;" oninput="filterRows()">
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Type</label>
            <select id="f-type" class="filter-ctrl" onchange="filterRows()">
                <option value="">Tous</option>
                <?php foreach ($typesAbsence as $t): ?>
                <option value="<?= strtolower(esc($t['Libelle_TAbs'])) ?>"><?= esc($t['Libelle_TAbs']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Statut</label>
            <select id="f-statut" class="filter-ctrl" onchange="filterRows()">
                <option value="">Tous</option>
                <option value="en_attente">En attente</option>
                <option value="valide_rh">Validé RH</option>
                <option value="rejete_rh">Rejeté RH</option>
                <option value="approuve">Approuvé</option>
                <option value="rejete">Rejeté</option>
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

    <?php if (empty($absences)): ?>
    <div class="empty-state">
        <i class="fas fa-user-clock"></i>
        Aucune absence déclarée pour le moment.
        <div style="margin-top:12px;">
            <a href="<?= base_url('absence/create') ?>" class="btn-green">
                <i class="fas fa-plus"></i> Déclarer une absence
            </a>
        </div>
    </div>
    <?php else: ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Motif</th>
                    <th>Statut</th>
                    <th>PJ</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($absences as $a): ?>
                <tr data-search="<?= strtolower(esc($a['Libelle_TAbs'] . ' ' . $a['Motif_Abs'])) ?>"
                    data-type="<?= strtolower(esc($a['Libelle_TAbs'])) ?>"
                    data-statut="<?= esc($a['Statut_Abs']) ?>">
                    <td>
                        <span class="badge badge-en_attente" style="background:var(--e-primary-pale);border-color:var(--e-primary-border);color:var(--e-accent);">
                            <?= esc($a['Libelle_TAbs']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($a['DateDebut_Abs'])) ?></td>
                    <td><?= $a['DateFin_Abs'] ? date('d/m/Y', strtotime($a['DateFin_Abs'])) : '—' ?></td>
                    <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?= esc($a['Motif_Abs'] ?? '—') ?>
                    </td>
                    <td>
                        <span class="badge badge-<?= $a['Statut_Abs'] ?>">
                            <?= $statutLabels[$a['Statut_Abs']] ?? $a['Statut_Abs'] ?>
                        </span>
                    </td>
                    <td>
                        <?php
                        $hasPJ = !empty($a['has_pj'] ?? false);
                        ?>
                        <span class="badge <?= $hasPJ ? 'badge-pj-oui' : 'badge-pj-non' ?>">
                            <i class="fas <?= $hasPJ ? 'fa-paperclip' : 'fa-minus' ?>"></i>
                            <?= $hasPJ ? 'Oui' : 'Non' ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="<?= base_url('absence/show/' . $a['id_Abs']) ?>"
                               class="btn-icon btn-icon-green" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($a['Statut_Abs'] === 'en_attente'): ?>
                            <a href="<?= base_url('absence/edit/' . $a['id_Abs']) ?>"
                               class="btn-icon btn-icon-green" title="Modifier">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="btn-icon btn-icon-red" title="Supprimer"
                                    onclick="openDelete(<?= $a['id_Abs'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer" id="table-footer"><?= $total ?> absence(s)</div>
    <?php endif; ?>
</div>

<!-- Modal suppression -->
<div class="modal-overlay" id="modal-delete">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <div class="modal-title">Supprimer cette absence ?</div>
        <div class="modal-msg">Cette action est irréversible.</div>
        <div class="modal-actions">
            <button type="button" class="btn-ghost" onclick="closeDelete()">
                <i class="fas fa-times"></i> Annuler
            </button>
            <form id="form-delete" method="POST" action="">
                <?= csrf_field() ?>
                <button type="submit" class="btn-green" style="background:linear-gradient(135deg,var(--e-red),#c0392b);color:#fff;">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var btnReset = document.getElementById('btn-reset');

    window.filterRows = function () {
        var search = document.getElementById('f-search').value.trim().toLowerCase();
        var type   = document.getElementById('f-type').value.toLowerCase();
        var statut = document.getElementById('f-statut').value;

        btnReset.style.display = (search || type || statut) ? '' : 'none';

        var rows    = document.querySelectorAll('#table-body tr');
        var visible = 0;

        rows.forEach(function (row) {
            var match =
                (search === '' || row.dataset.search.includes(search)) &&
                (type   === '' || row.dataset.type   === type)         &&
                (statut === '' || row.dataset.statut === statut);

            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        var footer = document.getElementById('table-footer');
        if (footer) footer.textContent = visible + ' absence(s)';
    };

    window.resetFilters = function () {
        document.getElementById('f-search').value = '';
        document.getElementById('f-type').value   = '';
        document.getElementById('f-statut').value = '';
        filterRows();
    };

    window.openDelete = function (id) {
        document.getElementById('form-delete').action = '<?= base_url('absence/delete/') ?>' + id;
        document.getElementById('modal-delete').classList.add('is-open');
    };

    window.closeDelete = function () {
        document.getElementById('modal-delete').classList.remove('is-open');
    };
})();
</script>
<?= $this->endSection() ?>