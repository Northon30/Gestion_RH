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
        --c-blue-pale:     rgba(58,123,213,0.10);
        --c-blue-border:   rgba(58,123,213,0.25);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .form-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; max-width: 820px; margin: 0 auto;
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

    .form-card-body { padding: 22px; }

    .form-section {
        border: 1px solid var(--c-border); border-radius: 10px;
        margin-bottom: 18px; overflow: hidden;
    }

    .form-section-head {
        padding: 10px 16px; background: rgba(245,166,35,0.04);
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
        color: var(--c-orange); font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.6px;
    }

    .form-section-body { padding: 18px 16px; }

    .form-row   { display: grid; gap: 14px; margin-bottom: 14px; }
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

    .form-control:focus { border-color: var(--c-orange-border); }
    .form-control::placeholder { color: var(--c-muted); }
    .form-control option { background: #1a1a1a; }
    textarea.form-control { resize: vertical; min-height: 80px; }

    .field-hint { font-size: 0.7rem; color: var(--c-muted); margin-top: 4px; }

    /* Source toggle */
    .source-toggle { display: flex; gap: 10px; margin-bottom: 16px; }

    .source-opt {
        flex: 1; border: 1px solid var(--c-border); border-radius: 10px;
        padding: 14px 16px; cursor: pointer; transition: all 0.2s;
        display: flex; align-items: center; gap: 12px; background: #111;
    }

    .source-opt:hover { border-color: var(--c-orange-border); }

    .source-opt.selected {
        border-color: var(--c-orange-border); background: var(--c-orange-pale);
    }

    .source-opt input[type="radio"] { display: none; }

    .source-opt-icon {
        width: 38px; height: 38px; border-radius: 9px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.9rem; flex-shrink: 0;
    }

    .source-opt-label { font-size: 0.85rem; color: var(--c-soft); font-weight: 700; }
    .source-opt-desc  { font-size: 0.72rem; color: var(--c-muted); margin-top: 2px; }
    .source-opt.selected .source-opt-label { color: var(--c-orange); }

    .source-panel { display: none; }
    .source-panel.visible { display: block; }

    /* Type toggle */
    .type-toggle { display: flex; gap: 10px; margin-bottom: 0; }

    .type-opt {
        flex: 1; border: 1px solid var(--c-border); border-radius: 8px;
        padding: 10px 14px; cursor: pointer; transition: all 0.2s;
        display: flex; align-items: center; gap: 10px; background: #111;
    }

    .type-opt:hover { border-color: var(--c-orange-border); }
    .type-opt.selected { border-color: var(--c-orange-border); background: var(--c-orange-pale); }
    .type-opt input[type="radio"] { display: none; }

    .type-opt-icon {
        width: 30px; height: 30px; border-radius: 7px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.75rem; flex-shrink: 0;
    }

    .type-opt-label { font-size: 0.8rem; color: var(--c-soft); font-weight: 600; }
    .type-opt-desc  { font-size: 0.68rem; color: var(--c-muted); margin-top: 1px; }
    .type-opt.selected .type-opt-label { color: var(--c-orange); }

    /* Formation card preview */
    .frm-preview {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 9px; padding: 13px 15px; margin-top: 10px; display: none;
    }

    .frm-preview.visible { display: block; }

    .frm-preview-title {
        color: #fff; font-size: 0.83rem; font-weight: 700; margin-bottom: 8px;
    }

    .frm-preview-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 8px; font-size: 0.75rem;
    }

    .frm-preview-item { display: flex; flex-direction: column; gap: 2px; }
    .frm-preview-lbl  { color: var(--c-muted); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.4px; }
    .frm-preview-val  { color: var(--c-soft); }

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

    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; margin-bottom: 18px;
    }

    .alert-error-dark ul { margin: 6px 0 0 16px; padding: 0; }

    @media (max-width: 640px) {
        .form-row-2    { grid-template-columns: 1fr; }
        .form-row-3    { grid-template-columns: 1fr; }
        .source-toggle { flex-direction: column; }
        .type-toggle   { flex-direction: column; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Données JS pour la preview des formations catalogue
$formationsJs = json_encode(array_map(fn($f) => [
    'id'          => $f['id_Frm'],
    'description' => $f['Description_Frm'],
    'debut'       => $f['DateDebut_Frm'],
    'fin'         => $f['DateFin_Frm'],
    'lieu'        => $f['Lieu_Frm'],
    'formateur'   => $f['Formateur_Frm'],
    'capacite'    => $f['Capacite_Frm'],
    'nb_valides'  => $f['nb_valides'] ?? 0,
], $formations));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-file-alt me-2" style="color:#F5A623;"></i>Nouvelle demande de formation</h1>
        <p>Soumettre une demande ou une invitation</p>
    </div>
    <a href="<?= base_url('demande-formation') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-error-dark" style="max-width:820px;margin:0 auto 18px;">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Erreurs de saisie
    </div>
    <?php $errs = session()->getFlashdata('errors') ?: [session()->getFlashdata('error')]; ?>
    <ul>
        <?php foreach ((array)$errs as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-file-alt"></i></div>
        <div>
            <p class="form-card-title">Demande de formation</p>
            <p class="form-card-subtitle">Tous les champs marqués <span style="color:var(--c-orange);">*</span> sont obligatoires</p>
        </div>
    </div>

    <form action="<?= base_url('demande-formation/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <!-- Type de demande -->
            <div class="form-section">
                <div class="form-section-head">
                    <i class="fas fa-tag"></i> Type de demande
                </div>
                <div class="form-section-body">
                    <div class="type-toggle">
                        <label class="type-opt selected" id="type-opt-demande" onclick="selectType('demande')">
                            <input type="radio" name="Type_DFrm" value="demande" checked>
                            <div class="type-opt-icon"><i class="fas fa-hand-paper"></i></div>
                            <div>
                                <div class="type-opt-label">Demande</div>
                                <div class="type-opt-desc">Je souhaite participer à une formation</div>
                            </div>
                        </label>
                        <label class="type-opt" id="type-opt-invitation" onclick="selectType('invitation')">
                            <input type="radio" name="Type_DFrm" value="invitation">
                            <div class="type-opt-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="type-opt-label">Invitation</div>
                                <div class="type-opt-desc">J'ai reçu une invitation externe</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Source de la formation -->
            <div class="form-section">
                <div class="form-section-head">
                    <i class="fas fa-chalkboard-teacher"></i> Formation concernée
                </div>
                <div class="form-section-body">
                    <div class="source-toggle">
                        <label class="source-opt selected" id="src-opt-catalogue" onclick="selectSource('catalogue')">
                            <input type="radio" name="_source" value="catalogue" checked>
                            <div class="source-opt-icon"><i class="fas fa-list-alt"></i></div>
                            <div>
                                <div class="source-opt-label">Depuis le catalogue</div>
                                <div class="source-opt-desc">Choisir parmi les formations existantes</div>
                            </div>
                        </label>
                        <label class="source-opt" id="src-opt-libre" onclick="selectSource('libre')">
                            <input type="radio" name="_source" value="libre">
                            <div class="source-opt-icon"><i class="fas fa-pen"></i></div>
                            <div>
                                <div class="source-opt-label">Formation libre</div>
                                <div class="source-opt-desc">Saisir les détails manuellement</div>
                            </div>
                        </label>
                    </div>

                    <!-- Catalogue -->
                    <div class="source-panel visible" id="src-panel-catalogue">
                        <div class="form-group">
                            <label class="form-label">Sélectionner une formation <span class="req">*</span></label>
                            <select name="id_Frm" class="form-control" id="sel-formation"
                                    onchange="previewFormation()">
                                <option value="">— Choisir dans le catalogue —</option>
                                <?php foreach ($formations as $frm): ?>
                                <option value="<?= $frm['id_Frm'] ?>"
                                        <?= old('id_Frm') == $frm['id_Frm'] ? 'selected' : '' ?>>
                                    <?= esc($frm['Description_Frm']) ?>
                                    (<?= date('d/m/Y', strtotime($frm['DateDebut_Frm'])) ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="frm-preview" id="frm-preview">
                            <div class="frm-preview-title" id="prev-desc"></div>
                            <div class="frm-preview-grid">
                                <div class="frm-preview-item">
                                    <span class="frm-preview-lbl">Début</span>
                                    <span class="frm-preview-val" id="prev-debut"></span>
                                </div>
                                <div class="frm-preview-item">
                                    <span class="frm-preview-lbl">Fin</span>
                                    <span class="frm-preview-val" id="prev-fin"></span>
                                </div>
                                <div class="frm-preview-item">
                                    <span class="frm-preview-lbl">Lieu</span>
                                    <span class="frm-preview-val" id="prev-lieu"></span>
                                </div>
                                <div class="frm-preview-item">
                                    <span class="frm-preview-lbl">Formateur</span>
                                    <span class="frm-preview-val" id="prev-formateur"></span>
                                </div>
                                <div class="frm-preview-item">
                                    <span class="frm-preview-lbl">Places restantes</span>
                                    <span class="frm-preview-val" id="prev-places"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Libre -->
                    <div class="source-panel" id="src-panel-libre">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Intitulé de la formation <span class="req">*</span></label>
                                <input type="text" name="Description_Libre" class="form-control"
                                       placeholder="Ex : Formation en gestion de projet"
                                       value="<?= old('Description_Libre') ?>">
                            </div>
                        </div>
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Date de début <span class="req">*</span></label>
                                <input type="date" name="DateDebut_Libre" class="form-control"
                                       value="<?= old('DateDebut_Libre') ?>" id="libre-debut">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date de fin <span class="req">*</span></label>
                                <input type="date" name="DateFin_Libre" class="form-control"
                                       value="<?= old('DateFin_Libre') ?>" id="libre-fin">
                            </div>
                        </div>
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Lieu</label>
                                <input type="text" name="Lieu_Libre" class="form-control"
                                       placeholder="Ex : Paris, en ligne..."
                                       value="<?= old('Lieu_Libre') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Formateur / Organisme</label>
                                <input type="text" name="Formateur_Libre" class="form-control"
                                       placeholder="Ex : Institut de formation XYZ"
                                       value="<?= old('Formateur_Libre') ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Motif -->
            <div class="form-section">
                <div class="form-section-head">
                    <i class="fas fa-comment-alt"></i> Motivation
                </div>
                <div class="form-section-body">
                    <div class="form-group">
                        <label class="form-label">Motif de la demande <span class="req">*</span></label>
                        <textarea name="Motif" class="form-control" rows="4"
                                  placeholder="Expliquez pourquoi vous souhaitez participer à cette formation..."><?= old('Motif') ?></textarea>
                        <span class="field-hint">Décrivez l'utilité de cette formation pour votre poste ou vos objectifs professionnels.</span>
                    </div>
                </div>
            </div>

        </div><!-- /.form-card-body -->

        <div class="form-footer">
            <a href="<?= base_url('demande-formation') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-orange">
                <i class="fas fa-paper-plane"></i> Soumettre la demande
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    var formations = <?= $formationsJs ?>;

    // ===== TYPE =====
    window.selectType = function (type) {
        ['demande','invitation'].forEach(function (t) {
            document.getElementById('type-opt-' + t).classList.toggle('selected', t === type);
        });
    };

    // ===== SOURCE =====
    window.selectSource = function (src) {
        ['catalogue','libre'].forEach(function (s) {
            document.getElementById('src-opt-' + s).classList.toggle('selected', s === src);
            document.getElementById('src-panel-' + s).classList.toggle('visible', s === src);
        });
        if (src === 'catalogue') {
            // Vider les champs libres
            ['Description_Libre','DateDebut_Libre','DateFin_Libre','Lieu_Libre','Formateur_Libre']
            .forEach(function (n) {
                var el = document.querySelector('[name="' + n + '"]');
                if (el) el.value = '';
            });
        } else {
            // Vider la sélection catalogue
            document.getElementById('sel-formation').value = '';
            document.getElementById('frm-preview').classList.remove('visible');
        }
    };

    // ===== PREVIEW FORMATION =====
    window.previewFormation = function () {
        var sel = document.getElementById('sel-formation');
        var prev = document.getElementById('frm-preview');
        var id = parseInt(sel.value);
        if (!id) { prev.classList.remove('visible'); return; }
        var frm = formations.find(function (f) { return f.id == id; });
        if (!frm) { prev.classList.remove('visible'); return; }

        function fmt(d) {
            if (!d) return '-';
            var p = d.split('-'); return p[2] + '/' + p[1] + '/' + p[0];
        }

        document.getElementById('prev-desc').textContent     = frm.description;
        document.getElementById('prev-debut').textContent    = fmt(frm.debut);
        document.getElementById('prev-fin').textContent      = fmt(frm.fin);
        document.getElementById('prev-lieu').textContent     = frm.lieu || '-';
        document.getElementById('prev-formateur').textContent = frm.formateur || '-';
        var restants = parseInt(frm.capacite) - parseInt(frm.nb_valides);
        var placesEl = document.getElementById('prev-places');
        placesEl.textContent = restants + ' place(s)';
        placesEl.style.color = restants <= 0 ? '#ff8080' : (restants <= 3 ? '#ffc107' : '#7ab86a');
        prev.classList.add('visible');
    };

    // Déclencher preview si valeur pré-remplie (old input)
    var sel = document.getElementById('sel-formation');
    if (sel && sel.value) previewFormation();

})();
</script>
<?= $this->endSection() ?>