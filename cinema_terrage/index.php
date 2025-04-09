<?php
require_once "inc/functions.inc.php";


$info = "";

// Récupération des films selon la page et la superglobale $_GET
if (isset($_GET) && !empty($_GET)) { // Vérifie si la superglobale $_GET existe et n'est pas vide

    // Le premier affichage dépend de l'existence de la clé id_category dans la superglobale $_GET
    if (isset($_GET['id_category'])) {
        $idCategory = htmlentities($_GET['id_category']); // Sécurise l'ID en échappant les caractères spéciaux

        if (is_numeric($idCategory)) { // Vérifie si l'ID est numérique
            $cat = showCategoryViaId($idCategory); // Récupère les détails de la catégorie via son ID

            if (($cat['id_categorie'] != $idCategory) || empty($idCategory)) { // Vérifie la validité de l'ID de la catégorie
                header('location:index.php'); // Redirige vers la page d'accueil si l'ID n'est pas valide
            } else {
                $films = filmsByCategory($idCategory); // Récupère les films par catégorie
                $message = "Cette catégorie contient : ";

                if (!$films) { // Si aucun film n'est trouvé
                    $info = alert("Désolé ! cette catégorie ne contient aucun film", "danger"); // Affiche un message d'alerte
                }
            }
        } else {
            header('location:index.php'); // Redirige vers la page d'accueil si l'ID n'est pas numérique
        }
    } elseif (isset($_GET['action']) && $_GET['action'] == 'voirPlus') { // Vérifie si l'action est 'voirPlus'
        $films = allFilms(); // Récupère tous les films
        $message = "Le nombre total de films : ";
    }
} else {
    $films = filmByDate(); // Récupère les films par date
    $message = "Le nombre de films sortie en dernier ";
}

require_once "inc/header.inc.php";
?>


<div class="films">
    <h2 class="fw-bolder fs-1 mx-5 text-center"> <?= $message . count($films) ?></h2> <!-- Affiche le message et le nombre de films -->

    <div class="row">
        <?php
        echo $info; // Affiche les informations (alertes)
        foreach ($films as $film) { // Boucle à travers les films
        ?>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                <div class="card">
                    <img src="<?= RACINE_SITE ?>assets/img/<?= $film['image'] ?>" alt="image du film"> <!-- Affiche l'image du film -->
                    <div class="card-body">
                        <h3><?= $film['title'] ?></h3> <!-- Affiche le titre du film -->
                        <h4><?= $film['director'] ?></h4> <!-- Affiche le réalisateur du film -->
                        <p><span class="fw-bolder">Résumé:</span> <?= substr($film['synopsis'], 0, 90) . '...' ?></p> <!-- Affiche un résumé du film -->
                        <a href="<?= RACINE_SITE ?>showFilm.php?id_film=<?= $film['id_film'] ?>" class="btn">Voir plus</a> <!-- Lien pour voir plus de détails -->
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <?php
    if (empty($_GET)) { // Si aucun paramètre n'est passé dans l'URL  : on affiche le bouton que sur le rendu avec les 6 films
    ?>
        <div class="col-12 text-center">
            <a href="<?= RACINE_SITE ?>?action=voirPlus" class="btn p-4 fs-3">Voir plus de films</a> <!-- Lien pour voir plus de films -->
        </div>
    <?php
    }
    ?>
</div>





<?php
require_once "inc/footer.inc.php";
