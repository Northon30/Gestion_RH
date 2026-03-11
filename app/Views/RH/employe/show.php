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

    /* ===== HEADER FICHE ===== */
    .fiche-header {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        padding: 24px;
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 20px;
        position: relative; overflow: hidden;
    }

    .fiche-header::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--c-orange), #d4891a);
    }

    .fiche-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 800; text-transform: uppercase;
        flex-shrink: 0; border: 2px solid var(--c-orange-border);
    }

    .fiche-avatar.male   { background: var(--c-orange-pale); color: var(--c-orange); }
    .fiche-avatar.female { background: rgba(255,105,180,0.12); color: #ff8fbf; border-color: rgba(255,105,180,0.3); }

    .fiche-identity { flex: 1; min-width: 0; }
    .fiche-identity h2 { color: #fff; font-size: 1.2rem; font-weight: 800; margin: 0 0 4px; }
    .fiche-identity p  { color: var(--c-muted); font-size: 0.8rem; margin: 0 0 10px; }

    .fiche-meta { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }

    .meta-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600;
    }

    .mc-dir       { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .mc-grade     { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);   color: #5B9BF0; }
    .mc-profil    { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .mc-dispo-oui { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }
    .mc-dispo-non { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);    color: #ff8080; }
    .mc-neutral   { background: rgba(255,255,255,0.04); border: 1px solid var(--c-border); color: var(--c-muted); }

    .dispo-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .dispo-dot.oui { background: #7ab86a; }
    .dispo-dot.non { background: #ff8080; }

    .fiche-actions { display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; }

    /* ===== BOUTONS ===== */
    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap; justify-content: center;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-outline {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 7px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap; justify-content: center;
    }

    .btn-outline:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .btn-blue {
        background: transparent; border: 1px solid var(--c-blue-border);
        color: #5B9BF0; font-weight: 600; border-radius: 8px;
        padding: 7px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap; justify-content: center;
    }

    .btn-blue:hover { background: var(--c-blue-pale); color: #5B9BF0; }

    /* ===== ONGLETS ===== */
    .tabs-nav {
        display: flex; gap: 4px; flex-wrap: wrap;
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; padding: 6px; margin-bottom: 16px;
    }

    .tab-btn {
        padding: 8px 16px; border-radius: 8px; border: none;
        background: transparent; color: var(--c-muted); font-size: 0.8rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 7px; white-space: nowrap;
    }

    .tab-btn:hover { color: var(--c-soft); background: rgba(255,255,255,0.03); }

    .tab-btn.active {
        background: var(--c-orange-pale);
        border: 1px solid var(--c-orange-border);
        color: var(--c-orange);
    }

    .tab-btn .tab-count {
        background: rgba(255,255,255,0.08); color: var(--c-muted);
        font-size: 0.65rem; font-weight: 700; padding: 1px 6px; border-radius: 10px;
    }

    .tab-btn.active .tab-count { background: var(--c-orange-border); color: var(--c-orange); }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ===== CARDS ===== */
    .card-dark {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 12px; padding: 18px; margin-bottom: 16px;
    }

    .card-dark-title {
        font-size: 0.78rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; letter-spacing: 0.7px;
        margin-bottom: 16px; padding-bottom: 10px;
        border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 8px;
    }

    .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }

    .info-item { display: flex; flex-direction: column; gap: 3px; }

    .info-label { font-size: 0.67rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: 0.6px; }

    .info-value { font-size: 0.85rem; color: var(--c-text); font-weight: 500; }
    .info-value.highlight { color: var(--c-orange); font-weight: 700; }

    /* ===== SOLDES ===== */
    .solde-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 10px; margin-bottom: 4px;
    }

    .solde-card {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 10px; padding: 14px; text-align: center;
        transition: border-color 0.2s;
    }

    .solde-card:hover { border-color: var(--c-orange-border); }

    .solde-val   { font-size: 1.8rem; font-weight: 900; color: var(--c-orange); line-height: 1; }
    .solde-unit  { font-size: 0.68rem; color: var(--c-muted); margin-bottom: 4px; }
    .solde-label { font-size: 0.72rem; color: var(--c-soft); font-weight: 600; }
    .solde-pris  { font-size: 0.68rem; color: var(--c-muted); margin-top: 4px; }

    /* ===== TABLEAUX ===== */
    .data-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .data-table thead th {
        padding: 8px 12px; font-size: 0.67rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border); white-space: nowrap;
    }

    .data-table tbody td {
        padding: 9px 12px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    /* ===== BADGES STATUT ===== */
    .badge-statut {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 20px;
        font-size: 0.67rem; font-weight: 700; white-space: nowrap;
    }

    .bs-attente  { background: rgba(255,193,7,0.1);  border: 1px solid rgba(255,193,7,0.3);   color: #ffc107; }
    .bs-valide   { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);  color: #5B9BF0; }
    .bs-approuve { background: var(--c-green-pale);  border: 1px solid var(--c-green-border); color: #7ab86a; }
    .bs-rejete   { background: var(--c-red-pale);    border: 1px solid var(--c-red-border);   color: #ff8080; }

    /* ===== COMPETENCES ===== */
    .competences-wrap { display: flex; flex-wrap: wrap; gap: 8px; }

    .competence-tag {
        background: var(--c-blue-pale); border: 1px solid var(--c-blue-border);
        color: #5B9BF0; font-size: 0.78rem; font-weight: 600;
        padding: 5px 12px; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 6px;
    }

    .niveau-badge {
        background: rgba(255,255,255,0.08); padding: 1px 6px;
        border-radius: 10px; font-size: 0.65rem; margin-left: 2px;
    }

    /* ===== ETAT VIDE ===== */
    .empty-tab { padding: 40px 20px; text-align: center; }

    .empty-tab-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: var(--c-orange); margin: 0 auto 12px;
    }

    .empty-tab p { color: var(--c-muted); font-size: 0.82rem; margin: 0; }

    /* ===== ANCIENNETE ===== */
    .anciennete-bar {
        height: 6px; background: rgba(255,255,255,0.06);
        border-radius: 3px; overflow: hidden; margin-top: 6px;
    }

    .anciennete-fill {
        height: 100%; background: linear-gradient(90deg, var(--c-orange), #d4891a);
        border-radius: 3px; transition: width 1s ease;
    }

    /* ===== PRINT ONLY ===== */
    .print-only   { display: none; }
    .print-footer { display: none; }
    .print-section-title { display: none; }

    /* ===== IMPRESSION ===== */
    @media print {
        * { box-sizing: border-box; }

        html, body {
            width: 100% !important;
            margin: 0 !important; padding: 0 !important;
            background: #fff !important; color: #111 !important;
            font-family: 'Segoe UI', Arial, sans-serif !important;
        }

        /* Masquer navigation */
        #sidebar, .sidebar, [class*="sidebar"],
        #navbar, .navbar, nav,
        .page-header, .tabs-nav, .fiche-actions,
        #btn-print, .btn-orange, .btn-outline, .btn-blue {
            display: none !important;
        }

        /* Layout pleine largeur */
        .wrapper, #wrapper, .main-wrapper,
        .d-flex, [class*="wrapper"] {
            display: block !important;
            width: 100% !important; padding: 0 !important; margin: 0 !important;
        }

        .main-content, #main-content, .content-wrapper,
        #content, main, [class*="main-content"], [class*="content-area"],
        [class*="content"] {
            width: 100% !important; max-width: 100% !important;
            margin: 0 !important; padding: 8mm 12mm !important;
            min-height: unset !important; float: none !important;
            position: static !important; left: 0 !important;
            overflow: visible !important;
        }

        /* En-tete impression */
        .print-only { display: flex !important; }

        .print-header {
            display: flex !important; align-items: center;
            justify-content: space-between; margin-bottom: 14px;
            padding-bottom: 10px; border-bottom: 2px solid #F5A623;
        }

        .print-header-logo {
            font-size: 1rem; font-weight: 800; color: #F5A623 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .print-header-info { font-size: 0.72rem; color: #666; text-align: right; }

        /* Header fiche */
        .fiche-header {
            background: #fff !important; border: 1px solid #ddd !important;
            border-radius: 8px !important; page-break-inside: avoid;
        }

        .fiche-header::before {
            background: #F5A623 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .fiche-avatar.male {
            background: #fff3e0 !important; color: #F5A623 !important;
            border-color: #F5A623 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .fiche-avatar.female {
            background: #fce4ec !important; color: #e91e63 !important;
            border-color: #e91e63 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .fiche-identity h2 { color: #111 !important; }
        .fiche-identity p  { color: #555 !important; }

        .meta-chip {
            border: 1px solid #ccc !important; color: #333 !important;
            background: #f5f5f5 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        /* Tous les onglets a plat */
        .tab-panel { display: block !important; page-break-inside: avoid; }

        .print-section-title {
            display: block !important; font-size: 0.75rem; font-weight: 800;
            color: #F5A623 !important; text-transform: uppercase; letter-spacing: 0.8px;
            margin: 16px 0 8px; padding-bottom: 5px; border-bottom: 1px solid #F5A623;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .card-dark {
            background: #fff !important; border: 1px solid #ddd !important;
            border-radius: 6px !important; margin-bottom: 10px; page-break-inside: avoid;
        }

        .card-dark-title { color: #333 !important; border-bottom-color: #eee !important; }

        .info-label  { color: #888 !important; }
        .info-value  { color: #111 !important; }
        .info-value.highlight { color: #F5A623 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        .data-table thead th {
            background: #fff8e6 !important; color: #111 !important;
            border-bottom: 1px solid #F5A623 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .data-table tbody td { color: #333 !important; border-color: #eee !important; }

        .badge-statut, .competence-tag {
            border: 1px solid #ccc !important; color: #333 !important;
            background: #f5f5f5 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .solde-grid { grid-template-columns: repeat(3, 1fr) !important; }

        .solde-card {
            background: #f9f9f9 !important; border: 1px solid #ddd !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .solde-val { color: #F5A623 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .solde-label { color: #333 !important; }

        .anciennete-bar { background: #eee !important; }
        .anciennete-fill {
            background: #F5A623 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        #tab-infos > div {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important; gap: 10px !important;
        }

        .print-footer {
            display: block !important; margin-top: 20px; padding-top: 10px;
            border-top: 1px solid #ddd; font-size: 0.68rem; color: #888; text-align: center;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$anciennete    = '';
$anciennetePct = 0;
if (!empty($employe['DateEmbauche_Emp'])) {
    $debut  = new \DateTime($employe['DateEmbauche_Emp']);
    $now    = new \DateTime();
    $diff   = $debut->diff($now);
    $years  = $diff->y;
    $months = $diff->m;
    $anciennete = $years > 0
        ? $years . ' an' . ($years > 1 ? 's' : '') . ($months > 0 ? ' et ' . $months . ' mois' : '')
        : $months . ' mois';
    $anciennetePct = min(100, round(($years * 12 + $months) / (30 * 12) * 100));
}
?>

<!-- En-tete impression uniquement -->
<div class="print-only print-header">
    <div class="print-header-logo">ANSTAT &mdash; Dossier Employe</div>
    <div class="print-header-info">
        Imprime le <?= date('d/m/Y') ?> a <?= date('H:i') ?><br>
        <span style="color:#999;">Document confidentiel</span>
    </div>
</div>

<!-- ===== HEADER ===== -->
<div class="fiche-header">
    <div class="fiche-avatar <?= (int)$employe['Sexe_Emp'] === 0 ? 'female' : 'male' ?>">
        <?= mb_substr($employe['Nom_Emp'], 0, 1) . mb_substr($employe['Prenom_Emp'], 0, 1) ?>
    </div>

    <div class="fiche-identity">
        <h2><?= esc($employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']) ?></h2>
        <p><?= esc($employe['Email_Emp']) ?></p>
        <div class="fiche-meta">
            <?php if (!empty($employe['Nom_Dir'])): ?>
            <span class="meta-chip mc-dir">
                <i class="fas fa-building" style="font-size:0.6rem;"></i>
                <?= esc($employe['Nom_Dir']) ?>
            </span>
            <?php endif; ?>

            <?php if (!empty($employe['Libelle_Grd'])): ?>
            <span class="meta-chip mc-grade">
                <i class="fas fa-graduation-cap" style="font-size:0.6rem;"></i>
                <?= esc($employe['Libelle_Grd']) ?>
            </span>
            <?php endif; ?>

            <?php if (!empty($employe['Libelle_Pfl'])): ?>
            <span class="meta-chip mc-profil"><?= esc($employe['Libelle_Pfl']) ?></span>
            <?php endif; ?>

            <?php if ((int)$employe['Disponibilite_Emp'] === 1): ?>
            <span class="meta-chip mc-dispo-oui">
                <span class="dispo-dot oui"></span> Disponible
            </span>
            <?php else: ?>
            <span class="meta-chip mc-dispo-non">
                <span class="dispo-dot non"></span> Absent
            </span>
            <?php endif; ?>

            <?php if ($anciennete): ?>
            <span class="meta-chip mc-neutral">
                <i class="fas fa-clock" style="font-size:0.6rem;"></i>
                <?= $anciennete ?>
            </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="fiche-actions">
        <a href="<?= base_url('employe/edit/' . $employe['id_Emp']) ?>" class="btn-orange">
            <i class="fas fa-pen"></i> Modifier
        </a>
        <button class="btn-blue" id="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Imprimer
        </button>
        <a href="<?= base_url('employe') ?>" class="btn-outline">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<!-- ===== ONGLETS ===== -->
<div class="tabs-nav" id="tabs-nav">
    <button class="tab-btn active" onclick="switchTab('infos', this)">
        <i class="fas fa-id-card"></i> Infos personnelles
    </button>
    <button class="tab-btn" onclick="switchTab('conges', this)">
        <i class="fas fa-umbrella-beach"></i> Conges
        <span class="tab-count"><?= count($conges) ?></span>
    </button>
    <button class="tab-btn" onclick="switchTab('absences', this)">
        <i class="fas fa-user-clock"></i> Absences
        <span class="tab-count"><?= count($absences) ?></span>
    </button>
    <button class="tab-btn" onclick="switchTab('formations', this)">
        <i class="fas fa-chalkboard-teacher"></i> Formations
        <span class="tab-count"><?= count($formations) ?></span>
    </button>
    <button class="tab-btn" onclick="switchTab('competences', this)">
        <i class="fas fa-star"></i> Competences
        <span class="tab-count"><?= count($competences) ?></span>
    </button>
    <button class="tab-btn" onclick="switchTab('evenements', this)">
        <i class="fas fa-calendar-alt"></i> Evenements
        <span class="tab-count"><?= count($evenements) ?></span>
    </button>
</div>

<!-- ===== ONGLET 1 : INFOS ===== -->
<div class="tab-panel active" id="tab-infos">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

        <div class="card-dark">
            <div class="card-dark-title"><i class="fas fa-user"></i> Identite</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nom</span>
                    <span class="info-value"><?= esc($employe['Nom_Emp']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Prenom</span>
                    <span class="info-value"><?= esc($employe['Prenom_Emp']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Sexe</span>
                    <span class="info-value"><?= (int)$employe['Sexe_Emp'] === 1 ? 'Homme' : 'Femme' ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date de naissance</span>
                    <span class="info-value">
                        <?= !empty($employe['DateNaissance_Emp'])
                            ? date('d/m/Y', strtotime($employe['DateNaissance_Emp']))
                            : '<span style="color:var(--c-muted)">-</span>' ?>
                    </span>
                </div>
                <div class="info-item" style="grid-column:span 2;">
                    <span class="info-label">Email</span>
                    <span class="info-value highlight"><?= esc($employe['Email_Emp']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Telephone</span>
                    <span class="info-value"><?= esc($employe['Telephone_Emp'] ?? '-') ?></span>
                </div>
                <div class="info-item" style="grid-column:span 2;">
                    <span class="info-label">Adresse</span>
                    <span class="info-value"><?= esc($employe['Adresse_Emp'] ?? '-') ?></span>
                </div>
            </div>
        </div>

        <div class="card-dark">
            <div class="card-dark-title"><i class="fas fa-briefcase"></i> Situation professionnelle</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Direction</span>
                    <span class="info-value"><?= esc($employe['Nom_Dir'] ?? '-') ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Grade</span>
                    <span class="info-value"><?= esc($employe['Libelle_Grd'] ?? '-') ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Profil</span>
                    <span class="info-value"><?= esc($employe['Libelle_Pfl'] ?? '-') ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Disponibilite</span>
                    <span class="info-value">
                        <?php if ((int)$employe['Disponibilite_Emp'] === 1): ?>
                        <span style="color:#7ab86a;">Disponible</span>
                        <?php else: ?>
                        <span style="color:#ff8080;">Absent</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date d'embauche</span>
                    <span class="info-value">
                        <?= !empty($employe['DateEmbauche_Emp'])
                            ? date('d/m/Y', strtotime($employe['DateEmbauche_Emp']))
                            : '<span style="color:var(--c-muted)">-</span>' ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Anciennete</span>
                    <span class="info-value highlight"><?= $anciennete ?: '-' ?></span>
                </div>
            </div>

            <?php if ($anciennetePct > 0): ?>
            <div style="margin-top:14px;">
                <div style="display:flex;justify-content:space-between;font-size:0.68rem;color:var(--c-muted);margin-bottom:4px;">
                    <span>Progression anciennete</span>
                    <span><?= $anciennetePct ?>% (sur 30 ans)</span>
                </div>
                <div class="anciennete-bar">
                    <div class="anciennete-fill" id="anciennete-fill" style="width:0%"></div>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ===== ONGLET 2 : CONGES ===== -->
<div class="tab-panel" id="tab-conges">
    <span class="print-section-title">Conges</span>

    <!-- Soldes : NbJoursDroit_Sld - NbJoursPris_Sld -->
    <?php if (!empty($soldes)): ?>
    <div class="card-dark">
        <div class="card-dark-title">
            <i class="fas fa-wallet"></i> Solde de conges (<?= date('Y') ?>)
        </div>
        <div class="solde-grid">
            <?php foreach ($soldes as $s): ?>
            <?php $restant = (int)$s['NbJoursDroit_Sld'] - (int)$s['NbJoursPris_Sld']; ?>
            <div class="solde-card">
                <div class="solde-val"><?= $restant ?></div>
                <div class="solde-unit">jours restants</div>
                <div class="solde-label">Conges <?= (int)$s['Annee_Sld'] ?></div>
                <div class="solde-pris"><?= (int)$s['NbJoursPris_Sld'] ?> pris / <?= (int)$s['NbJoursDroit_Sld'] ?> droits</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Historique congés -->
    <div class="card-dark">
        <div class="card-dark-title"><i class="fas fa-history"></i> Historique des demandes</div>
        <?php if (!empty($conges)): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Libelle</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conges as $c): ?>
                <tr>
                    <td><?= esc($c['Libelle_Tcg'] ?? '-') ?></td>
                    <td style="color:var(--c-text);font-weight:500;"><?= esc($c['Libelle_Cge'] ?? '-') ?></td>
                    <td><?= !empty($c['DateDebut_Cge']) ? date('d/m/Y', strtotime($c['DateDebut_Cge'])) : '-' ?></td>
                    <td><?= !empty($c['DateFin_Cge'])   ? date('d/m/Y', strtotime($c['DateFin_Cge']))   : '-' ?></td>
                    <td>
                        <?php
                        $st = $c['Statut_Cge'] ?? '';
                        [$cls, $label] = match($st) {
                            'en_attente' => ['bs-attente',  'En attente'],
                            'approuve'   => ['bs-approuve', 'Approuve'],
                            default      => ['bs-rejete',   'Refuse'],
                        };
                        ?>
                        <span class="badge-statut <?= $cls ?>"><?= $label ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-tab">
            <div class="empty-tab-icon"><i class="fas fa-umbrella-beach"></i></div>
            <p>Aucune demande de conge enregistree.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ONGLET 3 : ABSENCES ===== -->
<div class="tab-panel" id="tab-absences">
    <span class="print-section-title">Absences</span>

    <div class="card-dark">
        <div class="card-dark-title"><i class="fas fa-user-clock"></i> Historique des absences</div>
        <?php if (!empty($absences)): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Motif</th>
                    <th>Statut</th>
                    <th>Justificatif</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($absences as $a): ?>
                <tr>
                    <td><?= esc($a['Libelle_TAbs'] ?? '-') ?></td>
                    <td><?= !empty($a['DateDebut_Abs']) ? date('d/m/Y', strtotime($a['DateDebut_Abs'])) : '-' ?></td>
                    <td><?= !empty($a['DateFin_Abs'])   ? date('d/m/Y', strtotime($a['DateFin_Abs']))   : '-' ?></td>
                    <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?= esc($a['Motif_Abs'] ?? '-') ?>
                    </td>
                    <td>
                        <?php
                        $st = $a['Statut_Abs'] ?? '';
                        [$cls, $label] = match($st) {
                            'en_attente' => ['bs-attente',  'En attente'],
                            'valide_rh'  => ['bs-valide',   'Valide RH'],
                            'approuve'   => ['bs-approuve', 'Approuve'],
                            'rejete_rh'  => ['bs-rejete',   'Rejete RH'],
                            default      => ['bs-rejete',   'Refuse'],
                        };
                        ?>
                        <span class="badge-statut <?= $cls ?>"><?= $label ?></span>
                    </td>
                    <td>
                        <?php if (!empty($a['CheminFichier_PJ'])): ?>
                        <a href="<?= base_url('uploads/justificatifs/' . $a['CheminFichier_PJ']) ?>"
                           target="_blank"
                           style="color:#5B9BF0;font-size:0.75rem;display:inline-flex;align-items:center;gap:4px;">
                            <i class="fas fa-paperclip"></i> Voir
                        </a>
                        <?php else: ?>
                        <span style="color:var(--c-muted);font-size:0.75rem;">Aucun</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-tab">
            <div class="empty-tab-icon"><i class="fas fa-user-check"></i></div>
            <p>Aucune absence enregistree.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ONGLET 4 : FORMATIONS ===== -->
<div class="tab-panel" id="tab-formations">
    <span class="print-section-title">Formations</span>

    <div class="card-dark">
        <div class="card-dark-title"><i class="fas fa-chalkboard-teacher"></i> Formations suivies</div>
        <?php if (!empty($formations)): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Formateur</th>
                    <th>Lieu</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formations as $f): ?>
                <tr>
                    <td style="font-weight:600;color:var(--c-text);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?= esc($f['Description_Frm'] ?? '-') ?>
                    </td>
                    <td><?= esc($f['Formateur_Frm'] ?? '-') ?></td>
                    <td><?= esc($f['Lieu_Frm'] ?? '-') ?></td>
                    <td><?= !empty($f['DateDebut_Frm']) ? date('d/m/Y', strtotime($f['DateDebut_Frm'])) : '-' ?></td>
                    <td><?= !empty($f['DateFin_Frm'])   ? date('d/m/Y', strtotime($f['DateFin_Frm']))   : '-' ?></td>
                    <td>
                        <?php
                        $st  = $f['Stt_Ins'] ?? 'inscrit';
                        $cls = match($st) {
                            'valide'  => 'bs-approuve',
                            'annule'  => 'bs-rejete',
                            default   => 'bs-attente',
                        };
                        $label = match($st) {
                            'valide'  => 'Valide',
                            'annule'  => 'Annule',
                            default   => 'Inscrit',
                        };
                        ?>
                        <span class="badge-statut <?= $cls ?>"><?= $label ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-tab">
            <div class="empty-tab-icon"><i class="fas fa-graduation-cap"></i></div>
            <p>Aucune formation enregistree.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ONGLET 5 : COMPETENCES ===== -->
<div class="tab-panel" id="tab-competences">
    <span class="print-section-title">Competences</span>

    <div class="card-dark">
        <div class="card-dark-title"><i class="fas fa-star"></i> Competences</div>
        <?php if (!empty($competences)): ?>
        <div class="competences-wrap">
            <?php foreach ($competences as $comp): ?>
            <span class="competence-tag">
                <i class="fas fa-check-circle" style="font-size:0.65rem;"></i>
                <?= esc($comp['Libelle_Cmp'] ?? '-') ?>
                <?php if (!empty($comp['Niveau_Obt'])): ?>
                <span class="niveau-badge"><?= esc($comp['Niveau_Obt']) ?></span>
                <?php endif; ?>
            </span>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-tab">
            <div class="empty-tab-icon"><i class="fas fa-star"></i></div>
            <p>Aucune competence enregistree.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ONGLET 6 : EVENEMENTS ===== -->
<div class="tab-panel" id="tab-evenements">
    <span class="print-section-title">Evenements</span>

    <div class="card-dark">
        <div class="card-dark-title"><i class="fas fa-calendar-alt"></i> Evenements</div>
        <?php if (!empty($evenements)): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evenements as $ev): ?>
                <tr>
                    <td><?= esc($ev['Libelle_Tev'] ?? '-') ?></td>
                    <td style="color:var(--c-text);font-weight:500;max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?= esc($ev['Description_Evt'] ?? '-') ?>
                    </td>
                    <td><?= !empty($ev['Date_Evt']) ? date('d/m/Y', strtotime($ev['Date_Evt'])) : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-tab">
            <div class="empty-tab-icon"><i class="fas fa-calendar-times"></i></div>
            <p>Aucun evenement enregistre.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pied de page impression -->
<div class="print-footer">
    Systeme RH ANSTAT &mdash; Document confidentiel &mdash; Genere le <?= date('d/m/Y') ?> a <?= date('H:i') ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function() {
    window.switchTab = function(tabId, btn) {
        document.querySelectorAll('.tab-panel').forEach(function(p) { p.classList.remove('active'); });
        document.querySelectorAll('.tab-btn').forEach(function(b)   { b.classList.remove('active'); });
        document.getElementById('tab-' + tabId).classList.add('active');
        btn.classList.add('active');
    };

    setTimeout(function() {
        var fill = document.getElementById('anciennete-fill');
        if (fill) fill.style.width = '<?= $anciennetePct ?>%';
    }, 400);
})();
</script>
<?= $this->endSection() ?>