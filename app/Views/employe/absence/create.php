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

    .form-card {
        background:var(--e-surface); border:1px solid var(--e-border);
        border-radius:14px; overflow:hidden; max-width:680px; margin:0 auto;
    }
    .form-card-header {
        padding:16px 22px; border-bottom:1px solid var(--e-border);
        display:flex; align-items:center; gap:12px;
    }
    .form-card-icon {
        width:38px; height:38px; border-radius:10px;
        background:var(--e-primary-pale); border:1px solid var(--e-primary-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--e-primary); font-size:0.9rem; flex-shrink:0;
    }
    .form-card-title    { color:#fff; font-size:0.92rem; font-weight:700; margin:0; }
    .form-card-subtitle { color:var(--e-muted); font-size:0.75rem; margin:2px 0 0; }
    .form-card-body     { padding:24px; display:flex; flex-direction:column; gap:18px; }
    .form-card-footer {
        padding:16px 22px; border-top:1px solid var(--e-border);
        display:flex; align-items:center; justify-content:flex-end; gap:10px;
    }

    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-label {
        font-size:0.72rem; font-weight:600; color:var(--e-soft);
        text-transform:uppercase; letter-spacing:0.5px;
    }
    .form-label .req { color:var(--e-orange); margin-left:2px; }

    .form-control {
        background:#111; border:1px solid var(--e-border);
        border-radius:8px; color:var(--e-text); font-size:0.85rem;
        padding:10px 14px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif; width:100%;
    }
    .form-control:focus { border-color:var(--e-primary-border); }
    .form-control::placeholder { color:var(--e-muted); }

    textarea.form-control { resize:vertical; min-height:90px; }

    .form-hint { font-size:0.7rem; color:var(--e-muted); margin-top:2px; }

    .btn-green {
        background:linear-gradient(135deg,var(--e-primary),#4A8A4A);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:10px 22px; font-size:0.82rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-green:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(107,175,107,0.3); color:#fff; }

    .btn-ghost {
        background:transparent; border:1px solid var(--e-border);
        color:var(--e-soft); font-weight:600; border-radius:8px;
        padding:10px 22px; font-size:0.82rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--e-text); }

    .alert-error {
        background:var(--e-red-pale); border:1px solid var(--e-red-border);
        border-radius:10px; padding:11px 16px; color:var(--e-red);
        font-size:0.82rem; margin-bottom:18px; max-width:680px; margin-left:auto; margin-right:auto;
    }
    .alert-error ul { margin:6px 0 0 16px; padding:0; }

    @media (max-width:600px) { .two-col { grid-template-columns:1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-clock me-2" style="color:var(--e-primary);"></i>Déclarer une absence</h1>
        <p>Renseignez les informations de votre absence</p>
    </div>
    <a href="<?= base_url('absence') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert-error">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Veuillez corriger les erreurs
    </div>
    <ul>
        <?php foreach ((array)session()->getFlashdata('errors') as $e): ?>
        <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error">
    <i class="fas fa-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-user-clock"></i></div>
        <div>
            <p class="form-card-title">Nouvelle déclaration</p>
            <p class="form-card-subtitle">Tous les champs marqués * sont obligatoires</p>
        </div>
    </div>

    <form action="<?= base_url('absence/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <!-- Type absence -->
            <div class="form-group">
                <label class="form-label">Type d'absence <span class="req">*</span></label>
                <select name="id_TAbs" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($typesAbsence as $t): ?>
                    <option value="<?= $t['id_TAbs'] ?>"
                        <?= old('id_TAbs') == $t['id_TAbs'] ? 'selected' : '' ?>>
                        <?= esc($t['Libelle_TAbs']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dates -->
            <div class="two-col">
                <div class="form-group">
                    <label class="form-label">Date de début <span class="req">*</span></label>
                    <input type="date" name="DateDebut_Abs" class="form-control"
       value="<?= old('DateDebut_Abs') ?>"
       required>
                </div>
                <div class="form-group">
                    <label class="form-label">Date de fin</label>
                    <input type="date" name="DateFin_Abs" class="form-control"
                           value="<?= old('DateFin_Abs') ?>"
                           id="date-fin">
                    <span class="form-hint">Laisser vide si absence d'une journée</span>
                </div>
            </div>

            <!-- Motif -->
            <div class="form-group">
                <label class="form-label">Motif <span class="req">*</span></label>
                <textarea name="Motif_Abs" class="form-control"
                          placeholder="Décrivez brièvement le motif de votre absence..."
                          required><?= old('Motif_Abs') ?></textarea>
            </div>

            <!-- Rapport -->
            <div class="form-group">
                <label class="form-label">Rapport / Observations</label>
                <textarea name="Rapport_Abs" class="form-control"
                          placeholder="Informations complémentaires (optionnel)..."><?= old('Rapport_Abs') ?></textarea>
                <span class="form-hint">Champ optionnel — à remplir après retour si nécessaire</span>
            </div>

        </div>

        <div class="form-card-footer">
            <a href="<?= base_url('absence') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-green">
                <i class="fas fa-paper-plane"></i> Déclarer
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var debut = document.querySelector('[name="DateDebut_Abs"]');
    var fin   = document.getElementById('date-fin');

    if (debut && fin) {
        debut.addEventListener('change', function () {
            fin.min = this.value;
            if (fin.value && fin.value < this.value) fin.value = '';
        });
    }
})();
</script>
<?= $this->endSection() ?>