<?php

require_once "../inc/functions.inc.php";

//-----GESTION CLASSIQUE TEST SESSION --------------------------------------------------------------------------
if (!isset($_SESSION['client'])) { // si la cession n'existe pas avec id user je redirige vers page de connexion
    header('location:' . RACINE_SITE . 'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") { // on bloque l'acces a la partie d'administration 
        header('location:' . RACINE_SITE . 'profil.php'); //utilisateur simple. pas acces au reste 
    }
}

//-------Initialisation variable info pour bugs de saisie-------------------------------------------------------
$info = "";
//------- Récupération de toutes les catégories de films déja existantes----------------------------------------
$categories = allCategories();
// debug($categories);

//------ CAS MODIFICATION --------------------------------------------------------------------

// On vérifie que GET est config et a une action (pour la modif) , ensuite qu'il n'est pas vide pour affecter l'id du film dans la variable $idFilm et on va chercher le film correspondant à l'idFilm recupérée

if (isset($_GET) && isset($_GET['action']) && isset($_GET['id_film']) && !empty($_GET['action']) && !empty($_GET['id_film'])) {
    $idFilm = htmlentities($_GET['id_film']);
    $film = showFilm($idFilm);
}

//--------------------------------------------------------------------------------------------------------

// On verifie que on soumet le formulaire en methode POST---------------------------------------------------
if (!empty($_POST)) {
    $verif = true; // 1er test non vide flag ok 

    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {
            $verif = false; // test en boucle des entrées de valeurs non vides
        }
    }
    // -----------Tests sur le choix des fichiers images via la super globale $_FILES-----------------------------------------

    //Lorsqu'un fichier est téléchargé via un formulaire HTML (avec <input type="file">), PHP stocke temporairement ce fichier sur le serveur dans un répertoire temporaire. Les informations sur le fichier téléchargé sont stockées dans la superglobale $_FILES.

    // $_FILES a une clé "image" qui correspond au "name" de l'input type="file" du formulaire

    //----- la clé "name" contient le nom du fichier en cours de téléchargement.

    //----'tmp_name' est une clé dans le tableau $_FILES['image'] qui contient le chemin temporaire du fichier sur le serveur.Ce fichier temporaire sera supprimé à la fin de l'exécution du script PHP, sauf si vous le déplacez ou le copiez ailleurs.

    //-------TESTS si données non vides donc chargées
    // -----test $_FILES['image']['name'] non vide
    if (!empty($_FILES['image']['name'])) {
        // on affecte à $image le chemin relatif de la photo pour le stocker sur table film. On utilisera ce chemin pour les "src" des balises <img>.
        $image = 'img/' . $_FILES['image']['name'];

        //-----utilisation de la fonction copy() en PHP pour copier le fichier téléchargé depuis un emplacement temporaire vers un répertoire spécifique sur le serveur. 

        // La fonction copy() en PHP permet de copier un fichier d'un emplacement source vers un emplacement destination.
        //prototype : copy(string $source, string $destination): bool
        //$source : Chemin du fichier source (ici, $_FILES['image']['tmp_name']).
        // $destination : Chemin du fichier de destination (ici, '../assets/' . $image).
        // La fonction retourne true si la copie réussit, sinon false.

        //*********UTILISER move_uploaded_file() au lieu de copy() pour les fichiers téléchargés, car il est plus sécurisé et vérifie que le fichier a bien été téléchargé via HTTP POST :

        //----- vérifier l'existence du fichier temporaire  $_FILES ['image']['tmp_name']
        if (isset($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
            //  copy($_FILES['image']['tmp_name'], '../assets/' . $image); PAS ASSEZ SECURISE 
            move_uploaded_file($_FILES['image']['tmp_name'], '../assets/' . $image);
        }
        // on enregistre le fichier image qui se trouve à l'adresse contenue dans $_FILES['image']['tmp_name'] vers la destination qui est le dossier "img" à l'adresse "../assets/nom_du_fichier.jpg".
    }
    //-----ON TESTE LA REUSSITE DU MOVE ET DONC LA FONCTION RENVOIE TRUE SI OK SINON ERREUR
    if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/' . $image)) {
        echo "Fichier téléchargé avec succès.";
    } else {
        alert("Erreur lors du téléchargement du fichier via move-uploaded.", "danger");
        // die();
    }

    if ($verif == false || empty($image)) {
        //-------- JE DEBLOQUE EN MODE UPDATE LA SAISIE PARTIELLE DU FORMULAIRE SINON ALERTE ----------------------
        if (!isset($_GET) && !isset($_GET['action']) && !isset($_GET['id_film']) && empty($_GET['action']) && empty($_GET['id_film'] && $_GET['action'] != 'update')) {
            $info = alert("Veuillez renseigner tout les champs !", "danger");
        } else
            $verif == true; // j'echappe les tests en mode update 
    } else {
        //----TESTS SUR TOUTES LES CLES DE LA SUPERGLOBALE $_FILES 
        // $_FILES ['image']['type'] Type comparer à un tableau des extensions images normales sinon erreur à faire !
        // $_FILES ['image']['size'] Taille
        // $_FILES ['image']['error'] Erreur si oui/non l'image a été réceptionné

        if ($_FILES['image']['error'] || $_FILES['image']['size'] == 0 || !isset($_FILES['image']['type'])) {
            $info .= alert("PROBLEME SUR CLES TYPE, TAILLE, OU ERROR", "danger");
        }
        // si tout est ok on peut recupérer et affecter les variables depuis la methode POST (JE CROIS QUIL FAUT D ABORD VERIFIER QUE LES POST SONT OK AVANT DE LES AFFECTER DONC ON DOIT AVANT D4AFFECTER UTILISER ENCORE POST AVEC ISSET POST VOIR DESSOUS LES TESTS D ENTREES DE FORMULAIRE)
        $idcat = trim($_POST['categories']);
        $title = trim($_POST['title']);
        $director = trim($_POST['director']);
        $actors = trim($_POST['actors']);
        $age = trim($_POST['ageLimit']);
        $duration = trim($_POST['duration']);
        $date = trim($_POST['date']);
        $price = trim($_POST['price']);
        $stock = trim($_POST['stock']);
        $synopsis = trim($_POST['synopsis']);

        //---------TEST REMPLISSAGE TITLE
        if (!isset($title) || strlen($title) < 2) {
            $info .= alert("le champ titre n'est pas valide ", "danger");
        }
        //---------TEST  REMPLISSAGE REALISATEUR
        if (strlen($director) < 2 || preg_match('/[0-9]+/', $director)) {
            //--------test longueur > 1 sinon ERREUR / 
            $info .= alert("Champ Réalisateur non valide", "danger");
        }


        //-------TEST BONNE SAISIE ACTORS --------------------------------------------
        // valider la bonne saisie du slash '/' et une string qui contient au moins un caractère avant et après le symbole /. 
        //    .* : correspond à n'importe quel nombre de caractères (y compris zéro caractère), sauf une nouvelle ligne.
        //     \/ : Le backslash permet d'echapper le slash 




        if (!isset($actors) ||  strlen($actors) < 3 || preg_match('/[0-9]+/', $actors) || !preg_match('/.*\/.*/', $actors)) {
            $info .= alert("Champ acteurs invalide, verifier le slash et noms", "danger");
        }

        if (!isset($idcat) ||  showCategory($idcat) == false) {
            $info .= alert("La catégorie ($idcat) buggue", "danger");
        }
        if (!isset($duration)) {
            $info .= alert("Durée non saisie", "danger");
        }
        if (!isset($date)) {
            $info .= alert("Date de sortie non saisie", "danger");
        }
        if (!isset($price) || !is_numeric($price)) {
            $info .= alert("le prix non saisi ou pas un nombre", "danger");
        }
        if (!isset($synopsis) || strlen($synopsis) < 20) {
            $info .= alert("le champs synopsis non saisi", "danger");
        }
        if (!isset($stock)) {
            $info .= alert("pas de quantité de stock ????", "danger");
        }
        if (!isset($image)) {
            $info .= alert("le champs image non saisi", "danger");
        }
        if (!isset($age)) {
            $info .= alert("le champs nom de l'age limite non saisi", "danger");
        }

        //----------Si TOUT EST OK ON TESTE Si on est en  MODIFICATION de film ---------------------------------------------
        elseif (empty($info)) {

            //-----TEST GET ACTION EN MODIF AVEC UN ID FILM BIEN RECUPERE-----------------------------------
            if (isset($_GET) && isset($_GET['action']) && isset($_GET['id_film']) && !empty($_GET['action']) && !empty($_GET['id_film'] && $_GET['action'] == 'update')) {

                // ON AFFECTE L'id EN SECURISANT LES CARACTERES POUR LA RECHERCHE DANS LA VARIABLE 
                $idfilm = htmlentities($_GET['id_film']);

                //--------ON PEUT LANCER L'UPDATE ---------------------
                updateFilm($idfilm, $idcat, $title, $director, $actors, $age, $duration, $synopsis, $date, $image, $price, $stock);

                //----- ON RAFRAICHIT LA PAGE 
                header("location:" . RACINE_SITE . "admin/films.php");
                $info .= alert("c'est valide", "success");
            }
            //--------SINON ON EST EN CAS D'AJOUT CLASSIQUE DE FILM ET ON VERIFIE S'IL EXISTE DEJA
            else {
                if (checkFilm($title, $date)) { //si le film existe dans la bdd
                    $info .= alert("le film existe deja", "danger");
                } else {
                    addFilm($idcat, $title, $director, $actors, $age, $duration, $synopsis, $date, $price, $stock, $image);
                    $info .= alert("AJOUT REUSSI ", "success");
                }
            }
        }
    }
}

