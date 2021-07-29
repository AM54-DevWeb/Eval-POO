<?php

namespace Dao;

use Connexion;
use Model\Utilisateur;

class OffreDao extends BaseDao
{
    public function ajouterOffre($titre, $description)
    {

        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "INSERT INTO offre (titre, description)
             VALUES (?,?)"
        );

        $requete->execute(
            [
                $titre,
                $description
            ]
        );
    }

    public function modifierOffre($id, $titre, $description)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "UPDATE offre 
             SET titre = ?, description = ? 
             WHERE id = ?"
        );

        $requete->execute(
            [
                $titre,
                $description,
                $id
            ]
        );
    }

    public function recherche($mot)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "SELECT o.id, o.titre, o.description, o.id_utilisateur, u.pseudo
             FROM offre o
             JOIN utilisateur u ON o.id_utilisateur = u.id 
             WHERE titre LIKE :mot 
             OR description LIKE :mot
             OR pseudo LIKE :mot"
        );

        $requete->execute(
            [":mot" => "%" . $mot . "%"]
        );

        $listeOffre = [];

        foreach ($requete->fetchAll() as $ligneOffre) {
            $offre = $this->transformeTableauEnObjet($ligneOffre);

            $utilisateur = new Utilisateur();
            $utilisateur->setId($ligneOffre['id_utilisateur']);
            $utilisateur->setPseudo($ligneOffre['pseudo']);

            $offre->setUtilisateur($utilisateur);

            $listeOffre[] = $offre;
        }

        return $listeOffre;
    }

    public function findAllAvecUtilisateur()
    {
        $connexion = new Connexion();

        $resultat = $connexion->query(
            "SELECT o.id, o.titre, o.description, o.id_utilisateur, u.pseudo
             FROM offre o
             JOIN utilisateur u ON o.id_utilisateur = u.id"
        );

        $listeOffre = [];

        foreach ($resultat->fetchAll() as $ligneOffre) {
            $offre = $this->transformeTableauEnObjet($ligneOffre);

            $utilisateur = new Utilisateur();
            $utilisateur->setId($ligneOffre['id_utilisateur']);
            $utilisateur->setPseudo($ligneOffre['pseudo']);

            $offre->setUtilisateur($utilisateur);

            $listeOffre[] = $offre;
        }

        return $listeOffre;
    }
}
