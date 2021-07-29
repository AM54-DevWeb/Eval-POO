<form method="POST">

    <div class="form-group">
        <label for="inputDefault">Pseudo</label>
        <input style="max-width:300px" value="<?= $utilisateur->getPseudo() ?>" name="pseudo" type="text" class="form-control" placeholder="Pseudo">
    </div>

    <ul>
        <?php
        foreach ($listeCompetence as $competence) {
        ?>
            <li>
                <span><?= $competence->getDesignation() ?></span>
                <a href="/cci_dwwm_2021_118_annonce/utilisateur/supprimerCompetence/<?= $competence->getId() ?>" class=" btn btn-danger">
                    Supprimer la compétence
                </a>
            </li>
        <?php
        }
        ?>
    </ul>


    <input style="margin-top:20px" type="submit" class="btn btn-success" value="Modifier le profil">

</form>