require_once "../inc/header.inc.php";

?>

<main>
    <h2 class="text-center fw-bolder mb-5 text-danger"><?= isset($film) ? 'Modifier le film' : 'Ajouter un film' ?></h2>
    <!-- permet d'afficher en fonction de l'etat de la variable film en condition ternaire -->
    <?= $info ?>

    <form action="" method="post" class="back" enctype="multipart/form-data">
        <!-- il faut insérer une image pour chaque film, pour le traitement des images et des fichiers en PHP on utilise la surperglobale $_FILES -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title">Titre de film</label>
                <!-- ecriture conditionnelle des champs si la variable film existe -->
                <input type="text" name="title" id="title" class="form-control" value="<?= $film['title'] ?? '' ?>">

            </div>
            <div class="col-md-6 mb-5">
                <label for="image">Photo</label>
                <br>
                <input type="file" name="image" id="image">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="director">Réalisateur</label>
                <input type="text" class="form-control" id="director" name="director" value="<?= $film['director'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label for="actors">Acteur(s)</label>
                <input type="text" class="form-control" id="actors" name="actors" value="<?= $film['actors'] ?? '' ?>" placeholder="séparez les noms d'acteurs avec un /">
            </div>
        </div>
        <div class="row">
            <!-- raccouci bs5 select multiple -->
            <div class="mb-3">
                <label for="ageLimit" class="form-label">Àge limite</label>
                <select multiple class="form-select form-select-lg" name="ageLimit" id="ageLimit">
                    <!-- selection conditionnelle de l'age limite -->
                    <option value="10" <?php if (isset($film['ageLimit']) && $film['ageLimit'] == 10) echo 'selected' ?>>10</option>
                    <option value="13" <?php if (isset($film['ageLimit']) && $film['ageLimit'] == 13) echo 'selected' ?>>13</option>
                    <option value="16" <?php if (isset($film['ageLimit']) && $film['ageLimit'] == 16) echo 'selected' ?>>16</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label for="categories">Genre du film</label>

            <!--  Ici c'est les catégories qui sont déjà stockés dans la BDD et qu'on va récupérer à partir dela BDD -->
            <?php
            foreach ($categories as $key => $value) {
            ?>
                <div class="form-check col-sm-12 col-md-4 ">
                    <input class="form-check-input" type="radio" name="categories"
                        id="<?= $value['name'] ?>"
                        value="<?= $value['id_category'] ?>"
                        <?= isset($film['category_id']) && $film['category_id'] == $value['id_category'] ? 'checked' : '' ?>>
                    <!-- on a récupéré la notion checked en fonction des valeurs des identifiants de categorie  -->
                    <label class="form-check-label" for="<?= $value['name'] ?>"><?= $value['name'] ?></label>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="duration">Durée du film</label>
                <input type="time" class="form-control" id="duration" name="duration" min="01:00" value="<?= $film['duration'] ?? '' ?>">
            </div>

            <div class="col-md-6 mb-5">

                <label for="date">Date de sortie</label>
                <input type="date" name="date" id="date" class="form-control" value="<?= $film['date'] ?? '' ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros amount (with dot and two decimal places)" value="<?= $film['price'] ?? '' ?>">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?= $film['stock'] ?? '' ?>"> <!--pas de stock négativ donc je rajoute min="0"-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="synopsis">Synopsis</label>
                <textarea type="text" class="form-control" id="synopsis" name="synopsis" rows="10"><?= $film['synopsis'] ?? '' ?></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger p-3 w-25"><?= isset($film) ? 'Modifier le film' : 'Ajouter un film' ?></button>
        </div>

    </form>

    <?php
    require_once "../inc/footer.inc.php";
    ?>