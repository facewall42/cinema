<?php

require_once "../inc/functions.inc.php";

if (!isset($_SESSION['client'])) { // si la cession n'existe pas avec id user je redirige vers page de connexion
    header('location:' . RACINE_SITE . 'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") { // on bloque l'acces a la partie d'administration 
        header('location:' . RACINE_SITE . 'profil.php'); //utilisateur simple. pas acces au reste 
    }
}

//------- RECUPERATION DE TOUS LES FILMS DE LA TABLE FILMS
$films = allFilms();
//-------TESTS SUR GET  AVEC ACTION et ID FILM EXISTANTE
// TEST DELETE
if (isset($_GET) && isset($_GET['action']) && isset($_GET['id_film'])) {

    if ($_GET['action'] == 'delete' && !empty($_GET['id_film'])) {
        //----on récupère l'id du film pour l'affecter en variable (et parametre) pour supprimer
        $idfilm = htmlentities($_GET['id_film']);

        deleteFilm($idfilm);
        header("location:" . RACINE_SITE . "admin/films.php");
    }
}

require_once "../inc/header.inc.php";

?>
<main>
    <div class="container">
        <div class="d-flex flex-column m-auto mt-5">

            <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>
            <a href="./filmForm.php" class="btn align-self-end"> Ajouter un film</a>
            <table class="table table-dark table-bordered mt-5 ">
                <thea>
                    <tr>
                        <!-- th*7 -->
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Affiche</th>
                        <th>Réalisateur</th>
                        <th>Acteurs</th>
                        <th>Àge limite</th>
                        <th>Genre</th>
                        <th>Durée</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Synopsis</th>
                        <th>Date de sortie</th>
                        <th>Supprimer</th>
                        <th> Modifier</th>
                    </tr>
                </thea>
                <tbody>
                    <?php
                    //---------- BOUCLE D'affichage de la table film dans le tableau-----------------------------------------------
                    foreach ($films as $key => $film) {

                        //------ PHASE 1 FORMATAGE-------------------------
                        //--la str venant de la donnée $film['actors'] doit etre transforméé en tableau :
                        $actors = stringToArray($film['actors']);

                        // on va chercher la catégorie du film par l'id :
                        $category = showCategory($film['category_id']);
                        // on affecte la valeur du nom du film correspondant : 
                        $categoryName = $category['name'];

                        //Gérer l'affichage de la durée
                        // $objet = new NomDeLaClasse();
                        // instancier un nouvel objet DateTime en passant  la valeur de l'input de type time  en tant que paramètre
                        $date_time = new DateTime($film['duration']);
                        //UTILISER LA méthode format() pour EXTRAIRE l'heure et les minutes au format 'H:i'
                        $duration = $date_time->format('H:i');

                    ?>


                        <tr>
                            <!-- Je récupère les valeurs du tableau $film dans des td -->
                            <td><?= $film['id_film'] ?></td>
                            <td> <?= $film['title'] ?></td>
                            <td><img src="<?= RACINE_SITE . "assets/" . $film['image'] ?>" alt="affiche du film" class="img-fluid"></td>
                            <td> <?= $film['director'] ?></td>
                            <td>
                                <ul>
                                    <?php
                                    foreach ($actors as $key => $actor) {
                                    ?>
                                        <li><?= $actor; ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </td>
                            <td> <?= $film['ageLimit'] ?></td>
                            <td> <?= $categoryName ?></td>
                            <td> <?= $duration ?></td>
                            <td> <?= $film['price'] ?>€</td>
                            <td> <?= $film['stock'] ?></td>
                            <td> <?= substr($film['synopsis'], 0, 150) ?>...</td>
                            <td> <?= $film['date'] ?></td>
                            <td class="text-center"><a href="?action=delete&id_film=<?= $film['id_film'] ?>"><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href="./filmForm.php?action=update&id_film=<?= $film['id_film'] ?>"><i class="bi bi-pen-fill"></i></a></td>

                        </tr>


                    <?php
                    }
                    ?>


                </tbody>


            </table>


        </div>
    </div>
    <?php

    require_once "../inc/footer.inc.php";
    ?>