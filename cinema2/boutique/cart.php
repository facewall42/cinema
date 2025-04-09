<?php
require_once "../inc/functions.inc.php";

// TEST SESSION USER ACTIVE
if (empty($_SESSION['client'])) {
    header("location:" . RACINE_SITE . "authentication.php");
    exit();
}

// TEST SI METHODE POST EXISTE ET N'EST PAS VIDE
if (isset($_POST) && !empty($_POST)) {
    // SECURISATION DES ENTREES UTILISATEURS DES INFOS DU FILM
    $idFilm = htmlentities($_POST['id_film']);
    $quantite = htmlentities($_POST['quantity']);
    $title = htmlentities($_POST['title']);
    $price = htmlentities($_POST['price']);
    $stock = htmlentities($_POST['stock']);
    $image = htmlentities($_POST['image']);

    // VERIFIER SI IL EXISTE UN PANIER AVEC film dans panier sinon initialiser panier
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Ajouter un article au panier
    ajouterAuPanier($idFilm, $quantite, $title, $price, $image);
    // Ajouter le film au panier
    // debug($_POST);
    // debug($_SESSION['panier']);
}

// SUPPRIMER un film du panier
if (isset($_GET['id_film'])) {
    $idFilm = htmlentities($_GET['id_film']);
    if (isset($_SESSION['panier'][$idFilm])) {
        unset($_SESSION['panier'][$idFilm]);
    }
}

// vIDER  du panier
if (isset($_GET['vider'])) {
    // $_SESSION['panier'] = [];
    unset($_SESSION['panier']);
}

require_once "../inc/header.inc.php";
?>

<div class="panier d-flex justify-content-center" style="padding-top:8rem;">
    <div class="d-flex flex-column mt-5 p-5">
        <h2 class="text-center fw-bolder mb-5 text-danger">Mon panier</h2>

        <?php if (empty($_SESSION['panier'])): ?>
            <p class="alert alert-warning">Votre panier est vide.</p>
        <?php else: ?>
            <a href="?vider=1" class="btn align-self-end mb-5">Vider le panier</a>

            <table class="fs-4">
                <tr>
                    <th class="text-center text-danger fw-bolder">Affiche</th>
                    <th class="text-center text-danger fw-bolder">Nom</th>
                    <th class="text-center text-danger fw-bolder">Prix</th>
                    <th class="text-center text-danger fw-bolder">Quantité</th>
                    <th class="text-center text-danger fw-bolder">Sous-total</th>
                    <th class="text-center text-danger fw-bolder">Supprimer</th>
                </tr>

                <?php
                $totalpognon = 0; // Initialisation de la variable pour le total
                foreach ($_SESSION['panier'] as $idFilm => $filmDansPanier): ?>
                    <tr>
                        <td class="text-center border-top border-dark-subtle">
                            <a href="<?= RACINE_SITE ?>showFilm.php?id_film=<?= $idFilm ?>">
                                <img src="<?= RACINE_SITE ?>/assets/<?= $filmDansPanier['image'] ?>" style="width: 100px;">
                            </a>
                        </td>
                        <td class="text-center border-top border-dark-subtle"><?= $filmDansPanier['title'] ?></td>
                        <td class="text-center border-top border-dark-subtle"><?= $filmDansPanier['price'] ?>€</td>
                        <td class="text-center border-top border-dark-subtle d-flex align-items-center justify-content-center" style="padding: 7rem;">
                            <?= $filmDansPanier['quantity'] ?>
                        </td>
                        <td class="text-center border-top border-dark-subtle"><?= $filmDansPanier['price'] * $filmDansPanier['quantity'] ?>€</td>
                        <td class="text-center border-top border-dark-subtle">
                            <a href="?id_film=<?= $idFilm ?>"><i class="bi bi-trash3"></i></a>
                        </td>
                    </tr>
                <?php $totalpognon += $filmDansPanier['price'] * $filmDansPanier['quantity'];
                endforeach; ?>

                <tr class="border-top border-dark-subtle">
                    //calculMontant($_SESSION['panier']) devient obsolete car on a déjà le total dans $totalpognon
                    <th class="text-danger p-4 fs-3">Total : <?= $totalpognon ?> €</th>
                </tr>
            </table>

            <form action="checkout.php" method="post">
                <input type="hidden" name="total" value="<?= $totalpognon ?>">
                <button type="submit" class="btn btn-danger mt-5 p-3" id="checkout-button">Payer</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php
require_once "../inc/footer.inc.php";
?>






















<?php


require_once "../inc/footer.inc.php";


?>