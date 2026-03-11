<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANSTAT — Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: #111111;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-glow {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .bg-glow::before {
            content: '';
            position: absolute;
            top: -150px; left: -150px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(74,103,65,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .bg-glow::after {
            content: '';
            position: absolute;
            bottom: -150px; right: -150px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(245,166,35,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            margin: 20px;
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-top-bar {
            height: 3px;
            background: linear-gradient(90deg, #F5A623, #4A6741);
        }

        .card-body {
            padding: 44px 40px 36px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo img {
            width: 120px;
            margin-bottom: 16px;
        }

        .login-logo h2 {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .login-logo p {
            color: rgba(255,255,255,0.3);
            font-size: 0.8rem;
        }

        .sep-line {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin-bottom: 28px;
        }

        .alert-err, .alert-ok {
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 0.82rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .alert-err {
            background: rgba(220,53,69,0.12);
            border: 1px solid rgba(220,53,69,0.25);
            color: #ff6b7a;
        }

        .alert-ok {
            background: rgba(74,103,65,0.15);
            border: 1px solid rgba(74,103,65,0.3);
            color: #90c97f;
        }

        .field-label {
            display: block;
            color: rgba(255,255,255,0.5);
            font-size: 0.78rem;
            font-weight: 500;
            margin-bottom: 7px;
        }

        .field-wrap {
            position: relative;
            margin-bottom: 18px;
        }

        .field-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.2);
            font-size: 0.78rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field-wrap:focus-within .icon { color: #F5A623; }

        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            padding: 12px 14px 12px 38px;
            border-radius: 10px;
            font-family: 'Segoe UI', sans-serif;
            font-size: 0.88rem;
            outline: none;
            transition: all 0.2s;
        }

        .field-input::placeholder { color: rgba(255,255,255,0.18); }

        .field-input:focus {
            background: rgba(255,255,255,0.06);
            border-color: rgba(245,166,35,0.5);
            box-shadow: 0 0 0 3px rgba(245,166,35,0.08);
        }

        .toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.22);
            cursor: pointer;
            font-size: 0.78rem;
            transition: color 0.2s;
        }

        .toggle-eye:hover { color: #F5A623; }

        .opt-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .custom-check {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
        }

        .custom-check input {
            accent-color: #F5A623;
            width: 14px;
            height: 14px;
        }

        .custom-check span {
            color: rgba(255,255,255,0.3);
            font-size: 0.8rem;
        }

        .forgot-link {
            color: #F5A623;
            font-size: 0.8rem;
            text-decoration: none;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .forgot-link:hover { opacity: 1; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #F5A623, #d4891a);
            border: none;
            border-radius: 10px;
            color: #111;
            font-family: 'Segoe UI', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(245,166,35,0.28);
        }

        .btn-login:active { transform: translateY(0); }

        .card-footer-line {
            text-align: center;
            margin-top: 24px;
            color: rgba(255,255,255,0.18);
            font-size: 0.73rem;
        }

        .card-footer-line .sep {
            display: inline-block;
            width: 3px; height: 3px;
            border-radius: 50%;
            background: rgba(255,255,255,0.18);
            vertical-align: middle;
            margin: 0 7px;
        }
    </style>
</head>
<body>

<div class="bg-glow"></div>

<div class="login-card">
    <div class="card-top-bar"></div>
    <div class="card-body">

        <div class="login-logo">
            <img src="<?= base_url('assets/images/logo_anstat.png') ?>" alt="ANSTAT">
            <h2>Bienvenue</h2>
            <p>Connectez-vous à votre espace RH</p>
        </div>

        <div class="sep-line"></div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-err">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-ok">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="POST">
            <?= csrf_field() ?>

            <label class="field-label">Adresse e-mail</label>
            <div class="field-wrap">
                <i class="fas fa-envelope icon"></i>
                <input type="email" name="email" class="field-input" placeholder="votre@anstat.ci" required autofocus>
            </div>

            <label class="field-label">Mot de passe</label>
            <div class="field-wrap">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" id="password" class="field-input" placeholder="••••••••" required>
                <button type="button" class="toggle-eye" onclick="togglePwd()">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <div class="opt-row">
                <label class="custom-check">
                    <input type="checkbox" name="remember">
                    <span>Se souvenir de moi</span>
                </label>
                <a href="<?= base_url('auth/forgot-password') ?>" class="forgot-link">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
            </button>
        </form>

        <div class="card-footer-line">
            <span>ANSTAT © <?= date('Y') ?></span>
            <span class="sep"></span>
            <span>Accès réservé au personnel autorisé</span>
        </div>

    </div>
</div>

<script>
    function togglePwd() {
        const pwd = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            pwd.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

</body>
</html>