<?php

namespace Controller;

use Dao\CompetenceDao;
use Dao\UtilisateurDao;

class UtilisateurController extends BaseController
{

    public function profil()
    {
        $utilisateur = unserialize($_SESSION["utilisateur"]);
        $idUtilisateurConnecte = $utilisateur->getId();

        $dao = new CompetenceDao();
        $listeCompetence =
            $dao->findByIdUtilisateur($idUtilisateurConnecte);

        $donnees = compact("listeCompetence", "utilisateur");

        $this->afficherVue("profil", $donnees);
    }

    public function connexion()
    {
        $pseudo = "";

        //si l'utilisateur a validé le formulaire
        if (isset($_POST['pseudo'])) {

            $pseudo = $_POST['pseudo'];
            $dao = new UtilisateurDao();
            $utilisateur = $dao->findByPseudo($_POST['pseudo']);

            //si le pseudo existe et que le mot de passe correspond
            if ($utilisateur && password_verify($_POST['motDePasse'], $utilisateur->getMotDePasse())) {
                $_SESSION["utilisateur"] = serialize($utilisateur);
                $this->afficherMessage("Vous êtes connecté");
                $this->redirection();
            } else {
                $this->afficherMessage("mauvais pseudo / mot de passe", "danger");
            }
        }

        $donnees = compact("pseudo");
        $this->afficherVue("connexion", $donnees);
    }

    public function deconnexion()
    {
        session_destroy();
        session_start();
        $this->afficherMessage("Vous êtes deconnecté");
        $this->redirection();
    }

    public function inscription()
    {
        $pseudo = "";
        $entreprise = false;

        //si l'utilisateur a valider le formulaire
        if (isset($_POST["pseudo"])) {

            $pseudo = $_POST["pseudo"];
            $entreprise = isset($_POST['entreprise']);

            if ($_POST["motDePasse"] == $_POST["confirmeMotDePasse"]) {

                $dao = new UtilisateurDao();

                //si l'utilisateur a coché la case "entreprise"
                /*if (isset($_POST['entreprise'])) {
                    $entreprise = 1;
                } else {
                    $entreprise = 0;
                }*/

                //$entreprise = isset($_POST['entreprise']) ? 1 : 0;

                $dao->ajoutUtilisateur(
                    $_POST['pseudo'],
                    $_POST['motDePasse'],
                    isset($_POST['entreprise']) ? 1 : 0
                );

                $this->afficherMessage("Vous êtes bien inscrit, veuillez vous connecter", "success");
                $this->redirection("utilisateur/connexion");
            } else {

                $this->afficherMessage("Les mots de passes sont différents", "danger");
            }
        }

        $donnees = compact('pseudo', 'entreprise');

        $this->afficherVue("inscription", $donnees);
    }

    public function supprimerCompetence($parametres)
    {
        $idCompetence = $parametres[0];

        $utilisateur = unserialize($_SESSION['utilisateur']);
        $idUtilisateur = $utilisateur->getId();

        $dao = new UtilisateurDao();
        $dao->supprimerCompetenceUtilisateur($idCompetence, $idUtilisateur);

        $this->afficherMessage("La competence a bien été supprimée", "success");
        $this->redirection("utilisateur/profil");
    }
}
