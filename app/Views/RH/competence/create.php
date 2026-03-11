<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-orange:        #F5A623;
        --c-orange-pale:   rgba(245,166,35,0.10);
        --c-orange-border: rgba(245,166,35,0.25);
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
        border-radius: 14px; overflow: hidden; max-width: 540px; margin: 0 auto;
    }

    .form-card-header {
        padding: 16px 22px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 12px;
    }

    .form-card-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.9rem; flex-shrink: 0;
    }

    .form-card-title    { color: #fff; font-size: 0.92rem; font-weight: 700; margin: 0; }
    .form-card-subtitle { color: var(--c-muted); font-size: 0.75rem; margin: 2px 0 0; }

    .form-card-body { padding: 24px; }

    .form-group { display: flex; flex-direction: column; margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-label {
        font-size: 0.72rem; font-weight: 600; color: var(--c-soft);
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 7px;
    }

    .form-label .req { color: var(--c-orange); margin-left: 2px; }

    .form-control {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.85rem;
        padding: 11px 14px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }

    .form-control:focus { border-color: var(--c-orange-border); }
    .form-control::placeholder { color: var(--c-muted); }

    .field-hint { font-size: 0.7rem; color: var(--c-muted); margin-top: 5px; }

    .char-counter {
        font-size: 0.68rem; color: var(--c-muted); margin-top: 4px;
        text-align: right; transition: color 0.2s;
    }

    .char-counter.warn { color: var(--c-orange); }
    .char-counter.over { color: #ff8080; }

    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; margin-bottom: 18px;
    }

    .alert-error-dark ul { margin: 6px 0 0 16px; padding: 0; }

    .form-footer {
        padding: 16px 22px; border-top: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    }

    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 10px 22px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 10px 22px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    /* Preview badge */
    .preview-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        border-radius: 8px; padding: 8px 14px; margin-top: 10px;
        font-size: 0.8rem; color: var(--c-orange); font-weight: 600;
        transition: all 0.2s; max-width: 100%;
    }

    .preview-label { font-size: 0.68rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-plus me-2" style="color:#F5A623;"></i>Nouvelle compétence</h1>
        <p>Ajouter une compétence au référentiel</p>
    </div>
    <a href="<?= base_url('competence') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-error-dark" style="max-width:540px;margin:0 auto 18px;">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Erreur
    </div>
    <?php $errs = session()->getFlashdata('errors') ?: [session()->getFlashdata('error')]; ?>
    <ul>
        <?php foreach ((array)$errs as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-star"></i></div>
        <div>
            <p class="form-card-title">Référentiel des compétences</p>
            <p class="form-card-subtitle">Le libellé doit être unique dans le référentiel</p>
        </div>
    </div>

    <form action="<?= base_url('competence/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">
            <div class="form-group">
                <label class="form-label">
                    Libellé de la compétence <span class="req">*</span>
                </label>
                <input type="text" name="Libelle_Cmp" id="libelle-input"
                       class="form-control" maxlength="150"
                       placeholder="Ex : Analyse de données statistiques"
                       value="<?= old('Libelle_Cmp') ?>"
                       oninput="updatePreview(); updateCounter();"
                       autocomplete="off">
                <div class="char-counter" id="char-counter">0 / 150</div>
                <span class="field-hint">
                    Entre 2 et 150 caractères. La première lettre sera mise en majuscule automatiquement.
                </span>
            </div>

            <div>
                <div class="preview-label">Aperçu</div>
                <div class="preview-badge" id="preview-badge">
                    <i class="fas fa-star"></i>
                    <span id="preview-text" style="color:var(--c-muted);font-style:italic;">
                        Le libellé apparaîtra ici...
                    </span>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="<?= base_url('competence') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-orange" id="btn-submit" disabled>
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var input   = document.getElementById('libelle-input');
    var preview = document.getElementById('preview-text');
    var counter = document.getElementById('char-counter');
    var btn     = document.getElementById('btn-submit');

    window.updatePreview = function () {
        var val = input.value.trim();
        if (val.length > 0) {
            var display = val.charAt(0).toUpperCase() + val.slice(1);
            preview.textContent = display;
            preview.style.color = 'var(--c-orange)';
            preview.style.fontStyle = 'normal';
        } else {
            preview.textContent = 'Le libellé apparaîtra ici...';
            preview.style.color = 'var(--c-muted)';
            preview.style.fontStyle = 'italic';
        }
        btn.disabled = val.length < 2;
    };

    window.updateCounter = function () {
        var n = input.value.length;
        counter.textContent = n + ' / 150';
        counter.className = 'char-counter' + (n > 140 ? ' warn' : '') + (n >= 150 ? ' over' : '');
    };

    // Init si old() présent
    if (input.value) { updatePreview(); updateCounter(); }
})();
</script>
<?= $this->endSection() ?>