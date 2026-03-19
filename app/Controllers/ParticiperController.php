<?php

namespace App\Controllers;

/**
 * ParticiperController
 *
 * La gestion des participations aux événements est désormais
 * gérée directement dans EvenementController.
 */
class ParticiperController extends BaseController
{
    public function index()
    {
        return redirect()->to('evenement');
    }
}