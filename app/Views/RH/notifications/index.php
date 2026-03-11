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

    /* ── Stats ── */
    .stats-row { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; }
    .stat-pill {
        background:var(--c-surface); border:1px solid var(--c-border);
        border-radius:10px; padding:12px 18px;
        display:flex; align-items:center; gap:12px; flex:1; min-width:130px;
    }
    .stat-pill-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        font-size:0.82rem; flex-shrink:0;
    }
    .stat-pill-val { color:#fff; font-size:1.15rem; font-weight:800; line-height:1; }
    .stat-pill-lbl { color:var(--c-muted); font-size:0.7rem; margin-top:2px; }

    /* ── Card ── */
    .card { background:var(--c-surface); border:1px solid var(--c-border); border-radius:14px; overflow:hidden; }

    .card-header {
        padding:14px 18px; border-bottom:1px solid var(--c-border);
        display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
    }
    .card-header-left { display:flex; align-items:center; gap:10px; }
    .card-icon {
        width:34px; height:34px; border-radius:8px;
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        display:flex; align-items:center; justify-content:center;
        color:var(--c-orange); font-size:0.82rem; flex-shrink:0;
    }
    .card-title { color:#fff; font-size:0.85rem; font-weight:700; margin:0; }
    .card-count {
        background:var(--c-orange-pale); border:1px solid var(--c-orange-border);
        color:var(--c-orange); font-size:0.68rem; font-weight:700;
        padding:2px 9px; border-radius:10px;
    }

    /* ── Filtres ── */
    .filter-bar {
        padding:10px 14px; border-bottom:1px solid var(--c-border);
        display:flex; gap:8px; flex-wrap:wrap; align-items:flex-end;
    }
    .filter-group { display:flex; flex-direction:column; gap:4px; }
    .filter-lbl {
        font-size:0.62rem; font-weight:600; color:var(--c-muted);
        text-transform:uppercase; letter-spacing:0.5px;
    }
    .filter-ctrl {
        background:#111; border:1px solid var(--c-border);
        border-radius:7px; color:var(--c-text); font-size:0.75rem;
        padding:6px 9px; outline:none; transition:border-color 0.2s;
        font-family:'Segoe UI',sans-serif;
    }
    .filter-ctrl:focus { border-color:var(--c-orange-border); }

    /* ── Liste notifications ── */
    .notif-list { display:flex; flex-direction:column; }

    .notif-item {
        display:flex; align-items:flex-start; gap:14px;
        padding:14px 18px; border-bottom:1px solid var(--c-border);
        transition:background 0.18s; position:relative; cursor:pointer;
    }
    .notif-item:last-child  { border-bottom:none; }
    .notif-item:hover       { background:rgba(255,255,255,0.02); }
    .notif-item.unread      { background:rgba(245,166,35,0.04); }
    .notif-item.unread:hover{ background:rgba(245,166,35,0.07); }

    .notif-icon {
        width:40px; height:40px; border-radius:11px; border:1px solid;
        display:flex; align-items:center; justify-content:center;
        font-size:0.88rem; flex-shrink:0; margin-top:2px;
    }

    .notif-body { flex:1; min-width:0; }

    .notif-title {
        color:#fff; font-size:0.84rem; font-weight:600;
        margin-bottom:3px; display:flex; align-items:center; gap:8px;
    }

    .notif-dot {
        width:7px; height:7px; background:var(--c-orange);
        border-radius:50%; flex-shrink:0; display:inline-block;
    }

    .notif-msg {
        color:var(--c-soft); font-size:0.78rem; line-height:1.45;
        margin-bottom:6px;
    }

    .notif-meta {
        display:flex; align-items:center; gap:12px; flex-wrap:wrap;
    }

    .notif-time {
        color:var(--c-muted); font-size:0.7rem;
        display:flex; align-items:center; gap:4px;
    }

    .notif-type-badge {
        font-size:0.65rem; font-weight:700; padding:1px 8px;
        border-radius:20px; border:1px solid;
    }

    .notif-actions {
        display:flex; gap:6px; flex-shrink:0; align-items:flex-start;
        padding-top:2px;
    }

    .btn-icon {
        width:27px; height:27px; border-radius:6px;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.65rem; cursor:pointer; transition:all 0.15s; border:none;
    }
    .btn-icon-orange { background:var(--c-orange-pale); color:var(--c-orange); border:1px solid var(--c-orange-border); }
    .btn-icon-red    { background:var(--c-red-pale);    color:#ff8080;          border:1px solid var(--c-red-border); }
    .btn-icon:hover  { transform:scale(1.1); }

    /* ── Boutons header ── */
    .btn-orange {
        background:linear-gradient(135deg,var(--c-orange),#d4891a);
        border:none; color:#111; font-weight:700; border-radius:8px;
        padding:7px 14px; font-size:0.78rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; text-decoration:none;
    }
    .btn-orange:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(245,166,35,0.3); color:#111; }

    .btn-ghost {
        background:transparent; border:1px solid var(--c-border);
        color:var(--c-soft); font-weight:600; border-radius:8px;
        padding:7px 14px; font-size:0.78rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:6px;
    }
    .btn-ghost:hover { background:rgba(255,255,255,0.04); color:var(--c-text); }

    .btn-danger {
        background:linear-gradient(135deg,#c0392b,#922b21);
        border:none; color:#fff; font-weight:700; border-radius:8px;
        padding:7px 14px; font-size:0.78rem; cursor:pointer;
        transition:all 0.2s; display:inline-flex; align-items:center; gap:6px;
    }
    .btn-danger:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(192,57,43,0.35); }

    /* ── Alerts ── */
    .alert-success-dark {
        background:var(--c-green-pale); border:1px solid var(--c-green-border);
        border-radius:10px; padding:11px 16px; color:#7ab86a;
        font-size:0.82rem; display:flex; align-items:center; gap:10px; margin-bottom:14px;
    }

    .empty-state { padding:48px; text-align:center; color:var(--c-muted); font-size:0.82rem; }
    .empty-state i { font-size:2rem; opacity:0.15; margin-bottom:10px; display:block; }

    .table-footer {
        padding:10px 16px; border-top:1px solid var(--c-border);
        font-size:0.73rem; color:var(--c-muted);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$typeIcons = [
    'conge'      => 'fa-umbrella-beach',
    'absence'    => 'fa-user-minus',
    'formation'  => 'fa-graduation-cap',
    'evenement'  => 'fa-calendar-alt',
    'competence' => 'fa-star',
    'info'       => 'fa-info-circle',
];

$typeColors = [
    'conge'      => '#F5A623',
    'absence'    => '#ff6b7a',
    'formation'  => '#6ea8fe',
    'evenement'  => '#90c97f',
    'competence' => '#c29ffa',
    'info'       => '#888888',
];

$typeLabels = [
    'conge'      => 'Congé',
    'absence'    => 'Absence',
    'formation'  => 'Formation',
    'evenement'  => 'Événement',
    'competence' => 'Compétence',
    'info'       => 'Info',
];

$total   = count($notifications);
$lues    = count(array_filter($notifications, fn($n) => $n['Lu_Notif'] == 1));

if (!function_exists('timeAgo_notif')) {
    function timeAgo_notif(string $datetime): string {
        $now  = new DateTime();
        $past = new DateTime($datetime);
        $diff = $now->diff($past);
        if ($diff->days == 0) {
            if ($diff->h == 0) {
                if ($diff->i == 0) return 'À l\'instant';
                return 'Il y a ' . $diff->i . ' min';
            }
            return 'Il y a ' . $diff->h . 'h';
        }
        if ($diff->days == 1) return 'Hier';
        if ($diff->days  < 7) return 'Il y a ' . $diff->days . ' jours';
        return $past->format('d/m/Y à H:i');
    }
}
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-bell me-2" style="color:#F5A623;"></i>Notifications</h1>
        <p><?= $nonLues ?> non lue(s) sur <?= $total ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <?php if ($nonLues > 0): ?>
        <button type="button" class="btn-ghost" onclick="marquerToutesLues()">
            <i class="fas fa-check-double"></i> Tout marquer lu
        </button>
        <?php endif; ?>
        <?php if ($lues > 0): ?>
        <form method="POST" action="<?= base_url('notifications/delete-toutes') ?>"
              onsubmit="return confirm('Supprimer toutes les notifications lues ?')">
            <?= csrf_field() ?>
            <button type="submit" class="btn-danger">
                <i class="fas fa-trash-alt"></i> Supprimer les lues
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark">
    <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-orange-pale);border:1px solid var(--c-orange-border);">
            <i class="fas fa-bell" style="color:var(--c-orange);"></i>
        </div>
        <div>
            <div class="stat-pill-val"><?= $total ?></div>
            <div class="stat-pill-lbl">Total</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-red-pale);border:1px solid var(--c-red-border);">
            <i class="fas fa-bell" style="color:#ff8080;"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:#ff8080;"><?= $nonLues ?></div>
            <div class="stat-pill-lbl">Non lues</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon" style="background:var(--c-green-pale);border:1px solid var(--c-green-border);">
            <i class="fas fa-check-double" style="color:#7ab86a;"></i>
        </div>
        <div>
            <div class="stat-pill-val" style="color:#7ab86a;"><?= $lues ?></div>
            <div class="stat-pill-lbl">Lues</div>
        </div>
    </div>
</div>

<!-- Liste -->
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-icon"><i class="fas fa-bell"></i></div>
            <p class="card-title">Toutes les notifications</p>
        </div>
        <span class="card-count" id="notif-count"><?= $total ?></span>
    </div>

    <!-- Filtres -->
    <div class="filter-bar">
        <div class="filter-group">
            <label class="filter-lbl">Recherche</label>
            <input type="text" id="f-search" class="filter-ctrl"
                   placeholder="Titre, message..." style="width:220px;"
                   oninput="filterNotifs()">
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Type</label>
            <select id="f-type" class="filter-ctrl" onchange="filterNotifs()">
                <option value="">Tous</option>
                <option value="conge">Congé</option>
                <option value="absence">Absence</option>
                <option value="formation">Formation</option>
                <option value="evenement">Événement</option>
                <option value="competence">Compétence</option>
                <option value="info">Info</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-lbl">Statut</label>
            <select id="f-statut" class="filter-ctrl" onchange="filterNotifs()">
                <option value="">Tous</option>
                <option value="unread">Non lues</option>
                <option value="read">Lues</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-lbl">&nbsp;</label>
            <button type="button" class="btn-danger" id="btn-reset"
                    style="display:none;" onclick="resetFilters()">
                <i class="fas fa-times"></i> Réinitialiser
            </button>
        </div>
    </div>

    <?php if (empty($notifications)): ?>
    <div class="empty-state">
        <i class="fas fa-bell-slash"></i>
        Aucune notification pour le moment.
    </div>
    <?php else: ?>

    <div class="notif-list" id="notif-list">
        <?php foreach ($notifications as $n): ?>
        <?php
        $type   = $n['Type_Notif'] ?? 'info';
        $icon   = $typeIcons[$type]  ?? 'fa-info-circle';
        $color  = $typeColors[$type] ?? '#888888';
        $label  = $typeLabels[$type] ?? 'Info';
        $unread = $n['Lu_Notif'] == 0;
        ?>
        <div class="notif-item <?= $unread ? 'unread' : '' ?>"
             id="notif-<?= $n['id_Notif'] ?>"
             data-search="<?= strtolower(esc($n['Titre_Notif'] . ' ' . $n['Message_Notif'])) ?>"
             data-type="<?= esc($type) ?>"
             data-statut="<?= $unread ? 'unread' : 'read' ?>">

            <!-- Icône -->
            <div class="notif-icon"
                 style="background:<?= $color ?>18;border-color:<?= $color ?>40;">
                <i class="fas <?= $icon ?>" style="color:<?= $color ?>;"></i>
            </div>

            <!-- Corps -->
            <div class="notif-body">
                <div class="notif-title">
                    <?php if ($unread): ?>
                    <span class="notif-dot"></span>
                    <?php endif; ?>
                    <?= esc($n['Titre_Notif']) ?>
                </div>
                <div class="notif-msg"><?= esc($n['Message_Notif']) ?></div>
                <div class="notif-meta">
                    <span class="notif-time">
                        <i class="fas fa-clock"></i>
                        <?= timeAgo_notif($n['DateHeure_Notif']) ?>
                    </span>
                    <span class="notif-type-badge"
                          style="background:<?= $color ?>15;border-color:<?= $color ?>40;color:<?= $color ?>;">
                        <?= $label ?>
                    </span>
                    <?php if (!empty($n['src_nom'])): ?>
                    <span class="notif-time">
                        <i class="fas fa-user"></i>
                        <?= esc($n['src_nom'] . ' ' . $n['src_prenom']) ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="notif-actions">
                <?php if ($n['Lien_Notif'] ?? ''): ?>
                <a href="<?= esc($n['Lien_Notif']) ?>"
                   class="btn-icon btn-icon-orange" title="Voir"
                   onclick="marquerLue(<?= $n['id_Notif'] ?>)">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <?php endif; ?>
                <?php if ($unread): ?>
                <button class="btn-icon btn-icon-orange" title="Marquer comme lue"
                        onclick="marquerLue(<?= $n['id_Notif'] ?>)">
                    <i class="fas fa-check"></i>
                </button>
                <?php endif; ?>
                <button class="btn-icon btn-icon-red" title="Supprimer"
                        onclick="supprimerNotif(<?= $n['id_Notif'] ?>)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="no-match" style="display:none;" class="empty-state">
        <i class="fas fa-search"></i> Aucune notification ne correspond aux filtres.
    </div>

    <div class="table-footer" id="table-footer">
        <?= $total ?> notification(s) au total
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    var CSRF_NAME  = '<?= csrf_token() ?>';
    var CSRF_VALUE = '<?= csrf_hash() ?>';
    var btnReset   = document.getElementById('btn-reset');

    // ── Filtres ──────────────────────────────────────────────
    window.filterNotifs = function () {
        var search = document.getElementById('f-search').value.trim().toLowerCase();
        var type   = document.getElementById('f-type').value;
        var statut = document.getElementById('f-statut').value;

        btnReset.style.display = (search || type || statut) ? '' : 'none';

        var items   = document.querySelectorAll('.notif-item');
        var visible = 0;

        items.forEach(function (item) {
            var match =
                (search === '' || item.dataset.search.includes(search)) &&
                (type   === '' || item.dataset.type   === type)         &&
                (statut === '' || item.dataset.statut === statut);

            item.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        var noMatch = document.getElementById('no-match');
        var footer  = document.getElementById('table-footer');
        var counter = document.getElementById('notif-count');

        if (noMatch) noMatch.style.display = visible === 0 && items.length > 0 ? 'block' : 'none';
        if (footer)  footer.textContent    = visible + ' notification(s) affichée(s)';
        if (counter) counter.textContent   = visible;
    };

    window.resetFilters = function () {
        document.getElementById('f-search').value = '';
        document.getElementById('f-type').value   = '';
        document.getElementById('f-statut').value = '';
        filterNotifs();
    };

    // ── Marquer une notif lue ────────────────────────────────
    window.marquerLue = function (id) {
        fetch('<?= base_url('notifications/lire/') ?>' + id, {
            method:  'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type':     'application/x-www-form-urlencoded',
            },
            body: CSRF_NAME + '=' + CSRF_VALUE,
        }).then(function () {
            var item = document.getElementById('notif-' + id);
            if (!item) return;
            item.classList.remove('unread');
            item.dataset.statut = 'read';

            // Supprimer le dot
            var dot = item.querySelector('.notif-dot');
            if (dot) dot.remove();

            // Supprimer le bouton "marquer lue"
            var btns = item.querySelectorAll('.btn-icon-orange');
            btns.forEach(function (b) {
                if (b.title === 'Marquer comme lue') b.remove();
            });

            majCompteurs();
        });
    };

    // ── Marquer toutes lues ──────────────────────────────────
    window.marquerToutesLues = function () {
        fetch('<?= base_url('notifications/lire-toutes') ?>', {
            method:  'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type':     'application/x-www-form-urlencoded',
            },
            body: CSRF_NAME + '=' + CSRF_VALUE,
        }).then(function () {
            document.querySelectorAll('.notif-item.unread').forEach(function (item) {
                item.classList.remove('unread');
                item.dataset.statut = 'read';
                var dot = item.querySelector('.notif-dot');
                if (dot) dot.remove();
                var btns = item.querySelectorAll('.btn-icon-orange');
                btns.forEach(function (b) {
                    if (b.title === 'Marquer comme lue') b.remove();
                });
            });
            majCompteurs();
            // Cacher le bouton "tout marquer lu"
            var btnTout = document.querySelector('[onclick="marquerToutesLues()"]');
            if (btnTout) btnTout.style.display = 'none';
        });
    };

    // ── Supprimer une notif ──────────────────────────────────
    window.supprimerNotif = function (id) {
        if (!confirm('Supprimer cette notification ?')) return;

        fetch('<?= base_url('notifications/delete/') ?>' + id, {
            method:  'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type':     'application/x-www-form-urlencoded',
            },
            body: CSRF_NAME + '=' + CSRF_VALUE,
        }).then(function () {
            var item = document.getElementById('notif-' + id);
            if (item) {
                item.style.opacity    = '0';
                item.style.transition = 'opacity 0.2s';
                setTimeout(function () {
                    item.remove();
                    majCompteurs();
                }, 200);
            }
        });
    };

    // ── Mise à jour compteurs ────────────────────────────────
    function majCompteurs() {
        var items   = document.querySelectorAll('.notif-item');
        var nonLues = document.querySelectorAll('.notif-item.unread').length;
        var total   = items.length;

        // Navbar badge
        var badge = document.getElementById('notifBadge');
        if (badge) {
            if (nonLues > 0) {
                badge.textContent   = nonLues > 99 ? '99+' : nonLues;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // Footer
        var footer = document.getElementById('table-footer');
        if (footer) footer.textContent = total + ' notification(s) au total';

        var counter = document.getElementById('notif-count');
        if (counter) counter.textContent = total;
    }

})();
</script>
<?= $this->endSection() ?>