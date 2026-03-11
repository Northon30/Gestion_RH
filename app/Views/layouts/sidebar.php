<div class="sidebar" id="sidebar">

    <div class="sidebar-logo">
        <img src="<?= base_url('assets/images/logo_anstat.png') ?>" alt="ANSTAT">
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="user-info">
            <span class="user-name"><?= session()->get('nom') . ' ' . session()->get('prenom') ?></span>
            <span class="user-role">
                <?php
                $profils = [1 => 'RH', 2 => 'Chef Direction', 3 => 'Employé'];
                echo $profils[session()->get('id_Pfl')] ?? 'Utilisateur';
                ?>
            </span>
        </div>
    </div>

    <hr class="sidebar-divider">

    <?php
    $url    = current_url();
    $base   = base_url();
    $path   = str_replace($base, '', $url); // ex: "formation", "demande-formation/create"
    ?>

    <nav class="sidebar-nav">

        <a href="<?= base_url('dashboard') ?>"
           class="nav-item <?= ($path === 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <?php if (session()->get('id_Pfl') == 1): ?>
        <a href="<?= base_url('employe') ?>"
           class="nav-item <?= (strpos($path, 'employe') === 0) ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Employés</span>
        </a>
        <a href="<?= base_url('direction') ?>"
           class="nav-item <?= (strpos($path, 'direction') === 0) ? 'active' : '' ?>">
            <i class="fas fa-building"></i>
            <span>Directions</span>
        </a>
        <?php endif; ?>

        <a href="<?= base_url('conge') ?>"
           class="nav-item <?= (strpos($path, 'conge') === 0) ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Congés</span>
        </a>

        <a href="<?= base_url('absence') ?>"
           class="nav-item <?= (strpos($path, 'absence') === 0) ? 'active' : '' ?>">
            <i class="fas fa-user-clock"></i>
            <span>Absences</span>
        </a>

        <?php
        $isFormationActive = (strpos($path, 'formation') === 0 || strpos($path, 'demande-formation') === 0);
        ?>
        <div class="nav-group">
            <div class="nav-group-title <?= $isFormationActive ? 'active' : '' ?>"
                 onclick="toggleGroup('formation')">
                <div>
                    <i class="fas fa-graduation-cap"></i>
                    <span>Formations</span>
                </div>
                <i class="fas fa-chevron-down chevron <?= $isFormationActive ? 'open' : '' ?>"
                   id="chevron-formation"></i>
            </div>
            <div class="nav-group-items <?= $isFormationActive ? 'open' : '' ?>"
                 id="group-formation">
                <a href="<?= base_url('formation') ?>"
                   class="nav-subitem <?= (strpos($path, 'demande-formation') !== 0 && strpos($path, 'formation') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-chalkboard-teacher"></i> Catalogue
                </a>
                <a href="<?= base_url('demande-formation') ?>"
                   class="nav-subitem <?= (strpos($path, 'demande-formation') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-file-alt"></i> Demandes
                </a>
            </div>
        </div>

        <a href="<?= base_url('competence') ?>"
           class="nav-item <?= (strpos($path, 'competence') === 0) ? 'active' : '' ?>">
            <i class="fas fa-star"></i>
            <span>Compétences</span>
        </a>

        <a href="<?= base_url('evenement') ?>"
           class="nav-item <?= (strpos($path, 'evenement') === 0) ? 'active' : '' ?>">
            <i class="fas fa-calendar-check"></i>
            <span>Événements</span>
        </a>

        <?php if (session()->get('id_Pfl') == 1): ?>
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

    </nav>

    <div class="sidebar-logout">
        <a href="<?= base_url('logout') ?>" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
        </a>
    </div>

</div>