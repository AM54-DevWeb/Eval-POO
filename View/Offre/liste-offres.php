<h1>listes des offres</h1>

<?php

foreach ($listeOffres as $offre) {
?>

    <div class="card border-primary mb-3" style="max-width: 20rem;">
        <div class="card-header">Publier par : <?php echo $offre->getUtilisateur()->getPseudo(); ?></div>
        <div class="card-body">
            <h4 class="card-title"><?php echo $offre->getTitre(); ?></h4>
            <p class="card-text"><?php echo substr($offre->getDescription(), 0, 100); ?>...</p>
            <?php
            if (isset($_SESSION["utilisateur"])) {
                $utilisateur = unserialize($_SESSION["utilisateur"]);
                if ($utilisateur->getEntreprise()) {
            ?>
                    <a href="/cci_dwwm_2021_118_annonce/offre/modifier/<?php echo $offre->getId(); ?>" class="btn btn-info">Modifier l'offre</a>

                    <a href="/cci_dwwm_2021_118_annonce/offre/supprimer/<?php echo $offre->getId(); ?>" class="btn btn-danger">Supprimer l'offre</a>
            <?php
                }
            }
            ?>
            <a href="/cci_dwwm_2021_118_annonce/offre/detail/<?php echo $offre->getId(); ?>" class="btn btn-primary">Voir les details de l'offre</a>
        </div>
    </div>

<?php
}
?>