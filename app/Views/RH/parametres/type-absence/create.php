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
        background:var(--c-surface); border:1px solid var(--c-border);
        border-radius:14px; overflow:hidden; max-width:480px; margin:0 auto;
    }
    .form-card-header {
        padding:16px 22px; border-bottom:1px solid var(--c-border);
        display:flex; align-items:center; gap:12px;
    }
    .form-card-icon {
        width:38px; height:38px; border-radius:10px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-orange); font-size:0.9rem; flex-shrink:0;
    }
    .form-card-title    { color:#fff; font-size:0.92rem; font-weight:700; margin:0; }
    .form-card-subtitle { color:var(--c-muted); font-size:0.75rem; margin:2px 0 0; }
    .form-card-body { padding:24px; display:flex; flex-direction:column; gap:16px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-label { font-size:0.72rem; font-weight:600; color:var(--c-soft); text-transform:uppercase; letter-spacing:0.5px; }
    .form-label .req { color:var(--c-orange); margin-left:2px; }
    .form-control {
        background:#111; border:1px solid var(--c-border);
        border-radius:8px; color:var(--c-text); font-size:0.85rem;
        padding:11px 14px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif; width:100%;
    }
    .form-control:focus { border-color:var(--c-orange-border); }
    .form-control::placeholder { color:var(--c-muted); }
    .char-counter { font-size:0.68rem; color:var(--c-muted); text-align:right; }
    .char-counter.warn { color:var(--c-orange); }
    .char-counter.over { color:#ff8080; }
    .form-card-footer {
        padding:16px 22px; border-top:1px solid var(--c-border);
        display:flex; align-items:center; justify-content:flex-end; gap:10px;
    }
    .btn-orange {
        background:linear-gradient(135deg,var(--c-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:10px 22px; font-size:0.82rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-orange:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(245,166,35,0.3); color:#111; }
    .btn-ghost {
        background:transparent; border:1px solid var(--c-border);
        color:var(--c-soft); font-weight:600; border-radius:8px;
        padding:10px 22px; font-size:0.82rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--c-text); }
    .alert-error-dark {
        background:var(--c-red-pale); border:1px solid var(--c-red-border);
        border-radius:10px; padding:11px 16px; color:#ff8080;
        font-size:0.82rem; margin-bottom:18px; max-width:480px; margin-left:auto; margin-right:auto;
    }
    .alert-error-dark ul { margin:6px 0 0 16px; padding:0; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-plus me-2" style="color:#F5A623;"></i>Nouveau type d'absence</h1>
        <p>Ajouter un type d'absence au référentiel</p>
    </div>
    <a href="<?= base_url('parametres/type-absence') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-error-dark">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Erreur
    </div>
    <?php $errs = session()->getFlashdata('errors') ?: [session()->getFlashdata('error')]; ?>
    <ul><?php foreach ((array)$errs as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-tags"></i></div>
        <div>
            <p class="form-card-title">Informations du type</p>
            <p class="form-card-subtitle">Le libellé doit être unique</p>
        </div>
    </div>

    <form action="<?= base_url('parametres/type-absence/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="form-card-body">
            <div class="form-group">
                <label class="form-label">Libellé <span class="req">*</span></label>
                <input type="text" name="Libelle_TAbs" id="f-libelle"
                       class="form-control" maxlength="100"
                       placeholder="Ex : Absence maladie, Absence injustifiée..."
                       value="<?= old('Libelle_TAbs') ?>"
                       oninput="updateCounter()"
                       autocomplete="off">
                <div class="char-counter" id="char-counter">0 / 100</div>
            </div>
        </div>
        <div class="form-card-footer">
            <a href="<?= base_url('parametres/type-absence') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-orange">
                <i class="fas fa-save"></i> Créer le type
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var input = document.getElementById('f-libelle');
    var counter = document.getElementById('char-counter');
    window.updateCounter = function () {
        var n = input.value.length;
        counter.textContent = n + ' / 100';
        counter.className = 'char-counter' + (n > 80 ? ' warn' : '') + (n >= 100 ? ' over' : '');
    };
    updateCounter();
    input.focus();
})();
</script>
<?= $this->endSection() ?>  
