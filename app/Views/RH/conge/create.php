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

    .page-content { overflow-x: hidden; }

    /* ===== FORM CARD — pleine largeur ===== */
    .form-card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        overflow: hidden;
        width: 100%;
    }

    .form-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--c-border);
        position: relative;
    }

    .form-card-header::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--c-orange), #d4891a);
    }

    .form-card-header h5 {
        color: #fff; font-size: 0.9rem; font-weight: 700; margin: 0;
        display: flex; align-items: center; gap: 9px;
    }

    .form-card-header h5 i { color: var(--c-orange); }

    .form-card-body { padding: 22px; }

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

    .form-group { display: flex; flex-direction: column; gap: 5px; }

    .form-label {
        font-size: 0.72rem; font-weight: 700; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px;
    }

    .form-label span { color: #ff8080; margin-left: 2px; }

    .form-control-dark {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.82rem;
        padding: 9px 12px; outline: none; width: 100%;
        transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif;
        height: 38px;
    }

    .form-control-dark:focus { border-color: var(--c-orange-border); }
    .form-control-dark::placeholder { color: var(--c-muted); }
    .form-control-dark option { background: #1a1a1a; }
    .form-control-dark.is-invalid { border-color: rgba(224,82,82,0.5); }

    /* ===== SOLDE BANNER ===== */
    .solde-banner {
        background: var(--c-surface);
        border: 1px solid var(--c-orange-border);
        border-radius: 12px; padding: 14px 18px;
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 18px; flex-wrap: wrap;
    }

    .solde-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 1rem; flex-shrink: 0;
    }

    .solde-val   { font-size: 1.5rem; font-weight: 900; color: var(--c-orange); line-height: 1; }
    .solde-lbl   { font-size: 0.68rem; color: var(--c-muted); margin-top: 2px; }
    .solde-sep   { width: 1px; height: 32px; background: var(--c-orange-border); flex-shrink: 0; }

    /* ===== APERÇU DURÉE ===== */
    .duree-preview {
        background: var(--c-blue-pale); border: 1px solid var(--c-blue-border);
        border-radius: 8px; padding: 9px 14px;
        font-size: 0.8rem; color: #5B9BF0; font-weight: 600;
        display: none; align-items: center; gap: 7px; margin-top: 8px;
    }

    .duree-preview.visible { display: flex; }

    /* ===== SECTION DIVIDER ===== */
    .section-divider {
        font-size: 0.68rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.8px;
        padding-bottom: 8px; border-bottom: 1px solid var(--c-border);
        margin-bottom: 16px; margin-top: 20px;
        display: flex; align-items: center; gap: 8px;
    }

    .section-divider:first-child { margin-top: 0; }

    /* ===== ALERTS ===== */
    .alert-errors {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 12px 16px; margin-bottom: 18px;
    }

    .alert-errors p  { color: #ff8080; font-size: 0.8rem; margin: 0; }
    .alert-errors ul { color: #ff8080; font-size: 0.8rem; margin: 6px 0 0 16px; padding: 0; }

    /* ===== ACTIONS ===== */
    .form-actions {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        padding: 16px 22px; border-top: 1px solid var(--c-border);
    }

    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 9px 20px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); }

    .btn-outline {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 8px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
    }

    .btn-outline:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .form-grid-2 { grid-template-columns: 1fr; }
        .form-grid-3 { grid-template-columns: 1fr 1fr; }
        .form-card-body { padding: 16px; }
        .form-actions  { padding: 14px 16px; }
        .solde-banner  { gap: 10px; }
    }

    @media (max-width: 480px) {
        .form-grid-3 { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column; }
        .form-actions > * { width: 100%; justify-content: center; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .solde-sep { display: none; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$idPfl = $idPfl ?? session()->get('id_Pfl');
$idEmp = session()->get('id_Emp');
$soldeRestant = $solde
    ? (int)$solde['NbJoursDroit_Sld'] - (int)$solde['NbJoursPris_Sld']
    : null;
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1><i class="fas fa-plus-circle me-2" style="color:#F5A623;"></i>Nouvelle demande de congé</h1>
        <p>Remplissez le formulaire ci-dessous</p>
    </div>
    <a href="<?= base_url('conge') ?>" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<!-- Solde disponible -->
<?php if ($solde): ?>
<div class="solde-banner">
    <div class="solde-icon"><i class="fas fa-wallet"></i></div>
    <div>
        <div class="solde-val"><?= $soldeRestant ?></div>
        <div class="solde-lbl">jours restants (<?= date('Y') ?>)</div>
    </div>
    <div class="solde-sep"></div>
    <div>
        <div style="font-size:1rem;font-weight:700;color:var(--c-soft);"><?= (int)$solde['NbJoursPris_Sld'] ?></div>
        <div class="solde-lbl">jours pris</div>
    </div>
    <div class="solde-sep"></div>
    <div>
        <div style="font-size:1rem;font-weight:700;color:var(--c-soft);"><?= (int)$solde['NbJoursDroit_Sld'] ?></div>
        <div class="solde-lbl">droits totaux</div>
    </div>
</div>
<?php endif; ?>

<!-- Erreurs -->
<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-errors">
    <?php if (session()->getFlashdata('error')): ?>
    <p><i class="fas fa-exclamation-triangle"></i> <?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
    <ul>
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- FORMULAIRE -->
<div class="form-card">
    <div class="form-card-header">
        <h5><i class="fas fa-umbrella-beach"></i> Demande de congé</h5>
    </div>

    <form action="<?= base_url('conge/store') ?>" method="POST" id="form-conge">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <!-- RH peut choisir l'employé -->
            <?php if ($idPfl == 1 && !empty($employes)): ?>
            <div class="section-divider"><i class="fas fa-user"></i> Pour quel employé ?</div>
            <div class="form-group" style="margin-bottom:20px;">
                <label class="form-label">Employé <span>*</span></label>
                <select name="id_Emp" class="form-control-dark" id="sel-employe">
                    <option value="<?= $idEmp ?>">— Moi-même —</option>
                    <?php foreach ($employes as $emp): ?>
                    <?php if ($emp['id_Emp'] != $idEmp): ?>
                    <option value="<?= (int)$emp['id_Emp'] ?>"
                        <?= old('id_Emp') == $emp['id_Emp'] ? 'selected' : '' ?>>
                        <?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>
                    </option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="section-divider"><i class="fas fa-info-circle"></i> Informations du congé</div>

            <div class="form-grid-2" style="margin-bottom:16px;">
                <div class="form-group">
                    <label class="form-label">Type de congé <span>*</span></label>
                    <select name="id_Tcg" class="form-control-dark">
                        <option value="">-- Choisir --</option>
                        <?php foreach ($typesConge as $tc): ?>
                        <option value="<?= (int)$tc['id_Tcg'] ?>"
                            <?= old('id_Tcg') == $tc['id_Tcg'] ? 'selected' : '' ?>>
                            <?= esc($tc['Libelle_Tcg']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Libellé / Motif <span>*</span></label>
                    <input type="text" name="Libelle_Cge" class="form-control-dark"
                           placeholder="Ex : Congé annuel été 2026"
                           value="<?= old('Libelle_Cge') ?>">
                </div>
            </div>

            <div class="form-grid-2" style="margin-bottom:8px;">
                <div class="form-group">
                    <label class="form-label">Date de début <span>*</span></label>
                    <input type="date" name="DateDebut_Cge" id="date-debut"
                           class="form-control-dark"
                           value="<?= old('DateDebut_Cge') ?>"
                           min="<?= date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Date de fin <span>*</span></label>
                    <input type="date" name="DateFin_Cge" id="date-fin"
                           class="form-control-dark"
                           value="<?= old('DateFin_Cge') ?>"
                           min="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <!-- Aperçu durée -->
            <div class="duree-preview" id="duree-preview">
                <i class="fas fa-calendar-check"></i>
                <span id="duree-text">— jours</span>
                <span id="duree-warning" style="color:#ff8080;display:none;">
                    &nbsp;— <i class="fas fa-exclamation-triangle"></i> Solde insuffisant
                </span>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-orange">
                <i class="fas fa-paper-plane"></i> Soumettre la demande
            </button>
            <a href="<?= base_url('conge') ?>" class="btn-outline">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function() {
    var soldeRestant = <?= $soldeRestant !== null ? (int)$soldeRestant : 'null' ?>;
    var debut   = document.getElementById('date-debut');
    var fin     = document.getElementById('date-fin');
    var preview = document.getElementById('duree-preview');
    var texte   = document.getElementById('duree-text');
    var warning = document.getElementById('duree-warning');

    function calcDuree() {
        if (!debut.value || !fin.value) {
            preview.classList.remove('visible');
            return;
        }

        var d1   = new Date(debut.value);
        var d2   = new Date(fin.value);

        if (d2 < d1) {
            fin.classList.add('is-invalid');
            preview.classList.remove('visible');
            return;
        }

        fin.classList.remove('is-invalid');

        var diff = Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
        texte.textContent = diff + ' jour' + (diff > 1 ? 's' : '');
        preview.classList.add('visible');

        if (warning && soldeRestant !== null) {
            warning.style.display = diff > soldeRestant ? 'inline' : 'none';
        }
    }

    debut.addEventListener('change', function() {
        if (debut.value) fin.min = debut.value;
        calcDuree();
    });

    fin.addEventListener('change', calcDuree);

    // Pré-remplissage (withInput après erreur)
    if (debut.value && fin.value) calcDuree();
})();
</script>
<?= $this->endSection() ?>