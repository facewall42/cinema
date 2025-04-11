<?php
require_once('inc/init.inc.php');
//initialisation des variables de la page
$alert = "";
$h1 = 'Modifier les employés';
$paragraphe = "Modifier les infos de l'employé de la BDD";

// 1 - tester si on a une valeur d'id dans l'url pour recuperer les données de l'employé
if ($_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // on initialise l'id récupérée du tableau des employes en methode GET ici et on verifie que l'id est un entier
    //**insertion du test post */
    // 2 - traitement du formulaire de modif de l'employé 
    if (!empty($_POST)) {
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $nom = htmlspecialchars(trim($_POST['nom']));
        $service = htmlspecialchars(trim($_POST['service']));
        $sexe = htmlspecialchars(trim($_POST['sexe']));
        // validation plus serieuse de la date :
        $dateEmbauche = $_POST['date_embauche'];
        // on formate la date dans une variable datetime 
        $dateTime = DateTime::createFromFormat('Y-m-d', $dateEmbauche);
        // on compare si les formats sont identiques, ce qui prouve que la date est valide
        if ($dateTime && $dateTime->format('Y-m-d') === $dateEmbauche) {
            $dateEmbauche = $dateTime->format('Y-m-d'); // Format valide
        } else {
            // Gérer l'erreur : date invalide
            $alert = '<div class="alert alert-danger mt-3 text-center ">format de date non valide !</div>';
        }
        $salaire = filter_var($_POST['salaire'], FILTER_VALIDATE_FLOAT); //filtre de validation d'une valeur Float

        // test existence des donnees
        if ($prenom && $nom && $sexe && $service && $dateEmbauche && $salaire > 0) {
            //
            $result = $pdoEntreprise->prepare(
                "UPDATE employes 
             SET prenom = :prenom, 
                 nom = :nom, 
                 service = :service, 
                 sexe = :sexe, 
                 date_embauche = :date_embauche, 
                 salaire = :salaire 
             WHERE id_employes = :id"
            );

            //execution de la requete avec les donnees du formulaire :
            $result->execute(array(
                ":prenom" => $prenom,
                ":nom" => $nom,
                ":service" => $service,
                ":sexe" => $sexe,
                ":date_embauche" => $dateEmbauche,
                ":salaire" => $salaire,
                ":id" => $id
            ));
            // debug($result);
            // exit;
            if ($result->rowcount() != 0) { //on compte le nombre de ligne que contient result voir le debug(result) juste avant
                //affiche le msg de confirmation
                $alert = '<div class="alert alert-success mt-3 text-center "><p>Employé modifié avec succès !</p> </div>';
                //redirection vers la page employé au bout de 4 secondes
                header('refresh:4, URL=employe.php?id=' . $id);
            } else {
                $alert = '<div class="alert alert-danger mt-3 text-center ">Erreur lors de la modification de l\'employé</div>';
            }
        } else {
            //si un champ est manquant ou invalide  on affiche un message d'erreur
            $alert = '<div class="alert alert-danger mt-3 text-center ">Veuillez remplir tous les champs correctement.</div>';
        }
    }

    //connexion a la base entreprise et table employes
    $result = $pdoEntreprise->prepare("SELECT * FROM employes WHERE id_employes = :id ");
    $result->execute(array(
        ":id" => $id
    ));
    $employe = $result->fetch();
    if ($employe == false) { //pas de correspondance d'id avec la base
        header("location : employes.php"); //redirection vers la page employes
    }
} else { // si on n'a pas de valeur d'id dans l'url
    header("location: employes.php");
}
//debug($employe);

require_once('inc/header.inc.php');
?>

<form autocomplete="off" method="post" action="#" class="w-50 m-auto">
    <?= $alert ?>
    <fieldset>
        <div class="mb-3">
            <label for="prenom" class="form-label mt-4 text-primary fw-bold">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Ex: Jean" value="<?= htmlspecialchars(ucfirst($employe['prenom'])) ?>">
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label text-primary fw-bold">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Ex: DUPONT" value="<?= htmlspecialchars(strtoupper($employe['nom'])) ?>">
        </div>
    </fieldset>

    <fieldset>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexe" id="sexeH" value="m" <?= htmlspecialchars($employe['sexe']) == 'm' ? 'checked' : '' ?>>
            <label class="form-check-label" for="sexeH">Homme</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexe" id="sexeF" value="f" <?= htmlspecialchars($employe['sexe']) == 'f' ? 'checked' : '' ?>>
            <label class="form-check-label" for="sexeF">Femme</label>
        </div>

    </fieldset>

    <div class="mb-3 mt-4">
        <label for="service" class="form-label text-primary fw-bold">Service</label>
        <input type="text" class="form-control" id="service" name="service" placeholder="Ex: RH, Informatique..." value="<?= htmlspecialchars(ucfirst($employe['service'])) ?>">
    </div>

    <div class=" mb-3">
        <label for="date_embauche" class="form-label text-primary fw-bold">Date d'embauche</label>
        <input type="date" class="form-control" id="date_embauche" name="date_embauche" value="<?= ($employe['date_embauche']) ?>">
        <!-- pas besoin de convertir la date au format français grace aux fonctions strtotime() et date('Y-m-d', strtotime($employe['date_embauche'])) ?> -->
    </div>

    <div class="mb-3">
        <label for="salaire" class="form-label text-primary fw-bold">Salaire (€)</label>
        <input type="number" step="0.01" class="form-control" id="salaire" name="salaire" placeholder="" value="<?= $employe['salaire'] ?>">
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary ">Modifier</button>
    </div>
</form>

<?php
require_once('inc/footer.inc.php');
?>