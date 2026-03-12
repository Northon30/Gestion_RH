<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58,123,213,0.12);
        --c-primary-border: rgba(58,123,213,0.25);
        --c-accent:         #5B9BF0;
        --c-green:          #90c97f;
        --c-red:            #ff6b7a;
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.6);
    }

    .form-card { background: #1a1a1a; border: 1px solid rgba(255,255,255,0.07); border-radius: 14px; overflow: hidden;}
    .form-head { padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 10px; }
    .form-head h5 { color: #fff; font-size: 0.95rem; font-weight: 600; margin: 0; }
    .form-head i  { color: var(--c-primary); }
    .form-body { padding: 24px; }
    .form-row  { margin-bottom: 20px; }
    .form-label-dark { color: var(--c-muted); font-size: 0.82rem; margin-bottom: 7px; display: block; }
    .form-label-dark span { color: var(--c-red); }
    .form-control-dark, .form-select-dark {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        color: #fff; border-radius: 8px; padding: 10px 14px; font-size: 0.88rem;
        width: 100%; outline: none; transition: border-color 0.2s;
    }
    .form-control-dark:focus, .form-select-dark:focus { border-color: var(--c-primary); background: rgba(255,255,255,0.07); }
    .form-select-dark option { background: #222; }
    .form-foot { padding: 18px 24px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 10px; }
    .btn-submit { background: linear-gradient(135deg, var(--c-primary), #2A5FAA); border: none; color: #fff; font-weight: 600; border-radius: 8px; padding: 9px 22px; font-size: 0.88rem; cursor: pointer; transition: all 0.25s; display: inline-flex; align-items: center; gap: 7px; }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(58,123,213,0.35); }
    .btn-back { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: var(--c-soft); border-radius: 8px; padding: 9px 16px; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s; }
    .btn-back:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .alert-error-dark { background: rgba(220,53,69,0.1); border: 1px solid rgba(220,53,69,0.25); color: var(--c-red); border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 16px; }
    .info-badge { background: rgba(245,166,35,0.1); border: 1px solid rgba(245,166,35,0.2); color: var(--c-orange); border-radius: 10px; padding: 10px 16px; font-size: 0.82rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-pen me-2" style="color:var(--c-primary);"></i>Modifier ma demande de congé</h1>
        <p>Référence #<?= $conge['id_Cge'] ?></p>
    </div>
    <a href="<?= base_url('conge/show/' . $conge['id_Cge']) ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="info-badge" style="max-width:680px;">
    <i class="fas fa-info-circle"></i>
    Seules les demandes <strong>en attente</strong> peuvent être modifiées.
</div>

<div class="form-card">
    <div class="form-head">
        <i class="fas fa-file-alt"></i>
        <h5>Modification de la demande</h5>
    </div>
    <form method="post" action="<?= base_url('conge/update/' . $conge['id_Cge']) ?>">
        <?= csrf_field() ?>
        <div class="form-body">
            <div class="form-row">
                <label class="form-label-dark">Type de congé <span>*</span></label>
                <select name="id_Tcg" class="form-select-dark" required>
                    <option value="">— Sélectionner —</option>
                    <?php foreach ($typesConge as $t): ?>
                    <option value="<?= $t['id_Tcg'] ?>" <?= $conge['id_Tcg'] == $t['id_Tcg'] ? 'selected' : '' ?>>
                        <?= esc($t['Libelle_Tcg']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <label class="form-label-dark">Libellé / Motif <span>*</span></label>
                <input type="text" name="Libelle_Cge" class="form-control-dark"
                    value="<?= esc(old('Libelle_Cge', $conge['Libelle_Cge'])) ?>" required>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="form-row">
                        <label class="form-label-dark">Date début <span>*</span></label>
                        <input type="date" name="DateDebut_Cge" class="form-control-dark"
                            value="<?= esc(old('DateDebut_Cge', $conge['DateDebut_Cge'])) ?>" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-row">
                        <label class="form-label-dark">Date fin <span>*</span></label>
                        <input type="date" name="DateFin_Cge" class="form-control-dark"
                            value="<?= esc(old('DateFin_Cge', $conge['DateFin_Cge'])) ?>" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-foot">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer</button>
            <a href="<?= base_url('conge/show/' . $conge['id_Cge']) ?>" class="btn-back">Annuler</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>