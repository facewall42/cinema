<?php

require_once "inc/functions.inc.php";
//TEST si connecté en tant que user 
if (empty($_SESSION['client'])) {

    header("location:" . RACINE_SITE . "authentication.php");
}

if (isset($_GET) && isset($_GET['id_film']) && !empty($_GET['id_film'])) {


    $idfilm = htmlentities($_GET['id_film']);

    if (is_numeric($idfilm)) {

        $film  = showFilm($idfilm);

        if (!$film) {
            header('location:index.php');
        }
    } else {
        header('location:index.php');
    }
}
require_once "inc/header.inc.php";
//debug($film);
//debug($film['image']);
//debug($film['ageLimit']);
$actors = stringToArray($film['actors']);
//film['ageLimit'] = null;
$genre = showCategory($film['category_id']);
//debug($genre);
//debug($film['duration']);
$date_time = new DateTime($film['duration']);
$duration = $date_time->format('H:i');

$date = new DateTime($film['date']);
// Formatage de la date au format jour/mois/année
$formattedDate = $date->format('d/m/Y');
//echo $formattedDate; // Affiche 01/10/2023


?>
<main>
    <div class="film bg-dark">

        <div class="back">
            <a href="<?= RACINE_SITE . "index.php" ?>"><i class="bi bi-arrow-left-circle-fill"></i></a>
        </div>
        <div class="cardDetails row mt-5">
            <h2 class="text-center mb-5"></h2>
            <div class="col-12 col-xl-5 row p-5">
                <img src="<?= RACINE_SITE ?>assets/<?= $film['image'] ?>" alt="Affiche du film">

                <div class="col-12 mt-5">
                    <form action="./boutique/cart.php" method="post" enctype="multipart/form-data" class="w-75 m-auto row justify-content-center p-5">
                        <!-- Dans le formulaire d'ajout au panier, ajoutez des champs cachés pour chaque information que vous souhaitez conserver du film -->
                        <input type="hidden" name="id_film" value="<?= $film['id_film'] ?>">
                        <input type="hidden" name="title" value="<?= $film['title'] ?>">
                        <input type="hidden" name="price" value="<?= $film['price'] ?>">
                        <input type="hidden" name="image" value="<?= $film['image'] ?>">
                        <input type="hidden" name="stock" value="<?= $film['stock'] ?>">
                        <input type="hidden" name="category_id" value="<?= $film['category_id'] ?>">


                        <select name="quantity" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                            <!-- Je créé dynamiquement la quantité sélectionnable dans la limite du stock -->
                            <?php
                            for ($i = 1; $i <= $film['stock']; $i++) {
                            ?>
                                <option value="<?= $i ?>"> <?= $i ?> </option>
                            <?php
                            };
                            ?>
                        </select>

                        <button class="m-auto btn btn-danger btn-lg fs-5" type="submit">Ajouter et voir le panier</button>
                        <!-- au moment du click j'initialise une session de panier qui sera récupérée dans le fichier cart.php -->
                    </form>
                </div>
            </div>
            <div class="detailsContent  col-md-7 p-5">
                <div class="container mt-5">
                    <div class="row">
                        <h3 class="col-4"><span>Realisateur :</span></h3>
                        <ul class="col-8">
                            <li><?= $film['director'] ?></li>
                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Acteur :</span></h3>
                        <ul class="col-8">
                            <?php foreach ($actors as $actor) { ?>
                                <li><?= $actor ?></li>
                            <?php } ?>
                        </ul>
                        <hr>
                    </div>

                    <!-- // si j'ai un age limite renseigné je l'affiche si non pas de div avec Àge limite : -->
                    <?php if ($film['ageLimit'] != null) { ?>
                        <div class="row">
                            <h3 class="col-4"><span>Age limite :</span></h3>
                            <ul class="col-8">
                                <li>+ <?= $film['ageLimit'] ?>ans</li>
                            </ul>
                            <hr>
                        </div>
                    <?php } ?>


                </div>
                <div class="row">
                    <h3 class="col-4"><span>Genre : </span></h3>
                    <ul class="col-8">
                        <li> <?= $genre['name'] ?></li>
                    </ul>
                    <hr>
                </div>
                <div class="row">
                    <h3 class="col-4"><span>Durée : </span></h3>
                    <ul class="col-8">
                        <li><?= $duration ?></li>
                    </ul>
                    <hr>
                </div>
                <div class="row">
                    <h3 class="col-4"><span>Date de sortie:</span></h3>
                    <ul class="col-8">
                        <li><?= $formattedDate ?></li>
                    </ul>
                    <hr>
                </div>
                <div class="row">
                    <h3 class="col-4"><span>Prix : </span></h3>
                    <ul class="col-8">
                        <li><?= $film['price'] ?> €</li>
                    </ul>
                    <hr>
                </div>
                <div class="row">
                    <h3 class="col-4"><span>Stock :</span> </h3>
                    <ul class="col-8">
                        <li><?= $film['stock'] ?></li>
                    </ul>
                    <hr>
                </div>
                <div class="row">

                    <h5 class="col-4"><span>Synopsis :</span></h5>
                    <ul class="col-8">
                        <li><?= $film['synopsis'] ?></li>
                    </ul>
                </div>
            </div>
        </div>



        <?php

        require_once "inc/footer.inc.php";

        ?>