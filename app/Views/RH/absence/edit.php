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
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .form-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; padding: 28px 30px; margin-bottom: 16px;
    }

    .form-card-title {
        font-size: 0.78rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 18px; padding-bottom: 10px;
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
    }

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group  { display: flex; flex-direction: column; gap: 5px; }

    .form-label {
        font-size: 0.72rem; font-weight: 600; color: var(--c-soft);
        text-transform: uppercase; letter-spacing: 0.5px;
    }

    .form-label .req { color: var(--c-orange); margin-left: 2px; }

    .form-control-dark,
    .form-select-dark,
    .form-textarea-dark {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.82rem;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }

    .form-control-dark,
    .form-select-dark { padding: 9px 12px; height: 40px; }

    .form-textarea-dark { padding: 10px 12px; resize: vertical; min-height: 90px; height: auto; }

    .form-control-dark:focus,
    .form-select-dark:focus,
    .form-textarea-dark:focus {
        border-color: var(--c-orange-border);
        box-shadow: 0 0 0 3px rgba(245,166,35,0.08);
    }

    .form-control-dark::placeholder,
    .form-textarea-dark::placeholder { color: var(--c-muted); }
    .form-select-dark option { background: #1a1a1a; }

    .form-hint   { font-size: 0.68rem; color: var(--c-muted); margin-top: 2px; }

    .field-error {
        font-size: 0.7rem; color: #ff8080; margin-top: 2px;
        display: flex; align-items: center; gap: 4px;
    }

    .form-control-dark.is-invalid,
    .form-select-dark.is-invalid { border-color: rgba(224,82,82,0.5); }

    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 12px 16px; color: #ff8080;
        font-size: 0.82rem; margin-bottom: 16px;
    }

    .alert-error-dark ul { margin: 6px 0 0 0; padding-left: 18px; }
    .alert-error-dark li { margin-bottom: 2px; font-size: 0.78rem; }

    /* Info lecture seule */
    .readonly-field {
        background: rgba(255,255,255,0.02); border: 1px solid var(--c-border);
        border-radius: 8px; padding: 9px 12px; height: 40px;
        color: var(--c-muted); font-size: 0.82rem;
        display: flex; align-items: center;
    }

    .info-banner {
        background: rgba(245,166,35,0.06); border: 1px solid var(--c-orange-border);
        border-radius: 10px; padding: 11px 16px; margin-bottom: 16px;
        font-size: 0.8rem; color: var(--c-orange);
        display: flex; align-items: center; gap: 10px;
    }

    /* Durée */
    .duree-preview {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        border-radius: 8px; padding: 8px 14px;
        display: none; align-items: center; gap: 8px;
        font-size: 0.8rem; color: var(--c-orange); font-weight: 600; margin-top: 8px;
    }

    .duree-preview.visible { display: inline-flex; }

    /* Boutons */
    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 10px 22px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 10px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .form-actions { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding-top: 8px; }

    @media (max-width: 768px) { .form-grid-2 { grid-template-columns: 1fr; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$a   = $absence;
$old = fn($k, $d = '') => old($k, $d ?? $a[$k] ?? '');
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-edit me-2" style="color:#F5A623;"></i>Modifier l'absence</h1>
        <p>Déclaration du <?= date('d/m/Y', strtotime($a['DateDemande_Abs'])) ?></p>
    </div>
    <a href="<?= base_url('absence/show/' . $a['id_Abs']) ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="info-banner">
    <i class="fas fa-info-circle"></i>
    Seules les absences <strong>en attente</strong> peuvent être modifiées.
    Une fois traitée par le RH, cette action n'est plus disponible.
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert-error-dark">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Veuillez corriger les erreurs :</strong>
    <ul>
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="<?= base_url('absence/update/' . $a['id_Abs']) ?>" method="POST">
    <?= csrf_field() ?>

    <!-- Carte 1 : Identité (lecture seule) -->
    <div class="form-card">
        <div class="form-card-title">
            <i class="fas fa-user"></i> Demandeur
        </div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Employé</label>
                <div class="readonly-field">
                    <i class="fas fa-lock" style="font-size:0.65rem;margin-right:8px;color:var(--c-muted);"></i>
                    <?= esc(session()->get('prenom') . ' ' . session()->get('nom')) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Date de déclaration</label>
                <div class="readonly-field">
                    <i class="fas fa-lock" style="font-size:0.65rem;margin-right:8px;color:var(--c-muted);"></i>
                    <?= date('d/m/Y', strtotime($a['DateDemande_Abs'])) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte 2 : Informations -->
    <div class="form-card">
        <div class="form-card-title">
            <i class="fas fa-info-circle"></i> Informations de l'absence
        </div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Type d'absence <span class="req">*</span></label>
                <select name="id_TAbs" class="form-select-dark">
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($typesAbsence as $ta): ?>
                    <option value="<?= $ta['id_TAbs'] ?>"
                        <?= (old('id_TAbs', $a['id_TAbs']) == $ta['id_TAbs']) ? 'selected' : '' ?>>
                        <?= esc($ta['Libelle_TAbs']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div></div>

            <div class="form-group">
                <label class="form-label">Date de début <span class="req">*</span></label>
                <input type="date" name="DateDebut_Abs" class="form-control-dark"
                       id="date-debut"
                       value="<?= old('DateDebut_Abs', $a['DateDebut_Abs']) ?>"
                       onchange="calcDuree()">
            </div>

            <div class="form-group">
                <label class="form-label">Date de fin</label>
                <input type="date" name="DateFin_Abs" class="form-control-dark"
                       id="date-fin"
                       value="<?= old('DateFin_Abs', $a['DateFin_Abs'] ?? '') ?>"
                       onchange="calcDuree()">
                <div class="form-hint">Laisser vide si durée inconnue.</div>
                <div class="duree-preview" id="duree-preview">
                    <i class="fas fa-calendar-check"></i>
                    <span id="duree-texte"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte 3 : Motif -->
    <div class="form-card">
        <div class="form-card-title">
            <i class="fas fa-file-alt"></i> Motif et rapport
        </div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Motif</label>
                <input type="text" name="Motif_Abs" class="form-control-dark"
                       placeholder="Motif court"
                       value="<?= esc(old('Motif_Abs', $a['Motif_Abs'] ?? '')) ?>"
                       maxlength="255">
            </div>
            <div class="form-group">
                <label class="form-label">Rapport / Détails</label>
                <textarea name="Rapport_Abs" class="form-textarea-dark"
                          placeholder="Détails supplémentaires..."><?= esc(old('Rapport_Abs', $a['Rapport_Abs'] ?? '')) ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="<?= base_url('absence/show/' . $a['id_Abs']) ?>" class="btn-ghost">
            <i class="fas fa-times"></i> Annuler
        </a>
        <button type="submit" class="btn-orange">
            <i class="fas fa-save"></i> Enregistrer les modifications
        </button>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    window.calcDuree = function () {
        var debut   = document.getElementById('date-debut').value;
        var fin     = document.getElementById('date-fin').value;
        var preview = document.getElementById('duree-preview');
        var texte   = document.getElementById('duree-texte');

        if (debut && fin) {
            var d1 = new Date(debut), d2 = new Date(fin);
            if (d2 >= d1) {
                var j = Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
                texte.textContent = j + ' jour' + (j > 1 ? 's' : '');
                preview.classList.add('visible');
                return;
            }
        }
        preview.classList.remove('visible');
    };

    calcDuree();
})();
</script>
<?= $this->endSection() ?>