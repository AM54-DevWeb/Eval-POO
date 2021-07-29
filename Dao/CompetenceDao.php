<?php

namespace Dao;

use Connexion;

class CompetenceDao extends BaseDao
{

    /**
     * Retourne toutes les compétences d'un utilisateur via son id
     * (retourne les compétences dont l'id est associé à l'id de 
     * l'utilisteur dans la table "competence_utilisateur")
     */
    public function findByIdUtilisateur($idUtilisateur)
    {
        $connexion = new Connexion();
        $requete = $connexion->prepare(
            "SELECT c.id, c.designation 
             FROM competence_utilisateur cu
             JOIN competence c ON cu.id_competence = c.id
             WHERE cu.id_utilisateur = :idUtilisateur"
        );

        $requete->execute([":idUtilisateur" => $idUtilisateur]);

        $listeCompetence = [];

        foreach ($requete->fetchAll() as $ligneCompetence) {
            $listeCompetence[] =
                $this->transformeTableauEnObjet($ligneCompetence);
        }

        return $listeCompetence;
    }
}
