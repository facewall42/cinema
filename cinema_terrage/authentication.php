<?php
require_once "inc/functions.inc.php";

if (isset($_SESSION['client'])) { // si une session existe avec un identiafaint user je me redérige vers la page de profile
    
    header("location:profil.php");
}



$info = "";

if (!empty($_POST)) {

    // On vérifie si un champs est vide 

    $verif = true;
    foreach($_POST as $key=> $value) {
    
        if(empty(trim($value))) {

            $verif = false;
        }
    }

    if (!$verif) {  // $verif === false

        $info = alert("Veuillez renseigner tout les champs", "danger");

    }else{

        // debug($_POST['email']); //sahar.mahdouani@10mentionweb.org
        // debug($_POST['pseudo']); // sousou
        // debug($_POST['mdp']); // Sahar123!


        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        $user = checkUser($pseudo,$email); // je vérifie si les données passsés dans le formulaire existent dans la BD
       
        if ($user) { 
            
           // debug($user['mdp']);// mdp récupérer de la BDD

            if (password_verify($mdp,$user['mdp'])) { // Je vérifie si le mot de passe est bon

                // password_verify():  pour vérifier si un mot de passe correspond à un mot de passe haché créé par la fonction password_hash().
                // Si le hash du mdp de la BDD correspond au mdp du formulaire, alors password_verify retourne true
             

                /*  Suite à la connexion on vas créer ce qu'on appelle une session :
                    Principe des sessions : un fichier temporaire appeléé "session" est crée sur le serveur, avec un identifiant unique . Les sessions constituent un moyen de stocker les données sur le serveur. Cette session est liée à un internaute car ces données sont propres à ce dernier,  Les données du fichier de session sont accessibles et manipulables à partir de la superglobale $_SESSION, elle est mêmoriser par le serveur et est disponible tant que la session de l'utilsateur est maintenu sur le serveur.
                    Quand une session est créée sur le serveur, ce dernier envoie son identifiant (unique) au client sous forme d'un cookie.
                    un cookie est déposé sur le poste de l'internaute avec l'identifiant (au nom de PHPSESSID). Ce cookie se détruit lorsqu'on quitte le navigateur.
                        
                */ 

                // Création ou ouverture d'une sesssion

                // session_start();
                $_SESSION['client'] = $user;// nous créons une session  avec les infos de l'utilisateur provenant de la BDD
                // debug($_SESSION['client']);
               // $_SESSION['panier'] = "Yaya";


                header("location:profil.php");
                
            }else {

                $info = alert("Les identifiants sont incorrectes", "danger");
            }
            
        }else {
            
            $info = alert("Les identifiants sont incorrectes", "danger");
        }
    }
  

}

require_once "inc/header.inc.php" ;
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
 require_once "inc/footer.inc.php";