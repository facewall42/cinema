<?php

require_once "../inc/functions.inc.php";
$info = "";
$categories = allCategories();
$varCategoryName = "";
$varCategoryDescription = "";

// ******** VERIF SESSSION USER / ADMIN ********************
if (!isset($_SESSION['client'])) { // si la cession n'existe pas avec id user je redirige vers page de connexion
    header('location:' . RACINE_SITE . 'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") { // on bloque l'acces a la partie d'administration 
        header('location:' . RACINE_SITE . 'profil.php'); //utilisateur simple. pas acces au reste 
    }
}
//*************VERIF et Recup DONNEES à soumettre********* */
//************if $GET = modify
// **********on remplit le champ titre de categorie et description

if (!empty($_POST)) {

    $verif = true;
    foreach ($_POST as $key => $value) { // je prend les valeurs de mon tableau en le parcourant

        if (empty(trim($value))) { // si une de ces valeurs est vide, je passe verif en false
            $verif = false;
        }
    }
    if ($verif === false) {
        $info = alert("Veuillez renseigner tous les champs", "danger");
    } else {

        if (!isset($_POST['name']) || strlen($_POST['name']) < 3   || preg_match("/[0-9]/", $_POST['name'])) {
            $info = alert("Le champ nom de la categorie n'est pas valide", "danger");
        }
        if (!isset($_POST['description']) || strlen(trim($_POST['description'])) < 20) {
            $info .= alert("il faut minimum 20 caracteres", "danger");
        } elseif ($info == "") {

            // stockage des donnees inserees dans les variables
            $name = $_POST['name'];
            $description = trim(htmlspecialchars($_POST['description']));
            $categoryBdd = showCategory($name);
            $varCategoryName = $_POST['name'];
            $varCategoryDescription = $_POST['description'];

            //********inserer un by pass si GET != modify */
            // si on est en creation (on n'a pas appuyé sur modifier dans le tableau)

            if (empty($_GET['action']) || $_GET['action'] != "modify") {
                if ($categoryBdd) {
                    $info = alert("attention la categorie existe deja", "danger");
                } else
                    addCategory($name, $description);
            }

            // ***** else update category, on recup l'id de la categorie selectionnée dans le tableau : 
            else {
                if ($_GET['action'] == "modify") {
                    $idCategory = htmlspecialchars($_GET['id']);
                    //debug($idCategory);

                    // updateCategory($description, $name, $idCategory);
                    updateCategory($varCategoryDescription, $varCategoryName, $idCategory);
                    header('location:categories.php'); //refresh de page
                }
            }
        }
    }
}
//*****************PARTIE ACTION GESTION SUP MODIFY ************************************* */
if (isset($_GET['action']) && isset($_GET['id'])) { // on vérifie si y'a déjà une action

    $idCategory = htmlspecialchars($_GET['id']); // on peut recup la variable qui servira aux deux conditions

    if (!empty($_GET['action']) && $_GET['action'] == "modify" && !empty($_GET['id'])) { // $_GET['id'] ici, c'est l'id qui passe par l'url

        // afficher les données dans le tableau de saisie
        $category = showCategory($idCategory); // on place la variable qui va etre utilisee dans les conditions
        $varCategoryName = $category['name'];
        $varCategoryDescription = $category['description'];
    }
    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id'])) {

        deleteCategory($idCategory);

        header('location:categories.php'); //refresh de page
    }
}

require_once "../inc/header.inc.php";

?>
<main>
    <div class="row mt-5" style="padding-top: 8rem;">
        <div class="col-sm-12 col-md-6 mt-5">
            <h2 class="text-center fw-bolder mb-5 text-danger">Gestion des catégories</h2>


            <?= $info ?>
            <!-- pour afficher les messages d'erreur -->

            <form action="" method="post" class="back">

                <div class="row">
                    <div class="col-md-8 mb-5">
                        <label for="name">Nom de la catégorie</label>

                        <!-- // on verifie que on a appuyé sur modifier  -->
                        <?php
                        //debug($_GET['action']);
                        //debug($category); OK
                        ?>
                        <input type="text" id="name" name="name" class="form-control" value="<?= $varCategoryName ?>">
                        <?php
                        ?>
                    </div>
                    <div class="col-md-12 mb-5">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="10"><?= $varCategoryDescription ?> </textarea>
                    </div>

                </div>
                <div class="row justify-content-center"><button type="submit" class="btn btn-danger p-3"> <?php if (isset($_GET['action'])   && $_GET['action'] == "modify") { ?> modifier <?php } else { ?> ajouter <?php } ?></button>
                </div>
            </form>
        </div>

        <div class="col-sm-12 col-md-6 d-flex flex-column mt-5 pe-3">

            <h2 class="text-center fw-bolder mb-5 text-danger">Liste des catégories</h2>
            <table class="table table-dark table-bordered mt-5 ">
                <thead>
                    <tr>
                        <!-- th*7 -->
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Supprimer</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($categories as $categorie) { // $categories = tableau et $categorie = chaque categorie
                        // je boucle sur le tableau categories et je récupère chaque categorie dans la variable $categorie
                    ?>

                        <tr>
                            <td><?= $categorie['id_category'] ?></td>
                            <td><?= $categorie['name'] ?></td>
                            <td><?= substr(ucfirst($categorie['description']), 0, 50) ?></td><!-- une majuscule sur la premère lettre et on extrait que les 100 premiers caracteres-->

                            <td class="text-center" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cette categorie ?'))"><a href="categories.php?action=delete&id=<?= $categorie['id_category'] ?>"><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href="categories.php?action=modify&id=<?= $categorie['id_category'] ?>"><i class="bi bi-pen-fill"></i></a></td>

                        </tr>

                    <?php

                    }
                    //  debug($_GET['action']);
                    ?>

                </tbody>

            </table>

        </div>




        <?php


        require_once "../inc/footer.inc.php";


        ?>