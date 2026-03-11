<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-orange:        #F5A623;
        --c-orange-pale:   rgba(245,166,35,0.10);
        --c-orange-border: rgba(245,166,35,0.25);
        --c-surface:       #1a1a1a;
        --c-border:        rgba(255,255,255,0.06);
        --c-text:          rgba(255,255,255,0.85);
        --c-muted:         rgba(255,255,255,0.35);
        --c-soft:          rgba(255,255,255,0.55);
    }

    .form-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        align-items: start;
    }

    .form-block {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .form-block.full { grid-column: span 2; }

    .form-block-head {
        padding: 14px 20px;
        border-bottom: 1px solid var(--c-border);
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .form-block-head i { color: var(--c-orange); font-size: 0.85rem; }

    .form-block-head h6 {
        color: #fff;
        font-size: 0.85rem;
        font-weight: 600;
        margin: 0;
    }

    .form-block-body { padding: 20px; }

    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }

    .field-label {
        display: block;
        color: var(--c-muted);
        font-size: 0.75rem;
        font-weight: 500;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .field-label .req { color: #ff6b7a; margin-left: 2px; }

    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .field-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

    .field-error {
        color: #ff6b7a;
        font-size: 0.72rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .error-block {
        background: rgba(220,53,69,0.08);
        border: 1px solid rgba(220,53,69,0.2);
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 18px;
    }

    .error-block p {
        color: #ff6b7a;
        font-size: 0.82rem;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .error-block ul {
        margin: 0;
        padding-left: 18px;
        color: rgba(255,100,100,0.7);
        font-size: 0.78rem;
    }

    .error-block ul li { margin-bottom: 3px; }

    .form-footer {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 14px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        grid-column: span 2;
    }

    .password-wrap { position: relative; }

    .password-wrap .form-control-dark { padding-right: 42px; }

    .password-toggle {
        position: absolute;
        right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        color: var(--c-muted); cursor: pointer;
        padding: 0; font-size: 0.82rem;
        transition: color 0.2s;
    }

    .password-toggle:hover { color: var(--c-orange); }

    .radio-group { display: flex; gap: 8px; }

    .radio-item {
        flex: 1;
        border: 1px solid var(--c-border);
        border-radius: 9px;
        padding: 9px 12px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--c-soft);
        font-size: 0.82rem;
        user-select: none;
    }

    .radio-item:hover { border-color: var(--c-orange-border); }

    .radio-item input[type="radio"] { display: none; }

    .radio-item.selected {
        border-color: var(--c-orange-border);
        background: var(--c-orange-pale);
        color: var(--c-orange);
    }

    .radio-dot {
        width: 14px; height: 14px;
        border-radius: 50%;
        border: 2px solid currentColor;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: all 0.15s;
    }

    .radio-dot::after {
        content: ''; width: 5px; height: 5px;
        border-radius: 50%; background: currentColor; display: none;
    }

    .radio-item.selected .radio-dot::after { display: block; }

    .hint {
        color: var(--c-muted);
        font-size: 0.72rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 9px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-green-sm {
        background: linear-gradient(135deg, #2D6A4F, #1e4d38);
        border: none; color: #fff; font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.8rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-green-sm:hover { transform: translateY(-1px); color: #fff; }

    .btn-outline-gray {
        background: transparent;
        border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-outline-gray:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    @media (max-width: 992px) { .form-wrapper { grid-template-columns: 1fr; } .form-block.full, .form-footer { grid-column: span 1; } .field-row-3 { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 576px) { .field-row, .field-row-3 { grid-template-columns: 1fr; } .radio-group { flex-direction: column; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-plus me-2" style="color:#F5A623;"></i>Nouvel Employe</h1>
        <p>
            <a href="<?= base_url('employe') ?>" style="color:rgba(255,255,255,0.4);text-decoration:none;">Employes</a>
            / Creer
        </p>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="error-block">
    <p><i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs suivantes :</p>
    <ul>
        <?php foreach ($errors as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="error-block">
    <p><i class="fas fa-exclamation-circle"></i><?= session()->getFlashdata('error') ?></p>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
<div style="background:rgba(74,103,65,0.15);border:1px solid rgba(74,103,65,0.35);border-radius:10px;padding:12px 16px;color:#7ab86a;font-size:0.82rem;display:flex;align-items:center;gap:10px;margin-bottom:18px;">
    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<form action="<?= base_url('employe/store') ?>" method="POST" id="form-create" novalidate>
    <?= csrf_field() ?>

    <div class="form-wrapper">

        <!-- Bloc 1 : Identite -->
        <div class="form-block">
            <div class="form-block-head">
                <i class="fas fa-user"></i>
                <h6>Identite</h6>
            </div>
            <div class="form-block-body">

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Nom <span class="req">*</span></label>
                        <input type="text" name="Nom_Emp"
                               class="form-control-dark w-100"
                               value="<?= old('Nom_Emp') ?>"
                               placeholder="KOUASSI"
                               required autofocus>
                        <?php if (!empty($errors['Nom_Emp'])): ?>
                        <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Nom_Emp'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Prenom <span class="req">*</span></label>
                        <input type="text" name="Prenom_Emp"
                               class="form-control-dark w-100"
                               value="<?= old('Prenom_Emp') ?>"
                               placeholder="Jean"
                               required>
                        <?php if (!empty($errors['Prenom_Emp'])): ?>
                        <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Prenom_Emp'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Sexe <span class="req">*</span></label>
                    <div class="radio-group" id="sexe-group">
                        <label class="radio-item <?= old('Sexe_Emp') === '1' ? 'selected' : '' ?>">
                            <input type="radio" name="Sexe_Emp" value="1" <?= old('Sexe_Emp') === '1' ? 'checked' : '' ?>>
                            <span class="radio-dot"></span>
                            <i class="fas fa-mars" style="font-size:0.8rem;"></i> Homme
                        </label>
                        <label class="radio-item <?= old('Sexe_Emp') === '0' ? 'selected' : '' ?>">
                            <input type="radio" name="Sexe_Emp" value="0" <?= old('Sexe_Emp') === '0' ? 'checked' : '' ?>>
                            <span class="radio-dot"></span>
                            <i class="fas fa-venus" style="font-size:0.8rem;"></i> Femme
                        </label>
                    </div>
                    <?php if (!empty($errors['Sexe_Emp'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Sexe_Emp'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Date de naissance <span class="req">*</span></label>
                        <input type="date" name="DateNaissance_Emp"
                               class="form-control-dark w-100"
                               value="<?= old('DateNaissance_Emp') ?>"
                               required>
                        <?php if (!empty($errors['DateNaissance_Emp'])): ?>
                        <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['DateNaissance_Emp'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Date d'embauche</label>
                        <input type="date" name="DateEmbauche_Emp"
                               class="form-control-dark w-100"
                               value="<?= old('DateEmbauche_Emp') ?>">
                    </div>
                </div>

            </div>
        </div>

        <!-- Bloc 2 : Contact -->
        <div class="form-block">
            <div class="form-block-head">
                <i class="fas fa-address-card"></i>
                <h6>Contact</h6>
            </div>
            <div class="form-block-body">

                <div class="field-group">
                    <label class="field-label">Email <span class="req">*</span></label>
                    <input type="email" name="Email_Emp"
                           class="form-control-dark w-100"
                           value="<?= old('Email_Emp') ?>"
                           placeholder="prenom.nom@anstat.ci"
                           required>
                    <?php if (!empty($errors['Email_Emp'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Email_Emp'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Telephone <span class="req">*</span></label>
                    <input type="text" name="Telephone_Emp"
                           class="form-control-dark w-100"
                           value="<?= old('Telephone_Emp') ?>"
                           placeholder="07 XX XX XX XX"
                           required>
                    <?php if (!empty($errors['Telephone_Emp'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Telephone_Emp'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Adresse <span class="req">*</span></label>
                    <input type="text" name="Adresse_Emp"
                           class="form-control-dark w-100"
                           value="<?= old('Adresse_Emp') ?>"
                           placeholder="Cocody, Abidjan"
                           required>
                    <?php if (!empty($errors['Adresse_Emp'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Adresse_Emp'] ?></div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- Bloc 3 : Affectation -->
        <div class="form-block">
            <div class="form-block-head">
                <i class="fas fa-briefcase"></i>
                <h6>Affectation</h6>
            </div>
            <div class="form-block-body">

                <div class="field-group">
                    <label class="field-label">Direction <span class="req">*</span></label>
                    <select name="id_Dir" class="form-select-dark w-100" required>
                        <option value="">-- Selectionner --</option>
                        <?php foreach ($directions as $dir): ?>
                        <option value="<?= $dir['id_Dir'] ?>"
                            <?= old('id_Dir') == $dir['id_Dir'] ? 'selected' : '' ?>>
                            <?= esc($dir['Nom_Dir']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['id_Dir'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['id_Dir'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Grade <span class="req">*</span></label>
                    <select name="id_Grd" class="form-select-dark w-100" required>
                        <option value="">-- Selectionner --</option>
                        <?php foreach ($grades as $grd): ?>
                        <option value="<?= $grd['id_Grd'] ?>"
                            <?= old('id_Grd') == $grd['id_Grd'] ? 'selected' : '' ?>>
                            <?= esc($grd['Libelle_Grd']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['id_Grd'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['id_Grd'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Profil <span class="req">*</span></label>
                    <select name="id_Pfl" class="form-select-dark w-100" required>
                        <option value="">-- Selectionner --</option>
                        <?php foreach ($profils as $pfl): ?>
                        <option value="<?= $pfl['id_Pfl'] ?>"
                            <?= old('id_Pfl') == $pfl['id_Pfl'] ? 'selected' : '' ?>>
                            <?= esc($pfl['Libelle_Pfl']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['id_Pfl'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['id_Pfl'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Disponibilite</label>
                    <div class="radio-group" id="dispo-group">
                        <label class="radio-item selected" id="dispo-oui">
                            <input type="radio" name="Disponibilite_Emp" value="1" checked>
                            <span class="radio-dot"></span>
                            <span class="dispo-dot" style="width:6px;height:6px;border-radius:50%;background:#7ab86a;"></span>
                            Disponible
                        </label>
                        <label class="radio-item" id="dispo-non">
                            <input type="radio" name="Disponibilite_Emp" value="0">
                            <span class="radio-dot"></span>
                            <span class="dispo-dot" style="width:6px;height:6px;border-radius:50%;background:#ff8080;"></span>
                            Absent
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bloc 4 : Acces -->
        <div class="form-block">
            <div class="form-block-head">
                <i class="fas fa-lock"></i>
                <h6>Acces au systeme</h6>
            </div>
            <div class="form-block-body">

                <div class="field-group">
                    <label class="field-label">Mot de passe <span class="req">*</span></label>
                    <div class="password-wrap">
                        <input type="password" name="Password_Emp" id="pwd-input"
                               class="form-control-dark w-100"
                               placeholder="6 caracteres minimum"
                               required minlength="6">
                        <button type="button" class="password-toggle" onclick="togglePwd()">
                            <i class="fas fa-eye" id="pwd-eye"></i>
                        </button>
                    </div>
                    <div class="hint"><i class="fas fa-info-circle"></i> Min. 6 caracteres</div>
                    <?php if (!empty($errors['Password_Emp'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Password_Emp'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Confirmer le mot de passe</label>
                    <div class="password-wrap">
                        <input type="password" id="pwd-confirm"
                               class="form-control-dark w-100"
                               placeholder="Repeter le mot de passe">
                        <button type="button" class="password-toggle" onclick="togglePwdConfirm()">
                            <i class="fas fa-eye" id="pwd-eye2"></i>
                        </button>
                    </div>
                    <div class="hint" id="pwd-match-hint" style="display:none;"></div>
                </div>

                <div style="background:rgba(245,166,35,0.06);border:1px solid rgba(245,166,35,0.12);border-radius:9px;padding:12px 14px;margin-top:6px;">
                    <div style="font-size:0.72rem;color:rgba(255,255,255,0.4);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">
                        <i class="fas fa-info-circle me-1"></i> Information
                    </div>
                    <p style="color:rgba(255,255,255,0.45);font-size:0.78rem;margin:0;line-height:1.5;">
                        L'employe utilisera son email et ce mot de passe pour se connecter au systeme RH.
                    </p>
                </div>

            </div>
        </div>

        <!-- Footer actions -->
        <div class="form-footer">
            <a href="<?= base_url('employe') ?>" class="btn-outline-gray">
                <i class="fas fa-arrow-left"></i> Retour a la liste
            </a>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button type="submit" name="action" value="new" class="btn-green-sm">
                    <i class="fas fa-plus"></i> Enregistrer et ajouter un autre
                </button>
                <button type="submit" name="action" value="save" class="btn-orange">
                    <i class="fas fa-save"></i> Enregistrer la fiche
                </button>
            </div>
        </div>

    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function() {

    // Radio sexe
    document.querySelectorAll('#sexe-group .radio-item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('#sexe-group .radio-item').forEach(function(i) { i.classList.remove('selected'); });
            this.classList.add('selected');
            this.querySelector('input').checked = true;
        });
    });

    // Radio disponibilite
    document.querySelectorAll('#dispo-group .radio-item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('#dispo-group .radio-item').forEach(function(i) { i.classList.remove('selected'); });
            this.classList.add('selected');
            this.querySelector('input').checked = true;
        });
    });

    // Afficher/masquer mot de passe
    window.togglePwd = function() {
        var input = document.getElementById('pwd-input');
        var eye   = document.getElementById('pwd-eye');
        if (input.type === 'password') {
            input.type = 'text';
            eye.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            eye.className = 'fas fa-eye';
        }
    };

    window.togglePwdConfirm = function() {
        var input = document.getElementById('pwd-confirm');
        var eye   = document.getElementById('pwd-eye2');
        if (input.type === 'password') {
            input.type = 'text';
            eye.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            eye.className = 'fas fa-eye';
        }
    };

    // Verification correspondance mot de passe
    function checkPwd() {
        var pwd     = document.getElementById('pwd-input').value;
        var confirm = document.getElementById('pwd-confirm').value;
        var hint    = document.getElementById('pwd-match-hint');

        if (confirm === '') { hint.style.display = 'none'; return; }

        hint.style.display = 'flex';
        if (pwd === confirm) {
            hint.style.color = '#7ab86a';
            hint.innerHTML = '<i class="fas fa-check-circle"></i> Les mots de passe correspondent';
        } else {
            hint.style.color = '#ff6b7a';
            hint.innerHTML = '<i class="fas fa-times-circle"></i> Les mots de passe ne correspondent pas';
        }
    }

    document.getElementById('pwd-input').addEventListener('input',   checkPwd);
    document.getElementById('pwd-confirm').addEventListener('input', checkPwd);

    // Validation client avant envoi
    document.getElementById('form-create').addEventListener('submit', function(e) {
        var pwd     = document.getElementById('pwd-input').value;
        var confirm = document.getElementById('pwd-confirm').value;
        if (confirm !== '' && pwd !== confirm) {
            e.preventDefault();
            document.getElementById('pwd-confirm').focus();
            document.getElementById('pwd-match-hint').style.display = 'flex';
            document.getElementById('pwd-match-hint').style.color   = '#ff6b7a';
            document.getElementById('pwd-match-hint').innerHTML = '<i class="fas fa-times-circle"></i> Les mots de passe ne correspondent pas';
        }
    });

})();
</script>
<?= $this->endSection() ?>