<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANSTAT - <?= $title ?? 'Gestion RH' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #111111;
            font-family: 'Segoe UI', sans-serif;
            color: #ffffff;
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1a1a1a;
            border-right: 1px solid rgba(245, 166, 35, 0.15);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .sidebar-logo {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-align: center;
        }

        .sidebar-logo img {
            width: 140px;
        }

        .sidebar-user {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: rgba(245,166,35,0.15);
            border: 1px solid rgba(245,166,35,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #F5A623;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .user-role {
            color: #F5A623;
            font-size: 0.72rem;
            font-weight: 500;
        }

        .sidebar-divider {
            border-color: rgba(255,255,255,0.06);
            margin: 0 15px;
        }

        /* Nav items */
        .sidebar-nav {
    flex: 1;
    padding: 10px 0;
    overflow-y: auto;
    max-height: calc(100vh - 200px); /* hauteur max = écran - logo - user - logout */
}

        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(245,166,35,0.3); border-radius: 3px; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.88rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(245,166,35,0.08);
            color: #F5A623;
            border-left-color: rgba(245,166,35,0.4);
        }

        .nav-item.active {
            background: rgba(245,166,35,0.12);
            color: #F5A623;
            border-left-color: #F5A623;
            font-weight: 600;
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Nav group */
        .nav-group-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 20px;
            color: rgba(255,255,255,0.6);
            font-size: 0.88rem;
            cursor: pointer;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }

        .nav-group-title:hover {
            background: rgba(245,166,35,0.08);
            color: #F5A623;
        }

        .nav-group-title > div {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-group-title i { width: 18px; text-align: center; font-size: 0.9rem; }

        .chevron {
            font-size: 0.7rem;
            transition: transform 0.3s;
        }

        .chevron.open { transform: rotate(180deg); }

        .nav-group-items {
            display: none;
            background: rgba(0,0,0,0.2);
        }

        .nav-group-items.open { display: block; }

        .nav-subitem {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px 9px 45px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.82rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-subitem:hover {
            color: #F5A623;
            background: rgba(245,166,35,0.05);
        }

        .nav-subitem.active {
            color: #F5A623;
            font-weight: 600;
        }

        /* Logout */
        .sidebar-logout {
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
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

        /* ===== NAVBAR ===== */
        .navbar-top {
            height: 60px;
            background: #1a1a1a;
            border-bottom: 1px solid rgba(245,166,35,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 999;
        }

        .page-title {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-btn {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.6);
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .icon-btn:hover {
            background: rgba(245,166,35,0.1);
            color: #F5A623;
            border-color: rgba(245,166,35,0.2);
        }

        .badge-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #F5A623;
            border-radius: 50%;
            border: 2px solid #1a1a1a;
        }

        .user-btn {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.8);
            padding: 6px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-btn:hover {
            background: rgba(245,166,35,0.1);
            border-color: rgba(245,166,35,0.2);
            color: #ffffff;
        }

        .user-avatar-sm {
            width: 28px;
            height: 28px;
            background: rgba(245,166,35,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #F5A623;
            font-size: 0.8rem;
        }

        /* Dropdowns */
        .notification-dropdown,
        .user-dropdown {
            background: #222222;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            min-width: 250px;
            padding: 0;
            overflow: hidden;
        }

        .dropdown-header {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.5);
            font-size: 0.8rem;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .dropdown-header strong { color: #ffffff; font-size: 0.9rem; }

        .notification-item {
            padding: 10px 15px;
            color: rgba(255,255,255,0.6);
            font-size: 0.82rem;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            display: flex;
            align-items: center;
        }

        .dropdown-footer {
            padding: 10px 15px;
            text-align: center;
        }

        .dropdown-footer a {
            color: #F5A623;
            font-size: 0.82rem;
            text-decoration: none;
        }

        .dropdown-item {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: rgba(245,166,35,0.08);
            color: #F5A623;
        }

        .dropdown-item.text-danger:hover {
            background: rgba(220,53,69,0.1);
            color: #ff6b6b !important;
        }

        .dropdown-divider { border-color: rgba(255,255,255,0.06); }

        /* ===== MAIN WRAPPER ===== */
        .main-wrapper {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .page-content {
            margin-top: 60px;
            padding: 25px;
            flex: 1;
        }

        /* ===== COMPOSANTS GLOBAUX ===== */

        /* Cards */
        .card-dark {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            padding: 20px;
        }

        .card-dark .card-header-title {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Buttons */
        .btn-orange {
            background: linear-gradient(135deg, #F5A623, #d4891a);
            border: none;
            color: #1a1a1a;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-orange:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(245,166,35,0.3);
            color: #1a1a1a;
        }

        .btn-green {
            background: linear-gradient(135deg, #4A6741, #3a5231);
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-green:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(74,103,65,0.3);
            color: #ffffff;
        }

        .btn-outline-orange {
            background: transparent;
            border: 1px solid rgba(245,166,35,0.4);
            color: #F5A623;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-outline-orange:hover {
            background: rgba(245,166,35,0.1);
            color: #F5A623;
        }

        /* Tables */
        .table-dark-custom {
            color: rgba(255,255,255,0.8);
            font-size: 0.85rem;
        }

        .table-dark-custom thead th {
            background: rgba(245,166,35,0.1);
            color: #F5A623;
            font-weight: 600;
            border-color: rgba(255,255,255,0.06);
            padding: 12px 15px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-dark-custom tbody td {
            border-color: rgba(255,255,255,0.04);
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table-dark-custom tbody tr:hover {
            background: rgba(255,255,255,0.03);
        }

        /* Badges */
        .badge-orange {
            background: rgba(245,166,35,0.15);
            color: #F5A623;
            border: 1px solid rgba(245,166,35,0.3);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .badge-green {
            background: rgba(74,103,65,0.2);
            color: #90c97f;
            border: 1px solid rgba(74,103,65,0.4);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .badge-red {
            background: rgba(220,53,69,0.15);
            color: #ff6b7a;
            border: 1px solid rgba(220,53,69,0.3);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .badge-gray {
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.5);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        /* Alerts */
        .alert-dark-success {
            background: rgba(74,103,65,0.2);
            border: 1px solid rgba(74,103,65,0.4);
            color: #90c97f;
            border-radius: 10px;
        }

        .alert-dark-danger {
            background: rgba(220,53,69,0.15);
            border: 1px solid rgba(220,53,69,0.3);
            color: #ff6b7a;
            border-radius: 10px;
        }

        /* Forms */
        .form-control-dark {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #ffffff;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.88rem;
            transition: all 0.3s;
        }

        .form-control-dark:focus {
            background: rgba(255,255,255,0.08);
            border-color: #F5A623;
            color: #ffffff;
            box-shadow: 0 0 0 3px rgba(245,166,35,0.15);
        }

        .form-control-dark::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .form-label-dark {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-select-dark {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #ffffff;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.88rem;
        }

        .form-select-dark:focus {
            border-color: #F5A623;
            box-shadow: 0 0 0 3px rgba(245,166,35,0.15);
            background: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .form-select-dark option {
            background: #222222;
            color: #ffffff;
        }

        /* Page header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .page-header h1 {
            color: #ffffff;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .page-header p {
            color: rgba(255,255,255,0.4);
            font-size: 0.85rem;
            margin-top: 3px;
        }

        /* Scrollbar global */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: rgba(245,166,35,0.3); border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(245,166,35,0.5); }
    </style>

    <?= $this->renderSection('css') ?>
</head>
<body>

    <?= view('layouts/sidebar') ?>

    <div class="main-wrapper">
        <?= view('layouts/navbar') ?>
        <div class="page-content animate__animated animate__fadeIn">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function toggleGroup(name) {
        const group = document.getElementById('group-' + name);
        const chevron = document.getElementById('chevron-' + name);
        group.classList.toggle('open');
        chevron.classList.toggle('open');

        // Scroll automatique vers le groupe ouvert
        if (group.classList.contains('open')) {
            setTimeout(() => {
                group.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 300);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const activeSubitem = document.querySelector('.nav-subitem.active');
        if (activeSubitem) {
            const group = activeSubitem.closest('.nav-group-items');
            if (group) {
                group.classList.add('open');
                const chevron = document.getElementById('chevron-' + group.id.replace('group-', ''));
                if (chevron) chevron.classList.add('open');
            }
        }
    });
</script>

    <?= $this->renderSection('js') ?>

</body>
</html>