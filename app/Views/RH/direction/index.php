<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    .dir-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 20px;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .dir-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 3px; height: 100%;
        background: linear-gradient(to bottom, #F5A623, #4A6741);
        opacity: 0;
        transition: opacity 0.2s;
    }

    .dir-card:hover {
        transform: translateY(-3px);
        border-color: rgba(245,166,35,0.2);
        box-shadow: 0 10px 28px rgba(0,0,0,0.35);
    }

    .dir-card:hover::before { opacity: 1; }

    .dir-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .dir-icon {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        background: rgba(74,103,65,0.2);
        border: 1px solid rgba(74,103,65,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #90c97f;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .dir-actions {
        display: flex;
        gap: 6px;
    }

    .dir-name {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .dir-effectif {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255,255,255,0.4);
        font-size: 0.78rem;
    }

    .dir-effectif strong {
        color: #F5A623;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-icon.edit {
        background: rgba(245,166,35,0.1);
        color: #F5A623;
        border: 1px solid rgba(245,166,35,0.2);
    }

    .btn-icon.edit:hover {
        background: rgba(245,166,35,0.2);
        color: #F5A623;
    }

    .btn-icon.view {
        background: rgba(74,103,65,0.15);
        color: #90c97f;
        border: 1px solid rgba(74,103,65,0.25);
    }

    .btn-icon.view:hover {
        background: rgba(74,103,65,0.25);
        color: #90c97f;
    }

    .btn-icon.del {
        background: rgba(220,53,69,0.1);
        color: #ff6b7a;
        border: 1px solid rgba(220,53,69,0.2);
    }

    .btn-icon.del:hover {
        background: rgba(220,53,69,0.2);
        color: #ff6b7a;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255,255,255,0.25);
    }

    .empty-state i {
        font-size: 3rem;
        display: block;
        margin-bottom: 12px;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .modal-backdrop { z-index: 1040 !important; }
    #modal-delete   { z-index: 1050 !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-building me-2" style="color:#F5A623;"></i>Directions</h1>
        <p><?= count($directions) ?> direction(s) enregistrée(s)</p>
    </div>
    <a href="<?= base_url('direction/create') ?>" class="btn-orange">
        <i class="fas fa-plus me-2"></i>Nouvelle Direction
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-dark-success mb-3 p-3">
    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-dark-danger mb-3 p-3">
    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<?php if (!empty($directions)): ?>
<div class="row g-3">
    <?php foreach ($directions as $dir): ?>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="dir-card">
            <div class="dir-card-top">
                <div class="dir-icon"><i class="fas fa-building"></i></div>
                <div class="dir-actions">
                    <a href="<?= base_url('direction/show/' . $dir['id_Dir']) ?>" class="btn-icon view" title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?= base_url('direction/edit/' . $dir['id_Dir']) ?>" class="btn-icon edit" title="Modifier">
                        <i class="fas fa-pen"></i>
                    </a>
                    <button type="button" class="btn-icon del" title="Supprimer"
                        onclick="confirmDelete(<?= $dir['id_Dir'] ?>, '<?= esc($dir['Nom_Dir'], 'js') ?>')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="dir-name"><?= esc($dir['Nom_Dir']) ?></div>
            <div class="dir-effectif">
                <i class="fas fa-users" style="font-size:0.7rem;"></i>
                <strong><?= (int) $dir['effectif'] ?></strong> employé(s)
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php else: ?>
<div class="empty-state">
    <i class="fas fa-building"></i>
    <p>Aucune direction enregistrée.</p>
    <a href="<?= base_url('direction/create') ?>" class="btn-orange">
        <i class="fas fa-plus me-2"></i>Créer la première direction
    </a>
</div>
<?php endif; ?>

<!-- Form delete (hors page-content via JS) -->
<form id="form-delete" method="POST" action=""></form>

<!-- Modal confirmation suppression -->
<div class="modal fade" id="modal-delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#1a1a1a;border:1px solid rgba(255,255,255,0.08);border-radius:14px;">
            <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <h6 class="modal-title" style="color:#fff;">
                    <i class="fas fa-exclamation-triangle me-2" style="color:#ff6b7a;"></i>
                    Confirmer la suppression
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color:rgba(255,255,255,0.6);font-size:0.88rem;">
                Voulez-vous supprimer la direction <strong id="dir-name-confirm" style="color:#fff;"></strong> ?
                <div class="mt-2" style="color:#ff6b7a;font-size:0.8rem;">
                    <i class="fas fa-info-circle me-1"></i>
                    Cette action est irréversible. Impossible de supprimer une direction avec des employés.
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.06);">
                <button type="button" class="btn-outline-orange" data-bs-dismiss="modal" style="padding:7px 16px;">
                    Annuler
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="submitDelete()">
                    <i class="fas fa-trash me-1"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    let deleteUrl = '';

    document.addEventListener('DOMContentLoaded', function() {
        document.body.appendChild(document.getElementById('modal-delete'));
        document.body.appendChild(document.getElementById('form-delete'));
    });

    function confirmDelete(id, nom) {
        deleteUrl = '<?= base_url('direction/delete/') ?>' + id;
        document.getElementById('dir-name-confirm').textContent = nom;
        new bootstrap.Modal(document.getElementById('modal-delete')).show();
    }

    function submitDelete() {
        const form = document.getElementById('form-delete');
        form.action = deleteUrl;
        form.submit();
    }
</script>
<?= $this->endSection() ?>