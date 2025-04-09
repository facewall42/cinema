<?php

require_once "inc/functions.inc.php";
//debug($_SESSION);
//------- RECUPERATION DE TOUS LES FILMS DE LA TABLE FILMS
// $info = "";
$films = allFilms();
$derniersFilms = array_slice($films, -6); // On récupère les 6 derniers films
//debug($derniersFilms);
$message = "Le nombre de films visibles est  : ";
if (isset($_GET) && !empty($_GET) && (isset($_GET['action']) && $_GET['action'] == 'viewmore')) {
    $films = allFilms();
} else {
    $films = $derniersFilms;
}

require_once "inc/header.inc.php";
// debug(count($films));
//debug($_SESSION['client']);
//debug($_SESSION['panier']);
?>
<main>
    <div class=" films">
        <h2 class="fs-1 mx-5 text-center"> <?= $message . count($films) ?> films</h2> <!-- Affiche le message et le nombre de films -->

        <div class="row">
            <?php
            // echo $info;
            foreach ($films as $film) {
            ?>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                    <div class="card">
                        <img src="<?= RACINE_SITE . "assets/" . $film['image'] ?>" alt="affiche du film"> <!-- Affiche l'image du film -->
                        <div class="card-body">
                            <h3> <?= $film['title'] ?></h3> <!-- Affiche le titre du film -->
                            <h4><?= $film['director'] ?></h4> <!-- Affiche le réalisateur du film -->
                            <p><span class="fw-bolder">Résumé:</span> <?= substr($film['synopsis'], 0, 200) ?></p> <!-- Affiche un résumé du film -->
                            <a href="./showFilm.php?action=view&id_film=<?= $film['id_film'] ?>" class="btn">Voir plus</a> <!-- Lien pour voir plus de détails -->
                        </div>
                    </div>

                </div>
            <?php
            }
            ?>
        </div>

        <div class="col-12 text-center">
            <a href="?action=viewmore" class="btn p-4 fs-3">Voir plus de films</a> <!-- Lien pour voir plus de films -->
        </div>
    </div>

    <?php

    require_once "inc/footer.inc.php";

    ?>