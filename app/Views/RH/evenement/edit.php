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
        background:var(--c-surface); border:1px solid var(--c-border);
        border-radius:14px; overflow:hidden; max-width:560px; margin:0 auto;
    }

    .form-card-header {
        padding:16px 22px; border-bottom:1px solid var(--c-border);
        display:flex; align-items:center; justify-content:space-between; gap:12px;
    }

    .form-card-header-left { display:flex; align-items:center; gap:12px; }

    .form-card-icon {
        width:38px; height:38px; border-radius:10px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-orange); font-size:0.9rem; flex-shrink:0;
    }

    .form-card-title    { color:#fff; font-size:0.92rem; font-weight:700; margin:0; }
    .form-card-subtitle { color:var(--c-muted); font-size:0.75rem; margin:2px 0 0; }

    .badge-id {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.7rem; font-weight:700;
        padding:3px 10px; border-radius:20px;
    }

    .form-card-body { padding:24px; display:flex; flex-direction:column; gap:18px; }

    .form-group { display:flex; flex-direction:column; gap:6px; }

    .form-label {
        font-size:0.72rem; font-weight:600; color:var(--c-soft);
        text-transform:uppercase; letter-spacing:0.5px;
    }

    .form-label .req { color:var(--c-orange); margin-left:2px; }

    .form-control {
        background:#111; border:1px solid var(--c-border);
        border-radius:8px; color:var(--c-text); font-size:0.85rem;
        padding:11px 14px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif; width:100%;
    }

    .form-control:focus { border-color:var(--c-orange-border); }
    .form-control::placeholder { color:var(--c-muted); }
    .form-control option { background:#1a1a1a; }

    .char-counter {
        font-size:0.68rem; color:var(--c-muted); text-align:right; transition:color 0.2s;
    }

    .char-counter.warn { color:var(--c-orange); }
    .char-counter.over { color:#ff8080; }

    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

    .current-val {
        background:rgba(255,255,255,0.03); border:1px solid var(--c-border);
        border-radius:8px; padding:10px 14px; font-size:0.78rem; color:var(--c-muted);
    }

    .current-val span { color:var(--c-soft); font-weight:600; }

    .alert-error-dark {
        background:var(--c-red-pale); border:1px solid var(--c-red-border);
        border-radius:10px; padding:11px 16px; color:#ff8080;
        font-size:0.82rem; margin-bottom:18px; max-width:560px; margin-left:auto; margin-right:auto;
    }

    .alert-error-dark ul { margin:6px 0 0 16px; padding:0; }

    .form-footer {
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $e = $evenement; ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-pen me-2" style="color:#F5A623;"></i>Modifier l'événement</h1>
        <p><?= esc($e['Description_Evt']) ?></p>
    </div>
    <a href="<?= base_url('evenement/show/' . $e['id_Evt']) ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-error-dark">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Erreur
    </div>
    <?php $errs = session()->getFlashdata('errors') ?: [session()->getFlashdata('error')]; ?>
    <ul>
        <?php foreach ((array)$errs as $e2): ?><li><?= esc($e2) ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-header-left">
            <div class="form-card-icon"><i class="fas fa-pen"></i></div>
            <div>
                <p class="form-card-title">Modifier les informations</p>
                <p class="form-card-subtitle">Événement ID # <?= (int)$e['id_Evt'] ?></p>
            </div>
        </div>
        <span class="badge-id"># <?= (int)$e['id_Evt'] ?></span>
    </div>

    <form action="<?= base_url('evenement/update/' . $e['id_Evt']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <div class="current-val">
                <i class="fas fa-history" style="color:var(--c-orange);margin-right:6px;"></i>
                Valeur actuelle :
                <span><?= esc($e['Description_Evt']) ?></span>
                · <span><?= date('d/m/Y', strtotime($e['Date_Evt'])) ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">Description <span class="req">*</span></label>
                <input type="text" name="Description_Evt" id="f-desc"
                       class="form-control" maxlength="255"
                       value="<?= old('Description_Evt', esc($e['Description_Evt'])) ?>"
                       oninput="updateCounter()" autocomplete="off">
                <div class="char-counter" id="char-counter">0 / 255</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Type d'événement <span class="req">*</span></label>
                    <select name="id_Tev" class="form-control">
                        <option value="">— Choisir —</option>
                        <?php foreach ($typesEvenement as $t): ?>
                        <option value="<?= $t['id_Tev'] ?>"
                                <?= old('id_Tev', $e['id_Tev']) == $t['id_Tev'] ? 'selected' : '' ?>>
                            <?= esc($t['Libelle_Tev']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Date de l'événement <span class="req">*</span></label>
                    <input type="date" name="Date_Evt" class="form-control"
                           value="<?= old('Date_Evt', $e['Date_Evt']) ?>">
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="<?= base_url('evenement/show/' . $e['id_Evt']) ?>" class="btn-ghost">
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
    var descInput = document.getElementById('f-desc');
    var counter   = document.getElementById('char-counter');

    window.updateCounter = function () {
        var n = descInput.value.length;
        counter.textContent = n + ' / 255';
        counter.className   = 'char-counter' + (n > 230 ? ' warn' : '') + (n >= 255 ? ' over' : '');
    };

    updateCounter();
})();
</script>
<?= $this->endSection() ?>