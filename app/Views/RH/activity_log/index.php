<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<style>
    .stat-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: border-color 0.2s;
    }
    .stat-card:hover { border-color: rgba(245,166,35,0.2); }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 6px;
    }
    .stat-label { color: rgba(255,255,255,0.4); font-size: 0.78rem; }

    .filter-bar {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .log-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        overflow: hidden;
    }
    .log-table th {
        background: rgba(245,166,35,0.06);
        color: rgba(255,255,255,0.5);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid rgba(255,255,255,0.07) !important;
        padding: 12px 16px;
    }
    .log-table td {
        border-bottom: 1px solid rgba(255,255,255,0.04) !important;
        padding: 11px 16px;
        vertical-align: middle;
        color: rgba(255,255,255,0.75);
        font-size: 0.85rem;
    }
    .log-table tbody tr:hover td { background: rgba(255,255,255,0.02); }
    .log-table tbody tr:last-child td { border-bottom: none !important; }

    .action-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }
    .module-tag { font-size: 0.78rem; font-weight: 500; }

    .log-footer {
        border-top: 1px solid rgba(255,255,255,0.06);
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .page-btn {
        width: 32px; height: 32px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
        background: transparent;
        color: rgba(255,255,255,0.6);
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .page-btn:hover:not(:disabled) { border-color: #F5A623; color: #F5A623; }
    .page-btn.active { background: #F5A623; border-color: #F5A623; color: #000; font-weight: 700; }
    .page-btn:disabled { opacity: 0.3; cursor: not-allowed; }

    .reset-btn {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.5);
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .reset-btn:hover { border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.8); }

    .empty-log { padding: 50px; text-align: center; color: rgba(255,255,255,0.25); }
    .empty-log i { font-size: 2.5rem; display: block; margin-bottom: 10px; opacity: 0.3; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1><i class="bi bi-journal-text me-2" style="color:#F5A623;"></i>Logs d'activité</h1>
        <p>Historique complet des actions effectuées dans le système</p>
    </div>
    <form action="<?= base_url('activity-log/clear') ?>" method="post"
          onsubmit="return confirm('Effacer tous les logs ? Cette action est irréversible.')">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-trash me-1"></i>Vider les logs
        </button>
    </form>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert-dark-success mb-3 p-3">
    <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<!-- STATS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value" style="color:#F5A623;"><?= $totalLogs ?></div>
            <div class="stat-label">Total logs</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value" style="color:#4A6741;"><?= $logsAujourdhui ?></div>
            <div class="stat-label">Aujourd'hui</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value" style="color:#3A7BD5;"><?= $actionsCreate ?></div>
            <div class="stat-label">Créations</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value" style="color:#dc3545;"><?= $actionsDelete ?></div>
            <div class="stat-label">Suppressions</div>
        </div>
    </div>
</div>

<!-- FILTRES -->
<div class="filter-bar">
    <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
        <div style="flex:0 0 auto; width:24%;">
            <label class="form-label-dark">Recherche</label>
            <input type="text" id="f_q" class="form-control form-control-dark"
                   placeholder="Description, nom, IP...">
        </div>
        <div style="flex:0 0 auto; width:14%;">
            <label class="form-label-dark">Module</label>
            <select id="f_module" class="form-select form-select-dark">
                <option value="">Tous</option>
                <?php foreach ($modules as $m): ?>
                    <?php if ($m === 'Auth') continue; ?>
                    <option value="<?= esc($m) ?>"><?= esc($m) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="flex:0 0 auto; width:16%;">
            <label class="form-label-dark">Action</label>
            <select id="f_action" class="form-select form-select-dark">
                <option value="">Toutes</option>
                <option value="CREATE">Création</option>
                <option value="UPDATE">Modification</option>
                <option value="DELETE">Suppression</option>
                <option value="VALIDATE">Validation</option>
                <option value="REJECT">Refus</option>
                <option value="APPROVE">Approbation</option>
                <option value="REJECT_RH">Rejet RH</option>
                <option value="ADD_PARTICIPANT">Ajout participant</option>
                <option value="REMOVE_PARTICIPANT">Retrait participant</option>
                <option value="CONFIRM_PARTICIPATION">Participation confirmée</option>
                <option value="REFUSE_PARTICIPATION">Participation refusée</option>
            </select>
        </div>
        <div style="flex:0 0 auto; width:17%;">
            <label class="form-label-dark">Employé</label>
            <select id="f_emp" class="form-select form-select-dark">
                <option value="">Tous</option>
                <?php foreach ($employes as $emp): ?>
                    <option value="<?= $emp['id_Emp'] ?>">
                        <?= esc($emp['Nom_Emp'] . ' ' . $emp['Prenom_Emp']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="flex:0 0 auto; width:12%;">
            <label class="form-label-dark">Du</label>
            <input type="date" id="f_du" class="form-control form-control-dark">
        </div>
        <div style="flex:0 0 auto; width:12%;">
            <label class="form-label-dark">Au</label>
            <input type="date" id="f_au" class="form-control form-control-dark">
        </div>
        <div style="flex:0 0 auto; width:10%; display:flex; align-items:flex-end;">
            <button id="btnReset" class="reset-btn w-100" style="display:none;
                background:rgba(220,53,69,0.15);
                border-color:rgba(220,53,69,0.4);
                color:#ff6b7a;">
                <i class="bi bi-x-lg me-1"></i>Réinitialiser
            </button>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="log-card">
    <div style="padding:14px 20px; border-bottom:1px solid rgba(255,255,255,0.06);
                display:flex; justify-content:space-between; align-items:center;">
        <span style="color:#F5A623; font-weight:600; font-size:0.88rem;">
            <i class="bi bi-list-ul me-2"></i>
            <span id="totalCount">—</span> entrée(s)
        </span>
        <span id="pageInfo" style="color:rgba(255,255,255,0.35); font-size:0.8rem;"></span>
    </div>

    <div class="table-responsive">
        <table class="log-table w-100">
            <thead>
                <tr>
                    <th style="width:155px;">Date / Heure</th>
                    <th style="width:110px;">Module</th>
                    <th style="width:150px;">Action</th>
                    <th>Description</th>
                    <th style="width:160px;">Employé</th>
                    <th style="width:105px;">IP</th>
                </tr>
            </thead>
            <tbody id="logsBody">
                <tr><td colspan="6" class="empty-log">
                    <i class="bi bi-hourglass-split"></i>Chargement...
                </td></tr>
            </tbody>
        </table>
    </div>

    <div class="log-footer">
        <button id="btnPrev" class="page-btn" disabled>
            <i class="bi bi-chevron-left"></i>
        </button>
        <div id="paginationPages" style="display:flex; gap:5px; flex-wrap:wrap; justify-content:center;"></div>
        <button id="btnNext" class="page-btn" disabled>
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
const FETCH_URL = '<?= base_url('activity-log/fetch') ?>';
let currentPage = 1;
let totalPages  = 1;
let searchTimer = null;
let abortCtrl   = null;

// Labels français pour les actions
const actionLabels = {
    'CREATE'               : 'Création',
    'UPDATE'               : 'Modification',
    'DELETE'               : 'Suppression',
    'LOGIN'                : 'Connexion',
    'LOGOUT'               : 'Déconnexion',
    'APPROVE'              : 'Approbation',
    'REJECT'               : 'Refus',
    'VALIDATE'             : 'Validation',
    'REJECT_RH'            : 'Rejet RH',
    'APPROVE_CHEF'         : 'Approbation Chef',
    'ADD_PARTICIPANT'      : 'Ajout participant',
    'REMOVE_PARTICIPANT'   : 'Retrait participant',
    'CONFIRM_PARTICIPATION': 'Participation confirmée',
    'REFUSE_PARTICIPATION' : 'Participation refusée',
    'VALIDATE_RH'          : 'Validation RH',
    'APPROVE_DIR'          : 'Approbation Direction',
};

const actionStyles = {
    'CREATE'               : { bg:'rgba(74,103,65,0.15)',   color:'#90c97f', border:'rgba(74,103,65,0.3)' },
    'UPDATE'               : { bg:'rgba(58,123,213,0.15)',  color:'#6ba3f5', border:'rgba(58,123,213,0.3)' },
    'DELETE'               : { bg:'rgba(220,53,69,0.15)',   color:'#ff6b7a', border:'rgba(220,53,69,0.3)' },
    'LOGIN'                : { bg:'rgba(245,166,35,0.12)',  color:'#F5A623', border:'rgba(245,166,35,0.3)' },
    'LOGOUT'               : { bg:'rgba(255,255,255,0.06)', color:'#888',    border:'rgba(255,255,255,0.1)' },
    'APPROVE'              : { bg:'rgba(74,103,65,0.15)',   color:'#90c97f', border:'rgba(74,103,65,0.3)' },
    'REJECT'               : { bg:'rgba(220,53,69,0.15)',   color:'#ff6b7a', border:'rgba(220,53,69,0.3)' },
    'VALIDATE'             : { bg:'rgba(74,103,65,0.15)',   color:'#90c97f', border:'rgba(74,103,65,0.3)' },
    'REJECT_RH'            : { bg:'rgba(220,53,69,0.15)',   color:'#ff6b7a', border:'rgba(220,53,69,0.3)' },
    'APPROVE_CHEF'         : { bg:'rgba(74,103,65,0.15)',   color:'#90c97f', border:'rgba(74,103,65,0.3)' },
    'ADD_PARTICIPANT'      : { bg:'rgba(58,123,213,0.15)',  color:'#6ba3f5', border:'rgba(58,123,213,0.3)' },
    'REMOVE_PARTICIPANT'   : { bg:'rgba(220,53,69,0.15)',   color:'#ff6b7a', border:'rgba(220,53,69,0.3)' },
    'CONFIRM_PARTICIPATION': { bg:'rgba(74,103,65,0.15)',   color:'#90c97f', border:'rgba(74,103,65,0.3)' },
    'REFUSE_PARTICIPATION' : { bg:'rgba(220,53,69,0.15)',   color:'#ff6b7a', border:'rgba(220,53,69,0.3)' },
};

const moduleColors = {
    'Employe'  : '#6ba3f5',
    'Direction': '#c39bd3',
    'Conge'    : '#90c97f',
    'Absence'  : '#f0a070',
    'Formation': '#4ecdc4',
};

function actionBadge(action) {
    const s = actionStyles[action] || { bg:'rgba(255,255,255,0.06)', color:'#aaa', border:'rgba(255,255,255,0.1)' };
    const label = actionLabels[action] || action;
    return `<span class="action-badge" style="background:${s.bg}; color:${s.color}; border:1px solid ${s.border};">${label}</span>`;
}

function moduleTag(module) {
    const c = moduleColors[module] || '#aaa';
    return `<span class="module-tag" style="color:${c};">
                <i class="bi bi-tag me-1" style="font-size:0.7rem;"></i>${module}
            </span>`;
}

function formatDate(str) {
    if (!str) return '—';
    const d = new Date(str.replace(' ', 'T'));
    return `<span style="color:rgba(255,255,255,0.5); font-size:0.78rem;">
                ${d.toLocaleDateString('fr-FR')}<br>
                <span style="color:#F5A623;">${d.toLocaleTimeString('fr-FR',{hour:'2-digit',minute:'2-digit',second:'2-digit'})}</span>
            </span>`;
}

function getFilters() {
    return {
        q      : document.getElementById('f_q').value.trim(),
        module : document.getElementById('f_module').value,
        action : document.getElementById('f_action').value,
        id_Emp : document.getElementById('f_emp').value,
        date_du: document.getElementById('f_du').value,
        date_au: document.getElementById('f_au').value,
        page   : currentPage,
    };
}

function hasActiveFilter(f) {
    return f.q || f.module || f.action || f.id_Emp || f.date_du || f.date_au;
}

function loadLogs(silent = false) {
    const f = getFilters();
    document.getElementById('btnReset').style.display = hasActiveFilter(f) ? 'inline-flex' : 'none';

    const params = new URLSearchParams();
    Object.entries(f).forEach(([k, v]) => { if (v) params.set(k, v); });

    // Annuler la requête précédente si encore en cours
    if (abortCtrl) abortCtrl.abort();
    abortCtrl = new AbortController();

    // Si chargement initial (pas silent) on met un placeholder léger
    if (!silent) {
        document.getElementById('logsBody').style.opacity = '0.4';
    }

    fetch(FETCH_URL + '?' + params.toString(), { signal: abortCtrl.signal })
        .then(r => r.json())
        .then(data => {
            totalPages = data.totalPages || 1;
            document.getElementById('totalCount').textContent = data.total;
            document.getElementById('pageInfo').textContent  =
                data.total > 0 ? `Page ${data.page} / ${totalPages}` : '';

            const body = document.getElementById('logsBody');
            body.style.opacity = '1';

            if (!data.logs || data.logs.length === 0) {
                body.innerHTML = `<tr><td colspan="6" class="empty-log">
                    <i class="bi bi-journal-x"></i>Aucun log trouvé.
                </td></tr>`;
                renderPagination();
                return;
            }

            body.innerHTML = data.logs.map(log => {
                const nom = log.Nom_Emp
                    ? `<i class="bi bi-person me-1" style="color:#F5A623; font-size:0.75rem;"></i>${log.Nom_Emp} ${log.Prenom_Emp}`
                    : `<span style="color:rgba(255,255,255,0.25);">Système</span>`;
                return `<tr>
                    <td>${formatDate(log.DateHeure_Log)}</td>
                    <td>${moduleTag(log.Module_Log)}</td>
                    <td>${actionBadge(log.Action_Log)}</td>
                    <td style="color:rgba(255,255,255,0.6); max-width:280px;">${log.Description_Log || '—'}</td>
                    <td style="font-size:0.82rem;">${nom}</td>
                    <td style="color:rgba(255,255,255,0.3); font-family:monospace; font-size:0.78rem;">${log.IpAdresse_Log || '—'}</td>
                </tr>`;
            }).join('');

            renderPagination();
        })
        .catch(err => {
            if (err.name === 'AbortError') return; // requête annulée, normal
            document.getElementById('logsBody').style.opacity = '1';
            document.getElementById('logsBody').innerHTML = `<tr><td colspan="6" class="empty-log" style="color:#ff6b7a;">
                <i class="bi bi-exclamation-circle"></i>Erreur de chargement.
            </td></tr>`;
        });
}

function renderPagination() {
    document.getElementById('btnPrev').disabled = currentPage <= 1;
    document.getElementById('btnNext').disabled = currentPage >= totalPages;

    let start = Math.max(1, currentPage - 3);
    let end   = Math.min(totalPages, currentPage + 3);
    let html  = '';

    if (start > 1) html += `<button class="page-btn" onclick="goPage(1)">1</button>`;
    if (start > 2) html += `<span style="color:rgba(255,255,255,0.3); align-self:center;">…</span>`;
    for (let i = start; i <= end; i++) {
        html += `<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
    }
    if (end < totalPages - 1) html += `<span style="color:rgba(255,255,255,0.3); align-self:center;">…</span>`;
    if (end < totalPages)     html += `<button class="page-btn" onclick="goPage(${totalPages})">${totalPages}</button>`;

    document.getElementById('paginationPages').innerHTML = html;
}

function goPage(p) { currentPage = p; loadLogs(true); }

// Recherche texte — délai 400ms, le tableau se met à jour en douceur
document.getElementById('f_q').addEventListener('input', () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => { currentPage = 1; loadLogs(true); }, 400);
});

// Selects & dates — immédiat, juste opacité légère
['f_module', 'f_action', 'f_emp', 'f_du', 'f_au'].forEach(id => {
    document.getElementById(id).addEventListener('change', () => {
        currentPage = 1;
        loadLogs(true);
    });
});

document.getElementById('btnPrev').addEventListener('click', () => {
    if (currentPage > 1) { currentPage--; loadLogs(true); }
});
document.getElementById('btnNext').addEventListener('click', () => {
    if (currentPage < totalPages) { currentPage++; loadLogs(true); }
});
document.getElementById('btnReset').addEventListener('click', () => {
    document.getElementById('f_q').value      = '';
    document.getElementById('f_module').value = '';
    document.getElementById('f_action').value = '';
    document.getElementById('f_emp').value    = '';
    document.getElementById('f_du').value     = '';
    document.getElementById('f_au').value     = '';
    currentPage = 1;
    loadLogs(true);
});

// Chargement initial
loadLogs();
</script>
<?= $this->endSection() ?>