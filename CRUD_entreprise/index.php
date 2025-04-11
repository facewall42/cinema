<?php
require_once('inc/init.inc.php');

$h1 = 'Insertion des employes';
$paragraphe = 'Ici vous pouvez ajouter des employes dans la BDD';
$alert = '';

if (!empty($_POST)) { //verification que le formulaire a ete soumis en methode post
    //debug($_POST);
    //debug($_FILES);
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $service = htmlspecialchars(trim($_POST['service']));
    $sexe = htmlspecialchars(trim($_POST['sexe']));
    $dateEmbauche = htmlspecialchars(trim($_POST['date_embauche']));
    $salaire = htmlspecialchars(trim($_POST['salaire']));
    if ($prenom && $nom && $sexe && $service && $dateEmbauche && $salaire > 0) { //pas la peine de mettre salaire>0 si on a des valeurs positives
        $result = $pdoEntreprise->prepare(
            "INSERT INTO employes (prenom, nom, service, sexe, date_embauche, salaire)
        VALUES (:prenom, :nom, :service, :sexe, :date_embauche, :salaire)"
        );

        //execution de la requete avec les donnees du formulaire :
        $result->execute(array(
            ":prenom" => $prenom,
            ":nom" => $nom,
            ":service" => $service,
            ":sexe" => $sexe,
            ":date_embauche" => $dateEmbauche,
            ":salaire" => $salaire,

        ));
        // debug($result);
        // exit;
        if ($result->rowcount() != 0) { //on compte le nombre de ligne que contient result voir le debug(result) juste avant
            //affiche le msg de confirmation
            $alert = '<div class="alert alert-success mt-3 text-center "><p>Employé ajouté avec succès !</p> <p>Consultez le <a href="employes.php"> tableau des employés (redirection dans 4 secondes)</a></p> </div>';
            header('refresh:4, URL=employes.php');
        } else {
            $alert = '<div class="alert alert-danger mt-3 text-center ">Erreur lors de l\'ajout de l\'employé</div>';
        }
    } else {
        //si un champ est manquant ou invalide  on affiche un message d'erreur
        $alert = '<div class="alert alert-danger mt-3 text-center ">Veuillez remplir tous les champs correctement.</div>';
    }
}

require_once('inc/header.inc.php');
?>
<!-- on a recuperé depuis Bootswatch le style et supprimé ce qui etait superflu -->
<form autocomplete="off" method="post" action="" class="w-50 m-auto">
    <?= $alert ?>
    <fieldset>
        <div class="mb-3">
            <label for="prenom" class="form-label mt-4 text-primary fw-bold">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Ex: Jean">
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label text-primary fw-bold">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Ex: DUPONT">
        </div>
    </fieldset>

    <fieldset>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexe" id="sexeH" value="m" checked>
            <label class="form-check-label" for="sexeH">Homme</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexe" id="sexeF" value="f">
            <label class="form-check-label" for="sexeF">Femme</label>
        </div>

    </fieldset>

    <div class="mb-3 mt-4">
        <label for="service" class="form-label text-primary fw-bold">Service</label>
        <input type="text" class="form-control" id="service" name="service" placeholder="Ex: RH, Informatique...">
    </div>

    <div class="mb-3">
        <label for="date_embauche" class="form-label text-primary fw-bold">Date d'embauche</label>
        <input type="date" class="form-control" id="date_embauche" name="date_embauche">
    </div>

    <div class="mb-3">
        <label for="salaire" class="form-label text-primary fw-bold">Salaire (€)</label>
        <input type="number" step="0.01" class="form-control" id="salaire" name="salaire" placeholder="Ex: 2500">
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary ">Enregistrer</button>
    </div>
</form>

<?php
require_once('inc/footer.inc.php');
?>