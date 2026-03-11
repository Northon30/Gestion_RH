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

    .show-grid { display:grid; grid-template-columns:280px 1fr; gap:16px; align-items:start; }

    .card { background:var(--c-surface); border:1px solid var(--c-border); border-radius:14px; overflow:hidden; }

    .card-header {
        padding:14px 18px; border-bottom:1px solid var(--c-border);
        display:flex; align-items:center; gap:10px;
    }

    .card-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-orange); font-size:0.82rem; flex-shrink:0;
    }

    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }

    /* Info rows */
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

    /* Grand libellé hero */
    .grade-hero {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        border-radius:10px; padding:16px 18px; margin:16px 18px 0;
        display:flex; align-items:center; gap:12px;
    }

    .grade-hero-icon {
        width:42px; height:42px; border-radius:12px;
        background:var(--c-orange); display:flex; align-items:center;
        justify-content:center; font-size:1.1rem; color:#111; flex-shrink:0;
    }

    .grade-hero-name { color:#fff; font-size:1rem; font-weight:800; }
    .grade-hero-id   { color:var(--c-orange); font-size:0.72rem; margin-top:2px; }

    /* Table employés */
    .emp-table { width:100%; border-collapse:collapse; font-size:0.8rem; }

    .emp-table thead th {
        padding:8px 16px; font-size:0.65rem; font-weight:700;
        letter-spacing:0.8px; text-transform:uppercase;
        color:var(--c-orange); background:var(--c-orange-pale);
        border-bottom:1px solid var(--c-orange-border);
    }

    .emp-table tbody td {
        padding:10px 16px; color:var(--c-soft);
        border-bottom:1px solid var(--c-border); vertical-align:middle;
    }

    .emp-table tbody tr:last-child td { border-bottom:none; }
    .emp-table tbody tr:hover td { background:rgba(245,166,35,0.02); }

    .emp-avatar {
        width:28px; height:28px; border-radius:50%;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.62rem; font-weight:700; color:var(--c-orange);
        text-transform:uppercase; margin-right:8px; vertical-align:middle;
    }

    /* Boutons */
    .btn-orange {
        background:linear-gradient(135deg,var(--c-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:8px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-orange:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(245,166,35,0.3); color:#111; }

    .btn-ghost {
        background:transparent; border:1px solid var(--c-border);
        color:var(--c-soft); font-weight:600; border-radius:8px;
        padding:8px 18px; font-size:0.8rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }

    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--c-text); }

    .btn-icon {
        width:27px; height:27px; border-radius:6px;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.65rem; cursor:pointer; transition:all 0.15s; border:none; text-decoration:none;
    }

    .btn-icon-orange { background:var(--c-orange-pale); color:var(--c-orange); border:1px solid var(--c-orange-border); }
    .btn-icon:hover  { transform:scale(1.1); }

    .badge-count {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.68rem; font-weight:700;
        padding:2px 9px; border-radius:10px;
    }

    .empty-state { padding:30px; text-align:center; color:var(--c-muted); font-size:0.8rem; }
    .empty-state i { font-size:1.4rem; opacity:0.2; margin-bottom:8px; display:block; }

    .alert-success-dark {
        background:var(--c-green-pale); border:1px solid var(--c-green-border);
        border-radius:10px; padding:11px 16px; color:#7ab86a;
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    @media (max-width:860px) { .show-grid { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $nbEmployes = count($employes); ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-medal me-2" style="color:#F5A623;"></i><?= esc($grade['Libelle_Grd']) ?></h1>
        <p><?= $nbEmployes ?> employé(s) associé(s)</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="<?= base_url('parametres/grade') ?>" class="btn-ghost">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <a href="<?= base_url('parametres/grade/edit/' . $grade['id_Grd']) ?>" class="btn-orange">
            <i class="fas fa-pen"></i> Modifier
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark">
    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<div class="show-grid">

    <!-- COL GAUCHE — Infos grade -->
    <div class="card">
        <div class="grade-hero">
            <div class="grade-hero-icon"><i class="fas fa-medal"></i></div>
            <div>
                <div class="grade-hero-name"><?= esc($grade['Libelle_Grd']) ?></div>
                <div class="grade-hero-id">ID # <?= (int)$grade['id_Grd'] ?></div>
            </div>
        </div>

        <div class="info-body">
            <div class="info-row">
                <span class="info-label">Libellé</span>
                <span class="info-value" style="font-weight:600;"><?= esc($grade['Libelle_Grd']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Identifiant</span>
                <span class="info-value"><?= (int)$grade['id_Grd'] ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Employés associés</span>
                <span class="info-value" style="font-size:1.1rem;font-weight:800;color:var(--c-orange);">
                    <?= $nbEmployes ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Statut</span>
                <?php if ($nbEmployes > 0): ?>
                <span style="display:inline-flex;align-items:center;gap:5px;
                             background:var(--c-blue-pale);border:1px solid var(--c-blue-border);
                             color:#5B9BF0;border-radius:20px;padding:3px 10px;
                             font-size:0.72rem;font-weight:700;">
                    <i class="fas fa-check"></i> Utilisé
                </span>
                <?php else: ?>
                <span style="display:inline-flex;align-items:center;gap:5px;
                             background:rgba(255,255,255,0.04);border:1px solid var(--c-border);
                             color:var(--c-muted);border-radius:20px;padding:3px 10px;
                             font-size:0.72rem;font-weight:700;">
                    <i class="fas fa-minus"></i> Non utilisé
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- COL DROITE — Employés associés -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon"><i class="fas fa-users"></i></div>
            <p class="card-title">Employés avec ce grade</p>
            <span class="badge-count" style="margin-left:auto;"><?= $nbEmployes ?></span>
        </div>

        <?php if (empty($employes)): ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            Aucun employé n'a ce grade pour l'instant.
        </div>
        <?php else: ?>
        <table class="emp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employé</th>
                    <th>Direction</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employes as $i => $e): ?>
                <tr>
                    <td style="color:var(--c-muted);font-size:0.7rem;"><?= $i + 1 ?></td>
                    <td>
                        <span class="emp-avatar">
                            <?= mb_substr($e['Nom_Emp'], 0, 1) . mb_substr($e['Prenom_Emp'] ?? '', 0, 1) ?>
                        </span>
                        <span style="color:#fff;font-weight:500;">
                            <?= esc($e['Nom_Emp'] . ' ' . $e['Prenom_Emp']) ?>
                        </span>
                    </td>
                    <td style="color:var(--c-muted);font-size:0.75rem;">
                        <?= esc($e['Nom_Dir'] ?? '-') ?>
                    </td>
                    <td style="text-align:center;">
                        <a href="<?= base_url('employe/show/' . $e['id_Emp']) ?>"
                           class="btn-icon btn-icon-orange" title="Voir l'employé">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>  
