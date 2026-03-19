<?php

namespace App\Controllers;

/**
 * AttribuerController
 *
 * L'attribution des grades aux employés est désormais
 * gérée directement dans EmployeController par le RH.
 */
class AttribuerController extends BaseController
{
    public function index()
    {
        return redirect()->to('employe');
    }
}