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
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        overflow: hidden;
        max-width: 780px;
        margin: 0 auto;
    }

    .form-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 12px;
    }

    .form-card-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.9rem; flex-shrink: 0;
    }

    .form-card-title  { color: #fff; font-size: 0.92rem; font-weight: 700; margin: 0; }
    .form-card-subtitle { color: var(--c-muted); font-size: 0.75rem; margin: 2px 0 0; }

    .form-card-body { padding: 22px; }

    .form-section {
        border: 1px solid var(--c-border);
        border-radius: 10px; margin-bottom: 18px; overflow: hidden;
    }

    .form-section-head {
        padding: 10px 16px;
        background: rgba(245,166,35,0.04);
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
        color: var(--c-orange); font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.6px;
    }

    .form-section-body { padding: 18px 16px; }

    .form-row {
        display: grid; gap: 14px; margin-bottom: 14px;
    }

    .form-row-2 { grid-template-columns: 1fr 1fr; }
    .form-row-3 { grid-template-columns: 1fr 1fr 1fr; }
    .form-row:last-child { margin-bottom: 0; }

    .form-group { display: flex; flex-direction: column; }

    .form-label {
        font-size: 0.72rem; font-weight: 600; color: var(--c-soft);
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;
    }

    .form-label .req { color: var(--c-orange); margin-left: 2px; }

    .form-control {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.82rem;
        padding: 9px 12px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }

    .form-control:focus  { border-color: var(--c-orange-border); }
    .form-control.error  { border-color: var(--c-red-border); }
    .form-control::placeholder { color: var(--c-muted); }
    .form-control option { background: #1a1a1a; }

    textarea.form-control { resize: vertical; min-height: 90px; }

    .field-error {
        font-size: 0.7rem; color: #ff8080; margin-top: 4px;
        display: flex; align-items: center; gap: 4px;
    }

    .field-hint {
        font-size: 0.7rem; color: var(--c-muted); margin-top: 4px;
    }

    /* Capacité options */
    .cap-options { display: flex; gap: 10px; margin-bottom: 12px; }

    .cap-opt {
        flex: 1; border: 1px solid var(--c-border); border-radius: 8px;
        padding: 10px 14px; cursor: pointer; transition: all 0.2s;
        display: flex; align-items: center; gap: 10px;
        background: #111;
    }

    .cap-opt:hover { border-color: var(--c-orange-border); }

    .cap-opt.selected {
        border-color: var(--c-orange-border);
        background: var(--c-orange-pale);
    }

    .cap-opt input[type="radio"] { display: none; }

    .cap-opt-icon {
        width: 30px; height: 30px; border-radius: 7px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.75rem; flex-shrink: 0;
    }

    .cap-opt-label { font-size: 0.8rem; color: var(--c-soft); font-weight: 600; }
    .cap-opt-desc  { font-size: 0.68rem; color: var(--c-muted); margin-top: 1px; }
    .cap-opt.selected .cap-opt-label { color: var(--c-orange); }

    .cap-detail { display: none; }
    .cap-detail.visible { display: block; }

    /* Boutons */
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

    .form-footer {
        padding: 16px 22px; border-top: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    }

    /* Alerts */
    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; margin-bottom: 18px;
    }

    .alert-error-dark ul { margin: 6px 0 0 16px; padding: 0; }
    .alert-error-dark li { margin-bottom: 3px; }

    @media (max-width: 640px) {
        .form-row-2 { grid-template-columns: 1fr; }
        .form-row-3 { grid-template-columns: 1fr; }
        .cap-options { flex-direction: column; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chalkboard-teacher me-2" style="color:#F5A623;"></i>Nouvelle formation</h1>
        <p>Ajouter une formation au catalogue</p>
    </div>
    <a href="<?= base_url('formation') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-error-dark" style="max-width:780px;margin:0 auto 18px;">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Erreurs de saisie
    </div>
    <?php $errs = session()->getFlashdata('errors') ?: [session()->getFlashdata('error')]; ?>
    <ul>
        <?php foreach ($errs as $e): ?>
        <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-graduation-cap"></i></div>
        <div>
            <p class="form-card-title">Informations de la formation</p>
            <p class="form-card-subtitle">Tous les champs marqués <span style="color:var(--c-orange);">*</span> sont obligatoires</p>
        </div>
    </div>

    <form action="<?= base_url('formation/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <!-- Section infos générales -->
            <div class="form-section">
                <div class="form-section-head">
                    <i class="fas fa-info-circle"></i> Informations générales
                </div>
                <div class="form-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Description <span class="req">*</span></label>
                            <textarea name="Description_Frm" class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['Description_Frm']) ? 'error' : '' ?>"
                                      placeholder="Ex : Formation en analyse de données statistiques..."
                                      rows="3"><?= old('Description_Frm') ?></textarea>
                            <span class="field-hint">Décrivez brièvement l'objet et les objectifs de la formation.</span>
                        </div>
                    </div>
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Lieu <span class="req">*</span></label>
                            <input type="text" name="Lieu_Frm" class="form-control"
                                   placeholder="Ex : Salle de conférence A, ANSTAT..."
                                   value="<?= old('Lieu_Frm') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Formateur <span class="req">*</span></label>
                            <input type="text" name="Formateur_Frm" class="form-control"
                                   placeholder="Ex : M. Koné Amadou"
                                   value="<?= old('Formateur_Frm') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section dates -->
            <div class="form-section">
                <div class="form-section-head">
                    <i class="fas fa-calendar-alt"></i> Dates
                </div>
                <div class="form-section-body">
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Date de début <span class="req">*</span></label>
                            <input type="date" name="DateDebut_Frm" class="form-control"
                                   value="<?= old('DateDebut_Frm') ?>" id="date-debut">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date de fin <span class="req">*</span></label>
                            <input type="date" name="DateFin_Frm" class="form-control"
                                   value="<?= old('DateFin_Frm') ?>" id="date-fin">
                            <span class="field-error" id="date-error" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i>
                                La date de fin doit être après la date de début.
                            </span>
                        </div>
                    </div>
                    <div id="duree-info" class="field-hint" style="display:none;">
                        <i class="fas fa-clock" style="color:var(--c-orange);"></i>
                        Durée : <strong id="duree-val" style="color:var(--c-orange);"></strong>
                    </div>
                </div>
            </div>

            <!-- Section capacité -->
            <div class="form-section">
                <div class="form-section-head">
                    <i class="fas fa-users"></i> Capacité
                </div>
                <div class="form-section-body">
                    <div class="cap-options">
                        <label class="cap-opt selected" id="cap-opt-manuel" onclick="selectCap('manuel')">
                            <input type="radio" name="option_capacite" value="manuel" checked>
                            <div class="cap-opt-icon"><i class="fas fa-keyboard"></i></div>
                            <div>
                                <div class="cap-opt-label">Manuel</div>
                                <div class="cap-opt-desc">Saisir le nombre de places</div>
                            </div>
                        </label>
                        <label class="cap-opt" id="cap-opt-tous" onclick="selectCap('tous')">
                            <input type="radio" name="option_capacite" value="tous">
                            <div class="cap-opt-icon"><i class="fas fa-building"></i></div>
                            <div>
                                <div class="cap-opt-label">Toute une direction</div>
                                <div class="cap-opt-desc">Capacité = nb d'employés</div>
                            </div>
                        </label>
                    </div>

                    <!-- Manuel -->
                    <div class="cap-detail visible" id="cap-detail-manuel">
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Nombre de places <span class="req">*</span></label>
                                <input type="number" name="Capacite_Frm" class="form-control"
                                       placeholder="Ex : 20" min="1"
                                       value="<?= old('Capacite_Frm') ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Direction -->
                    <div class="cap-detail" id="cap-detail-tous">
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Direction <span class="req">*</span></label>
                                <select name="id_Dir_capacite" class="form-control" id="sel-direction"
                                        onchange="updateDirCount()">
                                    <option value="">— Choisir une direction —</option>
                                    <?php foreach ($directions as $dir): ?>
                                    <option value="<?= $dir['id_Dir'] ?>"
                                            data-count="<?= (int)$dir['nb_employes'] ?>"
                                            <?= old('id_Dir_capacite') == $dir['id_Dir'] ? 'selected' : '' ?>>
                                        <?= esc($dir['Nom_Dir']) ?> (<?= (int)$dir['nb_employes'] ?> employés)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Capacité calculée</label>
                                <div id="dir-count-display"
                                     style="height:38px;border:1px solid var(--c-border);border-radius:8px;background:#111;display:flex;align-items:center;padding:0 12px;color:var(--c-muted);font-size:0.82rem;">
                                    Sélectionnez une direction
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.form-card-body -->

        <div class="form-footer">
            <a href="<?= base_url('formation') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-orange" id="btn-submit">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    // ===== CAPACITÉ =====
    window.selectCap = function (type) {
        ['manuel','tous'].forEach(function (t) {
            document.getElementById('cap-opt-' + t).classList.toggle('selected', t === type);
            document.getElementById('cap-detail-' + t).classList.toggle('visible', t === type);
        });
        // reset les inputs de l'autre option
        if (type === 'manuel') {
            document.getElementById('sel-direction').value = '';
            updateDirCount();
        } else {
            var inp = document.querySelector('input[name="Capacite_Frm"]');
            if (inp) inp.value = '';
        }
    };

    window.updateDirCount = function () {
        var sel = document.getElementById('sel-direction');
        var disp = document.getElementById('dir-count-display');
        if (!sel || !disp) return;
        var opt = sel.options[sel.selectedIndex];
        if (sel.value && opt) {
            var n = opt.getAttribute('data-count');
            disp.innerHTML = '<span style="color:var(--c-orange);font-weight:700;font-size:1rem;">' + n + '</span>&nbsp;<span style="color:var(--c-muted);">places</span>';
        } else {
            disp.textContent = 'Sélectionnez une direction';
            disp.style.color = 'var(--c-muted)';
        }
    };

    // ===== DURÉE =====
    var debEl  = document.getElementById('date-debut');
    var finEl  = document.getElementById('date-fin');
    var errEl  = document.getElementById('date-error');
    var durDiv = document.getElementById('duree-info');
    var durVal = document.getElementById('duree-val');

    function calcDuree() {
        if (!debEl.value || !finEl.value) { durDiv.style.display = 'none'; errEl.style.display = 'none'; return; }
        var d1 = new Date(debEl.value), d2 = new Date(finEl.value);
        if (d2 < d1) {
            errEl.style.display = 'flex';
            durDiv.style.display = 'none';
        } else {
            errEl.style.display = 'none';
            var diff = Math.round((d2 - d1) / 86400000) + 1;
            durVal.textContent = diff + ' jour' + (diff > 1 ? 's' : '');
            durDiv.style.display = 'block';
        }
    }

    debEl.addEventListener('change', calcDuree);
    finEl.addEventListener('change', calcDuree);
    calcDuree();

    // ===== SUBMIT GUARD =====
    document.querySelector('form').addEventListener('submit', function (e) {
        if (finEl.value && debEl.value && new Date(finEl.value) < new Date(debEl.value)) {
            e.preventDefault();
            errEl.style.display = 'flex';
            finEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

})();
</script>
<?= $this->endSection() ?>