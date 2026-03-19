<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ObtenirSeeder extends Seeder
{
    public function run()
    {
        // ══════════════════════════════════════════════════════
        // Compétences obtenues via formations terminées
        //
        // Formation 1 (id=1) : Analyse Statistique Avancée → terminée
        //   Compétence liée : Analyse Statistique (id_Cmp=1)
        //
        // Formation 2 (id=2) : Gestion de Projet → terminée
        //   Compétence liée : Gestion de Projet (id_Cmp=2)
        //
        // Formation 3 (id=3) : Base de Données → planifiée
        //   Pas de compétences attribuées (pas encore terminée)
        //
        // Attributions manuelles (id_Frm = null)
        //   Compétences attribuées directement par le Chef
        // ══════════════════════════════════════════════════════

        $data = [
            // ── Via Formation 1 : Analyse Statistique ────────
            [
                'id_Emp'     => 1,  // KOUASSI Jean (RH)
                'id_Cmp'     => 1,  // Analyse Statistique
                'id_Frm'     => 1,  // Formation Analyse Statistique Avancée
                'Niveau_Obt' => 'avance',
                'Dte_Obt'    => '2026-02-05',
            ],
            [
                'id_Emp'     => 3,  // DIALLO Moussa
                'id_Cmp'     => 1,  // Analyse Statistique
                'id_Frm'     => 1,
                'Niveau_Obt' => 'intermediaire',
                'Dte_Obt'    => '2026-02-05',
            ],
            [
                'id_Emp'     => 4,  // TRAORE Fatou
                'id_Cmp'     => 1,  // Analyse Statistique
                'id_Frm'     => 1,
                'Niveau_Obt' => 'debutant',
                'Dte_Obt'    => '2026-02-05',
            ],

            // ── Via Formation 2 : Gestion de Projet ──────────
            [
                'id_Emp'     => 2,  // KONE Aminata (Chef)
                'id_Cmp'     => 2,  // Gestion de Projet
                'id_Frm'     => 2,
                'Niveau_Obt' => 'avance',
                'Dte_Obt'    => '2026-03-12',
            ],
            [
                'id_Emp'     => 5,  // YAO Norton
                'id_Cmp'     => 2,  // Gestion de Projet
                'id_Frm'     => 2,
                'Niveau_Obt' => 'intermediaire',
                'Dte_Obt'    => '2026-03-12',
            ],

            // ── Attributions manuelles (id_Frm = null) ───────
            [
                'id_Emp'     => 3,  // DIALLO Moussa
                'id_Cmp'     => 3,  // Programmation PHP
                'id_Frm'     => null,
                'Niveau_Obt' => 'intermediaire',
                'Dte_Obt'    => '2026-01-15',
            ],
            [
                'id_Emp'     => 5,  // YAO Norton
                'id_Cmp'     => 5,  // Base de Données
                'id_Frm'     => null,
                'Niveau_Obt' => 'debutant',
                'Dte_Obt'    => '2026-02-20',
            ],
        ];

        $this->db->table('obtenir')->insertBatch($data);
    }
}