<?php

namespace App\Controllers;

/**
 * SInscrireController
 *
 * La logique d'inscription aux formations est désormais
 * entièrement gérée dans FormationController :
 *   - sInscrire()          → inscription libre (Employé)
 *   - inviter()            → invitation RH → Employé
 *   - accepterInvitation() → Employé accepte
 *   - refuserInvitation()  → Employé refuse
 *   - seDesinscrire()      → Employé se désinscrit
 *   - confirmerCompetences() → Chef confirme après formation
 */
class SInscrireController extends BaseController
{
    public function index()
    {
        return redirect()->to('formation');
    }
}