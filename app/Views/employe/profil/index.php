<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --e-primary:        #6BAF6B;
        --e-primary-pale:   rgba(107,175,107,0.10);
        --e-primary-border: rgba(107,175,107,0.25);
        --c-green-pale:     rgba(74,103,65,0.15);
        --c-green-border:   rgba(74,103,65,0.35);
        --c-surface:        #1a1a1a;
        --c-border:         rgba(255,255,255,0.06);
        --c-text:           rgba(255,255,255,0.85);
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.55);
    }

    .profil-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 16px;
        align-items: start;
    }

    .card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .card-header {
        padding: 14px 18px;
        border-bottom: 1px solid var(--c-border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-icon {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--e-primary-pale); border: 1px solid var(--e-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--e-primary); font-size: 0.82rem; flex-shrink: 0;
    }

    .card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }

    .avatar-hero {
        padding: 28px 18px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid var(--c-border);
    }

    .avatar-circle {
        width: 80px; height: 80px; border-radius: 50%;
        background: var(--e-primary-pale);
        border: 2px solid var(--e-primary-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; font-weight: 800; color: var(--e-primary);
        text-transform: uppercase;
    }

    .avatar-name {
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        text-align: center;
    }

    .avatar-role {
        background: var(--e-primary-pale);
        border: 1px solid var(--e-primary-border);
        color: var(--e-primary);
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 12px;
        border-radius: 20px;
    }

    .info-body { padding: 16px 18px; }

    .info-row {
        display: flex; flex-direction: column; gap: 3px;
        padding: 10px 0; border-bottom: 1px solid var(--c-border);
    }
    .info-row:first-child { padding-top: 0; }
    .info-row:last-child  { border-bottom: none; padding-bottom: 0; }

    .info-label {
        font-size: 0.67rem; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;
    }

    .info-value           { color: var(--c-text); font-size: 0.82rem; }
    .info-value-highlight { color: var(--e-primary); font-weight: 700; font-size: 0.85rem; }

    .right-grid { display: flex; flex-direction: column; gap: 16px; }

    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .info-block {
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-item { display: flex; flex-direction: column; gap: 3px; }

    .dispo-oui {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        color: #7ab86a; border-radius: 20px;
        padding: 3px 12px; font-size: 0.75rem; font-weight: 700;
    }

    .dispo-non {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,0.04); border: 1px solid var(--c-border);
        color: var(--c-muted); border-radius: 20px;
        padding: 3px 12px; font-size: 0.75rem; font-weight: 700;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--e-primary), #4a8a4a);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 8px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(107,175,107,0.3); color: #fff; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 8px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }
    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .alert-success-dark {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        border-radius: 10px; padding: 11px 16px; color: #7ab86a;
        font-size: 0.82rem; display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
    }

    @media (max-width: 900px) {
        .profil-grid { grid-template-columns: 1fr; }
        .two-col     { grid-template-columns: 1fr; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$initiales = mb_strtoupper(
    mb_substr($emp['Prenom_Emp'] ?? '', 0, 1) .
    mb_substr($emp['Nom_Emp']   ?? '', 0, 1)
);
$sexeLabel  = match($emp['Sexe_Emp'] ?? '') {
    'M' => 'Masculin', 'F' => 'Féminin', default => '-'
};
$dispoLabel = ($emp['Disponibilite_Emp'] ?? '') === 'oui';
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-circle me-2" style="color:var(--e-primary);"></i>Mon profil</h1>
        <p>Vos informations personnelles et professionnelles</p>
    </div>
    <a href="<?= base_url('profil/password') ?>" class="btn-primary">
        <i class="fas fa-lock"></i> Changer mot de passe
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark">
    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<div class="profil-grid">

    <!-- COL GAUCHE -->
    <div class="card">
        <div class="avatar-hero">
            <div class="avatar-circle"><?= $initiales ?></div>
            <div class="avatar-name"><?= esc($emp['Prenom_Emp'] . ' ' . $emp['Nom_Emp']) ?></div>
            <span class="avatar-role">
                <i class="fas fa-id-badge me-1"></i><?= esc($emp['Libelle_Pfl'] ?? '-') ?>
            </span>
        </div>

        <div class="info-body">
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value"><?= esc($emp['Email_Emp'] ?? '-') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Téléphone</span>
                <span class="info-value"><?= esc($emp['Telephone_Emp'] ?? '-') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Direction</span>
                <span class="info-value info-value-highlight"><?= esc($emp['Nom_Dir'] ?? '-') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Grade</span>
                <span class="info-value"><?= esc($emp['Libelle_Grd'] ?? '-') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Disponibilité</span>
                <?php if ($dispoLabel): ?>
                <span class="dispo-oui"><i class="fas fa-check"></i> Disponible</span>
                <?php else: ?>
                <span class="dispo-non"><i class="fas fa-minus"></i> Non disponible</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- COL DROITE -->
    <div class="right-grid">

        <!-- Informations personnelles -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-user"></i></div>
                <p class="card-title">Informations personnelles</p>
            </div>
            <div class="info-block">
                <div class="two-col">
                    <div class="info-item">
                        <span class="info-label">Nom</span>
                        <span class="info-value" style="font-weight:600;"><?= esc($emp['Nom_Emp']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Prénom</span>
                        <span class="info-value" style="font-weight:600;"><?= esc($emp['Prenom_Emp']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Sexe</span>
                        <span class="info-value"><?= $sexeLabel ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de naissance</span>
                        <span class="info-value">
                            <?= $emp['DateNaissance_Emp']
                                ? date('d/m/Y', strtotime($emp['DateNaissance_Emp']))
                                : '-' ?>
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-label">Adresse</span>
                    <span class="info-value"><?= esc($emp['Adresse_Emp'] ?? '-') ?></span>
                </div>
                <div class="two-col">
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value"><?= esc($emp['Email_Emp'] ?? '-') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value"><?= esc($emp['Telephone_Emp'] ?? '-') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations professionnelles -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-briefcase"></i></div>
                <p class="card-title">Informations professionnelles</p>
            </div>
            <div class="info-block">
                <div class="two-col">
                    <div class="info-item">
                        <span class="info-label">Direction</span>
                        <span class="info-value info-value-highlight"><?= esc($emp['Nom_Dir'] ?? '-') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Grade</span>
                        <span class="info-value"><?= esc($emp['Libelle_Grd'] ?? '-') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Profil</span>
                        <span class="info-value"><?= esc($emp['Libelle_Pfl'] ?? '-') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date d'embauche</span>
                        <span class="info-value">
                            <?= $emp['DateEmbauche_Emp']
                                ? date('d/m/Y', strtotime($emp['DateEmbauche_Emp']))
                                : '-' ?>
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-label">Disponibilité</span>
                    <?php if ($dispoLabel): ?>
                    <span class="dispo-oui" style="width:fit-content;"><i class="fas fa-check"></i> Disponible</span>
                    <?php else: ?>
                    <span class="dispo-non" style="width:fit-content;"><i class="fas fa-minus"></i> Non disponible</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display:flex;justify-content:flex-end;gap:10px;">
            <a href="<?= base_url('profil/password') ?>" class="btn-ghost">
                <i class="fas fa-lock"></i> Changer mon mot de passe
            </a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>