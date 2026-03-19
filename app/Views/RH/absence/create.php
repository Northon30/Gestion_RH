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

    .page-content { overflow-x: hidden; }

    .form-card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 16px;
        width: 100%;
    }

    .form-card-title {
        font-size: 0.78rem; font-weight: 700;
        color: var(--c-orange); text-transform: uppercase;
        letter-spacing: 0.8px; margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
    }

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .form-group { display: flex; flex-direction: column; gap: 5px; }

    .form-label {
        font-size: 0.72rem; font-weight: 600;
        color: var(--c-soft); text-transform: uppercase; letter-spacing: 0.5px;
    }

    .form-label .req { color: var(--c-orange); margin-left: 2px; }

    .form-control-dark,
    .form-select-dark,
    .form-textarea-dark {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text);
        font-size: 0.82rem; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: 'Segoe UI', sans-serif;
        width: 100%;
    }

    .form-control-dark,
    .form-select-dark { padding: 9px 12px; height: 38px; }

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
    .form-control-dark.is-invalid,
    .form-select-dark.is-invalid { border-color: rgba(224,82,82,0.5); }

    .form-hint  { font-size: 0.68rem; color: var(--c-muted); margin-top: 2px; }

    .field-error {
        font-size: 0.7rem; color: #ff8080; margin-top: 2px;
        display: flex; align-items: center; gap: 4px;
    }

    /* ===== ALERTE ERREURS ===== */
    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 12px 16px; color: #ff8080;
        font-size: 0.82rem; margin-bottom: 16px;
    }

    .alert-error-dark ul { margin: 6px 0 0 0; padding-left: 18px; }
    .alert-error-dark li { margin-bottom: 2px; font-size: 0.78rem; }

    /* ===== PREVIEW EMPLOYÉ ===== */
    .emp-preview {
        background: #0d0d0d; border: 1px solid var(--c-border);
        border-radius: 10px; padding: 10px 14px;
        display: none; align-items: center; gap: 12px;
        margin-top: 8px;
    }

    .emp-preview.visible { display: flex; }

    .emp-preview-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.68rem; font-weight: 700; color: var(--c-orange);
        flex-shrink: 0; text-transform: uppercase;
    }

    .emp-preview-name { color: #fff; font-weight: 600; font-size: 0.82rem; }
    .emp-preview-dir  { color: var(--c-muted); font-size: 0.7rem; margin-top: 2px; }

    /* ===== COMPTEUR JOURS ===== */
    .duree-preview {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        border-radius: 8px; padding: 7px 12px;
        display: none; align-items: center; gap: 8px;
        font-size: 0.8rem; color: var(--c-orange); font-weight: 600;
        margin-top: 8px;
    }

    .duree-preview.visible { display: inline-flex; }

    /* ===== BOUTONS ===== */
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
        padding: 9px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .form-actions {
        display: flex; align-items: center; gap: 10px;
        flex-wrap: wrap; padding-top: 4px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .form-card   { padding: 16px; }
        .form-grid-2 { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    }

    @media (max-width: 480px) {
        .form-actions { flex-direction: column; }
        .form-actions > * { width: 100%; justify-content: center; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$idPfl = $idPfl ?? session()->get('id_Pfl');
$idEmp = session()->get('id_Emp');
$old   = fn($k, $d = '') => old($k, $d);
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-plus me-2" style="color:#F5A623;"></i>Déclarer une absence</h1>
        <p>Nouvelle déclaration — <?= date('d/m/Y') ?></p>
    </div>
    <a href="<?= base_url('absence') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
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
    <strong>Veuillez corriger les erreurs suivantes :</strong>
    <ul>
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="<?= base_url('absence/store') ?>" method="POST">
    <?= csrf_field() ?>

    <!-- Carte 1 : Demandeur (RH seulement) -->
    <?php if ($idPfl == 1 && !empty($employes)): ?>
    <div class="form-card">
        <div class="form-card-title"><i class="fas fa-user"></i> Pour quel employé ?</div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Employé concerné <span class="req">*</span></label>
                <select name="id_Emp" class="form-select-dark" id="sel-employe"
                        onchange="previewEmploye(this)">
                    <option value="<?= $idEmp ?>">— Moi-même —</option>
                    <?php foreach ($employes as $emp): ?>
                    <?php if ($emp['id_Emp'] != $idEmp): ?>
                    <option value="<?= (int)$emp['id_Emp'] ?>"
                            data-nom="<?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>"
                            data-dir="<?= esc($emp['Nom_Dir'] ?? '') ?>"
                            <?= $old('id_Emp') == $emp['id_Emp'] ? 'selected' : '' ?>>
                        <?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>
                    </option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <div class="emp-preview" id="emp-preview">
                    <div class="emp-preview-avatar" id="emp-avatar"></div>
                    <div>
                        <div class="emp-preview-name" id="emp-name"></div>
                        <div class="emp-preview-dir"  id="emp-dir"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Carte 2 : Informations -->
    <div class="form-card">
        <div class="form-card-title"><i class="fas fa-info-circle"></i> Informations de l'absence</div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Type d'absence <span class="req">*</span></label>
                <select name="id_TAbs" class="form-select-dark <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['id_TAbs']) ? 'is-invalid' : '' ?>">
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($typesAbsence as $ta): ?>
                    <option value="<?= $ta['id_TAbs'] ?>"
                        <?= $old('id_TAbs') == $ta['id_TAbs'] ? 'selected' : '' ?>>
                        <?= esc($ta['Libelle_TAbs']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['id_TAbs'])): ?>
                <div class="field-error"><i class="fas fa-times-circle"></i> <?= esc(session()->getFlashdata('errors')['id_TAbs']) ?></div>
                <?php endif; ?>
            </div>

            <div></div>

            <div class="form-group">
                <label class="form-label">Date de début <span class="req">*</span></label>
                <input type="date" name="DateDebut_Abs" id="date-debut"
                       class="form-control-dark <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['DateDebut_Abs']) ? 'is-invalid' : '' ?>"
                       value="<?= $old('DateDebut_Abs') ?>"
                       onchange="calcDuree()">
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['DateDebut_Abs'])): ?>
                <div class="field-error"><i class="fas fa-times-circle"></i> <?= esc(session()->getFlashdata('errors')['DateDebut_Abs']) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">
                    Date de fin
                    <span style="color:var(--c-muted);font-weight:400;text-transform:none;">(optionnel)</span>
                </label>
                <input type="date" name="DateFin_Abs" id="date-fin"
                       class="form-control-dark"
                       value="<?= $old('DateFin_Abs') ?>"
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
        <div class="form-card-title"><i class="fas fa-file-alt"></i> Motif et rapport</div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Motif</label>
                <input type="text" name="Motif_Abs" class="form-control-dark"
                       placeholder="Ex : Rendez-vous médical"
                       value="<?= esc($old('Motif_Abs')) ?>" maxlength="255">
                <div class="form-hint">Résumé court et explicite.</div>
            </div>
            <div class="form-group">
                <label class="form-label">Rapport / Détails</label>
                <textarea name="Rapport_Abs" class="form-textarea-dark"
                          placeholder="Détails supplémentaires..."><?= esc($old('Rapport_Abs')) ?></textarea>
            </div>
        </div>
    </div>

    <!-- Note PJ -->
    <div style="background:rgba(245,166,35,0.05);border:1px solid var(--c-orange-border);border-radius:10px;padding:11px 16px;font-size:0.78rem;color:var(--c-muted);margin-bottom:16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-paperclip" style="color:var(--c-orange);flex-shrink:0;"></i>
        La pièce justificative pourra être déposée depuis le <strong style="color:var(--c-soft);">détail de l'absence</strong> après soumission.
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-orange">
            <i class="fas fa-paper-plane"></i> Soumettre la déclaration
        </button>
        <a href="<?= base_url('absence') ?>" class="btn-ghost">
            <i class="fas fa-times"></i> Annuler
        </a>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    window.previewEmploye = function(sel) {
        var opt     = sel.options[sel.selectedIndex];
        var preview = document.getElementById('emp-preview');
        var avatar  = document.getElementById('emp-avatar');
        var name    = document.getElementById('emp-name');
        var dir     = document.getElementById('emp-dir');

        if (!opt || !opt.dataset.nom) {
            preview.classList.remove('visible');
            return;
        }

        var nom   = opt.dataset.nom;
        var parts = nom.trim().split(' ');
        avatar.textContent = (parts[0] ? parts[0][0] : '') + (parts[1] ? parts[1][0] : '');
        name.textContent   = nom;
        dir.textContent    = opt.dataset.dir || '';
        preview.classList.add('visible');
    };

    window.calcDuree = function() {
        var debut   = document.getElementById('date-debut').value;
        var fin     = document.getElementById('date-fin').value;
        var preview = document.getElementById('duree-preview');
        var texte   = document.getElementById('duree-texte');

        if (debut && fin) {
            var d1    = new Date(debut);
            var d2    = new Date(fin);
            if (d2 >= d1) {
                var jours = Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
                texte.textContent = jours + ' jour' + (jours > 1 ? 's' : '');
                preview.classList.add('visible');
            } else {
                preview.classList.remove('visible');
            }
        } else {
            preview.classList.remove('visible');
        }
    };

    calcDuree();
})();
</script>
<?= $this->endSection() ?>