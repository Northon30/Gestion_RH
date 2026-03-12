<?php
use App\Models\NotificationModel;

$notifModel = new NotificationModel();
$idEmp      = (int) session()->get('id_Emp');
$idPfl      = (int) session()->get('id_Pfl');
$nonLues    = $idEmp ? $notifModel->nonLues($idEmp) : 0;
$dernieres  = $idEmp ? $notifModel->dernieres($idEmp, 5) : [];

// Palette (même logique que sidebar)
$themeColor = match($idPfl) {
    1       => '#F5A623',
    2       => '#3A7BD5',
    default => '#6BAF6B',
};
$themeRgb = match($idPfl) {
    1       => '245,166,35',
    2       => '58,123,213',
    default => '107,175,107',
};

$typeIcons = [
    'conge'      => 'fa-umbrella-beach',
    'absence'    => 'fa-user-minus',
    'formation'  => 'fa-graduation-cap',
    'evenement'  => 'fa-calendar-alt',
    'competence' => 'fa-star',
    'info'       => 'fa-info-circle',
];

$typeColors = [
    'conge'      => $themeColor,
    'absence'    => '#ff6b7a',
    'formation'  => '#6ea8fe',
    'evenement'  => '#90c97f',
    'competence' => '#c29ffa',
    'info'       => '#888888',
];

if (!function_exists('timeAgo_navbar')) {
    function timeAgo_navbar(string $datetime): string {
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
        return $past->format('d/m/Y');
    }
}
?>

<!-- ════════════════════════════════════════════════════════════
     STYLES — variables reprises depuis sidebar (déjà définies)
════════════════════════════════════════════════════════════ -->
<style>
.top-navbar {
    height: 60px;
    background: #111111;
    border-bottom: 1px solid rgba(<?= $themeRgb ?>, 0.12);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    position: fixed;
    top: 0; left: 250px; right: 0;
    z-index: 100;
    backdrop-filter: blur(10px);
}

.navbar-title {
    color: rgba(255,255,255,0.55);
    font-size: 0.88rem;
    font-weight: 500;
}

.navbar-title i { color: var(--c-theme) !important; }

.navbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Bouton icône */
.icon-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    color: rgba(255,255,255,0.55);
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center;
    position: relative;
}

.icon-btn:hover {
    background: var(--c-theme-pale);
    border-color: var(--c-theme-border);
    color: var(--c-theme);
}

/* Badge rouge */
.notif-badge {
    position: absolute;
    top: -5px; right: -5px;
    background: #dc3545;
    color: #fff;
    font-size: 0.58rem; font-weight: 700;
    min-width: 17px; height: 17px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 3px;
    border: 2px solid #111111;
    animation: pulseBadge 2s infinite;
}

@keyframes pulseBadge {
    0%,100% { transform: scale(1);    }
    50%     { transform: scale(1.18); }
}

/* Dropdown notifications */
.notif-wrapper    { position: relative; }

.notif-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 10px); right: 0;
    width: 370px;
    background: #1c1c1c;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    box-shadow: 0 24px 64px rgba(0,0,0,0.55);
    z-index: 1000;
    overflow: hidden;
    animation: fadeSlide 0.18s ease;
}

.notif-dropdown.open { display: block; }

@keyframes fadeSlide {
    from { opacity:0; transform:translateY(-6px); }
    to   { opacity:1; transform:translateY(0);    }
}

.nd-header {
    padding: 14px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    display: flex; align-items: center; justify-content: space-between;
    color: #fff; font-size: 0.88rem; font-weight: 600;
}

.nd-count {
    background: var(--c-theme-pale);
    color: var(--c-theme);
    border: 1px solid var(--c-theme-border);
    font-size: 0.7rem; font-weight: 700;
    padding: 1px 7px; border-radius: 20px;
}

.nd-read-all {
    background: none; border: none;
    color: rgba(255,255,255,0.35);
    font-size: 0.75rem; cursor: pointer;
    transition: color 0.2s;
}
.nd-read-all:hover { color: var(--c-theme); }

.nd-list {
    max-height: 310px; overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.08) transparent;
}

