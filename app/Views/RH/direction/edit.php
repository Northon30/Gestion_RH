<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    .form-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 14px;
        overflow: hidden;
    }

    .form-card-head {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card-head i { color: #F5A623; }

    .form-card-head h6 {
        color: #fff;
        font-size: 0.9rem;
        font-weight: 600;
        margin: 0;
    }

    .form-card-body { padding: 24px; }

    .field-group { margin-bottom: 20px; }

    .field-label {
        display: block;
        color: rgba(255,255,255,0.65);
        font-size: 0.82rem;
        font-weight: 500;
        margin-bottom: 7px;
    }

    .field-label span { color: #ff6b7a; margin-left: 2px; }

    .form-card-foot {
        padding: 16px 24px;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-pen me-2" style="color:#F5A623;"></i>Modifier la Direction</h1>
        <p>
            <a href="<?= base_url('direction') ?>" style="color:rgba(255,255,255,0.4);text-decoration:none;">Directions</a>
            / <?= esc($direction['Nom_Dir']) ?>
        </p>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-dark-danger mb-3 p-3">
    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-head">
        <i class="fas fa-building"></i>
        <h6>Modifier les informations</h6>
    </div>

    <form action="<?= base_url('direction/update/' . $direction['id_Dir']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">
            <div class="field-group">
                <label class="field-label">
                    Nom de la Direction <span>*</span>
                </label>
                <input
                    type="text"
                    name="Nom_Dir"
                    class="form-control-dark w-100"
                    value="<?= esc($direction['Nom_Dir']) ?>"
                    required
                    autofocus
                >
            </div>
        </div>

        <div class="form-card-foot">
            <a href="<?= base_url('direction') ?>" class="btn-outline-orange" style="padding:8px 18px;">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
            <button type="submit" class="btn-orange">
                <i class="fas fa-save me-1"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>