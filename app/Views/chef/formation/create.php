<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58,123,213,0.10);
        --c-primary-border: rgba(58,123,213,0.25);
        --c-accent:         #5B9BF0;
        --c-purple-pale:    rgba(139,92,246,0.10);
        --c-purple-border:  rgba(139,92,246,0.25);
        --c-red-pale:       rgba(224,82,82,0.10);
        --c-red-border:     rgba(224,82,82,0.25);
        --c-surface:        #1a1a1a;
        --c-border:         rgba(255,255,255,0.06);
        --c-text:           rgba(255,255,255,0.85);
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.55);
    }

    .form-card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden;
        max-width: 860px; margin: 0 auto;
    }

    .form-card-header {
        padding: 16px 22px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 12px;
    }

    .form-card-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--c-primary-pale); border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-accent); font-size: 0.9rem; flex-shrink: 0;
    }

    .form-card-title    { color: #fff; font-size: 0.92rem; font-weight: 700; margin: 0; }
    .form-card-subtitle { color: var(--c-muted); font-size: 0.75rem; margin: 2px 0 0; }

    .form-card-body { padding: 22px; }

    .form-section {
        border: 1px solid var(--c-border);
        border-radius: 10px; margin-bottom: 18px; overflow: hidden;
    }
    .form-section:last-child { margin-bottom: 0; }

    .form-section-head {
        padding: 10px 16px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
        font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.6px;
    }
    .form-section-head.blue   { color: var(--c-accent); background: rgba(58,123,213,0.04); }
    .form-section-head.purple { color: #8b5cf6; background: rgba(139,92,246,0.04); }

    .form-section-body { padding: 18px 16px; }

    .form-row   { display: grid; gap: 14px; margin-bottom: 14px; }
    .form-row-2 { grid-template-columns: 1fr 1fr; }
    .form-row:last-child { margin-bottom: 0; }

    .form-group { display: flex; flex-direction: column; }

    .form-label {
        font-size: 0.72rem; font-weight: 600; color: var(--c-soft);
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;
    }
    .form-label .req { color: var(--c-accent); margin-left: 2px; }

    .form-control {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.82rem;
        padding: 9px 12px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }
    .form-control:focus       { border-color: var(--c-primary-border); }
    .form-control::placeholder { color: var(--c-muted); }
    .form-control option      { background: #1a1a1a; }
    textarea.form-control     { resize: vertical; min-height: 80px; }

    .field-error {
        font-size: 0.7rem; color: #ff8080; margin-top: 4px;
        display: flex; align-items: center; gap: 4px;
    }
    .field-hint { font-size: 0.7rem; color: var(--c-muted); margin-top: 4px; }

    /* ===== COMPÉTENCES ===== */
    .cmp-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 8px;
    }
    .cmp-item {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 9px 12px;
        display: flex; align-items: center; gap: 8px;
        cursor: pointer; transition: all 0.15s;
    }
    .cmp-item:hover   { border-color: var(--c-purple-border); }
    .cmp-item.selected {
        background: var(--c-purple-pale);
        border-color: var(--c-purple-border);
    }
    .cmp-item input[type="checkbox"] {
        accent-color: #8b5cf6; width: 14px; height: 14px; flex-shrink: 0;
    }
    .cmp-item-label { font-size: 0.78rem; color: var(--c-text); font-weight: 500; }
    .cmp-item.selected .cmp-item-label { color: #8b5cf6; }

    /* ===== CAPACITÉ ===== */
    .cap-options { display: flex; gap: 10px; margin-bottom: 14px; }
    .cap-opt {
        flex: 1; border: 1px solid var(--c-border); border-radius: 8px;
        padding: 10px 14px; cursor: pointer; transition: all 0.2s;
        display: flex; align-items: center; gap: 10px; background: #111;
    }
    .cap-opt:hover    { border-color: var(--c-primary-border); }
    .cap-opt.selected { border-color: var(--c-primary-border); background: var(--c-primary-pale); }
    .cap-opt input[type="radio"] { display: none; }
    .cap-opt-icon {
        width: 30px; height: 30px; border-radius: 7px;
        background: var(--c-primary-pale); border: 1px solid var(--c-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-accent); font-size: 0.75rem; flex-shrink: 0;
    }
    .cap-opt-label { font-size: 0.8rem; color: var(--c-soft); font-weight: 600; }
    .cap-opt-desc  { font-size: 0.68rem; color: var(--c-muted); margin-top: 1px; }
    .cap-opt.selected .cap-opt-label { color: var(--c-accent); }
    .cap-detail         { display: none; }
    .cap-detail.visible { display: block; }

    /* ===== INVITATION ===== */
    .emp-filter-bar { display: flex; gap: 8px; margin-bottom: 10px; flex-wrap: wrap; }
    .emp-filter-bar .form-control { flex: 1; min-width: 140px; height: 34px; padding: 0 10px; }

    .emp-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 7px; max-height: 280px; overflow-y: auto; padding: 4px;
    }
    .emp-item {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 8px 12px;
        display: flex; align-items: center; gap: 8px;
        cursor: pointer; transition: all 0.15s;
    }
    .emp-item:hover   { border-color: var(--c-primary-border); }
    .emp-item.selected {
        background: var(--c-primary-pale);
        border-color: var(--c-primary-border);
    }
    .emp-item input[type="checkbox"] {
        accent-color: var(--c-accent); width: 14px; height: 14px; flex-shrink: 0;
    }
    .emp-item-name { font-size: 0.77rem; color: var(--c-text); font-weight: 500; }
    .emp-item-meta { font-size: 0.67rem; color: var(--c-muted); }
    .emp-item.selected .emp-item-name { color: var(--c-accent); }
    .emp-item.hidden { display: none; }

    .emp-select-actions { display: flex; gap: 6px; margin-bottom: 8px; }
    .btn-xs {
        padding: 4px 10px; border-radius: 6px; border: 1px solid var(--c-border);
        background: transparent; color: var(--c-muted); font-size: 0.7rem;
        font-weight: 600; cursor: pointer; transition: all 0.15s;
    }
    .btn-xs:hover { border-color: var(--c-primary-border); color: var(--c-accent); }

    .emp-counter { font-size: 0.72rem; color: var(--c-muted); margin-top: 6px; }
    .emp-counter strong { color: var(--c-accent); }

    /* ===== BOUTONS ===== */
    .btn-primary {
        background: linear-gradient(135deg, var(--c-primary), #2d62b8);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 10px 22px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(58,123,213,0.3); color: #fff; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 10px 22px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }
    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .form-footer {
        padding: 16px 22px; border-top: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    }

    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; margin-bottom: 18px;
    }
    .alert-error-dark ul { margin: 6px 0 0 16px; padding: 0; }
    .alert-error-dark li { margin-bottom: 3px; }

    .inv-modes { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
    .inv-mode-btn {
        padding: 7px 14px; border-radius: 8px; border: 1px solid var(--c-border);
        background: #111; color: var(--c-muted); font-size: 0.75rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
    }
    .inv-mode-btn:hover { border-color: var(--c-primary-border); color: var(--c-accent); }
    .inv-mode-btn.active { background: var(--c-primary-pale); border-color: var(--c-primary-border); color: var(--c-accent); }
    .inv-detail         { display: none; }
    .inv-detail.visible { display: block; }

    @media (max-width: 640px) {
        .form-row-2 { grid-template-columns: 1fr; }
        .cap-options { flex-direction: column; }
        .inv-modes   { flex-direction: column; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chalkboard-teacher me-2" style="color:var(--c-accent);"></i>Nouvelle formation</h1>
        <p>Ajouter une formation au catalogue</p>
    </div>
    <a href="<?= base_url('formation') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-error-dark" style="max-width:860px;margin:0 auto 18px;">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Erreurs de saisie
    </div>
    <?php $errs = session()->getFlashdata('errors') ?: [session()->getFlashdata('error')]; ?>
    <ul>
        <?php foreach ((array)$errs as $e): ?>
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
            <p class="form-card-subtitle">Les champs <span style="color:var(--c-accent);">*</span> sont obligatoires</p>
        </div>
    </div>

    <form action="<?= base_url('formation/store') ?>" method="POST" id="form-create">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <!-- 1 — INFORMATIONS GÉNÉRALES -->
            <div class="form-section">
                <div class="form-section-head blue">
                    <i class="fas fa-info-circle"></i> Informations générales
                </div>
                <div class="form-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Titre <span class="req">*</span></label>
                            <input type="text" name="Titre_Frm" class="form-control"
                                   placeholder="Ex : Formation en analyse statistique avancée"
                                   value="<?= old('Titre_Frm') ?>">
                            <span class="field-hint">Titre court et descriptif de la formation.</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Description <span class="req">*</span></label>
                            <textarea name="Description_Frm" class="form-control"
                                      placeholder="Décrivez l'objet, les objectifs et le programme..."
                                      rows="3"><?= old('Description_Frm') ?></textarea>
                        </div>
                    </div>
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Lieu <span class="req">*</span></label>
                            <input type="text" name="Lieu_Frm" class="form-control"
                                   placeholder="Ex : Salle de conférence A, ANSTAT"
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

            <!-- 2 — DATES -->
            <div class="form-section">
                <div class="form-section-head blue">
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
                        <i class="fas fa-clock" style="color:var(--c-accent);"></i>
                        Durée : <strong id="duree-val" style="color:var(--c-accent);"></strong>
                    </div>
                </div>
            </div>

            <!-- 3 — COMPÉTENCES -->
            <div class="form-section">
                <div class="form-section-head purple">
                    <i class="fas fa-award"></i> Compétences à acquérir
                    <span style="font-size:0.68rem;font-weight:400;color:rgba(139,92,246,0.6);margin-left:4px;">
                        — Vous les confirmerez après la formation
                    </span>
                </div>
                <div class="form-section-body">
                    <div class="field-hint" style="margin-bottom:10px;">
                        Sélectionnez les compétences que cette formation permettra d'acquérir.
                        Vous pourrez les confirmer individuellement pour chaque participant après la formation.
                    </div>
                    <div class="cmp-grid">
                        <?php foreach ($competences as $cmp): ?>
                        <label class="cmp-item" id="cmp-item-<?= (int)$cmp['id_Cmp'] ?>"
                               onclick="toggleCmp(this)">
                            <input type="checkbox"
                                   name="competences[]"
                                   value="<?= (int)$cmp['id_Cmp'] ?>"
                                   <?= in_array($cmp['id_Cmp'], (array)old('competences', [])) ? 'checked' : '' ?>>
                            <span class="cmp-item-label">
                                <i class="fas fa-star" style="font-size:0.65rem;margin-right:4px;"></i>
                                <?= esc($cmp['Libelle_Cmp']) ?>
                            </span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="emp-counter" style="margin-top:8px;">
                        <strong id="cmp-count">0</strong> compétence(s) sélectionnée(s)
                    </div>
                </div>
            </div>

            <!-- 4 — CAPACITÉ -->
            <div class="form-section">
                <div class="form-section-head blue">
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
                                <div class="cap-opt-label">Par direction</div>
                                <div class="cap-opt-desc">Capacité = nb d'employés</div>
                            </div>
                        </label>
                    </div>

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

            <!-- 5 — INVITATIONS -->
            <div class="form-section">
                <div class="form-section-head blue">
                    <i class="fas fa-paper-plane"></i> Invitations
                    <span style="font-size:0.68rem;font-weight:400;color:rgba(58,123,213,0.6);margin-left:4px;">
                        — Optionnel, vous pouvez inviter plus tard
                    </span>
                </div>
                <div class="form-section-body">

                    <div class="inv-modes">
                        <button type="button" class="inv-mode-btn active" id="inv-btn-aucun"
                                onclick="setInvMode('aucun')">
                            <i class="fas fa-clock"></i> Plus tard
                        </button>
                        <button type="button" class="inv-mode-btn" id="inv-btn-selection"
                                onclick="setInvMode('selection')">
                            <i class="fas fa-filter"></i> Sélection
                        </button>
                    </div>
                    <input type="hidden" name="inv_mode" id="inv_mode" value="aucun">

                    <!-- Aucun -->
                    <div class="inv-detail visible" id="inv-detail-aucun">
                        <div class="field-hint" style="padding:10px 0;">
                            <i class="fas fa-info-circle" style="color:var(--c-accent);"></i>
                            Vous pourrez inviter des participants depuis la page de détail de la formation.
                        </div>
                    </div>

                    <!-- Sélection — uniquement les employés de la direction du Chef -->
                    <div class="inv-detail" id="inv-detail-selection">
                        <div class="field-hint" style="margin-bottom:10px;">
                            Sélectionnez les employés de votre direction à inviter.
                        </div>

                        <input type="text" class="form-control" id="f-emp-search"
                               placeholder="Rechercher un employé..."
                               oninput="filterEmps()"
                               style="margin-bottom:10px;max-width:260px;">

                        <div class="emp-select-actions">
                            <button type="button" class="btn-xs" onclick="selectAllEmps(true)">
                                <i class="fas fa-check-square"></i> Tout cocher
                            </button>
                            <button type="button" class="btn-xs" onclick="selectAllEmps(false)">
                                <i class="fas fa-square"></i> Tout décocher
                            </button>
                        </div>

                        <div class="emp-grid" id="emp-grid">
                            <?php foreach ($employes as $emp): ?>
                            <label class="emp-item"
                                   id="emp-item-<?= (int)$emp['id_Emp'] ?>"
                                   data-search="<?= strtolower(esc($emp['Nom_Emp'].' '.$emp['Prenom_Emp'])) ?>"
                                   onclick="toggleEmp(this)">
                                <input type="checkbox"
                                       name="inv_employes[]"
                                       value="<?= (int)$emp['id_Emp'] ?>"
                                       onchange="updateEmpCount()">
                                <div>
                                    <div class="emp-item-name">
                                        <?= esc($emp['Nom_Emp'].' '.$emp['Prenom_Emp']) ?>
                                    </div>
                                    <div class="emp-item-meta">
                                        <?= esc($emp['Libelle_Grd'] ?? '') ?>
                                    </div>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>

                        <div class="emp-counter">
                            <strong id="emp-count">0</strong> employé(s) sélectionné(s)
                        </div>
                    </div>

                </div>
            </div>

        </div><!-- /.form-card-body -->

        <div class="form-footer">
            <a href="<?= base_url('formation') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-primary" id="btn-submit">
                <i class="fas fa-save"></i> Enregistrer la formation
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

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
            errEl.style.display = 'flex'; durDiv.style.display = 'none';
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

    // ===== CAPACITÉ =====
    window.selectCap = function (type) {
        ['manuel', 'tous'].forEach(function (t) {
            document.getElementById('cap-opt-' + t).classList.toggle('selected', t === type);
            document.getElementById('cap-detail-' + t).classList.toggle('visible', t === type);
        });
        if (type === 'manuel') {
            var sel = document.getElementById('sel-direction');
            if (sel) sel.value = '';
            updateDirCount();
        } else {
            var inp = document.querySelector('input[name="Capacite_Frm"]');
            if (inp) inp.value = '';
        }
    };

    window.updateDirCount = function () {
        var sel  = document.getElementById('sel-direction');
        var disp = document.getElementById('dir-count-display');
        if (!sel || !disp) return;
        var opt = sel.options[sel.selectedIndex];
        if (sel.value && opt) {
            var n = opt.getAttribute('data-count');
            disp.innerHTML = '<span style="color:var(--c-accent);font-weight:700;font-size:1rem;">' + n + '</span>&nbsp;<span style="color:var(--c-muted);">places</span>';
        } else {
            disp.textContent = 'Sélectionnez une direction';
        }
    };

    // ===== COMPÉTENCES =====
    window.toggleCmp = function (label) {
        var cb = label.querySelector('input[type="checkbox"]');
        if (!cb) return;
        label.classList.toggle('selected', cb.checked);
        updateCmpCount();
    };

    function updateCmpCount() {
        var n  = document.querySelectorAll('.cmp-item input:checked').length;
        var el = document.getElementById('cmp-count');
        if (el) el.textContent = n;
    }

    document.querySelectorAll('.cmp-item input:checked').forEach(function (cb) {
        cb.closest('.cmp-item').classList.add('selected');
    });
    updateCmpCount();

    // ===== MODES INVITATION =====
    var invModes = ['aucun', 'selection'];

    window.setInvMode = function (mode) {
        document.getElementById('inv_mode').value = mode;
        invModes.forEach(function (m) {
            var btn = document.getElementById('inv-btn-' + m);
            var det = document.getElementById('inv-detail-' + m);
            if (btn) btn.classList.toggle('active', m === mode);
            if (det) det.classList.toggle('visible', m === mode);
        });
    };

    // ===== EMPLOYÉS =====
    window.toggleEmp = function (label) {
        var cb = label.querySelector('input[type="checkbox"]');
        if (!cb) return;
        label.classList.toggle('selected', cb.checked);
        updateEmpCount();
    };

    window.updateEmpCount = function () {
        var n  = document.querySelectorAll('#emp-grid input:checked').length;
        var el = document.getElementById('emp-count');
        if (el) el.textContent = n;
    };

    window.selectAllEmps = function (checked) {
        document.querySelectorAll('#emp-grid .emp-item:not(.hidden)').forEach(function (item) {
            var cb = item.querySelector('input');
            cb.checked = checked;
            item.classList.toggle('selected', checked);
        });
        updateEmpCount();
    };

    window.filterEmps = function () {
        var search = document.getElementById('f-emp-search').value.toLowerCase().trim();
        document.querySelectorAll('#emp-grid .emp-item').forEach(function (item) {
            var match = !search || item.dataset.search.includes(search);
            item.classList.toggle('hidden', !match);
        });
    };

    // ===== SUBMIT GUARD =====
    document.getElementById('form-create').addEventListener('submit', function (e) {
        if (finEl.value && debEl.value && new Date(finEl.value) < new Date(debEl.value)) {
            e.preventDefault();
            errEl.style.display = 'flex';
            finEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

})();
</script>
<?= $this->endSection() ?>