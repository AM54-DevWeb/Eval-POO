<form method="POST">

    <div class="form-group">
        <label>Titre</label>
        <input value="<?= $titre ?>" style="max-width:300px" name="titre" type="text" class="form-control" placeholder="Titre de l'offre (ex : 'Développeur')">
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" placeholder="Descrition de l'offre (ex : 'Une offre trop top !')"><?= $description ?></textarea>
    </div>

    <input style="margin-top:20px" type="submit" class="btn btn-success" value="<?php echo $modification ? "Modifier l'offre" : "Ajouter l'offre" ?>">

</form>