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

    .grade-change-notice {
        background: rgba(245,166,35,0.07);
        border: 1px solid rgba(245,166,35,0.18);
        border-radius: 8px;
        padding: 10px 13px;
        font-size: 0.75rem;
        color: rgba(245,166,35,0.65);
        margin-top: 8px;
        display: none;
        align-items: center;
        gap: 7px;
    }

    .grade-change-notice.visible { display: flex; }

    .fiche-mini {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: #111;
        border: 1px solid var(--c-border);
        border-radius: 10px;
        margin-bottom: 16px;
    }

    .fiche-mini-avatar {
        width: 42px; height: 42px; border-radius: 50%;
        background: var(--c-orange-pale);
        border: 1px solid var(--c-orange-border);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; font-weight: 800;
        color: var(--c-orange); text-transform: uppercase;
        flex-shrink: 0;
    }

    .fiche-mini-avatar.female {
        background: rgba(255,105,180,0.1);
        border-color: rgba(255,105,180,0.25);
        color: #ff8fbf;
    }

    .fiche-mini-name { color: #fff; font-weight: 700; font-size: 0.88rem; margin: 0; }
    .fiche-mini-email { color: var(--c-muted); font-size: 0.72rem; margin-top: 2px; }

    .btn-orange {
        background: linear-gradient(135deg, var(--c-orange), #d4891a);
        border: none; color: #111; font-weight: 700; border-radius: 8px;
        padding: 9px 18px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-orange:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(245,166,35,0.3); color: #111; }

    .btn-outline-gray {
        background: transparent;
        border: 1px solid var(--c-border);
        color: var(--c-soft); font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-outline-gray:hover { background: rgba(255,255,255,0.04); color: var(--c-text); }

    .btn-outline-blue {
        background: transparent;
        border: 1px solid rgba(58,123,213,0.25);
        color: #5B9BF0; font-weight: 600; border-radius: 8px;
        padding: 9px 16px; font-size: 0.82rem; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center;
        gap: 6px; text-decoration: none; white-space: nowrap;
    }

    .btn-outline-blue:hover { background: rgba(58,123,213,0.10); color: #5B9BF0; }

    @media (max-width: 992px) { .form-wrapper { grid-template-columns: 1fr; } .form-block.full, .form-footer { grid-column: span 1; } }
    @media (max-width: 576px) { .field-row { grid-template-columns: 1fr; } .radio-group { flex-direction: column; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-edit me-2" style="color:#F5A623;"></i>Modifier un Employe</h1>
        <p>
            <a href="<?= base_url('employe') ?>" style="color:rgba(255,255,255,0.4);text-decoration:none;">Employes</a>
            /
            <a href="<?= base_url('employe/show/' . $employe['id_Emp']) ?>" style="color:rgba(255,255,255,0.4);text-decoration:none;">
                <?= esc($employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']) ?>
            </a>
            / Modifier
        </p>
    </div>
    <a href="<?= base_url('employe/show/' . $employe['id_Emp']) ?>" class="btn-outline-blue">
        <i class="fas fa-eye"></i> Voir la fiche
    </a>
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

<form action="<?= base_url('employe/update/' . $employe['id_Emp']) ?>" method="POST" id="form-edit" novalidate>
    <?= csrf_field() ?>

    <div class="form-wrapper">

        <!-- Bloc 1 : Identite -->
        <div class="form-block">
            <div class="form-block-head">
                <i class="fas fa-user"></i>
                <h6>Identite</h6>
            </div>
            <div class="form-block-body">

                <!-- Mini fiche recapitulatif -->
                <div class="fiche-mini">
                    <div class="fiche-mini-avatar <?= (int)$employe['Sexe_Emp'] === 0 ? 'female' : '' ?>">
                        <?= mb_substr($employe['Nom_Emp'], 0, 1) . mb_substr($employe['Prenom_Emp'], 0, 1) ?>
                    </div>
                    <div>
                        <p class="fiche-mini-name"><?= esc($employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']) ?></p>
                        <div class="fiche-mini-email"><?= esc($employe['Email_Emp']) ?></div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Nom <span class="req">*</span></label>
                        <input type="text" name="Nom_Emp"
                               class="form-control-dark w-100"
                               value="<?= old('Nom_Emp', $employe['Nom_Emp']) ?>"
                               required>
                        <?php if (!empty($errors['Nom_Emp'])): ?>
                        <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Nom_Emp'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Prenom <span class="req">*</span></label>
                        <input type="text" name="Prenom_Emp"
                               class="form-control-dark w-100"
                               value="<?= old('Prenom_Emp', $employe['Prenom_Emp']) ?>"
                               required>
                        <?php if (!empty($errors['Prenom_Emp'])): ?>
                        <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Prenom_Emp'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Sexe <span class="req">*</span></label>
                    <?php $sexeVal = old('Sexe_Emp', (string)$employe['Sexe_Emp']); ?>
                    <div class="radio-group" id="sexe-group">
                        <label class="radio-item <?= $sexeVal === '1' ? 'selected' : '' ?>">
                            <input type="radio" name="Sexe_Emp" value="1" <?= $sexeVal === '1' ? 'checked' : '' ?>>
                            <span class="radio-dot"></span>
                            <i class="fas fa-mars" style="font-size:0.8rem;"></i> Homme
                        </label>
                        <label class="radio-item <?= $sexeVal === '0' ? 'selected' : '' ?>">
                            <input type="radio" name="Sexe_Emp" value="0" <?= $sexeVal === '0' ? 'checked' : '' ?>>
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
                               value="<?= old('DateNaissance_Emp', $employe['DateNaissance_Emp'] ?? '') ?>"
                               required>
                        <?php if (!empty($errors['DateNaissance_Emp'])): ?>
                        <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['DateNaissance_Emp'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Date d'embauche</label>
                        <input type="date" name="DateEmbauche_Emp"
                               class="form-control-dark w-100"
                               value="<?= old('DateEmbauche_Emp', $employe['DateEmbauche_Emp'] ?? '') ?>">
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
                           value="<?= old('Email_Emp', $employe['Email_Emp']) ?>"
                           required>
                    <?php if (!empty($errors['Email_Emp'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Email_Emp'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Telephone <span class="req">*</span></label>
                    <input type="text" name="Telephone_Emp"
                           class="form-control-dark w-100"
                           value="<?= old('Telephone_Emp', $employe['Telephone_Emp'] ?? '') ?>"
                           required>
                    <?php if (!empty($errors['Telephone_Emp'])): ?>
                    <div class="field-error"><i class="fas fa-times-circle"></i><?= $errors['Telephone_Emp'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label class="field-label">Adresse <span class="req">*</span></label>
                    <input type="text" name="Adresse_Emp"
                           class="form-control-dark w-100"
                           value="<?= old('Adresse_Emp', $employe['Adresse_Emp'] ?? '') ?>"
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
                            <?= old('id_Dir', $employe['id_Dir']) == $dir['id_Dir'] ? 'selected' : '' ?>>
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
                    <select name="id_Grd" class="form-select-dark w-100" id="select-grade"
                            data-original="<?= (int)$employe['id_Grd'] ?>" required>
                        <option value="">-- Selectionner --</option>
                        <?php foreach ($grades as $grd): ?>
                        <option value="<?= $grd['id_Grd'] ?>"
                            <?= old('id_Grd', $employe['id_Grd']) == $grd['id_Grd'] ? 'selected' : '' ?>>
                            <?= esc($grd['Libelle_Grd']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="grade-change-notice" id="grade-notice">
                        <i class="fas fa-info-circle"></i>
                        Le changement de grade sera enregistre dans l'historique d'affectation.
                    </div>
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
                            <?= old('id_Pfl', $employe['id_Pfl']) == $pfl['id_Pfl'] ? 'selected' : '' ?>>
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
                    <?php $dispoVal = old('Disponibilite_Emp', (string)$employe['Disponibilite_Emp']); ?>
                    <div class="radio-group" id="dispo-group">
                        <label class="radio-item <?= $dispoVal === '1' ? 'selected' : '' ?>">
                            <input type="radio" name="Disponibilite_Emp" value="1" <?= $dispoVal === '1' ? 'checked' : '' ?>>
                            <span class="radio-dot"></span>
                            <span style="width:6px;height:6px;border-radius:50%;background:#7ab86a;display:inline-block;"></span>
                            Disponible
                        </label>
                        <label class="radio-item <?= $dispoVal === '0' ? 'selected' : '' ?>">
                            <input type="radio" name="Disponibilite_Emp" value="0" <?= $dispoVal === '0' ? 'checked' : '' ?>>
                            <span class="radio-dot"></span>
                            <span style="width:6px;height:6px;border-radius:50%;background:#ff8080;display:inline-block;"></span>
                            Absent
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bloc 4 : Mot de passe (optionnel) -->
        <div class="form-block">
            <div class="form-block-head">
                <i class="fas fa-lock"></i>
                <h6>Mot de passe</h6>
            </div>
            <div class="form-block-body">

                <div style="background:rgba(245,166,35,0.06);border:1px solid rgba(245,166,35,0.12);border-radius:9px;padding:12px 14px;margin-bottom:16px;">
                    <p style="color:rgba(245,166,35,0.6);font-size:0.78rem;margin:0;line-height:1.5;display:flex;align-items:flex-start;gap:8px;">
                        <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
                        Laissez ce champ vide pour conserver le mot de passe actuel. Remplissez-le uniquement pour le modifier.
                    </p>
                </div>

                <div class="field-group">
                    <label class="field-label">Nouveau mot de passe</label>
                    <div style="position:relative;">
                        <input type="password" name="Password_Emp" id="pwd-input"
                               class="form-control-dark w-100"
                               placeholder="Laisser vide pour ne pas changer"
                               style="padding-right:42px;"
                               minlength="6">
                        <button type="button"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--c-muted);cursor:pointer;padding:0;font-size:0.82rem;transition:color 0.2s;"
                                onclick="togglePwd()">
                            <i class="fas fa-eye" id="pwd-eye"></i>
                        </button>
                    </div>
                    <div style="color:var(--c-muted);font-size:0.72rem;margin-top:5px;display:flex;align-items:center;gap:4px;">
                        <i class="fas fa-info-circle"></i> Min. 6 caracteres si renseigne
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer actions -->
        <div class="form-footer">
            <a href="<?= base_url('employe/show/' . $employe['id_Emp']) ?>" class="btn-outline-gray">
                <i class="fas fa-arrow-left"></i> Annuler
            </a>
            <button type="submit" class="btn-orange">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
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

    // Notice changement de grade
    var gradeSelect = document.getElementById('select-grade');
    var gradeNotice = document.getElementById('grade-notice');
    var originalGrd = gradeSelect ? gradeSelect.dataset.original : null;

    if (gradeSelect) {
        gradeSelect.addEventListener('change', function() {
            if (this.value !== '' && this.value !== originalGrd) {
                gradeNotice.classList.add('visible');
            } else {
                gradeNotice.classList.remove('visible');
            }
        });
    }

    // Toggle mot de passe
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

})();
</script>
<?= $this->endSection() ?>