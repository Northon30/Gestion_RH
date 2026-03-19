<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    :root {
        --c-primary:        #3A7BD5;
        --c-primary-pale:   rgba(58,123,213,0.12);
        --c-primary-border: rgba(58,123,213,0.25);
        --c-accent:         #5B9BF0;
        --c-green:          #90c97f;
        --c-red:            #ff6b7a;
        --c-orange:         #F5A623;
        --c-muted:          rgba(255,255,255,0.35);
        --c-soft:           rgba(255,255,255,0.6);
    }

    .detail-card { background:#1a1a1a; border:1px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; margin-bottom:16px; }
    .detail-head { padding:16px 22px; border-bottom:1px solid rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:space-between; }
    .detail-head h5 { color:#fff; font-size:0.92rem; font-weight:600; margin:0; display:flex; align-items:center; gap:9px; }
    .detail-head h5 i { color:var(--c-primary); }
    .detail-body { padding:22px; }

    .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; }
    .info-item { display:flex; flex-direction:column; gap:4px; }
    .info-label { color:var(--c-muted); font-size:0.72rem; text-transform:uppercase; letter-spacing:0.6px; }
    .info-value { color:rgba(255,255,255,0.85); font-size:0.87rem; font-weight:500; }

    .capacity-block {
        background: linear-gradient(135deg, rgba(58,123,213,0.1), rgba(58,123,213,0.05));
        border: 1px solid var(--c-primary-border);
        border-radius: 12px;
        padding: 18px;
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 16px;
    }
    .cap-icon { width:46px; height:46px; border-radius:12px; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:1.1rem; flex-shrink:0; }
    .cap-val  { color:#fff; font-size:1.8rem; font-weight:800; line-height:1; }
    .cap-label { color:var(--c-muted); font-size:0.75rem; text-transform:uppercase; letter-spacing:0.6px; margin-top:3px; }
    .cap-bar-track { height:6px; background:rgba(255,255,255,0.06); border-radius:6px; overflow:hidden; margin-top:8px; }
    .cap-bar-fill  { height:100%; border-radius:6px; transition:width 0.5s; }

    .table-c { width:100%; border-collapse:collapse; font-size:0.83rem; }
    .table-c thead th { padding:10px 16px; font-size:0.72rem; font-weight:600; letter-spacing:0.7px; text-transform:uppercase; color:var(--c-accent); background:var(--c-primary-pale); border-bottom:1px solid rgba(255,255,255,0.05); }
    .table-c tbody td { padding:12px 16px; color:var(--c-soft); border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
    .table-c tbody tr:last-child td { border-bottom:none; }
    .table-c tbody tr:hover td { background:rgba(255,255,255,0.02); }

    .emp-cell { display:flex; align-items:center; gap:9px; }
    .emp-av { width:30px; height:30px; border-radius:50%; background:var(--c-primary-pale); border:1px solid var(--c-primary-border); display:flex; align-items:center; justify-content:center; color:var(--c-accent); font-size:0.72rem; font-weight:700; flex-shrink:0; }

    .badge-ins { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-ins.invite  { background:var(--c-primary-pale); border:1px solid var(--c-primary-border); color:var(--c-accent); }
    .badge-ins.valide  { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); }
    .badge-ins.annule  { background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:var(--c-red); }

    .badge-period { display:inline-flex; align-items:center; padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; }
    .badge-period.avenir  { background:rgba(58,123,213,0.15); border:1px solid var(--c-primary-border); color:var(--c-accent); }
    .badge-period.encours { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); }
    .badge-period.passe   { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--c-muted); }

    .btn-back    { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:var(--c-soft); border-radius:8px; padding:8px 16px; font-size:0.83rem; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-back:hover { background:rgba(255,255,255,0.1); color:#fff; }

    .btn-edit    { background:rgba(245,166,35,0.12); border:1px solid rgba(245,166,35,0.3); color:var(--c-orange); border-radius:8px; padding:8px 16px; font-size:0.83rem; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-edit:hover { background:rgba(245,166,35,0.2); color:var(--c-orange); }

    .btn-danger  { background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:var(--c-red); border-radius:8px; padding:8px 16px; font-size:0.83rem; cursor:pointer; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-danger:hover { background:rgba(220,53,69,0.2); }

    .btn-primary { background:var(--c-primary); border:none; color:#fff; border-radius:8px; padding:8px 16px; font-size:0.83rem; cursor:pointer; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-primary:hover { background:var(--c-accent); color:#fff; }

    .btn-green   { background:rgba(144,201,127,0.12); border:1px solid rgba(144,201,127,0.3); color:var(--c-green); border-radius:8px; padding:8px 16px; font-size:0.83rem; cursor:pointer; display:inline-flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-green:hover { background:rgba(144,201,127,0.2); }

    .action-box { display:flex; flex-direction:column; gap:8px; }

    .invite-form { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
    .invite-form select { flex:1; min-width:140px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fff; border-radius:8px; padding:8px 12px; font-size:0.82rem; outline:none; }
    .invite-form select:focus { border-color:var(--c-primary); }
    .invite-form select option { background:#222; }

    .comp-form { display:flex; flex-direction:column; gap:10px; }
    .comp-form select, .comp-form input { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fff; border-radius:8px; padding:8px 12px; font-size:0.82rem; outline:none; width:100%; }
    .comp-form select:focus, .comp-form input:focus { border-color:var(--c-primary); }
    .comp-form select option { background:#222; }

    .alert-success-dark { background:rgba(144,201,127,0.1); border:1px solid rgba(144,201,127,0.25); color:var(--c-green); border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .alert-error-dark   { background:rgba(220,53,69,0.1);   border:1px solid rgba(220,53,69,0.25);   color:var(--c-red);   border-radius:10px; padding:12px 16px; font-size:0.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }

    .empty-state { padding:30px 20px; text-align:center; color:var(--c-muted); font-size:0.82rem; }
    .empty-state i { font-size:1.5rem; display:block; margin-bottom:8px; opacity:0.3; }

    .cmp-tag { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; background:rgba(91,155,240,0.12); border:1px solid rgba(91,155,240,0.25); color:var(--c-accent); margin:3px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$today   = date('Y-m-d');
$pct     = $formation['Capacite_Frm'] > 0
    ? round($nbValides / $formation['Capacite_Frm'] * 100) : 0;
$fillCol = $pct >= 100 ? '#ff6b7a' : ($pct >= 75 ? '#F5A623' : '#90c97f');
$estTerminee = $formation['Statut_Frm'] === 'terminee' || $formation['DateFin_Frm'] < $today;

if ($formation['DateDebut_Frm'] > $today)    { $periode = 'avenir';  $periodeLabel = 'À venir'; }
elseif ($formation['DateFin_Frm'] >= $today) { $periode = 'encours'; $periodeLabel = 'En cours'; }
else                                          { $periode = 'passe';   $periodeLabel = 'Terminée'; }
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-graduation-cap me-2" style="color:var(--c-primary);"></i>Détail de la Formation</h1>
        <p>Référence #<?= $formation['id_Frm'] ?></p>
    </div>
    <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
        <?php if (!$estTerminee): ?>
        <a href="<?= base_url('formation/edit/'.$formation['id_Frm']) ?>" class="btn-edit">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <?php if ($nbValides == 0): ?>
        <form action="<?= base_url('formation/delete/'.$formation['id_Frm']) ?>" method="post"
              onsubmit="return confirm('Supprimer cette formation ?')">
            <?= csrf_field() ?>
            <button type="submit" class="btn-danger"><i class="fas fa-trash"></i> Supprimer</button>
        </form>
        <?php endif; ?>
        <?php endif; ?>
        <a href="<?= base_url('formation') ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-success-dark"><i class="fas fa-check-circle"></i><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert-error-dark"><i class="fas fa-exclamation-circle"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="row g-3">

    <div class="col-xl-8">

        <!-- Infos formation -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-info-circle"></i> Informations</h5>
                <span class="badge-period <?= $periode ?>"><?= $periodeLabel ?></span>
            </div>
            <div class="detail-body">
                <div style="color:#fff;font-size:1rem;font-weight:700;margin-bottom:16px;">
                    <?= esc($formation['Titre_Frm']) ?>
                </div>
                <div style="color:var(--c-muted);font-size:0.83rem;margin-bottom:18px;line-height:1.6;">
                    <?= esc($formation['Description_Frm']) ?>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Date début</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($formation['DateDebut_Frm'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date fin</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($formation['DateFin_Frm'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lieu</span>
                        <span class="info-value"><?= esc($formation['Lieu_Frm']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Formateur</span>
                        <span class="info-value"><?= esc($formation['Formateur_Frm']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Statut</span>
                        <span class="info-value"><?= ucfirst(str_replace('_', ' ', $formation['Statut_Frm'])) ?></span>
                    </div>
                </div>

                <!-- Compétences prévues -->
                <?php
                $competencesPrevues = array_filter($competencesObtenues, fn($c) => $c['id_Emp'] === null);
                ?>
                <?php if (!empty($competencesPrevues)): ?>
                <div style="margin-top:18px;">
                    <div style="color:var(--c-muted);font-size:0.72rem;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">Compétences prévues</div>
                    <?php foreach ($competencesPrevues as $cmp): ?>
                    <span class="cmp-tag"><i class="fas fa-star"></i><?= esc($cmp['Libelle_Cmp']) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Participants -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-users"></i> Participants</h5>
                <span style="color:var(--c-muted);font-size:0.78rem;">
                    <?= $nbValides ?> confirmé(s) · <?= $nbInvites ?> invité(s) · <?= $nbAnnules ?> annulé(s)
                </span>
            </div>
            <?php if (!empty($participants)): ?>
            <table class="table-c">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Direction</th>
                        <th>Inscrit le</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $p): ?>
                    <?php $ini = strtoupper(mb_substr($p['Prenom_Emp'],0,1).mb_substr($p['Nom_Emp'],0,1)); ?>
                    <tr>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-av"><?= $ini ?></div>
                                <div>
                                    <div style="color:rgba(255,255,255,0.8);font-weight:500;"><?= esc($p['Prenom_Emp'].' '.$p['Nom_Emp']) ?></div>
                                    <div style="color:var(--c-muted);font-size:0.72rem;"><?= esc($p['Email_Emp']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--c-muted);font-size:0.8rem;"><?= esc($p['Nom_Dir'] ?? '—') ?></td>
                        <td><?= date('d/m/Y', strtotime($p['Dte_Ins'])) ?></td>
                        <td><span class="badge-ins <?= $p['Stt_Ins'] ?>"><?= ucfirst($p['Stt_Ins']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                Aucun participant pour le moment
            </div>
            <?php endif; ?>
        </div>

        <!-- Compétences confirmées -->
        <?php
        $competencesConfirmees = array_filter($competencesObtenues, fn($c) => $c['id_Emp'] !== null);
        ?>
        <?php if (!empty($competencesConfirmees)): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-medal"></i> Compétences confirmées</h5>
            </div>
            <table class="table-c">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Compétence</th>
                        <th>Niveau</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($competencesConfirmees as $c): ?>
                    <tr>
                        <td><?= esc($c['Prenom_Emp'].' '.$c['Nom_Emp']) ?></td>
                        <td><?= esc($c['Libelle_Cmp']) ?></td>
                        <td><span class="cmp-tag"><?= ucfirst($c['Niveau_Obt'] ?? '—') ?></span></td>
                        <td><?= $c['Dte_Obt'] ? date('d/m/Y', strtotime($c['Dte_Obt'])) : '—' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </div>

    <div class="col-xl-4">

        <!-- Capacité -->
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-chart-bar"></i> Capacité</h5>
            </div>
            <div class="detail-body">
                <div class="capacity-block">
                    <div class="cap-icon"><i class="fas fa-users"></i></div>
                    <div style="flex:1;">
                        <div class="cap-val">
                            <?= $nbValides ?>
                            <span style="font-size:1rem;font-weight:400;color:var(--c-muted);">/ <?= $formation['Capacite_Frm'] ?></span>
                        </div>
                        <div class="cap-label">Confirmés</div>
                        <div class="cap-bar-track">
                            <div class="cap-bar-fill" style="width:<?= min($pct,100) ?>%;background:<?= $fillCol ?>;"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div style="color:var(--c-green);font-size:1.3rem;font-weight:700;"><?= $nbValides ?></div>
                        <div style="color:var(--c-muted);font-size:0.72rem;">Confirmés</div>
                    </div>
                    <div class="col-4">
                        <div style="color:var(--c-accent);font-size:1.3rem;font-weight:700;"><?= $nbInvites ?></div>
                        <div style="color:var(--c-muted);font-size:0.72rem;">Invités</div>
                    </div>
                    <div class="col-4">
                        <div style="color:var(--c-red);font-size:1.3rem;font-weight:700;"><?= $nbAnnules ?></div>
                        <div style="color:var(--c-muted);font-size:0.72rem;">Annulés</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inviter un employé -->
        <?php if (!$estTerminee && !empty($employesDisponibles)): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-user-plus"></i> Inviter un employé</h5>
            </div>
            <div class="detail-body">
                <form action="<?= base_url('formation/inviter/'.$formation['id_Frm']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="invite-form">
                        <select name="id_Emp" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($employesDisponibles as $e): ?>
                            <option value="<?= $e['id_Emp'] ?>">
                                <?= esc($e['Prenom_Emp'].' '.$e['Nom_Emp']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane"></i> Inviter
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Confirmer compétences -->
        <?php if ($estTerminee && !empty($participantsDirChef)): ?>
        <div class="detail-card">
            <div class="detail-head">
                <h5><i class="fas fa-medal"></i> Confirmer compétences</h5>
            </div>
            <div class="detail-body">
                <form action="<?= base_url('formation/confirmer-competences/'.$formation['id_Frm']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="comp-form">

                        <div>
                            <label style="color:var(--c-muted);font-size:0.75rem;display:block;margin-bottom:5px;">Compétence</label>
                            <select name="id_Cmp" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($competences as $cmp): ?>
                                <option value="<?= $cmp['id_Cmp'] ?>"><?= esc($cmp['Libelle_Cmp']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label style="color:var(--c-muted);font-size:0.75rem;display:block;margin-bottom:5px;">Niveau</label>
                            <select name="niveau">
                                <option value="debutant">Débutant</option>
                                <option value="intermediaire">Intermédiaire</option>
                                <option value="avance">Avancé</option>
                                <option value="expert">Expert</option>
                            </select>
                        </div>

                        <div>
                            <label style="color:var(--c-muted);font-size:0.75rem;display:block;margin-bottom:5px;">Mode de sélection</label>
                            <select name="mode_selection" id="mode_selection" onchange="toggleModeSelection(this.value)">
                                <option value="ont_obtenu">Sélectionner ceux qui ont obtenu</option>
                                <option value="nont_pas_obtenu">Sélectionner ceux qui n'ont pas obtenu</option>
                            </select>
                        </div>

                        <div>
                            <label style="color:var(--c-muted);font-size:0.75rem;display:block;margin-bottom:5px;" id="label-employes">
                                Employés ayant obtenu la compétence
                            </label>
                            <?php foreach ($participantsDirChef as $p): ?>
                            <label style="display:flex;align-items:center;gap:8px;padding:6px 0;color:var(--c-soft);font-size:0.82rem;cursor:pointer;">
                                <input type="checkbox" name="employes_selectionnes[]" value="<?= $p['id_Emp'] ?>"
                                       style="accent-color:var(--c-primary);">
                                <?= esc($p['Prenom_Emp'].' '.$p['Nom_Emp']) ?>
                            </label>
                            <?php endforeach; ?>
                        </div>

                        <button type="submit" class="btn-green">
                            <i class="fas fa-check-double"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function toggleModeSelection(val) {
    var label = document.getElementById('label-employes');
    if (val === 'nont_pas_obtenu') {
        label.textContent = "Employés n'ayant PAS obtenu la compétence";
    } else {
        label.textContent = "Employés ayant obtenu la compétence";
    }
}
</script>
<?= $this->endSection() ?>