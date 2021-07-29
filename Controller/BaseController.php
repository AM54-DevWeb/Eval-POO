<?php

namespace Controller;

class BaseController
{

    //note : on utilise les methode compact et extract pour transférer plusieurs variables
    //à la vue : les variable sont ajoutée dans un tableau "$donnees" dans le controlleur
    //et sont de nouveau affectée à des variables dans cette méthode
    public function afficherVue($fichier = "index", $donnees = [])
    {
        //extract lit les index du tableau et créer une variable du même nom pour chacun
        //et y affect la valeur associée.
        //ex : si le tableau est le suivant ["listeA" => ["a","b","c"] , "autreIndex" => 42]
        //il créera une variable $listeA contenant ["a","b","c"] 
        //et une autre variable  $autreIndex contenant 42
        extract($donnees);

        if (isset($_SESSION['message'])) {

            $typeMessage = isset($_SESSION['type-message']) ? $_SESSION['type-message'] : "info";

            include("View/message.php");

            unset($_SESSION['message']);
        }

        //si la classe s'appelle Controller\AccueilController
        //on enlève les 11 caractères de "Controller\" et les 10
        //caractères de fin : "Controller"
        //On obtient la chaine "Accueil" dans $dossier
        $dossier =  substr(get_class($this), 11, -10);

        include("./View/" . $dossier . "/" . $fichier . ".php");
    }

    public function afficherMessage($message, $typeMessage = "info")
    {
        $_SESSION['message'] = $message;
        $_SESSION['type-message'] = $typeMessage; //warning, danger, info, success
    }

    public function redirection($chemin = "")
    {
        header("Location: /cci_dwwm_2021_118_annonce/" . $chemin);
        die();
    }
}
