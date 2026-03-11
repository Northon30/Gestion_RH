<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    .dir-header-card {
        background: linear-gradient(135deg, #1a1a1a 0%, #1f2a1a 100%);
        border: 1px solid rgba(74,103,65,0.25);
        border-radius: 14px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .dir-header-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, #F5A623, #4A6741, transparent);
    }

    .dir-header-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(74,103,65,0.25);
        border: 1px solid rgba(74,103,65,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #90c97f;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .dir-header-info { flex: 1; }

    .dir-header-info h2 {
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .dir-header-info p {
        color: rgba(255,255,255,0.4);
        font-size: 0.82rem;
        margin: 0;
    }

    .dir-header-stat {
        text-align: right;
    }

    .dir-header-stat .val {
        color: #F5A623;
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
    }

    .dir-header-stat .lbl {
        color: rgba(255,255,255,0.35);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-top: 4px;
    }

    .section-block {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        overflow: hidden;
    }

    .section-head {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-head h6 {
        color: #fff;
        font-size: 0.88rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-head h6 i { color: #F5A623; }

    .emp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    .emp-table thead th {
        padding: 10px 16px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.7px;
        text-transform: uppercase;
        color: rgba(245,166,35,0.8);
        background: rgba(245,166,35,0.06);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .emp-table tbody td {
        padding: 12px 16px;
        color: rgba(255,255,255,0.65);
        border-bottom: 1px solid rgba(255,255,255,0.03);
        vertical-align: middle;
    }

    .emp-table tbody tr:last-child td { border-bottom: none; }
    .emp-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .emp-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .emp-av {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(245,166,35,0.12);
        border: 1px solid rgba(245,166,35,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #F5A623;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .emp-av.femme {
        background: rgba(74,103,65,0.15);
        border-color: rgba(74,103,65,0.25);
        color: #90c97f;
    }

    .dispo-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .dispo-dot.on  { background: #90c97f; }
    .dispo-dot.off { background: #ff6b7a; }

    .empty-box {
        padding: 30px 20px;
        text-align: center;
        color: rgba(255,255,255,0.25);
        font-size: 0.83rem;
    }

    .empty-box i {
        font-size: 1.8rem;
        display: block;
        margin-bottom: 8px;
        opacity: 0.3;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-building me-2" style="color:#F5A623;"></i><?= esc($direction['Nom_Dir']) ?></h1>
        <p>
            <a href="<?= base_url('direction') ?>" style="color:rgba(255,255,255,0.4);text-decoration:none;">Directions</a>
            / Détail
        </p>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="<?= base_url('direction/edit/' . $direction['id_Dir']) ?>" class="btn-orange">
            <i class="fas fa-pen me-1"></i> Modifier
        </a>
        <a href="<?= base_url('direction') ?>" class="btn-outline-orange">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<!-- Carte direction -->
<div class="dir-header-card">
    <div class="dir-header-icon"><i class="fas fa-building"></i></div>
    <div class="dir-header-info">
        <h2><?= esc($direction['Nom_Dir']) ?></h2>
        <p>Direction #<?= $direction['id_Dir'] ?> &mdash; ANSTAT</p>
    </div>
    <div class="dir-header-stat">
        <div class="val"><?= count($employes) ?></div>
        <div class="lbl">Employé(s)</div>
    </div>
</div>

<!-- Liste des employés -->
<div class="section-block">
    <div class="section-head">
        <h6><i class="fas fa-users"></i> Employés de cette direction</h6>
        <a href="<?= base_url('employe/create') ?>" class="btn-orange" style="padding:5px 12px;font-size:0.75rem;">
            <i class="fas fa-user-plus me-1"></i> Ajouter un employé
        </a>
    </div>

    <?php if (!empty($employes)): ?>
    <table class="emp-table">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Email</th>
                <th>Grade</th>
                <th>Profil</th>
                <th>Disponibilité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employes as $emp): ?>
            <tr>
                <td>
                    <div class="emp-cell">
                        <div class="emp-av <?= $emp['Sexe_Emp'] == 0 ? 'femme' : '' ?>">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div style="color:#fff;font-weight:500;">
                                <?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>
                            </div>
                            <div style="font-size:0.72rem;color:rgba(255,255,255,0.3);">
                                <?= $emp['Sexe_Emp'] == 1 ? 'M.' : 'Mme' ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td><?= esc($emp['Email_Emp']) ?></td>
                <td>
                    <span class="badge-gray"><?= esc($emp['Libelle_Grd'] ?? '—') ?></span>
                </td>
                <td>
                    <span class="badge-orange"><?= esc($emp['Libelle_Pfl'] ?? '—') ?></span>
                </td>
                <td>
                    <span class="dispo-dot <?= $emp['Disponibilite_Emp'] ? 'on' : 'off' ?>"></span>
                    <?= $emp['Disponibilite_Emp'] ? 'Disponible' : 'Indisponible' ?>
                </td>
                <td>
                    <a href="<?= base_url('employe/show/' . $emp['id_Emp']) ?>"
                       style="color:#F5A623;font-size:0.8rem;text-decoration:none;">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-box">
        <i class="fas fa-users"></i>
        Aucun employé dans cette direction.
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>