.nd-item {
    display: flex; align-items: flex-start; gap: 11px;
    padding: 11px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.03);
    cursor: pointer; transition: background 0.18s; position: relative;
}

.nd-item:hover        { background: rgba(255,255,255,0.03); }
.nd-item.unread       { background: rgba(<?= $themeRgb ?>, 0.04); }
.nd-item.unread:hover { background: rgba(<?= $themeRgb ?>, 0.08); }

.nd-icon {
    width: 36px; height: 36px; border-radius: 9px; border: 1px solid;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.82rem; flex-shrink: 0; margin-top: 2px;
}

.nd-body { flex: 1; min-width: 0; }

.nd-title {
    color: #fff; font-size: 0.81rem; font-weight: 600;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 3px;
}

.nd-msg  { color: rgba(255,255,255,0.4); font-size: 0.76rem; line-height: 1.35; margin-bottom: 4px; }
.nd-time { color: rgba(255,255,255,0.22); font-size: 0.7rem; display: flex; align-items: center; gap: 4px; }

.nd-dot {
    width: 7px; height: 7px;
    background: var(--c-theme);
    border-radius: 50%; flex-shrink: 0; margin-top: 5px;
}

.nd-empty { text-align: center; padding: 36px 20px; color: rgba(255,255,255,0.2); }
.nd-empty i { font-size: 2.2rem; margin-bottom: 10px; display: block; }
.nd-empty p { font-size: 0.83rem; margin: 0; }

.nd-footer { padding: 11px 16px; border-top: 1px solid rgba(255,255,255,0.06); }
.nd-footer a {
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.35); font-size: 0.78rem;
    text-decoration: none; transition: color 0.2s;
}
.nd-footer a:hover { color: var(--c-theme); }

/* User button */
.user-wrapper { position: relative; }

.user-btn {
    display: flex; align-items: center; gap: 9px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 10px; padding: 5px 10px 5px 5px;
    cursor: pointer; transition: all 0.2s;
}
.user-btn:hover {
    background: var(--c-theme-pale);
    border-color: var(--c-theme-border);
}

.user-avatar {
    width: 30px; height: 30px;
    background: var(--c-theme-pale);
    border: 1px solid var(--c-theme-border);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: var(--c-theme);
    font-size: 0.85rem; font-weight: 700; flex-shrink: 0;
}

.user-info   { text-align: left; }
.user-name   { color: #fff; font-size: 0.81rem; font-weight: 600; line-height: 1.2; white-space: nowrap; }
.user-role   { color: rgba(255,255,255,0.3); font-size: 0.7rem; white-space: nowrap; }
.user-chevron { color: rgba(255,255,255,0.25); font-size: 0.68rem; transition: transform 0.2s; }
.user-chevron.rotated { transform: rotate(180deg); }

/* User dropdown */
.user-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 10px); right: 0;
    width: 220px;
    background: #1c1c1c;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    box-shadow: 0 24px 64px rgba(0,0,0,0.55);
    z-index: 1000; overflow: hidden;
    padding: 6px;
    animation: fadeSlide 0.18s ease;
}
.user-dropdown.open { display: block; }

.ud-profile {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 10px 12px;
}

.ud-avatar {
    width: 34px; height: 34px;
    background: var(--c-theme-pale);
    border: 1px solid var(--c-theme-border);
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    color: var(--c-theme);
    font-size: 0.9rem; font-weight: 700; flex-shrink: 0;
}

.ud-divider { height: 1px; background: rgba(255,255,255,0.06); margin: 3px 0; }

