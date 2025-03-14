<?php

require_once "inc/functions.inc.php";
//require_once "inc/header.inc.php"; // on ne peut pas le mettre ici car la fonction header ne prend pas de html 

if (isset($_SESSION['client'])){ // si une session existe avec un identifiant user je me redirige vers la page profile
    header('location:profil.php');
};

$info = "";
// on va tester le champ de formulaire :

if (!empty($_POST)) {

    // On vérifie si un champ est vide
    $verif = true;
    foreach ($_POST as $key => $value) {

        if(empty( trim($value) )) {

            $verif = false;

        }
    }

    if(!$verif){

        $info = alert("Veuillez renseigner tout les champs", "danger");
// les champs sont bien remplis : 
    }else {
        $pseudo = trim($_POST['pseudo']);
        $email = trim($_POST['email']);
        $mdp = $_POST['mdp'];

        // Je vérifie si les données passés dans le formulaire existe dans la BDD , il faut récuperer l'utilisateur de la BDD s'il existe
        $user= checkUser($pseudo, $email); //Le tableau avec les données de l'utilisateur inscrit dans la BDD
        // pour récupérer le mdp => $user ['mdp'] car la fonction checkUser recupere toutes les infos avec SELECT *
        // on peut faire un debug($user['mdp']); pour afficher sur notre page web le mdp hashé provenant de la base 
        if ($user) {
            if (password_verify($mdp, $user['mdp'])) {
                // Je vérifie si le mot de passe est bon
                // password_verify() pour vérifier si un mot de passe correspond à un mot de passe haché créé par la password_hash().
                // Si le hash du mdp de la BDD correspond au $mdp du formulaire, alors password_verify retourne true
                
                /*  Suite à la connexion on va créer ce qu'on appelle une session :

                    Principe des sessions : un fichier temporaire appelée "session" est créé sur le serveur, avec un identifiant unique . Les sessions constituent un moyen de stocker les données sur le serveur. Cette session est liée à un internaute car ces données sont propres à ce dernier.

                    Les données du fichier de session sont accessibles et manipulables à partir de la superglobale $_SESSION, elle est mémorisee par le serveur et est disponible tant que la session de l'utilisateur est maintenue sur le serveur.
                    
                    Quand une session est créée sur le serveur, ce dernier envoie son identifiant (unique) au client sous forme d'un cookie.

                    un cookie est déposé sur le poste de l'internaute avec l'identifiant (au nom de PHPSESSID). Ce cookie se détruit lorsqu'on quitte le navigateur.
                */
                // Création ou ouverture d'une session :
                // Une variable de session est une variable superglobale du nom de $_SESSION, c'est un tableau associatif
                //session_start(); 
                // SESSION START EST MIS DANS FUNCTIONS INC ; IL permet de démarrer une nouvelle session ou reprendre une session déjà existante. On utilise une session quand cette fonction est exécutée, le serveur vérifie si la sesssion  qui a le m^me identifiant enviyé existe 
                //Ensuite on stocke les données dans cette session :
                $_SESSION['client']=$user;
                debug($_SESSION['client']);
                // nous créons une session avec les infos de l'utilisateur client provenant de la BDD. 
                //  cette variable créée et affectée dans cette page sera accessible partout dans le site une fois la fonction session_start() est appelé

                header('location: profil.php'); //header est une fct PHP qui redirige l'utilisateur vers la page profil.php. header impose que 

            } else{
                $info = alert('les identifiants sont incorrects', 'danger');
            }

        }else{
            $info = alert('les identifiants sont incorrects', 'danger');
        }
    }



}

require_once "inc/header.inc.php";

?>
<main style="background:url(assets/img/5818.png) no-repeat; background-size: cover; background-attachment: fixed;" >
    <div class="w-50 m-auto p-5 mt-5" style="background: rgba(20, 20, 20, 0.9);">
        <h2 class="text-center mb-5 p-3">Connexion</h2>

        <?php
            echo($info);   // pour afficher les messages de vérification
        ?>

        <form action="" method="post" class="p-5" >  
                <div class="row mb-3">
                    <div class="col-12 mb-5">
                        <label for="pseudo" class="form-label mb-3">Pseudo</label>
                        <input type="text" class="form-control fs-5" id="pseudo" name="pseudo">
                    </div>
                    <div class="col-12 mb-5">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control fs-5" id="email" name="email" placeholder="exemple.email@exemple.com">
                    </div>
                    <div class="col-12 mb-5">
                        <label for="mdp" class="form-label mb-3">Mot de passe</label>
                        <input type="password" class="form-control fs-5 mb-3" id="mdp" name="mdp" >
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