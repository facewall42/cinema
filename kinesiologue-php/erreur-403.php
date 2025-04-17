<!-- public/erreur-403.php -->
<?php http_response_code(403); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Donnees constantes -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow">
    <title>Accès interdit</title>
    <meta name="description" content="Vous n'avez pas la permission d'accéder à cette page.">

    <!-- COMPATIBILITE EDGE ########################################## -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- feuille de style -->
    <link rel="stylesheet" href="./assets/css/index_style.css" />
</head>

<body>
    <?php
    include_once("./templates/header.php"); ?>
    <main>
        <br><br><br><br><br><br><br><br>
        <h1>Accès interdit : Ressource introuvable</h1>
        <br><br><br><br><br><br><br><br>
        <h2>Désolé, vous n'avez pas de permission d'accéder à cette ressource.</h2>
        <br><br><br><br><br><br><br><br>
    </main>

    <?php
    include_once("./templates/footer.php"); ?>

</html>