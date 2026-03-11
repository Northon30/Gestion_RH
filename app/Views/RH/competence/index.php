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

    /* ===== STATS PILLS ===== */
    .stats-row { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; }

    .stat-pill {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 10px; padding: 12px 18px;
        display: flex; align-items: center; gap: 12px; flex: 1; min-width: 140px;
    }

    .stat-pill-icon {
        width: 34px; height: 34px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.82rem; flex-shrink: 0;
    }

    .stat-pill-val { color: #fff; font-size: 1.15rem; font-weight: 800; line-height: 1; }
    .stat-pill-lbl { color: var(--c-muted); font-size: 0.7rem; margin-top: 2px; }

    /* ===== LAYOUT GRILLE ===== */
    .main-grid { display: grid; grid-template-columns: 380px 1fr; gap: 16px; align-items: start; }

    /* ===== CARD GÉNÉRIQUE ===== */
    .card { background: var(--c-surface); border: 1px solid var(--c-border); border-radius: 14px; overflow: hidden; }

    .card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;
    }

    .card-header-left { display: flex; align-items: center; gap: 10px; }

    .card-icon {
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.82rem; flex-shrink: 0;
    }

    .card-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin: 0; }

    .card-count {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-size: 0.68rem; font-weight: 700;
        padding: 2px 9px; border-radius: 10px;
    }

    /* ===== RECHERCHE ===== */
    .search-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; margin-bottom: 16px;
    }

    .search-card-header {
        padding: 14px 18px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;
    }

    .search-card-body { padding: 16px 18px; }

    .filter-grid {
        display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 10px; margin-bottom: 0;
    }

    .filter-group { display: flex; flex-direction: column; gap: 5px; }

    .filter-label {
        font-size: 0.68rem; font-weight: 600; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
    }

    .filter-control {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.8rem;
        padding: 8px 11px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }

    .filter-control:focus { border-color: var(--c-orange-border); }
    .filter-control::placeholder { color: var(--c-muted); }
    .filter-control option { background: #1a1a1a; }

    /* ===== LISTE RÉFÉRENTIEL ===== */
    .cmp-list { padding: 8px; }

    .cmp-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px; border-radius: 9px; border: 1px solid transparent;
        cursor: pointer; transition: all 0.18s; text-decoration: none; margin-bottom: 4px;
    }

    .cmp-item:hover { background: var(--c-orange-pale); border-color: var(--c-orange-border); }
    .cmp-item:last-child { margin-bottom: 0; }

    .cmp-item-icon {
        width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 0.72rem;
    }

    .cmp-item-label { color: var(--c-text); font-size: 0.82rem; font-weight: 600; flex: 1; }
    .cmp-item-meta  { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }

    .mini-badge {
        font-size: 0.62rem; font-weight: 700; padding: 2px 7px; border-radius: 8px;
        display: inline-flex; align-items: center; gap: 3px;
    }

    .mb-total  { background: rgba(255,255,255,0.06); color: var(--c-soft); }
    .mb-deb    { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);  color: #5B9BF0; }
    .mb-inter  { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .mb-avance { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }

    .cmp-item-actions { display: flex; gap: 5px; opacity: 0; transition: opacity 0.2s; }
    .cmp-item:hover .cmp-item-actions { opacity: 1; }

    .btn-icon {
        width: 26px; height: 26px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.65rem; cursor: pointer; transition: all 0.15s; border: none; text-decoration: none;
    }

    .btn-icon-orange { background: var(--c-orange-pale); color: var(--c-orange); border: 1px solid var(--c-orange-border); }
    .btn-icon-red    { background: var(--c-red-pale);    color: #ff8080;          border: 1px solid var(--c-red-border); }
    .btn-icon:hover  { transform: scale(1.1); }

    .cmp-empty { padding: 30px; text-align: center; color: var(--c-muted); font-size: 0.8rem; }
    .cmp-empty i { font-size: 1.6rem; opacity: 0.25; margin-bottom: 8px; display: block; }

    /* ===== TABLEAU RÉSULTATS ===== */
    .result-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .result-table thead th {
        padding: 8px 14px; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--c-orange); background: var(--c-orange-pale);
        border-bottom: 1px solid var(--c-orange-border);
    }

    .result-table tbody td {
        padding: 10px 14px; color: var(--c-soft);
        border-bottom: 1px solid var(--c-border); vertical-align: middle;
    }

    .result-table tbody tr:last-child td { border-bottom: none; }
    .result-table tbody tr:hover td { background: rgba(245,166,35,0.02); }

    .emp-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.62rem; font-weight: 700; color: var(--c-orange);
        text-transform: uppercase; flex-shrink: 0; vertical-align: middle; margin-right: 8px;
    }

    .badge-niveau {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700;
    }

    .bn-debutant      { background: var(--c-blue-pale);   border: 1px solid var(--c-blue-border);  color: #5B9BF0; }
    .bn-intermediaire { background: var(--c-orange-pale); border: 1px solid var(--c-orange-border); color: var(--c-orange); }
    .bn-avance        { background: var(--c-green-pale);  border: 1px solid var(--c-green-border);  color: #7ab86a; }

    /* ===== PROMPT ===== */
    .search-prompt { padding: 50px 30px; text-align: center; }

    .search-prompt-icon {
        width: 60px; height: 60px; border-radius: 16px;
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--c-orange); font-size: 1.4rem; margin: 0 auto 14px;
    }

    .search-prompt h3 { color: #fff; font-size: 0.9rem; font-weight: 700; margin-bottom: 6px; }
    .search-prompt p  { color: var(--c-muted); font-size: 0.78rem; line-height: 1.5; margin: 0; }

    /* ===== BOUTONS ===== */
    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 8px 18px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px; text-decoration: none;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px; text-decoration: none;
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    /* Bouton réinitialiser ROUGE */
    .btn-danger {
        background: linear-gradient(135deg, #c0392b, #922b21);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 8px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
    }

    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(192,57,43,0.35); }

    /* Alerts */
    .alert-success-dark {
        background: var(--c-green-pale); border: 1px solid var(--c-green-border);
        border-radius: 10px; padding: 11px 16px; color: #7ab86a;
        font-size: 0.82rem; display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
    }

    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
    }

    .filter-active-badge {
        background: var(--c-orange-pale); border: 1px solid var(--c-orange-border);
        color: var(--c-orange); font-size: 0.68rem; font-weight: 700;
        padding: 2px 8px; border-radius: 8px;
    }

    .inline-search {
        display: flex; align-items: center; gap: 8px;
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; padding: 5px 10px; flex: 1; max-width: 220px;
    }

    .inline-search input {
        background: transparent; border: none; outline: none;
        color: var(--c-text); font-size: 0.78rem; width: 100%;
        font-family: 'Segoe UI', sans-serif;
    }

    .inline-search input::placeholder { color: var(--c-muted); }
    .inline-search i { color: var(--c-muted); font-size: 0.72rem; flex-shrink: 0; }

    /* ===== MODAL SUPPRESSION ===== */
    #modal-delete {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.65); z-index: 1040;
        backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
    }

    #modal-delete.is-open { display: flex; }

    @media (max-width: 960px) { .main-grid { grid-template-columns: 1fr; } .filter-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 560px) { .filter-grid { grid-template-columns: 1fr; } .stats-row { flex-direction: column; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-star me-2" style="color:#F5A623;"></i>Référentiel des compétences</h1>
        <p>Gérer les compétences et rechercher des employés par compétence</p>
    </div>
    <?php if ($idPfl == 1): ?>
    <a href="<?= base_url('competence/create') ?>" class="btn-orange">
        <i class="fas fa-plus"></i> Nouvelle compétence
    </a>
    <?php endif; ?>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark">
    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark">
    <i class="fas fa-exclamation-triangle"></i> <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-orange-pale);border:1px solid var(--c-orange-border);">
            <i class="fas fa-star" style="color:var(--c-orange);"></i>
        </div>
        <div>
            <div class="stat-pill-val"><?= $totalCompetences ?></div>
            <div class="stat-pill-lbl">Compétences</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:rgba(255,255,255,0.04);border:1px solid var(--c-border);">
            <i class="fas fa-link" style="color:var(--c-soft);"></i>
        </div>
        <div>
            <div class="stat-pill-val"><?= $totalAttributions ?></div>
            <div class="stat-pill-lbl">Attributions totales</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-blue-pale);border:1px solid var(--c-blue-border);">
            <i class="fas fa-seedling" style="color:#5B9BF0;"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:#5B9BF0;"><?= $totalDebutant ?></div>
            <div class="stat-pill-lbl">Débutants</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-orange-pale);border:1px solid var(--c-orange-border);">
            <i class="fas fa-layer-group" style="color:var(--c-orange);"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:var(--c-orange);"><?= $totalInter ?></div>
            <div class="stat-pill-lbl">Intermédiaires</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-green-pale);border:1px solid var(--c-green-border);">
            <i class="fas fa-trophy" style="color:#7ab86a;"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:#7ab86a;"><?= $totalAvance ?></div>
            <div class="stat-pill-lbl">Avancés</div>
        </div>
    </div>