.ud-item {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 10px;
    color: rgba(255,255,255,0.55);
    font-size: 0.82rem; text-decoration: none;
    border-radius: 8px; transition: all 0.18s;
}
.ud-item i { width: 15px; text-align: center; color: var(--c-theme); font-size: 0.82rem; }
.ud-item:hover { background: rgba(255,255,255,0.05); color: #fff; }

.ud-logout       { color: rgba(255,107,122,0.7) !important; }
.ud-logout i     { color: #ff6b7a !important; }
.ud-logout:hover { background: rgba(255,107,122,0.08) !important; color: #ff6b7a !important; }

/* Badge inline */
.badge-theme {
    background: var(--c-theme-pale);
    color: var(--c-theme);
    border: 1px solid var(--c-theme-border);
    padding: 2px 8px; border-radius: 20px;
    font-size: 0.7rem; font-weight: 700;
}

@media (max-width: 768px) {
    .top-navbar {
        left: 0;
        padding: 0 15px 0 65px; /* espace pour le bouton hamburger */
    }
} 
</style>

<nav class="top-navbar">

    <div class="navbar-title">
        <i class="fas fa-chevron-right me-2" style="color:var(--c-theme);font-size:0.7rem;"></i>
        <?= isset($title) ? esc($title) : 'ANSTAT RH' ?>
    </div>

    <div class="navbar-right">

        <!-- CLOCHE -->
        <div class="notif-wrapper" id="notifWrapper">
            <button class="icon-btn" id="notifBtn" onclick="toggleNotif(event)" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="notif-badge" id="notifBadge"
                      style="<?= $nonLues == 0 ? 'display:none;' : '' ?>">
                    <?= $nonLues > 99 ? '99+' : $nonLues ?>
                </span>
            </button>

            <div class="notif-dropdown" id="notifDropdown">
                <div class="nd-header">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-bell" style="color:var(--c-theme);"></i>
                        <span>Notifications</span>
                        <?php if ($nonLues > 0): ?>
                        <span class="nd-count"><?= $nonLues ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($nonLues > 0): ?>
                    <button class="nd-read-all" onclick="marquerToutesLues()">
                        <i class="fas fa-check-double me-1"></i>Tout lire
                    </button>
                    <?php endif; ?>
                </div>

                <div class="nd-list" id="notifList">
                    <?php if (!empty($dernieres)): ?>
                        <?php foreach ($dernieres as $n): ?>
                        <?php
                        $icon   = $typeIcons[$n['Type_Notif']]  ?? 'fa-info-circle';
                        $color  = $typeColors[$n['Type_Notif']] ?? '#888888';
                        $unread = $n['Lu_Notif'] == 0;
                        ?>
                        <div class="nd-item <?= $unread ? 'unread' : '' ?>"
                             id="nd-<?= $n['id_Notif'] ?>"
                             onclick="lireNotif(<?= $n['id_Notif'] ?>, '<?= esc($n['Lien_Notif'] ?? '') ?>')">
                            <div class="nd-icon" style="background:<?= $color ?>18;border-color:<?= $color ?>40;">
                                <i class="fas <?= $icon ?>" style="color:<?= $color ?>;"></i>
                            </div>
                            <div class="nd-body">
                                <div class="nd-title"><?= esc($n['Titre_Notif']) ?></div>
                                <div class="nd-msg">
                                    <?= esc(mb_substr($n['Message_Notif'], 0, 72)) ?>
                                    <?= mb_strlen($n['Message_Notif']) > 72 ? '…' : '' ?>
                                </div>
                                <div class="nd-time">
                                    <i class="fas fa-clock"></i>
                                    <?= timeAgo_navbar($n['DateHeure_Notif']) ?>
                                </div>
                            </div>
                            <?php if ($unread): ?>
                            <span class="nd-dot" id="dot-<?= $n['id_Notif'] ?>"></span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="nd-empty">
                            <i class="fas fa-bell-slash"></i>
                            <p>Aucune notification</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="nd-footer">
                    <a href="<?= base_url('notifications') ?>">
                        Voir toutes les notifications
                        <?php if ($nonLues > 0): ?>
                        <span class="badge-theme ms-1"><?= $nonLues ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- USER MENU -->
        <div class="user-wrapper" id="userWrapper">
            <button class="user-btn" onclick="toggleUser(event)">
                <div class="user-avatar">
                    <?= strtoupper(mb_substr(session()->get('prenom') ?? 'U', 0, 1)) ?>
                </div>
                <div class="user-info d-none d-md-block">
                    <div class="user-name">
                        <?= esc(session()->get('nom') . ' ' . session()->get('prenom')) ?>
                    </div>
                    <div class="user-role">
                        <?= esc(session()->get('profil') ?? '') ?>
                    </div>
                </div>
                <i class="fas fa-chevron-down user-chevron" id="userChevron"></i>
            </button>

            <div class="user-dropdown" id="userDropdown">
                <div class="ud-profile">
                    <div class="ud-avatar">
                        <?= strtoupper(mb_substr(session()->get('prenom') ?? 'U', 0, 1)) ?>
                    </div>
                    <div>
                        <div style="color:#fff;font-weight:600;font-size:0.85rem;">
                            <?= esc(session()->get('nom') . ' ' . session()->get('prenom')) ?>
                        </div>
                        <div style="color:rgba(255,255,255,0.35);font-size:0.75rem;">
                            <?= esc(session()->get('email') ?? '') ?>
                        </div>
                    </div>
                </div>
                <div class="ud-divider"></div>
                <a href="<?= base_url('profil') ?>" class="ud-item">
                    <i class="fas fa-user-circle"></i> Mon profil
                </a>
                <a href="<?= base_url('profil/password') ?>" class="ud-item">
                    <i class="fas fa-lock"></i> Changer mot de passe
                </a>
                <a href="<?= base_url('notifications') ?>" class="ud-item">
                    <i class="fas fa-bell"></i> Notifications
                    <?php if ($nonLues > 0): ?>
                    <span class="badge-theme ms-auto"><?= $nonLues ?></span>
                    <?php endif; ?>
                </a>
                <div class="ud-divider"></div>
                <a href="<?= base_url('logout') ?>" class="ud-item ud-logout"
                   onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>

    </div>
</nav>

<script>
function toggleNotif(e) {
    e.stopPropagation();
    document.getElementById('notifDropdown').classList.toggle('open');
    document.getElementById('userDropdown').classList.remove('open');
    document.getElementById('userChevron').classList.remove('rotated');
}

function toggleUser(e) {
    e.stopPropagation();
    document.getElementById('userDropdown').classList.toggle('open');
    document.getElementById('notifDropdown').classList.remove('open');
    document.getElementById('userChevron').classList.toggle('rotated');
}

document.addEventListener('click', function() {
    document.getElementById('notifDropdown').classList.remove('open');
    document.getElementById('userDropdown').classList.remove('open');
    document.getElementById('userChevron').classList.remove('rotated');
});

function lireNotif(id, lien) {
    fetch('<?= base_url('notifications/lire/') ?>' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(() => {
        const item = document.getElementById('nd-' + id);
        if (item) {
            item.classList.remove('unread');
            const dot = document.getElementById('dot-' + id);
            if (dot) dot.remove();
        }
        majBadge(-1);
        if (lien && lien !== '' && lien !== 'null') window.location.href = lien;
    }).catch(() => {
        if (lien && lien !== '' && lien !== 'null') window.location.href = lien;
    });
}

function marquerToutesLues() {
    fetch('<?= base_url('notifications/lire-toutes') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(() => {
        document.querySelectorAll('.nd-item.unread').forEach(el => el.classList.remove('unread'));
        document.querySelectorAll('.nd-dot').forEach(el => el.remove());
        document.querySelector('.nd-read-all')?.remove();
        document.querySelector('.nd-count')?.remove();
        resetBadge();
    });
}

function majBadge(delta) {
    const badge = document.getElementById('notifBadge');
    if (!badge) return;
    let n = Math.max(0, (parseInt(badge.textContent) || 0) + delta);
    badge.style.display = n === 0 ? 'none' : 'flex';
    if (n > 0) badge.textContent = n > 99 ? '99+' : n;
}

function resetBadge() {
    const badge = document.getElementById('notifBadge');
    if (badge) badge.style.display = 'none';
}

setInterval(function() {
    fetch('<?= base_url('notifications/count') ?>', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        const badge = document.getElementById('notifBadge');
        if (!badge) return;
        const n = data.count || 0;
        badge.style.display = n > 0 ? 'flex' : 'none';
        if (n > 0) badge.textContent = n > 99 ? '99+' : n;
    })
    .catch(() => {});
}, 30000);
</script>