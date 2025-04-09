<?php

require_once '../vendor/autoload.php';
require_once 'secrets.php';
require_once "../inc/functions.inc.php"; //on a ajouté function pour avoir la valeur RACINE_SITE

// Récupération du total du panier
$total = is_numeric($_POST['total']) ? (int)round($_POST['total'] * 100) : 0;

// $_POST['total'] * 100 convertit les euros en cents (ex: 10.50€ → 1050 cents)
// round() assure qu'aucune fraction de cent ne subsiste (ex: 10.501€ → 1050.1 → arrondi à 1050)
// (int) convertit le résultat en entier
// Pourquoi c'est important pour Stripe ?
// Stripe n'accepte que des montants entiers en cents
// Sans round(), vous pourriez avoir des erreurs si le calcul donne un nombre décimal (ex: 10.01 * 100 = 1001, mais 10.001 * 100 = 1000.1 → erreur)

// debug($_POST);
// debug($_SESSION['panier']);
// debug($total);
// die();


\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = RACINE_SITE . 'boutique'; // Remplacez par votre domaine

$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
        // # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
        // 'price' => '{{PRICE_ID}}', à remplacer par la config adaptee : 
        'price_data' => [
            'currency' => 'EUR',
            'unit_amount' => $total,
            'product_data' => [
                'name' => 'Film'
            ]
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . "/success.php?total=$_POST[total]",
    'cancel_url' => $YOUR_DOMAIN . '/cancel.php',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
