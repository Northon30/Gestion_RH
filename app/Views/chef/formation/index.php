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
        --c-orange:         #F5A623;
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.6);
    }

    .filter-bar {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        padding: 14px 20px;
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .filter-bar input, .filter-bar select {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff; border-radius: 8px;
        padding: 7px 12px; font-size: 0.82rem; outline: none;
        transition: border-color 0.2s;
    }
    .filter-bar input:focus, .filter-bar select:focus { border-color: var(--c-primary); }
    .filter-bar select option { background: #222; }
    .filter-bar label { color: var(--c-muted); font-size: 0.78rem; white-space: nowrap; }
    .filter-group { display: flex; align-items: center; gap: 7px; }
    .btn-filter-reset { background: transparent; border: 1px solid rgba(220,53,69,0.3); color: var(--c-red); border-radius: 8px; padding: 7px 14px; font-size: 0.78rem; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; }
    .btn-filter-reset:hover { background: rgba(220,53,69,0.1); }

    .formations-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; }

    .formation-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        position: relative;
    }
    .formation-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.4); border-color: var(--c-primary-border); }

    .formation-card-top {
        padding: 18px 20px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }

    .formation-title {
        color: #fff;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .formation-meta {
        display: flex; flex-direction: column; gap: 6px;
    }

    .meta-item {
        display: flex; align-items: center; gap: 8px;
        color: var(--c-muted); font-size: 0.78rem;
    }
    .meta-item i { width: 14px; text-align: center; color: var(--c-accent); font-size: 0.75rem; }

    .formation-card-bottom {
        padding: 12px 20px;
        display: flex; align-items: center; justify-content: space-between;
    }

    .capacity-bar-wrap {
        flex: 1; margin-right: 12px;
    }
    .capacity-label { color: var(--c-muted); font-size: 0.72rem; margin-bottom: 4px; display: flex; justify-content: space-between; }
    .capacity-bar { height: 4px; background: rgba(255,255,255,0.06); border-radius: 4px; overflow: hidden; }
    .capacity-fill { height: 100%; border-radius: 4px; transition: width 0.4s; }
    .capacity-fill.low    { background: var(--c-green); }
    .capacity-fill.medium { background: var(--c-orange); }
    .capacity-fill.high   { background: var(--c-red); }
    .capacity-fill.full   { background: var(--c-red); }

    .badge-inscription {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 600; white-space: nowrap;
    }
    .badge-inscription.inscrit  { background: var(--c-primary-pale); border: 1px solid var(--c-primary-border); color: var(--c-accent); }
    .badge-inscription.valide   { background: rgba(144,201,127,0.12); border: 1px solid rgba(144,201,127,0.3); color: var(--c-green); }
    .badge-inscription.annule   { background: rgba(220,53,69,0.12); border: 1px solid rgba(220,53,69,0.3); color: var(--c-red); }
    .badge-inscription.non      { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--c-muted); }

    .badge-period {
        position: absolute; top: 14px; right: 14px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.68rem; font-weight: 700; letter-spacing: 0.5px;
    }
    .badge-period.avenir  { background: rgba(58,123,213,0.15); border: 1px solid var(--c-primary-border); color: var(--c-accent); }
    .badge-period.encours { background: rgba(144,201,127,0.12); border: 1px solid rgba(144,201,127,0.3); color: var(--c-green); }
    .badge-period.passe   { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--c-muted); }

    .btn-voir {
        background: var(--c-primary-pale);
        border: 1px solid var(--c-primary-border);
        color: var(--c-accent);
        border-radius: 8px; padding: 6px 14px;
        font-size: 0.78rem; font-weight: 600;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-voir:hover { background: rgba(58,123,213,0.2); color: var(--c-accent); }

    .empty-state { padding: 60px 20px; text-align: center; color: var(--c-muted); }
    .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3; }

    .alert-success-dark { background: rgba(144,201,127,0.1); border: 1px solid rgba(144,201,127,0.25); color: var(--c-green); border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .alert-error-dark   { background: rgba(220,53,69,0.1);   border: 1px solid rgba(220,53,69,0.25);   color: var(--c-red);   border-radius: 10px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

    .stats-bar {
        display: flex; gap: 16px; flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .stat-pill {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 10px;
        padding: 10px 16px;
        display: flex; align-items: center; gap: 10px;
        min-width: 130px;
    }
    .stat-pill i { color: var(--c-accent); font-size: 0.9rem; }
    .stat-pill .sp-val { color: #fff; font-size: 1.1rem; font-weight: 700; line-height: 1; }
    .stat-pill .sp-label { color: var(--c-muted); font-size: 0.72rem; margin-top: 2px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$today    = date('Y-m-d');
$aVenir   = array_filter($formations, fn($f) => $f['DateDebut_Frm'] > $today);
$enCours  = array_filter($formations, fn($f) => $f['DateDebut_Frm'] <= $today && $f['DateFin_Frm'] >= $today);
$terminees = array_filter($formations, fn($f) => $f['DateFin_Frm'] < $today);
$mesInscriptions = array_filter($formations, fn($f) => !empty($f['mon_inscription']));
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-graduation-cap me-2" style="color:var(--c-primary);"></i>Catalogue des Formations</h1>
        <p>Consultez les formations disponibles et les inscriptions</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Stats rapides -->
<div class="stats-bar">
    <div class="stat-pill">
        <i class="fas fa-list"></i>
        <div>
            <div class="sp-val"><?= count($formations) ?></div>
            <div class="sp-label">Total</div>
        </div>
    </div>
    <div class="stat-pill">
        <i class="fas fa-clock"></i>
        <div>
            <div class="sp-val" style="color:var(--c-accent);"><?= count($aVenir) ?></div>
            <div class="sp-label">À venir</div>
        </div>
    </div>
    <div class="stat-pill">
        <i class="fas fa-play-circle"></i>
        <div>
            <div class="sp-val" style="color:var(--c-green);"><?= count($enCours) ?></div>
            <div class="sp-label">En cours</div>
        </div>
    </div>
    <div class="stat-pill">
        <i class="fas fa-user-check"></i>
        <div>
            <div class="sp-val" style="color:var(--c-orange);"><?= count($mesInscriptions) ?></div>
            <div class="sp-label">Mes inscriptions</div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="filter-bar">
    <div class="filter-group">
        <label><i class="fas fa-filter me-1"></i>Période</label>
        <select id="f-periode">
            <option value="">Toutes</option>
            <option value="avenir">À venir</option>
            <option value="encours">En cours</option>
            <option value="passe">Terminées</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Inscription</label>
        <select id="f-inscription">
            <option value="">Toutes</option>
            <option value="inscrit">Inscrit</option>
            <option value="valide">Validé</option>
            <option value="non">Non inscrit</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Recherche</label>
        <input type="text" id="f-search" placeholder="Titre, formateur, lieu...">
    </div>
    <button class="btn-filter-reset" onclick="resetFiltres()">
        <i class="fas fa-times"></i> Réinitialiser
    </button>
    <span style="margin-left:auto;color:var(--c-muted);font-size:0.78rem;" id="count-label"><?= count($formations) ?> formation(s)</span>
</div>

<!-- Grille -->
<?php if (!empty($formations)): ?>
<div class="formations-grid" id="formations-grid">
    <?php foreach ($formations as $f): ?>
    <?php
    $pct      = $f['Capacite_Frm'] > 0 ? round($f['nb_inscrits'] / $f['Capacite_Frm'] * 100) : 0;
    $fillClass = $pct >= 100 ? 'full' : ($pct >= 75 ? 'high' : ($pct >= 40 ? 'medium' : 'low'));

    if ($f['DateDebut_Frm'] > $today)       { $periode = 'avenir';  $periodeLabel = 'À venir'; }
    elseif ($f['DateFin_Frm'] >= $today)    { $periode = 'encours'; $periodeLabel = 'En cours'; }
    else                                     { $periode = 'passe';   $periodeLabel = 'Terminée'; }

    $ins    = $f['mon_inscription'];
    $insStr = $ins ? $ins['Stt_Ins'] : 'non';
    $insLab = ['inscrit'=>'Inscrit','valide'=>'Confirmé','annule'=>'Annulé','non'=>'Non inscrit'];
    ?>
    <div class="formation-card"
         data-periode="<?= $periode ?>"
         data-inscription="<?= $insStr ?>"
         data-search="<?= strtolower($f['Description_Frm'].' '.$f['Formateur_Frm'].' '.$f['Lieu_Frm']) ?>">

        <span class="badge-period <?= $periode ?>"><?= $periodeLabel ?></span>

        <div class="formation-card-top">
            <div class="formation-title"><?= esc($f['Description_Frm']) ?></div>
            <div class="formation-meta">
                <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <?= date('d/m/Y', strtotime($f['DateDebut_Frm'])) ?>
                    <?php if ($f['DateFin_Frm'] != $f['DateDebut_Frm']): ?>
                    — <?= date('d/m/Y', strtotime($f['DateFin_Frm'])) ?>
                    <?php endif; ?>
                </div>
                <div class="meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= esc($f['Lieu_Frm']) ?>
                </div>
                <div class="meta-item">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <?= esc($f['Formateur_Frm']) ?>
                </div>
            </div>
        </div>

        <div class="formation-card-bottom">
            <div class="capacity-bar-wrap">
                <div class="capacity-label">
                    <span><?= $f['nb_inscrits'] ?> / <?= $f['Capacite_Frm'] ?> inscrits</span>
                    <span><?= $pct ?>%</span>
                </div>
                <div class="capacity-bar">
                    <div class="capacity-fill <?= $fillClass ?>" style="width:<?= min($pct,100) ?>%;"></div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
                <?php if ($ins): ?>
                <span class="badge-inscription <?= $ins['Stt_Ins'] ?>"><?= $insLab[$ins['Stt_Ins']] ?? $ins['Stt_Ins'] ?></span>
                <?php endif; ?>
                <a href="<?= base_url('formation/show/'.$f['id_Frm']) ?>" class="btn-voir">
                    <i class="fas fa-eye"></i> Voir
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="empty-state">
    <i class="fas fa-graduation-cap"></i>
    Aucune formation disponible
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function applyFiltres() {
    var periode     = document.getElementById('f-periode').value;
    var inscription = document.getElementById('f-inscription').value;
    var search      = document.getElementById('f-search').value.toLowerCase();
    var cards       = document.querySelectorAll('.formation-card');
    var visible     = 0;

    cards.forEach(function(card) {
        var ok = true;
        if (periode     && card.dataset.periode     !== periode)     ok = false;
        if (inscription && card.dataset.inscription !== inscription) ok = false;
        if (search      && !card.dataset.search.includes(search))   ok = false;
        card.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });

    document.getElementById('count-label').textContent = visible + ' formation(s)';
}

function resetFiltres() {
    document.getElementById('f-periode').value     = '';
    document.getElementById('f-inscription').value = '';
    document.getElementById('f-search').value      = '';
    applyFiltres();
}

['f-periode','f-inscription','f-search'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', applyFiltres);
});
</script>
<?= $this->endSection() ?>