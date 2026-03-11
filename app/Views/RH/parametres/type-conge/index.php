<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-orange:        #F5A623;
        --c-orange-pale:   rgba(245,166,35,0.10);
        --c-orange-border: rgba(245,166,35,0.25);
        --c-green-pale:    rgba(74,103,65,0.15);
        --c-green-border:  rgba(74,103,65,0.35);
        --c-red-pale:      rgba(224,82,82,0.10);
        --c-red-border:    rgba(224,82,82,0.25);
        --c-blue-pale:     rgba(58,123,213,0.10);
        --c-blue-border:   rgba(58,123,213,0.25);
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

    .card {
        background:var(--c-surface); border:1px solid var(--c-border);
        border-radius:14px; overflow:hidden;
    }
    .card-header {
        padding:14px 18px; border-bottom:1px solid var(--c-border);
        display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
    }
    .card-header-left { display:flex; align-items:center; gap:10px; }
    .card-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-orange); font-size:0.82rem; flex-shrink:0;
    }
    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }
    .card-count {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.68rem; font-weight:700;
        padding:2px 9px; border-radius:10px;
    }

    .filter-bar {
        padding:10px 14px; border-bottom:1px solid var(--c-border);
        display:flex; gap:8px; flex-wrap:wrap; align-items:flex-end;
    }
    .filter-group { display:flex; flex-direction:column; gap:4px; }
    .filter-lbl {
        font-size:0.62rem; font-weight:600; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.5px;
    }
    .filter-ctrl {
        background:#111; border:1px solid var(--c-border);
        border-radius:7px; color:var(--c-text); font-size:0.75rem;
        padding:6px 9px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif;
    }
    .filter-ctrl:focus { border-color:var(--c-orange-border); }

    .data-table { width:100%; border-collapse:collapse; font-size:0.8rem; }
    .data-table thead th {
        padding:8px 16px; font-size:0.65rem; font-weight:700;
        letter-spacing:0.8px; text-transform:uppercase;
        color:var(--c-orange); background:var(--c-orange-pale);
        border-bottom:1px solid var(--c-orange-border);
    }
    .data-table tbody td {
        padding:11px 16px; color:var(--c-soft);
        border-bottom:1px solid var(--c-border); vertical-align:middle;
    }
    .data-table tbody tr:last-child td { border-bottom:none; }
    .data-table tbody tr:hover td { background:rgba(245,166,35,0.02); }

    .type-name { color:#fff; font-weight:600; font-size:0.83rem; text-decoration:none; }
    .type-name:hover { color:var(--c-orange); }

    .badge-used {
        display:inline-flex; align-items:center; gap:4px;
        padding:2px 9px; border-radius:20px; font-size:0.68rem; font-weight:700;
        background:var(--c-blue-pale); border:1px solid var(--c-blue-border); color:#5B9BF0;
    }
    .badge-unused {
        display:inline-flex; align-items:center; gap:4px;
        padding:2px 9px; border-radius:20px; font-size:0.68rem; font-weight:700;
        background:rgba(255,255,255,0.04); border:1px solid var(--c-border); color:var(--c-muted);
    }

    .btn-icon {
        width:27px; height:27px; border-radius:6px;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.65rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none;
    }
    .btn-icon-orange { background:var(--c-orange-pale); color:var(--c-orange); border:1px solid var(--c-orange-border); }
    .btn-icon-red    { background:var(--c-red-pale);    color:#ff8080;          border:1px solid var(--c-red-border); }
    .btn-icon:hover  { transform:scale(1.1); }

    .btn-orange {
        background:linear-gradient(135deg,var(--c-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:8px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-orange:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(245,166,35,0.3); color:#111; }

    .btn-danger {
        background:linear-gradient(135deg,#c0392b,#922b21);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }
    .btn-danger:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(192,57,43,0.35); }

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

    .table-footer {
        padding:10px 16px; border-top:1px solid var(--c-border);
        font-size:0.73rem; color:var(--c-muted);
    }

    #modal-delete {
        display:none; position:fixed; inset:0;
        background:rgba(0,0,0,0.65); z-index:1040;
        backdrop-filter:blur(3px); align-items:center; justify-content:center;
    }
    #modal-delete.is-open { display:flex; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-tags me-2" style="color:#F5A623;"></i>Types de congés</h1>
        <p>Gestion des types de congés</p>
    </div>
    <a href="<?= base_url('parametres/type-conge/create') ?>" class="btn-orange">
        <i class="fas fa-plus"></i> Nouveau type
    </a>
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
        <div class="stat-pill-icon" style="background:var(--c-orange-pale);border:1px solid var(--c-orange-border);">
            <i class="fas fa-tags" style="color:var(--c-orange);"></i>
        </div>
        <div>
            <div class="stat-pill-val"><?= $total ?></div>
            <div class="stat-pill-lbl">Types</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-blue-pale);border:1px solid var(--c-blue-border);">
            <i class="fas fa-calendar-alt" style="color:#5B9BF0;"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:#5B9BF0;"><?= $totalConges ?></div>
            <div class="stat-pill-lbl">Congés associés</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:rgba(255,255,255,0.04);border:1px solid var(--c-border);">
            <i class="fas fa-exclamation-circle" style="color:var(--c-muted);"></i>
        </div>
        <div>
            <div class="stat-pill-val"><?= $nonUtilises ?></div>
            <div class="stat-pill-lbl">Non utilisés</div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-icon"><i class="fas fa-tags"></i></div>
            <p class="card-title">Liste des types de congés</p>
        </div>
        <span class="card-count" id="type-count"><?= $total ?></span>
    </div>

    <div class="filter-bar">
        <div class="filter-group">
            <label class="filter-lbl">Recherche</label>
            <input type="text" id="f-search" class="filter-ctrl"
                   placeholder="Libellé..." style="width:220px;"
                   oninput="filterTypes()">
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Utilisation</label>
            <select id="f-usage" class="filter-ctrl" onchange="filterTypes()">
                <option value="">Tous</option>
                <option value="used">Utilisés</option>
                <option value="unused">Non utilisés</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-lbl">&nbsp;</label>
            <button type="button" class="btn-danger" id="btn-reset"
                    style="display:none;" onclick="resetFilters()">
                <i class="fas fa-times"></i> Réinitialiser
            </button>
        </div>
    </div>

    <?php if (empty($types)): ?>
    <div class="empty-state">
        <i class="fas fa-tags"></i>
        Aucun type de congé enregistré.
    </div>
    <?php else: ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Libellé</th>
                <th style="text-align:center;">Congés</th>
                <th>Statut</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types as $i => $t): ?>
            <tr class="type-row"
                data-libelle="<?= strtolower(esc($t['Libelle_Tcg'])) ?>"
                data-usage="<?= $t['nb_conges'] > 0 ? 'used' : 'unused' ?>">
                <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                <td>
                    <a href="<?= base_url('parametres/type-conge/show/' . $t['id_Tcg']) ?>"
                       class="type-name">
                        <?= esc($t['Libelle_Tcg']) ?>
                    </a>
                </td>
                <td style="text-align:center;">
                    <span class="card-count"><?= (int)$t['nb_conges'] ?></span>
                </td>
                <td>
                    <?php if ($t['nb_conges'] > 0): ?>
                    <span class="badge-used"><i class="fas fa-check"></i> Utilisé</span>
                    <?php else: ?>
                    <span class="badge-unused"><i class="fas fa-minus"></i> Non utilisé</span>
                    <?php endif; ?>
                </td>
                <td style="text-align:center;">
                    <div style="display:inline-flex;gap:5px;">
                        <a href="<?= base_url('parametres/type-conge/show/' . $t['id_Tcg']) ?>"
                           class="btn-icon btn-icon-orange" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= base_url('parametres/type-conge/edit/' . $t['id_Tcg']) ?>"
                           class="btn-icon btn-icon-orange" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="btn-icon btn-icon-red" title="Supprimer"
                                onclick="confirmDelete(<?= $t['id_Tcg'] ?>, '<?= esc($t['Libelle_Tcg'], 'js') ?>', <?= (int)$t['nb_conges'] ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="no-match" style="display:none;" class="empty-state">
        <i class="fas fa-search"></i> Aucun type ne correspond aux filtres.
    </div>

    <div class="table-footer" id="table-footer"><?= $total ?> type(s) au total</div>
    <?php endif; ?>
</div>

<!-- Modal suppression -->
<div id="modal-delete" role="dialog" aria-modal="true">
    <div style="background:#1e1e1e;border:1px solid rgba(255,255,255,0.08);border-radius:14px;
                padding:26px;width:100%;max-width:380px;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <div style="width:46px;height:46px;border-radius:12px;background:var(--c-red-pale);
                    border:1px solid var(--c-red-border);display:flex;align-items:center;
                    justify-content:center;font-size:1.1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 style="color:#fff;font-size:0.9rem;font-weight:700;text-align:center;margin-bottom:8px;">
            Supprimer le type de congé
        </h5>
        <p style="color:var(--c-muted);font-size:0.8rem;text-align:center;margin:0;line-height:1.5;"
           id="modal-delete-msg"></p>
        <div style="display:flex;gap:10px;margin-top:20px;">
            <button type="button" onclick="closeDeleteModal()"
                    style="flex:1;background:transparent;border:1px solid var(--c-border);
                           color:var(--c-soft);font-weight:600;border-radius:8px;
                           padding:9px 16px;font-size:0.82rem;cursor:pointer;">
                <i class="fas fa-times"></i> Annuler
            </button>
            <form id="form-delete" method="POST" style="flex:1;">
                <?= csrf_field() ?>
                <button type="submit"
                        style="width:100%;background:linear-gradient(135deg,#c0392b,#922b21);
                               border:none;color:#fff;font-weight:700;border-radius:8px;
                               padding:9px 16px;font-size:0.82rem;cursor:pointer;">
                    <i class="fas fa-trash-alt"></i> Supprimer
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

    window.filterTypes = function () {
        var search = document.getElementById('f-search').value.trim().toLowerCase();
        var usage  = document.getElementById('f-usage').value;

        var actifs = [search, usage].filter(function (v) { return v !== ''; }).length;
        btnReset.style.display = actifs > 0 ? '' : 'none';

        var rows    = document.querySelectorAll('.type-row');
        var visible = 0;

        rows.forEach(function (row) {
            var match =
                (search === '' || row.dataset.libelle.includes(search)) &&
                (usage  === '' || row.dataset.usage === usage);

            row.style.display = match ? '' : 'none';
            if (match) {
                visible++;
                var num = row.querySelector('.row-num');
                if (num) num.textContent = visible;
            }
        });

        var noMatch = document.getElementById('no-match');
        var footer  = document.getElementById('table-footer');
        var counter = document.getElementById('type-count');

        if (noMatch) noMatch.style.display = visible === 0 && rows.length > 0 ? 'block' : 'none';
        if (footer)  footer.textContent    = visible + ' type(s) affiché(s)';
        if (counter) counter.textContent   = visible;
    };

    window.resetFilters = function () {
        document.getElementById('f-search').value = '';
        document.getElementById('f-usage').value  = '';
        filterTypes();
    };

    window.confirmDelete = function (id, label, nbConges) {
        var modal = document.getElementById('modal-delete');
        var msg   = document.getElementById('modal-delete-msg');
        var form  = document.getElementById('form-delete');

        if (nbConges > 0) {
            msg.innerHTML = 'Impossible de supprimer <strong style="color:#fff;">' + label
                + '</strong> : ' + nbConges + ' congé(s) y sont associés.';
            form.innerHTML = '<button type="button" onclick="closeDeleteModal()" '
                + 'style="width:100%;background:transparent;border:1px solid rgba(255,255,255,0.1);'
                + 'color:rgba(255,255,255,0.55);font-weight:600;border-radius:8px;'
                + 'padding:9px 16px;font-size:0.82rem;cursor:pointer;">'
                + '<i class="fas fa-times"></i> Fermer</button>';
        } else {
            msg.innerHTML = 'Supprimer le type <strong style="color:#fff;">' + label + '</strong> ?';
            form.innerHTML = '<?= csrf_field() ?>'
                + '<button type="submit" style="width:100%;background:linear-gradient(135deg,#c0392b,#922b21);'
                + 'border:none;color:#fff;font-weight:700;border-radius:8px;'
                + 'padding:9px 16px;font-size:0.82rem;cursor:pointer;">'
                + '<i class=\'fas fa-trash-alt\'></i> Supprimer</button>';
            form.action = '<?= base_url('parametres/type-conge/delete/') ?>' + id;
        }

        modal.classList.add('is-open');
    };

    window.closeDeleteModal = function () {
        document.getElementById('modal-delete').classList.remove('is-open');
    };

    document.getElementById('modal-delete').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

})();
</script>
<?= $this->endSection() ?>  
