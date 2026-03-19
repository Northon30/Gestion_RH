<?php
$idPfl = (int) session()->get('id_Pfl');

if ($idPfl === 1) {
    $theme = ['color' => '#F5A623', 'color_rgb' => '245,166,35', 'btn_text' => '#111'];
} elseif ($idPfl === 2) {
    $theme = ['color' => '#3A7BD5', 'color_rgb' => '58,123,213', 'btn_text' => '#fff'];
} else {
    $theme = ['color' => '#6BAF6B', 'color_rgb' => '107,175,107', 'btn_text' => '#fff'];
}

$c   = $theme['color'];
$rgb = $theme['color_rgb'];
?>

<style>
:root {
    --c-theme:        <?= $c ?>;
    --c-theme-rgb:    <?= $rgb ?>;
    --c-theme-pale:   rgba(<?= $rgb ?>, 0.18);
    --c-theme-border: rgba(<?= $rgb ?>, 0.25);
    --c-theme-hover:  rgba(<?= $rgb ?>, 0.08);
    --c-theme-active: rgba(<?= $rgb ?>, 0.18);
}

.sidebar {
    width: 250px;
    min-height: 100vh;
    background: #1a1a1a;
    border-right: 1px solid rgba(<?= $rgb ?>, 0.15);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0;
    z-index: 1000;
    transition: transform 0.3s ease;
}

.sidebar-logo {
    padding: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    text-align: center;
}

.sidebar-logo img { width: 140px; }

.sidebar-user {
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-avatar {
    width: 40px; height: 40px;
    background: var(--c-theme-pale);
    border: 1px solid var(--c-theme-border);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--c-theme);
    font-size: 1.2rem; flex-shrink: 0;
}

.user-name { color: #fff; font-size: 0.85rem; font-weight: 600; }
.user-role { color: var(--c-theme); font-size: 0.72rem; font-weight: 500; }

.sidebar-divider { border-color: rgba(255,255,255,0.06); margin: 0 15px; }

.sidebar-nav {
    flex: 1;
    padding: 10px 0;
    overflow-y: auto;
    max-height: calc(100vh - 200px);
}

.sidebar-nav::-webkit-scrollbar       { width: 3px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: var(--c-theme-border); border-radius: 3px; }

.nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 20px;
    color: rgba(255,255,255,0.55);
    text-decoration: none;
    font-size: 0.88rem;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    position: relative;
}

.nav-item:hover {
    background: var(--c-theme-hover);
    color: var(--c-theme);
    border-left-color: rgba(<?= $rgb ?>, 0.4);
}

.nav-item.active {
    background: var(--c-theme-pale);
    color: var(--c-theme);
    border-left-color: var(--c-theme);
    border-left-width: 4px;
    font-weight: 700;
}

.nav-item.active:hover {
    background: var(--c-theme-pale);
    color: var(--c-theme);
    border-left-color: var(--c-theme);
}

.nav-item.active::after {
    content: '';
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    width: 6px; height: 6px;
    background: var(--c-theme);
    border-radius: 50%;
    opacity: 0.8;
}

.nav-item i { width: 18px; text-align: center; font-size: 0.9rem; }

/* ── Sous-label (chip) pour le lien employés du Chef ── */
.nav-item .nav-chip {
    margin-left: auto;
    font-size: 0.6rem; font-weight: 700;
    padding: 2px 7px; border-radius: 10px;
    background: rgba(<?= $rgb ?>, 0.15);
    border: 1px solid rgba(<?= $rgb ?>, 0.25);
    color: var(--c-theme);
    white-space: nowrap;
}

.nav-group-title {
    display: flex; align-items: center; justify-content: space-between;
    padding: 11px 20px;
    color: rgba(255,255,255,0.55);
    font-size: 0.88rem;
    cursor: pointer;
    border-left: 3px solid transparent;
    transition: all 0.2s;
}

.nav-group-title:hover {
    background: var(--c-theme-hover);
    color: var(--c-theme);
}

.nav-group-title.active {
    color: var(--c-theme);
    border-left-color: var(--c-theme);
    border-left-width: 4px;
    background: var(--c-theme-pale);
    font-weight: 700;
}

