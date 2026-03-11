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
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        overflow: hidden;
        max-width: 720px;
    }

    .form-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--c-border);
        position: relative;
        display: flex; align-items: center; justify-content: space-between;
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
    }

    .form-control-dark:focus { border-color: var(--c-orange-border); }
    .form-control-dark::placeholder { color: var(--c-muted); }
    .form-control-dark option { background: #1a1a1a; }
    .form-control-dark.is-invalid { border-color: rgba(224,82,82,0.5); }

    .badge-statut {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px;
        font-size: 0.67rem; font-weight: 700;
        background: rgba(255,193,7,0.1);
        border: 1px solid rgba(255,193,7,0.3);
        color: #ffc107;
    }

    .notice-info {
        background: var(--c-blue-pale); border: 1px solid var(--c-blue-border);
        border-radius: 10px; padding: 11px 16px;
        font-size: 0.79rem; color: #5B9BF0;
        display: flex; align-items: center; gap: 9px;
        margin-bottom: 18px;
    }

    .duree-preview {
        background: var(--c-blue-pale); border: 1px solid var(--c-blue-border);
        border-radius: 8px; padding: 8px 14px;
        font-size: 0.8rem; color: #5B9BF0; font-weight: 600;
        display: none; align-items: center; gap: 7px; margin-top: 8px;
    }

    .duree-preview.visible { display: flex; }

    .alert-errors {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 12px 16px; margin-bottom: 18px;
    }

    .alert-errors p  { color: #ff8080; font-size: 0.8rem; margin: 0; }
    .alert-errors ul { color: #ff8080; font-size: 0.8rem; margin: 6px 0 0 16px; padding: 0; }

    .form-actions {
        display: flex; align-items: center; gap: 10px;
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

    .section-divider {
        font-size: 0.68rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.8px;
        padding-bottom: 8px; border-bottom: 1px solid var(--c-border);
        margin-bottom: 16px; margin-top: 4px;
    }

    @media (max-width: 576px) {
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-pen me-2" style="color:#F5A623;"></i>Modifier la demande de congé</h1>
        <p>Seules les demandes en attente peuvent être modifiées</p>
    </div>
    <a href="<?= base_url('conge/show/' . $conge['id_Cge']) ?>" class="btn-outline">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="notice-info" style="max-width:720px;">
    <i class="fas fa-info-circle"></i>
    Modification autorisée uniquement si la demande est encore <strong>En attente</strong>.
    Une fois traitée, la demande ne peut plus être modifiée.
</div>

<!-- Erreurs -->
<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
<div class="alert-errors" style="max-width:720px;">
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

<div class="form-card">
    <div class="form-card-header">
        <h5><i class="fas fa-umbrella-beach"></i> Modifier le congé</h5>
        <span class="badge-statut">
            <span style="width:5px;height:5px;border-radius:50%;background:#ffc107;display:inline-block;"></span>
            En attente
        </span>
    </div>

    <form action="<?= base_url('conge/update/' . $conge['id_Cge']) ?>" method="POST" id="form-edit">
        <?= csrf_field() ?>

        <div class="form-card-body">
            <div class="section-divider">Informations du congé</div>

            <div class="form-grid-2" style="margin-bottom:16px;">
                <div class="form-group">
                    <label class="form-label">Type de congé <span>*</span></label>
                    <select name="id_Tcg" class="form-control-dark">
                        <option value="">-- Choisir --</option>
                        <?php foreach ($typesConge as $tc): ?>
                        <option value="<?= (int)$tc['id_Tcg'] ?>"
                            <?= (old('id_Tcg', $conge['id_Tcg']) == $tc['id_Tcg']) ? 'selected' : '' ?>>
                            <?= esc($tc['Libelle_Tcg']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Libellé / Motif <span>*</span></label>
                    <input type="text" name="Libelle_Cge" class="form-control-dark"
                           placeholder="Ex : Congé annuel été 2025"
                           value="<?= old('Libelle_Cge', esc($conge['Libelle_Cge'])) ?>">
                </div>
            </div>

            <div class="form-grid-2" style="margin-bottom:8px;">
                <div class="form-group">
                    <label class="form-label">Date de début <span>*</span></label>
                    <input type="date" name="DateDebut_Cge" id="date-debut"
                           class="form-control-dark"
                           value="<?= old('DateDebut_Cge', $conge['DateDebut_Cge']) ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Date de fin <span>*</span></label>
                    <input type="date" name="DateFin_Cge" id="date-fin"
                           class="form-control-dark"
                           value="<?= old('DateFin_Cge', $conge['DateFin_Cge']) ?>">
                </div>
            </div>

            <!-- Aperçu durée -->
            <div class="duree-preview" id="duree-preview">
                <i class="fas fa-calendar-check"></i>
                <span id="duree-text">— jours</span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-orange">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
            <a href="<?= base_url('conge/show/' . $conge['id_Cge']) ?>" class="btn-outline">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function() {
    var debut   = document.getElementById('date-debut');
    var fin     = document.getElementById('date-fin');
    var preview = document.getElementById('duree-preview');
    var texte   = document.getElementById('duree-text');

    function calcDuree() {
        if (!debut.value || !fin.value) { preview.classList.remove('visible'); return; }
        var d1   = new Date(debut.value);
        var d2   = new Date(fin.value);
        if (d2 < d1) { fin.classList.add('is-invalid'); preview.classList.remove('visible'); return; }
        fin.classList.remove('is-invalid');
        var diff = Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
        texte.textContent = diff + ' jour' + (diff > 1 ? 's' : '');
        preview.classList.add('visible');
    }

    debut.addEventListener('change', function() {
        if (debut.value) fin.min = debut.value;
        calcDuree();
    });

    fin.addEventListener('change', calcDuree);

    // Calcul initial avec les valeurs existantes
    calcDuree();
})();
</script>
<?= $this->endSection() ?>