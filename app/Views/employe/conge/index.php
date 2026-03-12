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
    .stat-pill-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:0.82rem; flex-shrink:0; }
    .stat-pill-val  { color:#fff; font-size:1.15rem; font-weight:800; line-height:1; }
    .stat-pill-lbl  { color:var(--e-muted); font-size:0.7rem; margin-top:2px; }

    .card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; }
    .card-header { padding:14px 18px; border-bottom:1px solid var(--e-border); display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
    .card-header-left { display:flex; align-items:center; gap:10px; }
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
    .badge-en_attente   { background:var(--e-orange-pale); border-color:var(--e-orange-border); color:var(--e-orange); }
    .badge-approuve_chef{ background:var(--e-blue-pale);   border-color:var(--e-blue-border);   color:#6ea8fe; }
    .badge-rejete_chef  { background:var(--e-red-pale);    border-color:var(--e-red-border);     color:var(--e-red); }
    .badge-valide_rh    { background:var(--e-primary-pale); border-color:var(--e-primary-border); color:var(--e-accent); }
    .badge-rejete_rh    { background:var(--e-red-pale);    border-color:var(--e-red-border);     color:var(--e-red); }

    .btn-green { background:linear-gradient(135deg,var(--e-primary),#4A8A4A); border:none; color:#fff; font-weight:700; border-radius:8px; padding:8px 16px; font-size:0.8rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; }
    .btn-green:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(107,175,107,0.3); color:#fff; }

    .btn-ghost { background:transparent; border:1px solid var(--e-border); color:var(--e-soft); font-weight:600; border-radius:8px; padding:7px 14px; font-size:0.78rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }

    .btn-icon { width:28px; height:28px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center; font-size:0.68rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none; }
    .btn-icon-green { background:var(--e-primary-pale); color:var(--e-primary); border:1px solid var(--e-primary-border); }
    .btn-icon-red   { background:var(--e-red-pale);    color:var(--e-red);     border:1px solid var(--e-red-border); }
    .btn-icon:hover { transform:scale(1.1); }

    .alert-success { background:var(--e-primary-pale); border:1px solid var(--e-primary-border); border-radius:10px; padding:11px 16px; color:var(--e-accent); font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }
    .alert-error   { background:var(--e-red-pale);    border:1px solid var(--e-red-border);     border-radius:10px; padding:11px 16px; color:var(--e-red);    font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px; }

    .empty-state { padding:40px; text-align:center; color:var(--e-muted); font-size:0.82rem; }
    .empty-state i { font-size:2rem; opacity:0.2; display:block; margin-bottom:10px; }

    .table-footer { padding:10px 14px; border-top:1px solid var(--e-border); font-size:0.73rem; color:var(--e-muted); }

    .solde-banner {
        margin-bottom:16px; background:var(--e-primary-pale);
        border:1px solid var(--e-primary-border); border-radius:12px;
        padding:14px 18px; display:flex; align-items:center; gap:16px; flex-wrap:wrap;
    }
    .solde-num { font-size:1.6rem; font-weight:800; color:var(--e-primary); line-height:1; }
    .solde-lbl { color:var(--e-muted); font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px; }

    .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); display:none; align-items:center; justify-content:center; z-index:1000; }
    .modal-overlay.is-open { display:flex; }
    .modal-box { background:#1f1f1f; border:1px solid var(--e-border); border-radius:14px; padding:28px; max-width:400px; width:90%; text-align:center; }
    .modal-icon  { font-size:2rem; color:var(--e-red); margin-bottom:12px; }
    .modal-title { color:#fff; font-size:0.95rem; font-weight:700; margin-bottom:8px; }
    .modal-msg   { color:var(--e-muted); font-size:0.82rem; margin-bottom:20px; }
    .modal-actions { display:flex; gap:10px; justify-content:center; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$statutLabels = [
    'en_attente'    => 'En attente',
    'approuve_chef' => 'Approuvé Chef',
    'rejete_chef'   => 'Rejeté Chef',
    'valide_rh'     => 'Validé RH',
    'rejete_rh'     => 'Rejeté RH',
];
$total       = count($conges);
$enAttente   = count(array_filter($conges, fn($c) => $c['Statut_Cge'] === 'en_attente'));
$valides     = count(array_filter($conges, fn($c) => $c['Statut_Cge'] === 'valide_rh'));
$rejetes     = count(array_filter($conges, fn($c) => in_array($c['Statut_Cge'], ['rejete_chef','rejete_rh'])));

$db    = \Config\Database::connect();
$solde = $db->table('solde_conge')
    ->where('id_Emp', $idEmp)
    ->where('Annee_Sld', date('Y'))
    ->get()->getRowArray();
$restant = $solde ? ($solde['NbJoursDroit_Sld'] - $solde['NbJoursPris_Sld']) : 0;
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-umbrella-beach me-2" style="color:var(--e-primary);"></i>Mes Congés</h1>
        <p>Gérez vos demandes de congé</p>
    </div>
    <a href="<?= base_url('conge/create') ?>" class="btn-green">
        <i class="fas fa-plus"></i> Nouvelle demande
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success"><i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<!-- Solde banner -->
<?php if ($solde): ?>
<div class="solde-banner">
    <div>
        <div class="solde-num"><?= (int) $restant ?></div>
        <div class="solde-lbl">Jours restants <?= date('Y') ?></div>
    </div>
    <div style="width:1px;height:40px;background:var(--e-primary-border);"></div>
    <div style="display:flex;gap:24px;flex-wrap:wrap;">
        <div>
            <div style="color:#fff;font-size:0.9rem;font-weight:700;"><?= (int) $solde['NbJoursDroit_Sld'] ?></div>
            <div class="solde-lbl">Jours alloués</div>
        </div>
        <div>
            <div style="color:var(--e-orange);font-size:0.9rem;font-weight:700;"><?= (int) $solde['NbJoursPris_Sld'] ?></div>
            <div class="solde-lbl">Jours pris</div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-primary-pale);border:1px solid var(--e-primary-border);"><i class="fas fa-list" style="color:var(--e-primary);"></i></div>
        <div><div class="stat-pill-val"><?= $total ?></div><div class="stat-pill-lbl">Total</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-orange-pale);border:1px solid var(--e-orange-border);"><i class="fas fa-clock" style="color:var(--e-orange);"></i></div>
        <div><div class="stat-pill-val" style="color:var(--e-orange);"><?= $enAttente ?></div><div class="stat-pill-lbl">En attente</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-primary-pale);border:1px solid var(--e-primary-border);"><i class="fas fa-check-double" style="color:var(--e-accent);"></i></div>
        <div><div class="stat-pill-val" style="color:var(--e-accent);"><?= $valides ?></div><div class="stat-pill-lbl">Validés</div></div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--e-red-pale);border:1px solid var(--e-red-border);"><i class="fas fa-times-circle" style="color:var(--e-red);"></i></div>
        <div><div class="stat-pill-val" style="color:var(--e-red);"><?= $rejetes ?></div><div class="stat-pill-lbl">Rejetés</div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-icon"><i class="fas fa-umbrella-beach"></i></div>
            <p class="card-title">Mes demandes</p>
        </div>
    </div>

    <div class="filter-bar">
        <div class="filter-group">
            <label class="filter-lbl">Recherche</label>
            <input type="text" id="f-search" class="filter-ctrl"
                   placeholder="Libellé, type..." style="width:200px;" oninput="filterRows()">
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Type</label>
            <select id="f-type" class="filter-ctrl" onchange="filterRows()">
                <option value="">Tous</option>
                <?php foreach ($typesConge as $t): ?>
                <option value="<?= strtolower(esc($t['Libelle_Tcg'])) ?>"><?= esc($t['Libelle_Tcg']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Statut</label>
            <select id="f-statut" class="filter-ctrl" onchange="filterRows()">
                <option value="">Tous</option>
                <option value="en_attente">En attente</option>
                <option value="approuve_chef">Approuvé Chef</option>
                <option value="rejete_chef">Rejeté Chef</option>
                <option value="valide_rh">Validé RH</option>
                <option value="rejete_rh">Rejeté RH</option>
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

    <?php if (empty($conges)): ?>
    <div class="empty-state">
        <i class="fas fa-umbrella-beach"></i>
        Aucune demande de congé pour le moment.
        <div style="margin-top:12px;">
            <a href="<?= base_url('conge/create') ?>" class="btn-green">
                <i class="fas fa-plus"></i> Nouvelle demande
            </a>
        </div>
    </div>
    <?php else: ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Jours</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($conges as $c): ?>
                <?php
                $nbJ = (new DateTime($c['DateDebut_Cge']))->diff(new DateTime($c['DateFin_Cge']))->days + 1;
                ?>
                <tr data-search="<?= strtolower(esc($c['Libelle_Cge'] . ' ' . $c['Libelle_Tcg'])) ?>"
                    data-type="<?= strtolower(esc($c['Libelle_Tcg'])) ?>"
                    data-statut="<?= esc($c['Statut_Cge']) ?>">
                    <td style="font-weight:600;color:var(--e-text);"><?= esc($c['Libelle_Cge']) ?></td>
                    <td>
                        <span class="badge badge-en_attente" style="background:var(--e-primary-pale);border-color:var(--e-primary-border);color:var(--e-accent);">
                            <?= esc($c['Libelle_Tcg']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($c['DateDebut_Cge'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['DateFin_Cge'])) ?></td>
                    <td style="color:var(--e-orange);font-weight:700;"><?= $nbJ ?> j</td>
                    <td>
                        <span class="badge badge-<?= $c['Statut_Cge'] ?>">
                            <?= $statutLabels[$c['Statut_Cge']] ?? $c['Statut_Cge'] ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="<?= base_url('conge/show/' . $c['id_Cge']) ?>"
                               class="btn-icon btn-icon-green" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($c['Statut_Cge'] === 'en_attente'): ?>
                            <a href="<?= base_url('conge/edit/' . $c['id_Cge']) ?>"
                               class="btn-icon btn-icon-green" title="Modifier">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="btn-icon btn-icon-red" title="Annuler"
                                    onclick="openDelete(<?= $c['id_Cge'] ?>)">
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

    <div class="table-footer" id="table-footer"><?= $total ?> demande(s)</div>
    <?php endif; ?>
</div>

<!-- Modal annulation -->
<div class="modal-overlay" id="modal-delete">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <div class="modal-title">Annuler cette demande ?</div>
        <div class="modal-msg">Cette action est irréversible.</div>
        <div class="modal-actions">
            <button type="button" class="btn-ghost" onclick="closeDelete()">
                <i class="fas fa-times"></i> Retour
            </button>
            <form id="form-delete" method="POST" action="">
                <?= csrf_field() ?>
                <button type="submit" class="btn-icon btn-icon-red"
                        style="width:auto;padding:8px 16px;font-size:0.8rem;gap:6px;display:inline-flex;align-items:center;">
                    <i class="fas fa-trash"></i> Annuler la demande
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
        var rows = document.querySelectorAll('#table-body tr');
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
        if (footer) footer.textContent = visible + ' demande(s)';
    };

    window.resetFilters = function () {
        document.getElementById('f-search').value = '';
        document.getElementById('f-type').value   = '';
        document.getElementById('f-statut').value = '';
        filterRows();
    };

    window.openDelete = function (id) {
        document.getElementById('form-delete').action = '<?= base_url('conge/delete/') ?>' + id;
        document.getElementById('modal-delete').classList.add('is-open');
    };
    window.closeDelete = function () {
        document.getElementById('modal-delete').classList.remove('is-open');
    };
})();
</script>
<?= $this->endSection() ?>