<?php

namespace App\Controllers;

/**
 * ObtenirController
 *
 * L'attribution des compétences est désormais gérée dans
 * FormationController::confirmerCompetences() — après la
 * fin d'une formation, le Chef confirme qui a obtenu la compétence.
 */
class ObtenirController extends BaseController
{
    public function index()
    {
        return redirect()->to('formation');
    }
}