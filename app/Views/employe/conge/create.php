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

    .layout { display:grid; grid-template-columns:1fr 280px; gap:16px; align-items:start; }

    .form-card { background:var(--e-surface); border:1px solid var(--e-border); border-radius:14px; overflow:hidden; }
    .form-card-header { padding:16px 22px; border-bottom:1px solid var(--e-border); display:flex; align-items:center; gap:12px; }
    .form-card-icon { width:38px; height:38px; border-radius:10px; background:var(--e-primary-pale); border:1px solid var(--e-primary-border); display:flex; align-items:center; justify-content:center; color:var(--e-primary); font-size:0.9rem; flex-shrink:0; }
    .form-card-title    { color:#fff; font-size:0.92rem; font-weight:700; margin:0; }
    .form-card-subtitle { color:var(--e-muted); font-size:0.75rem; margin:2px 0 0; }
    .form-card-body   { padding:24px; display:flex; flex-direction:column; gap:18px; }
    .form-card-footer { padding:16px 22px; border-top:1px solid var(--e-border); display:flex; align-items:center; justify-content:flex-end; gap:10px; }

    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-label { font-size:0.72rem; font-weight:600; color:var(--e-soft); text-transform:uppercase; letter-spacing:0.5px; }
    .form-label .req { color:var(--e-orange); margin-left:2px; }

    .form-control { background:#111; border:1px solid var(--e-border); border-radius:8px; color:var(--e-text); font-size:0.85rem; padding:10px 14px; outline:none; transition:border-color 0.2s; font-family:'Segoe UI',sans-serif; width:100%; }
    .form-control:focus { border-color:var(--e-primary-border); }
    .form-control::placeholder { color:var(--e-muted); }

    .form-hint { font-size:0.7rem; color:var(--e-muted); margin-top:2px; }

    /* Solde sidebar */
    .solde-card { background:var(--e-surface); border:1px solid var(--e-primary-border); border-radius:14px; overflow:hidden; }
    .solde-card-header { padding:14px 18px; border-bottom:1px solid var(--e-border); display:flex; align-items:center; gap:10px; }
    .solde-card-body { padding:18px; display:flex; flex-direction:column; gap:14px; }
    .solde-big { text-align:center; padding:16px; background:var(--e-primary-pale); border-radius:10px; border:1px solid var(--e-primary-border); }
    .solde-big-val { font-size:2.2rem; font-weight:800; color:var(--e-primary); line-height:1; }
    .solde-big-lbl { color:var(--e-muted); font-size:0.72rem; text-transform:uppercase; letter-spacing:0.5px; margin-top:4px; }
    .solde-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid var(--e-border); }
    .solde-row:last-child { border-bottom:none; }
    .solde-row-lbl { color:var(--e-muted); font-size:0.78rem; }
    .solde-row-val { color:var(--e-text); font-size:0.82rem; font-weight:600; }

    /* Compteur jours */
    .jours-indicator {
        background:var(--e-orange-pale); border:1px solid var(--e-orange-border);
        border-radius:8px; padding:10px 14px;
        display:flex; align-items:center; justify-content:space-between;
    }
    .jours-val { color:var(--e-orange); font-size:1.1rem; font-weight:800; }
    .jours-lbl { color:var(--e-muted); font-size:0.75rem; }

    .alert-warn { background:var(--e-orange-pale); border:1px solid var(--e-orange-border); border-radius:10px; padding:11px 16px; color:var(--e-orange); font-size:0.8rem; display:flex; align-items:center; gap:8px; }

    .btn-green { background:linear-gradient(135deg,var(--e-primary),#4A8A4A); border:none; color:#fff; font-weight:700; border-radius:8px; padding:10px 22px; font-size:0.82rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; }
    .btn-green:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(107,175,107,0.3); color:#fff; }

    .btn-ghost { background:transparent; border:1px solid var(--e-border); color:var(--e-soft); font-weight:600; border-radius:8px; padding:10px 22px; font-size:0.82rem; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none; }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }

    .alert-error { background:var(--e-red-pale); border:1px solid var(--e-red-border); border-radius:10px; padding:11px 16px; color:var(--e-red); font-size:0.82rem; margin-bottom:18px; }
    .alert-error ul { margin:6px 0 0 16px; padding:0; }

    @media (max-width:800px) { .layout { grid-template-columns:1fr; } .two-col { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$restant = $solde ? ($solde['NbJoursDroit_Sld'] - $solde['NbJoursPris_Sld']) : 0;
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-umbrella-beach me-2" style="color:var(--e-primary);"></i>Nouvelle demande de congé</h1>
        <p>Renseignez les détails de votre demande</p>
    </div>
    <a href="<?= base_url('conge') ?>" class="btn-ghost">
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

<div class="layout">

    <!-- Formulaire -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon"><i class="fas fa-umbrella-beach"></i></div>
            <div>
                <p class="form-card-title">Demande de congé</p>
                <p class="form-card-subtitle">Tous les champs * sont obligatoires</p>
            </div>
        </div>

        <form action="<?= base_url('conge/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-card-body">

                <!-- Libellé -->
                <div class="form-group">
                    <label class="form-label">Libellé <span class="req">*</span></label>
                    <input type="text" name="Libelle_Cge" class="form-control"
                           placeholder="Ex : Congé annuel été 2026"
                           value="<?= old('Libelle_Cge') ?>" required>
                </div>

                <!-- Type -->
                <div class="form-group">
                    <label class="form-label">Type de congé <span class="req">*</span></label>
                    <select name="id_Tcg" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($typesConge as $t): ?>
                        <option value="<?= $t['id_Tcg'] ?>"
                            <?= old('id_Tcg') == $t['id_Tcg'] ? 'selected' : '' ?>>
                            <?= esc($t['Libelle_Tcg']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dates -->
                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Date de début <span class="req">*</span></label>
                        <input type="date" name="DateDebut_Cge" id="date-debut"
                               class="form-control"
                               value="<?= old('DateDebut_Cge') ?>"
                               oninput="calcJours()" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date de fin <span class="req">*</span></label>
                        <input type="date" name="DateFin_Cge" id="date-fin"
                               class="form-control"
                               value="<?= old('DateFin_Cge') ?>"
                               oninput="calcJours()" required>
                    </div>
                </div>

                <!-- Compteur jours -->
                <div class="jours-indicator" id="jours-indicator" style="display:none;">
                    <div>
                        <div class="jours-lbl">Durée calculée</div>
                    </div>
                    <div>
                        <span class="jours-val" id="jours-val">0</span>
                        <span style="color:var(--e-muted);font-size:0.75rem;"> jour(s)</span>
                    </div>
                </div>

                <?php if ($restant <= 5 && $solde): ?>
                <div class="alert-warn">
                    <i class="fas fa-exclamation-triangle"></i>
                    Attention — il ne vous reste que <strong><?= $restant ?></strong> jour(s) de congé disponible(s).
                </div>
                <?php endif; ?>

            </div>

            <div class="form-card-footer">
                <a href="<?= base_url('conge') ?>" class="btn-ghost">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" class="btn-green">
                    <i class="fas fa-paper-plane"></i> Soumettre
                </button>
            </div>
        </form>
    </div>

    <!-- Solde sidebar -->
    <div class="solde-card">
        <div class="solde-card-header">
            <div class="card-icon" style="background:var(--e-primary-pale);border-color:var(--e-primary-border);color:var(--e-primary);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <p class="card-title" style="color:#fff;font-size:0.85rem;font-weight:700;margin:0;">
                Mon solde <?= date('Y') ?>
            </p>
        </div>
        <div class="solde-card-body">
            <?php if ($solde): ?>
            <div class="solde-big">
                <div class="solde-big-val"><?= (int) $restant ?></div>
                <div class="solde-big-lbl">Jours disponibles</div>
            </div>
            <div>
                <div class="solde-row">
                    <span class="solde-row-lbl">Jours alloués</span>
                    <span class="solde-row-val"><?= (int) $solde['NbJoursDroit_Sld'] ?></span>
                </div>
                <div class="solde-row">
                    <span class="solde-row-lbl">Jours pris</span>
                    <span class="solde-row-val" style="color:var(--e-orange);"><?= (int) $solde['NbJoursPris_Sld'] ?></span>
                </div>
                <div class="solde-row">
                    <span class="solde-row-lbl">Restants</span>
                    <span class="solde-row-val" style="color:var(--e-primary);"><?= (int) $restant ?></span>
                </div>
            </div>
            <?php else: ?>
            <div style="text-align:center;color:var(--e-muted);font-size:0.8rem;padding:16px;">
                <i class="fas fa-info-circle" style="display:block;margin-bottom:8px;opacity:0.3;font-size:1.5rem;"></i>
                Aucun solde enregistré pour <?= date('Y') ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    window.calcJours = function () {
        var debut = document.getElementById('date-debut').value;
        var fin   = document.getElementById('date-fin').value;
        var ind   = document.getElementById('jours-indicator');
        var val   = document.getElementById('jours-val');

        if (!debut || !fin) { ind.style.display = 'none'; return; }

        var d1 = new Date(debut);
        var d2 = new Date(fin);
        var diff = Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;

        if (diff <= 0) { ind.style.display = 'none'; return; }

        val.textContent    = diff;
        ind.style.display  = 'flex';

        var restant = <?= (int) $restant ?>;
        if (restant > 0 && diff > restant) {
            val.style.color = 'var(--e-red)';
        } else {
            val.style.color = 'var(--e-orange)';
        }

        // Sync min date fin
        document.getElementById('date-fin').min = debut;
    };
})();
</script>
<?= $this->endSection() ?>