.nav-group-title.active:hover {
    background: var(--c-theme-pale);
    color: var(--c-theme);
    border-left-color: var(--c-theme);
}

.nav-group-title > div { display: flex; align-items: center; gap: 12px; }
.nav-group-title i     { width: 18px; text-align: center; font-size: 0.9rem; }

.chevron { font-size: 0.7rem; transition: transform 0.3s; }
.chevron.open { transform: rotate(180deg); }

.nav-group-items      { display: none; background: rgba(0,0,0,0.2); }
.nav-group-items.open { display: block; }

.nav-subitem {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 20px 9px 45px;
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    font-size: 0.82rem;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    position: relative;
}

.nav-subitem:hover {
    color: var(--c-theme);
    background: var(--c-theme-hover);
}

.nav-subitem.active {
    color: var(--c-theme);
    font-weight: 700;
    border-left-color: var(--c-theme);
    border-left-width: 4px;
    background: rgba(<?= $rgb ?>, 0.10);
}

.nav-subitem.active:hover {
    background: rgba(<?= $rgb ?>, 0.10);
    color: var(--c-theme);
    border-left-color: var(--c-theme);
}

.nav-subitem.active::after {
    content: '';
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    width: 5px; height: 5px;
    background: var(--c-theme);
    border-radius: 50%;
    opacity: 0.7;
}

.sidebar-logout {
    padding: 15px;
    border-top: 1px solid rgba(255,255,255,0.06);
}

.logout-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 15px;
    color: rgba(255,100,100,0.8);
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.88rem;
    transition: all 0.2s;
}

.logout-btn:hover {
    background: rgba(220,53,69,0.15);
    color: #ff6b6b;
}

.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 999;
}

.sidebar-overlay.open { display: block; }

.hamburger {
    display: none;
    position: fixed;
    top: 15px; left: 15px;
    z-index: 1001;
    background: #1a1a1a;
    border: 1px solid var(--c-theme-border);
    color: var(--c-theme);
    width: 40px; height: 40px;
    border-radius: 8px;
    cursor: pointer;
    align-items: center; justify-content: center;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .hamburger { display: flex; }
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
}
</style>

