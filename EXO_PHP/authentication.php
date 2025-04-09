<?php

require_once "inc/ft_functions.inc.php";

if (isset($_SESSION['client'])) { // si une session existe avec un identifiant user je me redirige vers la page profile
    header('location:profil.php');
};

$info = "";
// on va tester le champ de formulaire :
if (!empty($_POST)) {
    // On vérifie si un champ est vide
    $verif = true;
    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {
            $verif = false;
        }
    }
    if (!$verif) {
        $info = alert("Veuillez renseigner tout les champs", "danger");
        // les champs sont bien remplis : 
    } else {
        $prenom = trim($_POST['prenom']);
        $nom = trim($_POST['nom']);
        $email = trim($_POST['email']);
        $mdp = $_POST['mdp'];

        // Je vérifie si les données passés dans le formulaire existe dans la BDD , il faut récuperer l'utilisateur de la BDD s'il existe
        $user = checkNameEmailUser($nom, $email); //Le tableau avec les données de l'utilisateur inscrit dans la BDD
        // pour récupérer le mdp => $user ['mdp'] car la fonction checkUser recupere toutes les infos avec SELECT *
        // on peut faire un debug($user['mdp']); pour afficher sur notre page web le mdp hashé provenant de la base 
        if ($user) {
            if (password_verify($mdp, $user['mdp'])) {

                $_SESSION['client'] = $user;
                //debug($_SESSION['client']);

                header('location: profil.php');
            } else {
                $info = alert('les identifiants sont incorrects', 'danger');
            }
        } else {
            $info = alert('les identifiants sont incorrects', 'danger');
        }
    }
}
require_once "inc/header.inc.php";
?>

<main style="background:url(assets/img/5818.png) no-repeat; background-size: cover; background-attachment: fixed;">
    <div class="w-50 m-auto p-5 mt-5" style="background: rgba(20, 20, 20, 0.9);">
        <h2 class="text-center mb-5 p-3">Connexion</h2>

        <?php
        echo ($info);   // pour afficher les messages de vérification
        ?>

        <form action="" method="post" class="p-5">
            <div class="row mb-3">
                <div class="col-12 mb-5">
                    <label for="prenom" class="form-label mb-3">Prénom</label>
                    <input type="text" class="form-control fs-5" id="prenom" name="prenom">
                </div>
                <div class="col-12 mb-5">
                    <label for="nom" class="form-label mb-3">Nom</label>
                    <input type="text" class="form-control fs-5" id="nom" name="nom">
                </div>
                <div class="col-12 mb-5">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control fs-5" id="email" name="email" placeholder="exemple.email@exemple.com">
                </div>
                <div class="col-12 mb-5">
                    <label for="mdp" class="form-label mb-3">Mot de passe</label>
                    <input type="password" class="form-control fs-5 mb-3" id="mdp" name="mdp">
                    <input type="checkbox" onclick="myFunction()"> <span class="text-danger">Afficher/masquer le mot de passe</span>
                </div>

                <button class="w-25 m-auto btn btn-danger btn-lg fs-5" type="submit">Se connecter</button>
                <p class="mt-5 text-center">Vous n'avez pas encore de compte ! <a href="register.php" class=" text-danger">créer un compte ici</a></p>
            </div>
        </form>
    </div>
</main>

<?php


require_once "inc/footer.inc.php"

?>