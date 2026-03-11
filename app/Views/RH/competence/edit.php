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
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
    }

    .form-card-header-left { display: flex; align-items: center; gap: 12px; }

    .form-card-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.9rem; flex-shrink: 0;
    }

    .form-card-title    { color: #fff; font-size: 0.92rem; font-weight: 700; margin: 0; }
    .form-card-subtitle { color: var(--c-muted); font-size: 0.75rem; margin: 2px 0 0; }

    .badge-id {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-size: 0.7rem; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
    }

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

    .current-val {
        background: rgba(255,255,255,0.03); border: 1px solid var(--c-border);
        border-radius: 8px; padding: 10px 14px; margin-bottom: 16px;
        font-size: 0.78rem; color: var(--c-muted);
    }

    .current-val span { color: var(--c-soft); font-weight: 600; }

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

    .preview-label { font-size: 0.68rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }

    .preview-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        border-radius: 8px; padding: 8px 14px; margin-top: 10px;
        font-size: 0.8rem; color: var(--c-orange); font-weight: 600;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $c = $competence; ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-pen me-2" style="color:#F5A623;"></i>Modifier la compétence</h1>
        <p><?= esc($c['Libelle_Cmp']) ?></p>
    </div>
    <a href="<?= base_url('competence/show/' . $c['id_Cmp']) ?>" class="btn-ghost">
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
        <div class="form-card-header-left">
            <div class="form-card-icon"><i class="fas fa-pen"></i></div>
            <div>
                <p class="form-card-title">Modifier le libellé</p>
                <p class="form-card-subtitle">Le libellé doit rester unique dans le référentiel</p>
            </div>
        </div>
        <span class="badge-id"># <?= (int)$c['id_Cmp'] ?></span>
    </div>

    <form action="<?= base_url('competence/update/' . $c['id_Cmp']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <div class="current-val">
                <i class="fas fa-history" style="color:var(--c-orange);margin-right:6px;"></i>
                Valeur actuelle : <span><?= esc($c['Libelle_Cmp']) ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">
                    Nouveau libellé <span class="req">*</span>
                </label>
                <input type="text" name="Libelle_Cmp" id="libelle-input"
                       class="form-control" maxlength="150"
                       value="<?= old('Libelle_Cmp', esc($c['Libelle_Cmp'])) ?>"
                       oninput="updatePreview(); updateCounter();"
                       autocomplete="off">
                <div class="char-counter" id="char-counter">0 / 150</div>
                <span class="field-hint">Entre 2 et 150 caractères.</span>
            </div>

            <div>
                <div class="preview-label">Aperçu</div>
                <div class="preview-badge">
                    <i class="fas fa-star"></i>
                    <span id="preview-text"></span>
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="<?= base_url('competence/show/' . $c['id_Cmp']) ?>" class="btn-ghost">
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
    var input   = document.getElementById('libelle-input');
    var preview = document.getElementById('preview-text');
    var counter = document.getElementById('char-counter');

    window.updatePreview = function () {
        var val = input.value.trim();
        preview.textContent = val.length > 0
            ? val.charAt(0).toUpperCase() + val.slice(1)
            : '';
    };

    window.updateCounter = function () {
        var n = input.value.length;
        counter.textContent = n + ' / 150';
        counter.className = 'char-counter' + (n > 140 ? ' warn' : '') + (n >= 150 ? ' over' : '');
    };

    updatePreview();
    updateCounter();
})();
</script>
<?= $this->endSection() ?>