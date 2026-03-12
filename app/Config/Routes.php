<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================================================================
// PAGES PUBLIQUES
// ================================================================
$routes->get('/',                              'AuthController::login');
$routes->get('login',                          'AuthController::login');
$routes->post('login',                         'AuthController::authenticate');
$routes->get('logout',                         'AuthController::logout');
$routes->get('auth/forgot-password',           'AuthController::forgotPassword');
$routes->post('auth/forgot-password',          'AuthController::sendResetLink');
$routes->get('auth/reset-password/(:any)',     'AuthController::resetPassword/$1');
$routes->post('auth/reset-password',           'AuthController::updatePassword');

// ================================================================
// PAGES PROTÉGÉES
// ================================================================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');

    // ============================================================
    // DIRECTIONS — RH uniquement
    // ============================================================
    $routes->get('direction',                        'DirectionController::index');
    $routes->get('direction/create',                 'DirectionController::create');
    $routes->post('direction/store',                 'DirectionController::store');
    $routes->get('direction/show/(:num)',            'DirectionController::show/$1');
    $routes->get('direction/edit/(:num)',            'DirectionController::edit/$1');
    $routes->post('direction/update/(:num)',         'DirectionController::update/$1');
    $routes->post('direction/delete/(:num)',         'DirectionController::delete/$1');

    // ============================================================
    // EMPLOYES — RH (CRUD + import/export), Chef (lecture)
    // ============================================================
    $routes->get('employe',                          'EmployeController::index');
    $routes->get('employe/create',                   'EmployeController::create');
    $routes->post('employe/store',                   'EmployeController::store');
    $routes->get('employe/show/(:num)',              'EmployeController::show/$1');
    $routes->get('employe/edit/(:num)',              'EmployeController::edit/$1');
    $routes->post('employe/update/(:num)',           'EmployeController::update/$1');
    $routes->post('employe/delete/(:num)',           'EmployeController::delete/$1');
    $routes->get('employe/export',                   'EmployeController::export');
    $routes->post('employe/import',                  'EmployeController::import');

    // ============================================================
    // CONGES
    // RH    → voir tout, valider (étape 2), rejeter, supprimer
    // Chef  → voir sa direction, approuver (étape 1), refuser
    // Employé → ses demandes, créer, modifier, annuler
    // ============================================================
    $routes->get('conge',                            'CongeController::index');
    $routes->get('conge/create',                     'CongeController::create');
    $routes->post('conge/store',                     'CongeController::store');
    $routes->get('conge/show/(:num)',                'CongeController::show/$1');
    $routes->get('conge/edit/(:num)',                'CongeController::edit/$1');
    $routes->post('conge/update/(:num)',             'CongeController::update/$1');
    $routes->post('conge/delete/(:num)',             'CongeController::delete/$1');
    $routes->post('conge/approuver/(:num)',          'CongeController::approuver/$1');
    $routes->post('conge/refuser/(:num)',            'CongeController::refuser/$1');
    $routes->post('conge/valider/(:num)',            'CongeController::valider/$1');
    $routes->post('conge/rejeter/(:num)',            'CongeController::rejeter/$1');

    // ============================================================
    // ABSENCES
    // RH      → voir tout, valider (étape 1), rejeter
    // Chef    → voir sa direction, approuver (étape 2), refuser
    // Employé → ses absences, créer, modifier, supprimer
    // PJ      → upload + validation RH
    // ============================================================
    $routes->get('absence',                          'AbsenceController::index');
    $routes->get('absence/create',                   'AbsenceController::create');
    $routes->post('absence/store',                   'AbsenceController::store');
    $routes->get('absence/show/(:num)',              'AbsenceController::show/$1');
    $routes->get('absence/edit/(:num)',              'AbsenceController::edit/$1');
    $routes->post('absence/update/(:num)',           'AbsenceController::update/$1');
    $routes->post('absence/delete/(:num)',           'AbsenceController::delete/$1');
    $routes->post('absence/valider-rh/(:num)',       'AbsenceController::validerRH/$1');
    $routes->post('absence/rejeter-rh/(:num)',       'AbsenceController::rejeterRH/$1');
    $routes->post('absence/approuver/(:num)',        'AbsenceController::approuver/$1');
    $routes->post('absence/refuser/(:num)',          'AbsenceController::refuser/$1');
    $routes->post('absence/ajouter-pj/(:num)',       'AbsenceController::ajouterPJ/$1');
    $routes->post('absence/valider-pj/(:num)',       'AbsenceController::validerPJ/$1');
    $routes->post('absence/rejeter-pj/(:num)',       'AbsenceController::rejeterPJ/$1');

    // ============================================================
    // FORMATIONS — Catalogue
    // RH      → CRUD complet
    // Chef    → voir formations
    // Employé → voir formations
    // ============================================================
    $routes->get('formation',                        'FormationController::index');
    $routes->get('formation/create',                 'FormationController::create');
    $routes->post('formation/store',                 'FormationController::store');
    $routes->get('formation/show/(:num)',            'FormationController::show/$1');
    $routes->get('formation/edit/(:num)',            'FormationController::edit/$1');
    $routes->post('formation/update/(:num)',         'FormationController::update/$1');
    $routes->post('formation/delete/(:num)',         'FormationController::delete/$1');

    // ============================================================
    // DEMANDES DE FORMATION
    // Employé → soumet → Chef approuve → RH valide → sélection participants
    // Chef    → soumet (saute étape Chef) → RH valide
    // ============================================================
    $routes->get('demande-formation',                        'DemandeFormationController::index');
    $routes->get('demande-formation/create',                 'DemandeFormationController::create');
    $routes->post('demande-formation/store',                 'DemandeFormationController::store');
    $routes->get('demande-formation/show/(:num)',            'DemandeFormationController::show/$1');
    $routes->get('demande-formation/edit/(:num)',            'DemandeFormationController::edit/$1');
    $routes->post('demande-formation/update/(:num)',         'DemandeFormationController::update/$1');
    $routes->post('demande-formation/delete/(:num)',         'DemandeFormationController::delete/$1');
    $routes->post('demande-formation/approuver/(:num)',      'DemandeFormationController::approuver/$1');
    $routes->post('demande-formation/rejeter/(:num)',        'DemandeFormationController::rejeter/$1');
    $routes->post('demande-formation/valider-rh/(:num)',     'DemandeFormationController::validerRH/$1');
    $routes->post('demande-formation/rejeter-rh/(:num)',     'DemandeFormationController::rejeterRH/$1');
    $routes->post('demande-formation/selectionner/(:num)',   'DemandeFormationController::selectionner/$1');
    $routes->post('demande-formation/accepter/(:num)',       'DemandeFormationController::accepter/$1');
    $routes->post('demande-formation/refuser/(:num)',        'DemandeFormationController::refuser/$1');

    // ============================================================
    // COMPETENCES
    // RH      → CRUD référentiel + attribuer/retirer aux employés
    // Chef    → voir compétences de sa direction
    // Employé → voir ses compétences
    // ============================================================
    $routes->get('competence',                          'CompetenceController::index');
    $routes->get('competence/create',                   'CompetenceController::create');
    $routes->post('competence/store',                   'CompetenceController::store');
    $routes->get('competence/show/(:num)',              'CompetenceController::show/$1');
    $routes->get('competence/edit/(:num)',              'CompetenceController::edit/$1');
    $routes->post('competence/update/(:num)',           'CompetenceController::update/$1');
    $routes->post('competence/delete/(:num)',           'CompetenceController::delete/$1');
    $routes->post('competence/attribuer/(:num)',        'CompetenceController::attribuer/$1');
    $routes->post('competence/modifier-niveau/(:num)', 'CompetenceController::modifierNiveau/$1');
    $routes->post('competence/retirer/(:num)',          'CompetenceController::retirer/$1');
    $routes->get('competence/employe/(:num)',           'CompetenceController::parEmploye/$1');

    // ============================================================
    // EVENEMENTS
    // RH      → CRUD complet + gérer participations
    // Chef    → voir événements + gérer participations de sa direction
    // Employé → voir + participer/se retirer
    // ============================================================
    $routes->get('evenement',                                    'EvenementController::index');
    $routes->get('evenement/create',                             'EvenementController::create');
    $routes->post('evenement/store',                             'EvenementController::store');
    $routes->get('evenement/show/(:num)',                        'EvenementController::show/$1');
    $routes->get('evenement/edit/(:num)',                        'EvenementController::edit/$1');
    $routes->post('evenement/update/(:num)',                     'EvenementController::update/$1');
    $routes->post('evenement/delete/(:num)',                     'EvenementController::delete/$1');
    $routes->post('evenement/ajouter-participants/(:num)',       'EvenementController::ajouterParticipants/$1');
    $routes->post('evenement/retirer-participant/(:num)',        'EvenementController::retirerParticipant/$1');
    $routes->post('evenement/notifier-participants/(:num)',      'EvenementController::notifierParticipants/$1');
    $routes->post('evenement/participer/(:num)',  'EvenementController::participer/$1');
    $routes->post('evenement/se-retirer/(:num)',  'EvenementController::seRetirer/$1');

    // ============================================================
    // NOTIFICATIONS — tous les profils
    // ============================================================
    $routes->get('notifications',                    'NotificationController::index');
    $routes->post('notifications/lire/(:num)',       'NotificationController::lire/$1');
    $routes->post('notifications/lire-toutes',       'NotificationController::lireToutes');
    $routes->get('notifications/count',              'NotificationController::count');
    $routes->post('notifications/delete/(:num)',     'NotificationController::delete/$1');     // AJOUT
    $routes->post('notifications/delete-toutes',     'NotificationController::deleteToutes');  // AJOUT

    // ============================================================
    // PROFIL PERSONNEL — tous les profils (navbar)
    // ============================================================
    $routes->get('profil',                          'ProfilUtilisateurController::index');      // MODIFIÉ
    $routes->get('profil/password',                 'ProfilUtilisateurController::password');   // MODIFIÉ
    $routes->post('profil/password/update',         'ProfilUtilisateurController::updatePassword'); // MODIFIÉ

    // ============================================================
    // ACTIVITY LOG — RH uniquement
    // ============================================================
    $routes->get('activity-log',        'ActivityLogController::index');
    $routes->get('activity-log/fetch',  'ActivityLogController::fetch');
    $routes->post('activity-log/clear', 'ActivityLogController::clear');

    // ============================================================
    // PARAMETRES — RH uniquement
    // ============================================================
    $routes->get('parametres', 'GradeController::index');

    // Grades
    $routes->get('parametres/grade',                  'GradeController::index');
    $routes->get('parametres/grade/create',           'GradeController::create');
    $routes->post('parametres/grade/store',           'GradeController::store');
    $routes->get('parametres/grade/show/(:num)',      'GradeController::show/$1');
    $routes->get('parametres/grade/edit/(:num)',      'GradeController::edit/$1');
    $routes->post('parametres/grade/update/(:num)',   'GradeController::update/$1');
    $routes->post('parametres/grade/delete/(:num)',   'GradeController::delete/$1');

    // Profils
    $routes->get('parametres/profil',                 'ProfilController::index');
    $routes->get('parametres/profil/create',          'ProfilController::create');
    $routes->post('parametres/profil/store',          'ProfilController::store');
    $routes->get('parametres/profil/show/(:num)',     'ProfilController::show/$1');
    $routes->get('parametres/profil/edit/(:num)',     'ProfilController::edit/$1');
    $routes->post('parametres/profil/update/(:num)',  'ProfilController::update/$1');
    $routes->post('parametres/profil/delete/(:num)',  'ProfilController::delete/$1');

    // Types congés
    $routes->get('parametres/type-conge',                  'TypeCongeController::index');
    $routes->get('parametres/type-conge/create',           'TypeCongeController::create');
    $routes->post('parametres/type-conge/store',           'TypeCongeController::store');
    $routes->get('parametres/type-conge/show/(:num)',      'TypeCongeController::show/$1');
    $routes->get('parametres/type-conge/edit/(:num)',      'TypeCongeController::edit/$1');
    $routes->post('parametres/type-conge/update/(:num)',   'TypeCongeController::update/$1');
    $routes->post('parametres/type-conge/delete/(:num)',   'TypeCongeController::delete/$1');

    // Types absences
    $routes->get('parametres/type-absence',                  'TypeAbsenceController::index');
    $routes->get('parametres/type-absence/create',           'TypeAbsenceController::create');
    $routes->post('parametres/type-absence/store',           'TypeAbsenceController::store');
    $routes->get('parametres/type-absence/show/(:num)',      'TypeAbsenceController::show/$1');
    $routes->get('parametres/type-absence/edit/(:num)',      'TypeAbsenceController::edit/$1');
    $routes->post('parametres/type-absence/update/(:num)',   'TypeAbsenceController::update/$1');
    $routes->post('parametres/type-absence/delete/(:num)',   'TypeAbsenceController::delete/$1');

    // Types événements
    $routes->get('parametres/type-evenement',                  'TypeEvenementController::index');
    $routes->get('parametres/type-evenement/create',           'TypeEvenementController::create');
    $routes->post('parametres/type-evenement/store',           'TypeEvenementController::store');
    $routes->get('parametres/type-evenement/show/(:num)',      'TypeEvenementController::show/$1');
    $routes->get('parametres/type-evenement/edit/(:num)',      'TypeEvenementController::edit/$1');
    $routes->post('parametres/type-evenement/update/(:num)',   'TypeEvenementController::update/$1');
    $routes->post('parametres/type-evenement/delete/(:num)',   'TypeEvenementController::delete/$1');

});