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

    .field-hint { font-size:0.7rem; color:var(--c-muted); }

    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

    /* Preview */
    .preview-box {
        background:#111; border:1px solid var(--c-border);
        border-radius:10px; padding:14px 16px;
    }

    .preview-box-label {
        font-size:0.65rem; font-weight:600; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;
    }

    .preview-desc { color:#fff; font-size:0.85rem; font-weight:600; margin-bottom:6px; }
    .preview-meta { display:flex; gap:8px; flex-wrap:wrap; }

    .preview-badge {
        display:inline-flex; align-items:center; gap:5px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        border-radius:7px; padding:3px 10px; font-size:0.72rem;
        color:var(--c-orange); font-weight:600;
    }

    /* Alerts */
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

<div class="page-header">
    <div>
        <h1><i class="fas fa-plus me-2" style="color:#F5A623;"></i>Nouvel événement</h1>
        <p>Créer un événement interne</p>
    </div>
    <a href="<?= base_url('evenement') ?>" class="btn-ghost">
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
        <?php foreach ((array)$errs as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-calendar-plus"></i></div>
        <div>
            <p class="form-card-title">Informations de l'événement</p>
            <p class="form-card-subtitle">Tous les champs marqués * sont obligatoires</p>
        </div>
    </div>

    <form action="<?= base_url('evenement/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <div class="form-group">
                <label class="form-label">Description <span class="req">*</span></label>
                <input type="text" name="Description_Evt" id="f-desc"
                       class="form-control" maxlength="255"
                       placeholder="Ex : Réunion bilan annuel, Journée portes ouvertes..."
                       value="<?= old('Description_Evt') ?>"
                       oninput="updatePreview(); updateCounter();"
                       autocomplete="off">
                <div class="char-counter" id="char-counter">0 / 255</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Type d'événement <span class="req">*</span></label>
                    <select name="id_Tev" id="f-type" class="form-control" onchange="updatePreview()">
                        <option value="">— Choisir un type —</option>
                        <?php foreach ($typesEvenement as $t): ?>
                        <option value="<?= $t['id_Tev'] ?>"
                                data-label="<?= esc($t['Libelle_Tev']) ?>"
                                <?= old('id_Tev') == $t['id_Tev'] ? 'selected' : '' ?>>
                            <?= esc($t['Libelle_Tev']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Date de l'événement <span class="req">*</span></label>
                    <input type="date" name="Date_Evt" id="f-date" class="form-control"
                           value="<?= old('Date_Evt', date('Y-m-d')) ?>"
                           onchange="updatePreview()">
                </div>
            </div>

            <!-- Aperçu -->
            <div class="preview-box">
                <div class="preview-box-label">Aperçu</div>
                <div class="preview-desc" id="preview-desc" style="color:var(--c-muted);font-style:italic;">
                    La description apparaîtra ici...
                </div>
                <div class="preview-meta">
                    <span class="preview-badge" id="preview-type" style="display:none;">
                        <i class="fas fa-tag"></i> <span id="preview-type-text"></span>
                    </span>
                    <span class="preview-badge" id="preview-date" style="display:none;">
                        <i class="fas fa-calendar"></i> <span id="preview-date-text"></span>
                    </span>
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="<?= base_url('evenement') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-orange" id="btn-submit">
                <i class="fas fa-save"></i> Créer l'événement
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {
    var descInput = document.getElementById('f-desc');
    var typeInput = document.getElementById('f-type');
    var dateInput = document.getElementById('f-date');
    var counter   = document.getElementById('char-counter');

    window.updatePreview = function () {
        var desc = descInput.value.trim();
        var typeOpt = typeInput.options[typeInput.selectedIndex];
        var typeLabel = typeOpt && typeOpt.value ? typeOpt.getAttribute('data-label') : '';
        var date = dateInput.value;

        // Description
        var previewDesc = document.getElementById('preview-desc');
        if (desc) {
            previewDesc.textContent  = desc;
            previewDesc.style.color  = '#fff';
            previewDesc.style.fontStyle = 'normal';
        } else {
            previewDesc.textContent  = 'La description apparaîtra ici...';
            previewDesc.style.color  = 'var(--c-muted)';
            previewDesc.style.fontStyle = 'italic';
        }

        // Type
        var previewType = document.getElementById('preview-type');
        if (typeLabel) {
            document.getElementById('preview-type-text').textContent = typeLabel;
            previewType.style.display = '';
        } else {
            previewType.style.display = 'none';
        }

        // Date
        var previewDate = document.getElementById('preview-date');
        if (date) {
            var d = new Date(date + 'T00:00:00');
            document.getElementById('preview-date-text').textContent =
                d.toLocaleDateString('fr-FR', { day:'2-digit', month:'long', year:'numeric' });
            previewDate.style.display = '';
        } else {
            previewDate.style.display = 'none';
        }
    };

    window.updateCounter = function () {
        var n = descInput.value.length;
        counter.textContent  = n + ' / 255';
        counter.className    = 'char-counter' + (n > 230 ? ' warn' : '') + (n >= 255 ? ' over' : '');
    };

    // Init
    updatePreview();
    updateCounter();
})();
</script>
<?= $this->endSection() ?>