<button class="hamburger" id="hamburger">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">

    <div class="sidebar-logo">
        <img src="<?= base_url('assets/images/logo_anstat.png') ?>" alt="ANSTAT">
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="user-info">
            <span class="user-name"><?= esc(session()->get('nom') . ' ' . session()->get('prenom')) ?></span>
            <span class="user-role">
                <?php
                $profils = [1 => 'RH', 2 => 'Chef Direction', 3 => 'Employé'];
                echo $profils[$idPfl] ?? 'Utilisateur';
                ?>
            </span>
        </div>
    </div>

    <hr class="sidebar-divider">

    <?php
    $url  = current_url();
    $base = base_url();
    $path = ltrim(str_replace($base, '', $url), '/');
    $path = ltrim(str_replace('index.php/', '', $path), '/');
    ?>

    <nav class="sidebar-nav">

        <!-- Dashboard -->
        <a href="<?= base_url('dashboard') ?>"
           class="nav-item <?= ($path === 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <!-- Employés : RH voit tout, Chef voit sa direction -->
        <?php if ($idPfl == 1): ?>
        <a href="<?= base_url('employe') ?>"
           class="nav-item <?= (strpos($path, 'employe') === 0) ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Employés</span>
        </a>
        <?php elseif ($idPfl == 2): ?>
        <a href="<?= base_url('employe') ?>"
           class="nav-item <?= (strpos($path, 'employe') === 0) ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Employés</span>
            <span class="nav-chip">Ma direction</span>
        </a>
        <?php endif; ?>

        <!-- Directions : RH uniquement -->
        <?php if ($idPfl == 1): ?>
        <a href="<?= base_url('direction') ?>"
           class="nav-item <?= (strpos($path, 'direction') === 0) ? 'active' : '' ?>">
            <i class="fas fa-building"></i>
            <span>Directions</span>
        </a>
        <?php endif; ?>

        <!-- Congés -->
        <a href="<?= base_url('conge') ?>"
           class="nav-item <?= (strpos($path, 'conge') === 0) ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Congés</span>
        </a>

        <!-- Absences -->
        <a href="<?= base_url('absence') ?>"
           class="nav-item <?= (strpos($path, 'absence') === 0) ? 'active' : '' ?>">
            <i class="fas fa-user-clock"></i>
            <span>Absences</span>
        </a>

        <!-- Formations -->
        <a href="<?= base_url('formation') ?>"
           class="nav-item <?= (strpos($path, 'formation') === 0) ? 'active' : '' ?>">
            <i class="fas fa-graduation-cap"></i>
            <span>Formations</span>
        </a>

        <!-- Compétences -->
        <a href="<?= base_url('competence') ?>"
           class="nav-item <?= (strpos($path, 'competence') === 0) ? 'active' : '' ?>">
            <i class="fas fa-star"></i>
            <span>Compétences</span>
        </a>

        <!-- Événements -->
        <a href="<?= base_url('evenement') ?>"
           class="nav-item <?= (strpos($path, 'evenement') === 0) ? 'active' : '' ?>">
            <i class="fas fa-calendar-check"></i>
            <span>Événements</span>
        </a>

        <!-- Paramètres : RH uniquement -->
        <?php if ($idPfl == 1): ?>
        <?php $isParamActive = (strpos($path, 'parametres') === 0); ?>
        <div class="nav-group">
            <div class="nav-group-title <?= $isParamActive ? 'active' : '' ?>"
                 onclick="toggleGroup('parametres')">
                <div>
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </div>
                <i class="fas fa-chevron-down chevron <?= $isParamActive ? 'open' : '' ?>"
                   id="chevron-parametres"></i>
            </div>
            <div class="nav-group-items <?= $isParamActive ? 'open' : '' ?>"
                 id="group-parametres">
                <a href="<?= base_url('parametres/grade') ?>"
                   class="nav-subitem <?= (strpos($path, 'parametres/grade') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-medal"></i> Grades
                </a>
                <a href="<?= base_url('parametres/profil') ?>"
                   class="nav-subitem <?= (strpos($path, 'parametres/profil') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-id-badge"></i> Profils
                </a>
                <a href="<?= base_url('parametres/type-conge') ?>"
                   class="nav-subitem <?= (strpos($path, 'parametres/type-conge') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i> Types Congés
                </a>
                <a href="<?= base_url('parametres/type-absence') ?>"
                   class="nav-subitem <?= (strpos($path, 'parametres/type-absence') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i> Types Absences
                </a>
                <a href="<?= base_url('parametres/type-evenement') ?>"
                   class="nav-subitem <?= (strpos($path, 'parametres/type-evenement') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i> Types Événements
                </a>
            </div>
        </div>

        <a href="<?= base_url('activity-log') ?>"
           class="nav-item <?= (strpos($path, 'activity-log') === 0) ? 'active' : '' ?>">
            <i class="fas fa-history"></i>
            <span>Logs d'activité</span>
        </a>
        <?php endif; ?>

        <!-- Notifications -->
        <a href="<?= base_url('notifications') ?>"
           class="nav-item <?= (strpos($path, 'notifications') === 0) ? 'active' : '' ?>">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
        </a>

        <!-- Mon profil -->
        <a href="<?= base_url('profil') ?>"
           class="nav-item <?= (strpos($path, 'profil') === 0) ? 'active' : '' ?>">
            <i class="fas fa-user-circle"></i>
            <span>Mon profil</span>
        </a>

    </nav>

    <div class="sidebar-logout">
        <a href="<?= base_url('logout') ?>" class="logout-btn"
           onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
        </a>
    </div>

</div>

<script>
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const hamburger = document.getElementById('hamburger');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
    });

    function toggleGroup(name) {
        const items   = document.getElementById('group-' + name);
        const chevron = document.getElementById('chevron-' + name);
        items.classList.toggle('open');
        chevron.classList.toggle('open');
    }
</script>