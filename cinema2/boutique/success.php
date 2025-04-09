<?php
require_once "../inc/functions.inc.php";
require_once "../inc/header.inc.php";
debug($_GET['total']);

$id_user = $_SESSION['client']['id_client'];
$price = $_GET['total'];
$dateAchat = date('Y-m-d H:i:s');
$result = addOrder($id_user, $price, $dateAchat, 1);
$orderId = lastId();

if ($result == true) {

    foreach ($_SESSION['panier'] as $value) {
        addOrderDetails($orderId['lastId'], $value['id_film'], $value['price'], $value['quantity']);
    }
    unset($_SESSION['panier']); // on vide le panier après avoir traité tous les articles
}

?>
<main>
    <div class="w-25 m-auto  d-flex flex-column align-item-center">
        <p class="alert alert-success text-center ">Votre achat est bien effectué </p>
        <a href="<?= RACINE_SITE ?>profil.php" class="btn text-center">Suivre ma commande </a>
    </div>