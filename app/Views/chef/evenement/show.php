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
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .show-grid { display:grid; grid-template-columns:300px 1fr; gap:16px; align-items:start; }

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

    .info-body { padding:16px 18px; }

    .info-row {
        display:flex; flex-direction:column; gap:3px;
        padding:10px 0; border-bottom:1px solid var(--c-border);
    }

    .info-row:first-child { padding-top:0; }
    .info-row:last-child  { border-bottom:none; padding-bottom:0; }

    .info-label {
        font-size:0.67rem; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.6px; font-weight:600;
    }

    .info-value { color:var(--c-text); font-size:0.82rem; }

    .badge-type {
        display:inline-flex; align-items:center; gap:4px;
        padding:3px 10px; border-radius:20px; font-size:0.68rem; font-weight:700;
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent);
    }

    .badge-avenir  { background:var(--c-green-pale);   border:1px solid var(--c-green-border);   color:#7ab86a; }
    .badge-passe   { background:rgba(255,255,255,0.05); border:1px solid var(--c-border);         color:var(--c-muted); }
    .badge-aujourd { background:var(--c-primary-pale);  border:1px solid var(--c-primary-border); color:var(--c-accent); }

    /* Participation */
    .participer-block {
        margin-top:14px; padding:14px;
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border);
        border-radius:10px; text-align:center;
    }

    .participer-block p { color:var(--c-soft); font-size:0.78rem; margin-bottom:10px; }

    .btn-participer {
        background:linear-gradient(135deg, var(--c-primary), #2A5FAA);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:9px 20px; font-size:0.82rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }

    .btn-participer:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(58,123,213,0.35); }

    .btn-retirer {
        background:var(--c-red-pale); border:1px solid var(--c-red-border);
        color:#ff8080; font-weight:700; border-radius:8px;
        padding:9px 20px; font-size:0.82rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }

    .btn-retirer:hover { background:rgba(224,82,82,0.2); }

    .deja-inscrit {
        display:inline-flex; align-items:center; gap:6px;
        color:#7ab86a; font-size:0.78rem; font-weight:600;
    }

    /* Filtres participants */
    .filter-bar {
        display:flex; gap:8px; padding:10px 14px;
        border-bottom:1px solid var(--c-border); flex-wrap:wrap; align-items:flex-end;
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

    /* Table participants */
    .emp-table { width:100%; border-collapse:collapse; font-size:0.8rem; }

    .emp-table thead th {
        padding:8px 14px; font-size:0.65rem; font-weight:700;
        letter-spacing:0.8px; text-transform:uppercase;
        color:var(--c-accent); background:var(--c-primary-pale);
        border-bottom:1px solid var(--c-primary-border);
    }

    .emp-table tbody td {
        padding:10px 14px; color:var(--c-soft);
        border-bottom:1px solid var(--c-border); vertical-align:middle;
    }

    .emp-table tbody tr:last-child td { border-bottom:none; }
    .emp-table tbody tr:hover td { background:rgba(58,123,213,0.02); }

    .emp-avatar {
        width:28px; height:28px; border-radius:50%;
        background:var(--c-primary-pale); border:1px solid var(--c-primary-border);
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.62rem; font-weight:700; color:var(--c-accent);
        text-transform:uppercase; flex-shrink:0; vertical-align:middle; margin-right:8px;
    }

    /* Boutons */
    .btn-icon {
        width:27px; height:27px; border-radius:6px;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.65rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none;
    }

    .btn-icon-primary { background:var(--c-primary-pale); color:var(--c-accent); border:1px solid var(--c-primary-border); }
    .btn-icon-red     { background:var(--c-red-pale);     color:#ff8080;         border:1px solid var(--c-red-border); }
    .btn-icon:hover   { transform:scale(1.1); }

    .btn-ghost {
        background:transparent; border:1px solid var(--c-border);
        color:var(--c-soft); font-weight:600; border-radius:8px;
        padding:8px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--c-text); }

    .btn-danger {
        background:linear-gradient(135deg,#c0392b,#922b21);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:8px 16px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px;
    }

    .btn-danger:hover { transform:translateY(-1px); }

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

    @media (max-width:900px) { .show-grid { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$evt    = $evenement;
$today  = date('Y-m-d');
$statut = $evt['Date_Evt'] > $today ? 'avenir' : ($evt['Date_Evt'] === $today ? 'aujourd_hui' : 'passe');
$total  = count($participants);
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-alt me-2" style="color:#3A7BD5;"></i><?= esc($evt['Description_Evt']) ?></h1>
        <p><?= date('d/m/Y', strtotime($evt['Date_Evt'])) ?> · <?= $total ?> participant(s)</p>
    </div>
    <a href="<?= base_url('evenement') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
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

<div class="show-grid">

    <!-- COL GAUCHE — Infos + Participation -->
    <div style="display:flex;flex-direction:column;gap:16px;">

        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon"><i class="fas fa-info-circle"></i></div>
                    <p class="card-title">Informations</p>
                </div>
            </div>
            <div class="info-body">
                <div class="info-row">
                    <span class="info-label">Description</span>
                    <span class="info-value" style="font-weight:700;"><?= esc($evt['Description_Evt']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Type</span>
                    <span class="badge-type"><?= esc($evt['Libelle_Tev'] ?? '-') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-value">
                        <?= date('d/m/Y', strtotime($evt['Date_Evt'])) ?>
                        <?php if ($statut === 'avenir'): ?>
                        <span class="badge-type badge-avenir" style="margin-left:6px;font-size:0.65rem;">À venir</span>
                        <?php elseif ($statut === 'aujourd_hui'): ?>
                        <span class="badge-type badge-aujourd" style="margin-left:6px;font-size:0.65rem;">Aujourd'hui</span>
                        <?php else: ?>
                        <span class="badge-type badge-passe" style="margin-left:6px;font-size:0.65rem;">Passé</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Participants</span>
                    <span class="info-value" style="font-size:1.1rem;font-weight:800;color:var(--c-accent);">
                        <?= $total ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Bloc participation personnelle -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon"><i class="fas fa-user-check"></i></div>
                    <p class="card-title">Ma participation</p>
                </div>
            </div>
            <div style="padding:16px 18px;">
                <?php if ($maParticipation): ?>
                <div style="text-align:center;margin-bottom:12px;">
                    <span class="deja-inscrit">
                        <i class="fas fa-check-circle" style="font-size:1.1rem;"></i>
                        Vous participez à cet événement
                    </span>
                    <div style="color:var(--c-muted);font-size:0.72rem;margin-top:4px;">
                        Inscrit le <?= date('d/m/Y', strtotime($maParticipation['Dte_Sig'])) ?>
                    </div>
                </div>
                <?php if ($statut !== 'passe'): ?>
                <form action="<?= base_url('evenement/se-retirer/' . $evt['id_Evt']) ?>" method="POST"
                      style="text-align:center;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-retirer">
                        <i class="fas fa-user-minus"></i> Se retirer
                    </button>
                </form>
                <?php endif; ?>
                <?php else: ?>
                <p style="color:var(--c-muted);font-size:0.78rem;text-align:center;margin-bottom:10px;">
                    Vous ne participez pas encore à cet événement.
                </p>
                <?php if ($statut !== 'passe'): ?>
                <form action="<?= base_url('evenement/participer/' . $evt['id_Evt']) ?>" method="POST"
                      style="text-align:center;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-participer">
                        <i class="fas fa-user-plus"></i> Participer
                    </button>
                </form>
                <?php else: ?>
                <p style="color:var(--c-muted);font-size:0.75rem;text-align:center;font-style:italic;">
                    Cet événement est passé.
                </p>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

    </div><!-- /COL GAUCHE -->

    <!-- COL DROITE — Participants de la direction -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <p class="card-title">Participants de ma direction</p>
            </div>
            <span class="card-count" id="part-count"><?= $total ?></span>
        </div>

        <div class="filter-bar">
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">Recherche</label>
                <input type="text" id="f-search" class="filter-ctrl-sm"
                       placeholder="Nom ou prénom..." style="width:160px;">
            </div>
            <div class="filter-group-sm">
                <label class="filter-lbl-sm">&nbsp;</label>
                <button type="button" class="btn-danger" id="btn-reset"
                        style="display:none;" onclick="resetFilters()">
                    <i class="fas fa-times"></i> Réinitialiser
                </button>
            </div>
        </div>

        <?php if (empty($participants)): ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            Aucun participant de votre direction pour cet événement.
        </div>
        <?php else: ?>
        <table class="emp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Participant</th>
                    <th>Grade</th>
                    <th>Date inscription</th>
                </tr>
            </thead>
            <tbody id="part-tbody">
                <?php foreach ($participants as $i => $p): ?>
                <tr class="part-row"
                    data-nom="<?= strtolower(esc(($p['Nom_Emp'] ?? '') . ' ' . ($p['Prenom_Emp'] ?? ''))) ?>">
                    <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                    <td>
                        <span class="emp-avatar">
                            <?= mb_substr($p['Nom_Emp'] ?? '?', 0, 1) . mb_substr($p['Prenom_Emp'] ?? '', 0, 1) ?>
                        </span>
                        <span style="color:#fff;font-weight:500;">
                            <?= esc(($p['Nom_Emp'] ?? '') . ' ' . ($p['Prenom_Emp'] ?? '')) ?>
                        </span>
                    </td>
                    <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($p['Libelle_Grd'] ?? '-') ?></td>
                    <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                        <?= $p['Dte_Sig'] ? date('d/m/Y', strtotime($p['Dte_Sig'])) : '-' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="no-match" style="display:none;padding:30px;text-align:center;">
            <i class="fas fa-search" style="font-size:1.4rem;color:var(--c-muted);opacity:0.3;display:block;margin-bottom:8px;"></i>
            <span style="color:var(--c-muted);font-size:0.82rem;">Aucun participant ne correspond.</span>
        </div>

        <div style="padding:10px 16px;border-top:1px solid var(--c-border);">
            <span style="font-size:0.73rem;color:var(--c-muted);" id="part-footer">
                <?= $total ?> participant(s) affiché(s)
            </span>
        </div>
        <?php endif; ?>
    </div>

</div><!-- /.show-grid -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var rows     = document.querySelectorAll('.part-row');
    var btnReset = document.getElementById('btn-reset');
    var count    = document.getElementById('part-count');
    var footer   = document.getElementById('part-footer');
    var noMatch  = document.getElementById('no-match');

    function applyFilters() {
        var search = document.getElementById('f-search').value.trim().toLowerCase();
        btnReset.style.display = search !== '' ? '' : 'none';

        var visible = 0;
        rows.forEach(function (row) {
            var match = search === '' || row.dataset.nom.includes(search);
            row.style.display = match ? '' : 'none';
            if (match) {
                visible++;
                var numCell = row.querySelector('.row-num');
                if (numCell) numCell.textContent = visible;
            }
        });

        if (count)  count.textContent  = visible;
        if (footer) footer.textContent = visible + ' participant(s) affiché(s)';
        if (noMatch) noMatch.style.display = visible === 0 && rows.length > 0 ? 'block' : 'none';
    }

    window.resetFilters = function () {
        var el = document.getElementById('f-search');
        if (el) el.value = '';
        applyFilters();
    };

    var searchEl = document.getElementById('f-search');
    if (searchEl) searchEl.addEventListener('input', applyFilters);
})();
</script>
<?= $this->endSection() ?>