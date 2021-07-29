<?php

namespace Controller;

use Controller\BaseController;
use Dao\OffreDao;

class OffreController extends BaseController
{

    public function afficherTout()
    {
        $dao = new OffreDao();

        if (isset($_POST["recherche"])) {
            $listeOffres = $dao->recherche($_POST["recherche"]);
        } else {

            $listeOffres = $dao->findAllAvecUtilisateur();
        }

        //note equivaut à faire :
        /*$donnees = [
            'listeOffres' => $listeOffres
        ];*/
        $donnees = compact('listeOffres');

        $this->afficherVue("liste-offres", $donnees);
    }

    //ex, si l'url est : localhost/.../offre/detail/42
    //alors parametre[0] contiendra "42" (l'id de l'offre à afficher)
    public function detail($parametres)
    {
        $id = $parametres[0];

        $dao = new OffreDao();

        $offre = $dao->findById($id);

        $donnees = compact('offre');

        $this->afficherVue("detail-offre", $donnees);
    }

    public function ajouter()
    {
        $modification = false;
        $titre = "";
        $description = "";

        if (isset($_POST["titre"])) {

            $dao = new OffreDao();

            $dao->ajouterOffre($_POST['titre'], $_POST['description']);

            $this->afficherMessage("Votre annonce a bien été ajoutée", "success");
            $this->redirection("offre/afficherTout");
        }

        $donnees = compact("modification", "titre", "description");
        $this->afficherVue("editer-offre", $donnees);
    }

    public function supprimer($parametres)
    {
        $id = $parametres[0];

        if (isset($_POST["confirmation"])) {

            $dao = new OffreDao();
            $dao->deleteById($id);
            $this->afficherMessage("L'offre a bien été supprimée");
            $this->redirection("offre/afficherTout");
        }

        $this->afficherVue("confirmation-suppression");
    }

    public function modifier($parametres)
    {
        $modification = true;
        $id = $parametres[0];
        $titre = "";
        $description = "";

        $dao = new OffreDao();

        if (isset($_POST["titre"])) {

            $dao->modifierOffre($id, $_POST['titre'], $_POST['description']);

            $this->afficherMessage("L'offre a bien été modifiée");
            $this->redirection("offre/afficherTout");
        } else {

            $offre = $dao->findById($id);
            $titre = $offre->getTitre();
            $description = $offre->getDescription();
        }

        $donnees = compact("modification", "titre", "description");
        $this->afficherVue("editer-offre", $donnees);
    }
}
