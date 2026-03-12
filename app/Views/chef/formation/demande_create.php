<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root { --c-primary:#3A7BD5; --c-primary-pale:rgba(58,123,213,0.12); --c-primary-border:rgba(58,123,213,0.25); --c-accent:#5B9BF0; --c-green:#90c97f; --c-red:#ff6b7a; --c-orange:#F5A623; --c-muted:rgba(255,255,255,0.35); --c-soft:rgba(255,255,255,0.6); }
    .form-card { background:#1a1a1a; border:1px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; max-width:720px; }
    .form-head { padding:18px 24px; border-bottom:1px solid rgba(255,255,255,0.05); display:flex; align-items:center; gap:10px; }
    .form-head h5 { color:#fff; font-size:0.95rem; font-weight:600; margin:0; }
    .form-head i { color:var(--c-primary); }
    .form-body { padding:24px; }
    .form-row { margin-bottom:20px; }
    .form-label-dark { color:var(--c-muted); font-size:0.82rem; margin-bottom:7px; display:block; }
    .form-label-dark span { color:var(--c-red); }
    .form-control-dark, .form-select-dark { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fff; border-radius:8px; padding:10px 14px; font-size:0.88rem; width:100%; outline:none; transition:border-color 0.2s; }
    .form-control-dark:focus, .form-select-dark:focus { border-color:var(--c-primary); background:rgba(255,255,255,0.07); }
    .form-select-dark option { background:#222; }
    .form-foot { padding:18px 24px; border-top:1px solid rgba(255,255,255,0.05); display:flex; align-items:center; gap:10px; }
    .btn-submit { background:linear-gradient(135deg,var(--c-primary),#2A5FAA); border:none; color:#fff; font-weight:600; border-radius:8px; padding:9px 22px; font-size:0.88rem; cursor:pointer; transition:all 0.25s; display:inline-flex; align-items:center; gap:7px; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 5px 15px rgba(58,123,213,0.35); }
    .btn-back { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:var(--c-soft); border-radius:8px; padding:9px 16px; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-back:hover { background:rgba(255,255,255,0.1); color:#fff; }
    .alert-error-dark { background:rgba(220,53,69,0.1); border:1px solid rgba(220,53,69,0.25); color:var(--c-red); border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; }
    .source-tabs { display:flex; gap:8px; margin-bottom:20px; }
    .source-tab { flex:1; padding:10px; border:1px solid rgba(255,255,255,0.1); border-radius:10px; text-align:center; cursor:pointer; color:var(--c-muted); font-size:0.83rem; font-weight:600; transition:all 0.2s; background:rgba(255,255,255,0.03); }
    .source-tab.active { background:var(--c-primary-pale); border-color:var(--c-primary-border); color:var(--c-accent); }
    .section-libre { display:none; }
    .section-libre.active, .section-catalogue.active { display:block; }
    .info-chef { background:rgba(58,123,213,0.08); border:1px solid var(--c-primary-border); border-radius:10px; padding:12px 16px; color:var(--c-accent); font-size:0.82rem; margin-bottom:20px; display:flex; align-items:flex-start; gap:8px; }
    .formation-option-card { display:flex; align-items:center; gap:10px; padding:12px; border:1px solid rgba(255,255,255,0.08); border-radius:10px; cursor:pointer; transition:all 0.2s; margin-bottom:8px; }
    .formation-option-card:hover { border-color:var(--c-primary-border); background:var(--c-primary-pale); }
    .formation-option-card input[type=radio] { accent-color:var(--c-primary); flex-shrink:0; }
    .formation-option-card label { cursor:pointer; flex:1; }
    .formation-option-card .f-title { color:rgba(255,255,255,0.85); font-size:0.85rem; font-weight:500; }
    .formation-option-card .f-meta  { color:var(--c-muted); font-size:0.75rem; margin-top:2px; }
    .cap-badge { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--c-muted); padding:2px 8px; border-radius:10px; font-size:0.72rem; white-space:nowrap; }
    .cap-badge.full { border-color:rgba(220,53,69,0.3); color:var(--c-red); background:rgba(220,53,69,0.08); }
    textarea.form-control-dark { resize:vertical; min-height:80px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-chalkboard-teacher me-2" style="color:var(--c-primary);"></i>Nouvelle demande de formation</h1>
        <p>Soumettez votre demande — elle sera transmise directement au RH</p>
    </div>
    <a href="<?= base_url('demande-formation') ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (!empty(session()->getFlashdata('errors'))): ?>
<div class="alert-error-dark">
    <?php foreach (session()->getFlashdata('errors') as $e): ?>
    <div><i class="fas fa-circle" style="font-size:0.4rem;vertical-align:middle;margin-right:6px;"></i><?= $e ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div class="form-card">
    <div class="form-head">
        <i class="fas fa-file-alt"></i>
        <h5>Informations de la demande</h5>
    </div>
    <form method="post" action="<?= base_url('demande-formation/store') ?>" id="form-demande">
        <?= csrf_field() ?>
        <input type="hidden" name="_source" id="hidden-source" value="catalogue">
        <div class="form-body">

            <div class="info-chef">
                <i class="fas fa-info-circle" style="margin-top:1px;flex-shrink:0;"></i>
                <span>En tant que Chef de Direction, votre demande passe directement à l'étape de validation RH sans passer par l'approbation d'un supérieur.</span>
            </div>

            <!-- Type de demande -->
            <div class="form-row">
                <label class="form-label-dark">Type de demande <span>*</span></label>
                <select name="Type_DFrm" class="form-select-dark" required>
                    <option value="">— Sélectionner —</option>
                    <option value="demande"    <?= old('Type_DFrm') == 'demande'    ? 'selected' : '' ?>>Demande spontanée</option>
                    <option value="invitation" <?= old('Type_DFrm') == 'invitation' ? 'selected' : '' ?>>Invitation reçue</option>
                </select>
            </div>

            <!-- Source : catalogue ou libre -->
            <div class="form-row">
                <label class="form-label-dark">Source de la formation <span>*</span></label>
                <div class="source-tabs">
                    <div class="source-tab active" data-source="catalogue" onclick="switchSource('catalogue')">
                        <i class="fas fa-list me-1"></i> Catalogue existant
                    </div>
                    <div class="source-tab" data-source="libre" onclick="switchSource('libre')">
                        <i class="fas fa-pen me-1"></i> Formation libre
                    </div>
                </div>
            </div>

            <!-- Catalogue -->
            <div id="section-catalogue" class="section-catalogue active">
                <div class="form-row">
                    <label class="form-label-dark">Sélectionner une formation <span>*</span></label>
                    <?php if (!empty($formations)): ?>
                    <div style="max-height:280px;overflow-y:auto;padding-right:4px;">
                        <?php foreach ($formations as $f): ?>
                        <?php
                        $plein = $f['Capacite_Frm'] > 0 && $f['nb_valides'] >= $f['Capacite_Frm'];
                        ?>
                        <div class="formation-option-card" onclick="this.querySelector('input').click()">
                            <input type="radio" name="id_Frm" value="<?= $f['id_Frm'] ?>"
                                <?= old('id_Frm') == $f['id_Frm'] ? 'checked' : '' ?>>
                            <label onclick="event.preventDefault()">
                                <div class="f-title"><?= esc($f['Description_Frm']) ?></div>
                                <div class="f-meta">
                                    <i class="fas fa-calendar me-1"></i><?= date('d/m/Y', strtotime($f['DateDebut_Frm'])) ?>
                                    <span class="mx-2">·</span>
                                    <i class="fas fa-map-marker-alt me-1"></i><?= esc($f['Lieu_Frm']) ?>
                                </div>
                            </label>
                            <span class="cap-badge <?= $plein ? 'full' : '' ?>">
                                <?= $plein ? 'Complet' : ($f['nb_valides'].'/'.$f['Capacite_Frm']) ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div style="padding:20px;text-align:center;color:var(--c-muted);font-size:0.83rem;background:rgba(255,255,255,0.03);border-radius:10px;">
                        Aucune formation disponible dans le catalogue.
                        <br>Utilisez l'option "Formation libre".
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Libre -->
            <div id="section-libre" class="section-libre">
                <div class="form-row">
                    <label class="form-label-dark">Intitulé de la formation <span>*</span></label>
                    <input type="text" name="Description_Libre" class="form-control-dark"
                        placeholder="Titre de la formation..." value="<?= old('Description_Libre') ?>">
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-row">
                            <label class="form-label-dark">Date début <span>*</span></label>
                            <input type="date" name="DateDebut_Libre" class="form-control-dark" value="<?= old('DateDebut_Libre') ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-row">
                            <label class="form-label-dark">Date fin</label>
                            <input type="date" name="DateFin_Libre" class="form-control-dark" value="<?= old('DateFin_Libre') ?>">
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-row">
                            <label class="form-label-dark">Lieu</label>
                            <input type="text" name="Lieu_Libre" class="form-control-dark"
                                placeholder="Lieu de la formation" value="<?= old('Lieu_Libre') ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-row">
                            <label class="form-label-dark">Formateur</label>
                            <input type="text" name="Formateur_Libre" class="form-control-dark"
                                placeholder="Nom du formateur" value="<?= old('Formateur_Libre') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motif -->
            <div class="form-row">
                <label class="form-label-dark">Motif de la demande <span>*</span></label>
                <textarea name="Motif" class="form-control-dark" rows="3"
                    placeholder="Expliquez votre besoin de formation..." required><?= old('Motif') ?></textarea>
            </div>
        </div>
        <div class="form-foot">
            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Soumettre</button>
            <a href="<?= base_url('demande-formation') ?>" class="btn-back">Annuler</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function switchSource(source) {
    document.getElementById('hidden-source').value = source;
    document.querySelectorAll('.source-tab').forEach(function(t) {
        t.classList.toggle('active', t.dataset.source === source);
    });
    document.getElementById('section-catalogue').style.display = source === 'catalogue' ? 'block' : 'none';
    document.getElementById('section-libre').style.display     = source === 'libre'     ? 'block' : 'none';
}

<?php if (old('_source') === 'libre'): ?>
switchSource('libre');
<?php endif; ?>
</script>
<?= $this->endSection() ?>