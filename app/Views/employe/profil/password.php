<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --e-primary:        #6BAF6B;
        --e-primary-pale:   rgba(107,175,107,0.10);
        --e-primary-border: rgba(107,175,107,0.25);
        --c-green-pale:     rgba(74,103,65,0.15);
        --c-green-border:   rgba(74,103,65,0.35);
        --c-red-pale:       rgba(224,82,82,0.10);
        --c-red-border:     rgba(224,82,82,0.25);
        --c-surface:        #1a1a1a;
        --c-border:         rgba(255,255,255,0.06);
        --c-text:           rgba(255,255,255,0.85);
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.55);
    }

    .form-card {
        background: var(--c-surface); border: 1px solid var(--c-border);
        border-radius: 14px; overflow: hidden; max-width: 480px; margin: 0 auto;
    }

    .form-card-header {
        padding: 16px 22px; border-bottom: 1px solid var(--c-border);
        display: flex; align-items: center; gap: 12px;
    }

    .form-card-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--e-primary-pale); border: 1px solid var(--e-primary-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--e-primary); font-size: 0.9rem; flex-shrink: 0;
    }

    .form-card-title    { color: #fff; font-size: 0.92rem; font-weight: 700; margin: 0; }
    .form-card-subtitle { color: var(--c-muted); font-size: 0.75rem; margin: 2px 0 0; }

    .form-card-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; }

    .form-group { display: flex; flex-direction: column; gap: 6px; }

    .form-label {
        font-size: 0.72rem; font-weight: 600; color: var(--c-soft);
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .form-label .req { color: var(--e-primary); margin-left: 2px; }

    .input-wrapper { position: relative; }

    .form-control {
        background: #111; border: 1px solid var(--c-border);
        border-radius: 8px; color: var(--c-text); font-size: 0.85rem;
        padding: 11px 40px 11px 14px; outline: none; transition: border-color 0.2s;
        font-family: 'Segoe UI', sans-serif; width: 100%;
    }
    .form-control:focus        { border-color: var(--e-primary-border); }
    .form-control::placeholder { color: var(--c-muted); }

    .toggle-pwd {
        position: absolute; right: 11px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: var(--c-muted); font-size: 0.82rem; padding: 0;
        transition: color 0.2s;
    }
    .toggle-pwd:hover { color: var(--e-primary); }

    .strength-bar {
        height: 4px; border-radius: 2px;
        background: rgba(255,255,255,0.06);
        overflow: hidden; margin-top: 6px;
    }
    .strength-fill {
        height: 100%; border-radius: 2px;
        transition: width 0.3s, background 0.3s;
        width: 0%;
    }
    .strength-label { font-size: 0.68rem; margin-top: 4px; color: var(--c-muted); }

    .form-hint { font-size: 0.7rem; color: var(--c-muted); margin-top: 2px; }

    .form-card-footer {
        padding: 16px 22px; border-top: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--e-primary), #4a8a4a);
        border: none; color: #fff; font-weight: 700; border-radius: 8px;
        padding: 10px 22px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(107,175,107,0.3); color: #fff; }

    .btn-ghost {
        background: transparent; border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 10px 22px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none;
    }
    .btn-ghost:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .alert-error-dark {
        background: var(--c-red-pale); border: 1px solid var(--c-red-border);
        border-radius: 10px; padding: 11px 16px; color: #ff8080;
        font-size: 0.82rem; margin-bottom: 18px;
        max-width: 480px; margin-left: auto; margin-right: auto;
    }
    .alert-error-dark ul { margin: 6px 0 0 16px; padding: 0; }

    .pwd-rules { display: flex; flex-direction: column; gap: 5px; margin-top: 4px; }
    .pwd-rule {
        display: flex; align-items: center; gap: 7px;
        font-size: 0.72rem; color: var(--c-muted); transition: color 0.2s;
    }
    .pwd-rule i  { font-size: 0.65rem; width: 12px; text-align: center; }
    .pwd-rule.ok { color: #7ab86a; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-lock me-2" style="color:var(--e-primary);"></i>Changer le mot de passe</h1>
        <p>Sécurisez votre compte</p>
    </div>
    <a href="<?= base_url('profil') ?>" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> Mon profil
    </a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert-error-dark">
    <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
        <i class="fas fa-exclamation-triangle"></i> Erreur
    </div>
    <ul>
        <?php foreach ((array)session()->getFlashdata('errors') as $e): ?>
        <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon"><i class="fas fa-lock"></i></div>
        <div>
            <p class="form-card-title">Nouveau mot de passe</p>
            <p class="form-card-subtitle">Minimum 8 caractères</p>
        </div>
    </div>

    <form action="<?= base_url('profil/password/update') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-card-body">

            <div class="form-group">
                <label class="form-label">Ancien mot de passe <span class="req">*</span></label>
                <div class="input-wrapper">
                    <input type="password" name="ancien_password" id="f-ancien"
                           class="form-control" placeholder="Votre mot de passe actuel"
                           autocomplete="current-password">
                    <button type="button" class="toggle-pwd" onclick="toggleVis('f-ancien', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nouveau mot de passe <span class="req">*</span></label>
                <div class="input-wrapper">
                    <input type="password" name="nouveau_password" id="f-nouveau"
                           class="form-control" placeholder="Nouveau mot de passe"
                           oninput="evalStrength(this.value)"
                           autocomplete="new-password">
                    <button type="button" class="toggle-pwd" onclick="toggleVis('f-nouveau', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="strength-bar">
                    <div class="strength-fill" id="strength-fill"></div>
                </div>
                <div class="strength-label" id="strength-label">Force du mot de passe</div>
                <div class="pwd-rules">
                    <div class="pwd-rule" id="rule-len">
                        <i class="fas fa-circle"></i> Au moins 8 caractères
                    </div>
                    <div class="pwd-rule" id="rule-upper">
                        <i class="fas fa-circle"></i> Une majuscule
                    </div>
                    <div class="pwd-rule" id="rule-num">
                        <i class="fas fa-circle"></i> Un chiffre
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Confirmer le mot de passe <span class="req">*</span></label>
                <div class="input-wrapper">
                    <input type="password" name="confirmation_password" id="f-confirm"
                           class="form-control" placeholder="Répéter le nouveau mot de passe"
                           oninput="checkMatch()"
                           autocomplete="new-password">
                    <button type="button" class="toggle-pwd" onclick="toggleVis('f-confirm', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="form-hint" id="match-hint"></div>
            </div>

        </div>

        <div class="form-card-footer">
            <a href="<?= base_url('profil') ?>" class="btn-ghost">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function () {

    window.toggleVis = function (inputId, btn) {
        var input = document.getElementById(inputId);
        var icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type     = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type     = 'password';
            icon.className = 'fas fa-eye';
        }
    };

    window.evalStrength = function (val) {
        var fill  = document.getElementById('strength-fill');
        var label = document.getElementById('strength-label');

        var score = 0;
        if (val.length >= 8)          score++;
        if (val.length >= 12)         score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        var levels = [
            { pct: '0%',   color: 'transparent',  text: 'Force du mot de passe' },
            { pct: '25%',  color: '#ff6b7a',       text: 'Très faible' },
            { pct: '45%',  color: '#F5A623',        text: 'Faible' },
            { pct: '65%',  color: '#f0c040',        text: 'Moyen' },
            { pct: '85%',  color: '#7ab86a',        text: 'Fort' },
            { pct: '100%', color: '#6BAF6B',        text: 'Très fort' },
        ];

        var lvl = levels[Math.min(score, 5)];
        fill.style.width      = lvl.pct;
        fill.style.background = lvl.color;
        label.textContent     = lvl.text;
        label.style.color     = lvl.color === 'transparent' ? 'rgba(255,255,255,0.35)' : lvl.color;

        setRule('rule-len',   val.length >= 8);
        setRule('rule-upper', /[A-Z]/.test(val));
        setRule('rule-num',   /[0-9]/.test(val));
        checkMatch();
    };

    function setRule(id, ok) {
        var el   = document.getElementById(id);
        var icon = el.querySelector('i');
        el.className   = 'pwd-rule ' + (ok ? 'ok' : '');
        icon.className = ok ? 'fas fa-check-circle' : 'fas fa-circle';
    }

    window.checkMatch = function () {
        var nouveau = document.getElementById('f-nouveau').value;
        var confirm = document.getElementById('f-confirm').value;
        var hint    = document.getElementById('match-hint');
        if (confirm === '') { hint.textContent = ''; return; }
        if (nouveau === confirm) {
            hint.textContent = '✓ Les mots de passe correspondent';
            hint.style.color = '#7ab86a';
        } else {
            hint.textContent = '✗ Les mots de passe ne correspondent pas';
            hint.style.color = '#ff8080';
        }
    };

})();
</script>
<?= $this->endSection() ?>