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
        --e-surface:        #1a1a1a;
        --e-border:         rgba(255,255,255,0.06);
        --e-text:           rgba(255,255,255,0.85);
        --e-muted:          rgba(255,255,255,0.35);
        --e-soft:           rgba(255,255,255,0.55);
    }

    .form-card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; max-width:680px; margin:0 auto; }
    .form-card-header { padding:16px 22px; border-bottom:1px solid var(--e-border); display:flex; align-items:center; gap:12px; }
    .form-card-icon { width:38px; height:38px; border-radius:10px; background:var(--e-orange-pale); border:1px solid var(--e-orange-border); display:flex; align-items:center; justify-content:center; color:var(--e-orange); font-size:0.9rem; flex-shrink:0; }
    .form-card-title    { color:#fff; font-size:0.92rem; font-weight:700; margin:0; }
    .form-card-subtitle { color:var(--e-muted); font-size:0.75rem; margin:2px 0 0; }
    .form-card-body   { padding:24px; display:flex; flex-direction:column; gap:18px; }
    .form-card-footer { padding:16px 22px; border-top:1px solid var(--e-border); display:flex; align-items:center; justify-content:flex-end; gap:10px; }

    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-label { font-size:0.72rem; font-weight:600; color:var(--e-soft); text-transform:uppercase; letter-spacing:0.5px; }
    .form-label .req { color:var(--e-orange); margin-left:2px; }

    .form-control { background:#111; border:1px solid var(--e-border); border-radius:8px; color:var(--e-text); font-size:0.85rem; padding:10px 14px; outline:none; transition:border-color 0.2s; font-family:'Segoe UI',sans-serif; width:100%; }
    .form-control:focus { border-color:var(--e-orange-border); }
    .form-control::placeholder { color:var(--e-muted); }

    .info-banner { background:var(--e-orange-pale); border:1px solid var(--e-orange-border); border-radius:10px; padding:11px 16px; color:var(--e-orange); font-size:0.8rem; display:flex; align-items:center; gap:10px; }

    .jours-indicator { background:var(--e-orange-pale); border:1px solid var(--e-orange-border); border-radius:8px; padding:10px 14px; display:flex; align-items:center; justify-content:space-between; }
    .jours-val { color:var(--e-orange); font-size:1.1rem; font-weight:800; }
    .jours-lbl { color:var(--e-muted); font-size:0.75rem; }

    .btn-orange { background:linear-gradient(135deg,var(--e-orange),#d4891a); border:none; color:#111; font-weight:700; border-radius:8px; padding:10px 22px; font-size:0.82rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; }
    .btn-orange:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(245,166,35,0.3); color:#111; }

    .btn-ghost { background:transparent; border:1px solid var(--e-border); color:var(--e-soft); font-weight:600; border-radius:8px; padding:10px 22px; font-size:0.82rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }

    .alert-error { background:var(--e-red-pale); border:1px solid var(--e-red-border); border-radius:10px; padding:11px 16px; color:var(--e-red); font-size:0.82rem; margin-bottom:18px; max-width:680px; margin-left:auto; margin-right:auto; }
    .alert-error ul { margin:6px 0 0 16px; padding:0; }

    @media (max-width:600px) { .two-col { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-pen me-2" style="color:var(--e-orange);"></i>Modifier la demande</h1>
        <p>Seules les demandes en attente peuvent être modifiées</p>
    </div>
    <a href="<?= base_url('conge/show/' . $conge['id_Cge']) ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert-error">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;"><i class="fas fa-exclamation-triangle"></i> Erreurs</div>
    <ul><?php foreach ((array)session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-pen"></i></div>
        <div>
            <p class="form-card-title">Modification</p>
            <p class="form-card-subtitle">Demandé le <?= date('d/m/Y', strtotime($conge['DateDemande_Cge'])) ?></p>
        </div>
    </div>

    <form action="<?= base_url('conge/update/' . $conge['id_Cge']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                Vous modifiez une demande en attente. Une fois traitée par le Chef, elle ne pourra plus être modifiée.
            </div>

            <div class="form-group">
                <label class="form-label">Libellé <span class="req">*</span></label>
                <input type="text" name="Libelle_Cge" class="form-control"
                       value="<?= esc($conge['Libelle_Cge']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Type de congé <span class="req">*</span></label>
                <select name="id_Tcg" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($typesConge as $t): ?>
                    <option value="<?= $t['id_Tcg'] ?>"
                        <?= $conge['id_Tcg'] == $t['id_Tcg'] ? 'selected' : '' ?>>
                        <?= esc($t['Libelle_Tcg']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="two-col">
                <div class="form-group">
                    <label class="form-label">Date de début <span class="req">*</span></label>
                    <input type="date" name="DateDebut_Cge" id="date-debut"
                           class="form-control"
                           value="<?= esc($conge['DateDebut_Cge']) ?>"
                           oninput="calcJours()" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Date de fin <span class="req">*</span></label>
                    <input type="date" name="DateFin_Cge" id="date-fin"
                           class="form-control"
                           value="<?= esc($conge['DateFin_Cge']) ?>"
                           oninput="calcJours()" required>
                </div>
            </div>

            <div class="jours-indicator" id="jours-indicator">
                <div><div class="jours-lbl">Durée</div></div>
                <div>
                    <span class="jours-val" id="jours-val">
                        <?= (new DateTime($conge['DateDebut_Cge']))->diff(new DateTime($conge['DateFin_Cge']))->days + 1 ?>
                    </span>
                    <span style="color:var(--e-muted);font-size:0.75rem;"> jour(s)</span>
                </div>
            </div>

        </div>

        <div class="form-card-footer">
            <a href="<?= base_url('conge/show/' . $conge['id_Cge']) ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-orange">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    window.calcJours = function () {
        var debut = document.getElementById('date-debut').value;
        var fin   = document.getElementById('date-fin').value;
        var val   = document.getElementById('jours-val');
        if (!debut || !fin) return;
        var diff = Math.round((new Date(fin) - new Date(debut)) / (1000*60*60*24)) + 1;
        val.textContent = diff > 0 ? diff : 0;
        document.getElementById('date-fin').min = debut;
    };
})();
</script>
<?= $this->endSection() ?>