</div>

<!-- Recherche — 100% client-side, aucun rechargement de page -->
<div class="search-card">
    <div class="search-card-header">
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="card-icon"><i class="fas fa-search"></i></div>
            <p class="card-title">Rechercher des employés par compétence</p>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <span class="filter-active-badge" id="filter-active-badge" style="display:none;">
                <i class="fas fa-filter"></i> <span id="filter-active-count">0</span> filtre(s) actif(s)
            </span>
            <button type="button" class="btn-danger" id="btn-reset-filters"
                    style="display:none;" onclick="resetFilters()">
                <i class="fas fa-times"></i> Réinitialiser
            </button>
        </div>
    </div>
    <div class="search-card-body">
        <div class="filter-grid">
            <div class="filter-group">
                <label class="filter-label">Recherche nom</label>
                <input type="text" id="f-search" class="filter-control" placeholder="Nom ou prénom...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Compétence</label>
                <select id="f-competence" class="filter-control">
                    <option value="">Toutes</option>
                    <?php foreach ($competences as $c): ?>
                    <option value="<?= $c['id_Cmp'] ?>"><?= esc($c['Libelle_Cmp']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Niveau</label>
                <select id="f-niveau" class="filter-control">
                    <option value="">Tous</option>
                    <option value="debutant">Débutant</option>
                    <option value="intermediaire">Intermédiaire</option>
                    <option value="avance">Avancé</option>
                </select>
            </div>
            <?php if ($idPfl == 1): ?>
            <div class="filter-group">
                <label class="filter-label">Direction</label>
                <select id="f-direction" class="filter-control">
                    <option value="">Toutes</option>
                    <?php foreach ($directions as $dir): ?>
                    <option value="<?= esc($dir['Nom_Dir']) ?>"><?= esc($dir['Nom_Dir']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php else: ?>
            <div><input type="hidden" id="f-direction" value=""></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Grille principale -->
<div class="main-grid">

    <!-- COL GAUCHE — Référentiel -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon"><i class="fas fa-list-alt"></i></div>
                <p class="card-title">Référentiel</p>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="card-count"><?= $totalCompetences ?></span>
                <div class="inline-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="cmp-search" placeholder="Filtrer..." oninput="filterCmpList()">
                </div>
            </div>
        </div>

        <?php if (empty($competences)): ?>
        <div class="cmp-empty">
            <i class="fas fa-star"></i>
            Aucune compétence dans le référentiel.
            <?php if ($idPfl == 1): ?>
            <br><a href="<?= base_url('competence/create') ?>"
                   style="color:var(--c-orange);font-size:0.78rem;margin-top:6px;display:inline-block;">
                Ajouter la première compétence
            </a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="cmp-list" id="cmp-list">
            <?php foreach ($competences as $c): ?>
            <a href="<?= base_url('competence/show/' . $c['id_Cmp']) ?>"
               class="cmp-item" data-label="<?= strtolower(esc($c['Libelle_Cmp'])) ?>">
                <div class="cmp-item-icon"><i class="fas fa-star"></i></div>
                <div style="flex:1;min-width:0;">
                    <div class="cmp-item-label"><?= esc($c['Libelle_Cmp']) ?></div>
                    <div class="cmp-item-meta" style="margin-top:4px;">
                        <span class="mini-badge mb-total">
                            <i class="fas fa-users"></i> <?= (int)$c['nb_employes'] ?>
                        </span>
                        <?php if ((int)$c['nb_debutant'] > 0): ?>
                        <span class="mini-badge mb-deb"><?= (int)$c['nb_debutant'] ?> deb.</span>
                        <?php endif; ?>
                        <?php if ((int)$c['nb_intermediaire'] > 0): ?>
                        <span class="mini-badge mb-inter"><?= (int)$c['nb_intermediaire'] ?> inter.</span>
                        <?php endif; ?>
                        <?php if ((int)$c['nb_avance'] > 0): ?>
                        <span class="mini-badge mb-avance"><?= (int)$c['nb_avance'] ?> avancé</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($idPfl == 1): ?>
                <div class="cmp-item-actions" onclick="event.preventDefault();">
                    <a href="<?= base_url('competence/edit/' . $c['id_Cmp']) ?>"
                       class="btn-icon btn-icon-orange" title="Modifier">
                        <i class="fas fa-pen"></i>
                    </a>
                    <button class="btn-icon btn-icon-red" title="Supprimer"
                            onclick="confirmDelete(<?= $c['id_Cmp'] ?>, '<?= esc($c['Libelle_Cmp'], 'js') ?>', <?= (int)$c['nb_employes'] ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
            <div id="cmp-no-match" style="display:none;" class="cmp-empty">
                <i class="fas fa-search"></i> Aucune compétence ne correspond.
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- COL DROITE — Résultats filtrés côté client -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <p class="card-title" id="results-title">Recherche d'employés</p>
            </div>
            <span class="card-count" id="results-count" style="display:none;"></span>
        </div>

        <!-- Prompt initial -->
        <div class="search-prompt" id="search-prompt">
            <div class="search-prompt-icon"><i class="fas fa-search"></i></div>
            <h3>Rechercher des employés</h3>
            <p>Utilisez les filtres ci-dessus pour trouver des employés<br>par compétence, niveau ou direction.</p>
        </div>

        <!-- Tableau — caché au chargement, révélé dès qu'un filtre est actif -->
        <div id="results-table-wrap" style="display:none;">
            <table class="result-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employé</th>
                        <th>Compétence</th>
                        <th>Niveau</th>
                        <?php if ($idPfl == 1): ?><th>Direction</th><?php endif; ?>
                        <th>Date obtention</th>
                        <th style="text-align:center;">Détail</th>
                    </tr>
                </thead>
                <tbody id="results-tbody">
                    <?php foreach ($resultats as $r):
                        [$bnCls, $bnLabel] = match($r['Niveau_Obt']) {
                            'debutant'      => ['bn-debutant',      'Débutant'],
                            'intermediaire' => ['bn-intermediaire', 'Intermédiaire'],
                            'avance'        => ['bn-avance',        'Avancé'],
                            default         => ['bn-debutant',       $r['Niveau_Obt']],
                        };
                    ?>
                    <tr class="result-row"
                        data-nom="<?= strtolower(esc(($r['Nom_Emp'] ?? '') . ' ' . ($r['Prenom_Emp'] ?? ''))) ?>"
                        data-competence="<?= $r['id_Cmp'] ?>"
                        data-niveau="<?= esc($r['Niveau_Obt']) ?>"
                        data-direction="<?= strtolower(esc($r['Nom_Dir'] ?? '')) ?>">
                        <td class="row-num" style="color:var(--c-muted);font-size:0.7rem;"></td>
                        <td>
                            <span class="emp-avatar">
                                <?= mb_substr($r['Nom_Emp'] ?? '?', 0, 1) . mb_substr($r['Prenom_Emp'] ?? '', 0, 1) ?>
                            </span>
                            <span style="color:#fff;font-weight:500;">
                                <?= esc(($r['Nom_Emp'] ?? '') . ' ' . ($r['Prenom_Emp'] ?? '')) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('competence/show/' . $r['id_Cmp']) ?>"
                               style="color:var(--c-orange);font-size:0.78rem;text-decoration:none;font-weight:600;">
                                <?= esc($r['Libelle_Cmp']) ?>
                            </a>
                        </td>
                        <td>
                            <span class="badge-niveau <?= $bnCls ?>"><?= $bnLabel ?></span>
                        </td>
                        <?php if ($idPfl == 1): ?>
                        <td style="color:var(--c-muted);font-size:0.75rem;"><?= esc($r['Nom_Dir'] ?? '-') ?></td>
                        <?php endif; ?>
                        <td style="color:var(--c-muted);font-size:0.75rem;white-space:nowrap;">
                            <?= $r['Dte_Obt'] ? date('d/m/Y', strtotime($r['Dte_Obt'])) : '-' ?>
                        </td>
                        <td style="text-align:center;">
                            <a href="<?= base_url('employe/show/' . $r['id_Emp']) ?>"
                               class="btn-icon btn-icon-orange" title="Voir l'employé">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="no-results-row" style="display:none;padding:36px;text-align:center;">
                <i class="fas fa-users-slash"
                   style="font-size:1.6rem;color:var(--c-muted);opacity:0.3;display:block;margin-bottom:10px;"></i>
                <span style="color:var(--c-muted);font-size:0.82rem;">Aucun employé ne correspond aux critères.</span>
            </div>

            <div style="padding:10px 16px;border-top:1px solid var(--c-border);">
                <span style="font-size:0.73rem;color:var(--c-muted);" id="results-footer"></span>
            </div>
        </div>
    </div>

</div><!-- /.main-grid -->

<?php if ($idPfl == 1): ?>
<!-- Modal suppression -->
<div id="modal-delete" role="dialog" aria-modal="true" aria-labelledby="modal-delete-title">
    <div style="background:#1e1e1e;border:1px solid rgba(255,255,255,0.08);border-radius:14px;
                padding:26px;width:100%;max-width:380px;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <div style="width:46px;height:46px;border-radius:12px;background:var(--c-red-pale);
                    border:1px solid var(--c-red-border);display:flex;align-items:center;
                    justify-content:center;font-size:1.1rem;color:#ff8080;margin:0 auto 12px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 id="modal-delete-title"
            style="color:#fff;font-size:0.9rem;font-weight:700;text-align:center;margin-bottom:8px;">
            Confirmer la suppression
        </h5>
        <p style="color:var(--c-muted);font-size:0.8rem;text-align:center;margin:0;line-height:1.5;"
           id="modal-delete-msg"></p>
        <div style="display:flex;gap:10px;margin-top:20px;">
            <button type="button" onclick="closeDeleteModal()"
                    style="flex:1;background:transparent;border:1px solid var(--c-border);
                           color:var(--c-soft);font-weight:600;border-radius:8px;
                           padding:9px 16px;font-size:0.82rem;cursor:pointer;">
                <i class="fas fa-times"></i> Annuler
            </button>
            <form id="form-delete" method="POST" style="flex:1;">
                <?= csrf_field() ?>
                <button id="btn-delete-confirm" type="submit"
                        style="width:100%;background:linear-gradient(135deg,#c0392b,#922b21);
                               border:none;color:#fff;font-weight:700;border-radius:8px;
                               padding:9px 16px;font-size:0.82rem;cursor:pointer;">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    // ===== FILTRE INLINE RÉFÉRENTIEL (colonne gauche) =====
    window.filterCmpList = function () {
        var q     = document.getElementById('cmp-search').value.toLowerCase().trim();
        var items = document.querySelectorAll('#cmp-list .cmp-item');
        var nb    = 0;
        items.forEach(function (item) {
            var match = !q || (item.getAttribute('data-label') || '').includes(q);
            item.style.display = match ? '' : 'none';
            if (match) nb++;
        });
        var noMatch = document.getElementById('cmp-no-match');
        if (noMatch) noMatch.style.display = nb === 0 ? 'block' : 'none';
    };

    // ===== FILTRE CLIENT-SIDE COLONNE DROITE =====
    var rows          = document.querySelectorAll('.result-row');
    var prompt        = document.getElementById('search-prompt');
    var tableWrap     = document.getElementById('results-table-wrap');
    var noResultsRow  = document.getElementById('no-results-row');
    var resultsTitle  = document.getElementById('results-title');
    var resultsCount  = document.getElementById('results-count');
    var resultsFooter = document.getElementById('results-footer');
    var activeBadge   = document.getElementById('filter-active-badge');
    var activeCount   = document.getElementById('filter-active-count');
    var btnReset      = document.getElementById('btn-reset-filters');

    var filterIds = ['f-search', 'f-competence', 'f-niveau', 'f-direction'];

    function applyFilters() {
        var search     = document.getElementById('f-search').value.trim().toLowerCase();
        var competence = document.getElementById('f-competence').value;
        var niveau     = document.getElementById('f-niveau').value;
        var dirEl      = document.getElementById('f-direction');
        var direction  = dirEl ? dirEl.value.toLowerCase() : '';

        // Nombre de filtres actifs
        var actifs = [search, competence, niveau, direction].filter(function (v) { return v !== ''; }).length;

        activeCount.textContent       = actifs;
        activeBadge.style.display     = actifs > 0 ? '' : 'none';
        btnReset.style.display        = actifs > 0 ? '' : 'none';

        // Aucun filtre → afficher le prompt, cacher le tableau
        if (actifs === 0) {
            prompt.style.display         = '';
            tableWrap.style.display      = 'none';
            resultsTitle.textContent     = 'Recherche d\'employés';
            resultsCount.style.display   = 'none';
            return;
        }

        // Filtrer les lignes
        var visible = 0;
        rows.forEach(function (row) {
            var match =
                (search     === '' || row.dataset.nom.includes(search)) &&
                (competence === '' || row.dataset.competence === competence) &&
                (niveau     === '' || row.dataset.niveau === niveau) &&
                (direction  === '' || row.dataset.direction.includes(direction));

            if (match) {
                row.style.display = '';
                visible++;
                var numCell = row.querySelector('.row-num');
                if (numCell) numCell.textContent = visible;
            } else {
                row.style.display = 'none';
            }
        });

        prompt.style.display         = 'none';
        tableWrap.style.display      = '';
        noResultsRow.style.display   = visible === 0 ? '' : 'none';
        resultsTitle.textContent     = 'Résultats de la recherche';
        resultsCount.style.display   = '';
        resultsCount.textContent     = visible + ' résultat(s)';
        resultsFooter.textContent    = visible + ' employé(s) affiché(s)';
    }

    window.resetFilters = function () {
        filterIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });
        applyFilters();
    };

    // Écouter tous les filtres — live, sans rechargement
    filterIds.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input',  applyFilters);
            el.addEventListener('change', applyFilters);
        }
    });

    // ===== MODAL SUPPRESSION =====
    window.confirmDelete = function (id, label, nbEmp) {
        var modal      = document.getElementById('modal-delete');
        var msg        = document.getElementById('modal-delete-msg');
        var form       = document.getElementById('form-delete');
        var btnConfirm = document.getElementById('btn-delete-confirm');

        if (!modal) return;

        if (nbEmp > 0) {
            msg.innerHTML = '<span style="color:#ff8080;font-weight:700;">' + label + '</span>'
                + ' est attribuée à <strong style="color:#fff;">' + nbEmp + '</strong> employé(s).<br>'
                + 'Retirez-la d\'abord de tous les profils avant de supprimer.';
            btnConfirm.style.display = 'none';
            btnConfirm.disabled      = true;
        } else {
            msg.innerHTML = 'Vous allez supprimer la compétence <span style="color:#fff;font-weight:700;">'
                + label + '</span> de façon définitive.';
            btnConfirm.style.display = '';
            btnConfirm.disabled      = false;
            form.action = '<?= base_url('competence/delete/') ?>' + id;
        }

        modal.classList.add('is-open');
    };

    window.closeDeleteModal = function () {
        var modal = document.getElementById('modal-delete');
        if (modal) modal.classList.remove('is-open');
    };

    var modal = document.getElementById('modal-delete');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === this) closeDeleteModal();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

})();
</script>
<?= $this->endSection() ?>