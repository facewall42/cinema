<?php
require_once "inc/functions.inc.php";

if (isset($_SESSION['client'])){ // si une session existe avec un identifiant user je me redirige vers la page profile
    header('location:profil.php');
};

// if (!empty($_SESSION['user'])) {
//     header('location:'.RACINE_SITE.'index.php');
// } 
require_once "inc/header.inc.php";

$info = "";





if (!empty($_POST)) {

    // On vérifie si un champ est vide
    $verif = true;
    foreach ($_POST as $key => $value) {

        if(empty( trim($value) )) {

            $verif = false;

        }
    }

    if($verif == false){

        $info = alert("Veuillez renseigner tout les champs", "danger");

    }else {

            // on récupére les valeurs de nos champs et on les stocke dans des variables attention le test trim POST name devrait etre fait en amont de l'affectation des variables
            $lastName = trim($_POST['lastName']);
            $firstName = trim($_POST['firstName']);
            $pseudo = trim($_POST['pseudo']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $mdp = $_POST['mdp']; //hasher le mdp 
            $confirmMdp = $_POST['confirmMdp'];// on ne stocke pas ca !
            $civility = trim($_POST['civility']);
            $birthday = trim($_POST['birthday']);
            $address = trim($_POST['address']);
            $zip = trim($_POST['zip']);
            $city = trim($_POST['city']);
            $country = trim($_POST['country']);
            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);// Cette fonction PHP crée un hachage sécurisé d'un mot de passe en utilisant un algorithme de hachage fort : génère une chaîne de caractères unique à partir d'une entrée. C'est un mécanisme unidirectionnel dont l'utilité est d'empêcher le déchiffrement d'un hash. Lors de la connexion, il faudra comparer le hash stocké dans la base de données avec celui du mot de passe fourni par l'internaute.
            // PASSWORD_DEFAULT : constante indique à password_hash() d'utiliser l'algorithme de hachage par défaut actuel c'est le plus recommandé car elle garantit que le code utilisera toujours le meilleur algorithme disponible sans avoir besoin de modification
            debug($mdpHash);


            $regex = '/[0-9]/'; // je stocke mon expression rationnelle dans une variable

            if(!isset($lastName) || strlen($lastName) < 2 || strlen($lastName) > 15 || preg_match($regex, $lastName)   ){ //preg_match — Effectue une recherche de correspondance avec une expression rationnelle standard

                $info .= alert("Le champs nom n'est pas valide", "danger");
            }

            if(!isset($firstName) || strlen($firstName) < 2 || strlen($firstName) > 15 || preg_match($regex, $firstName)   ){

                $info .= alert("Le champs prenom n'est pas valide", "danger");
            }

            if(!isset($pseudo) || strlen($pseudo) < 2 || strlen($pseudo) > 15 ){

               $info .= alert("Le champs pseudo n'est pas valide", "danger");
            }

            if(!isset($email) || strlen($email) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL) ){
               // La fonction filter_var() applique un filtre spécifique à une variable. Lorsqu'elle est utilisée avec la constante FILTER_VALIDATE_EMAIL, elle vérifie si la chaîne passée en paramètre est une adresse e-mail valide. Si l'adresse est valide, la fonction retourne la chaîne elle-même ; sinon, elle retourne false.
          // La constante FILTER_VALIDATE_EMAIL est utilisée dans la fonction filter_var() en PHP pour valider une adresse e-mail. C'est une option de filtrage qui permet de vérifier si une chaîne de caractères est une adresse e-mail valide selon le format standard des e-mails.
               $info .= alert("L'email n'est pas valide", "danger");
            }

            if (!isset($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {

               $info .= alert("Le champs phone n'est pas valide", "danger");
            }
               // preg_match vérifie si le phone correspond à l'expression régulière précisée.
               /* La regex s'écrit entre #
               Le ^ définit le début de l'expression
               Le $ définit la fin de l'expression
               [0-9] définit l'intervalle des chiffres autorisés
               si je met {10} c'est que je définit que l'on en veut 10 précisément
               */
            //  if () {
            //     # code...
            //  }

            $regexMdp = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
          /*
                    ^ : Début de la chaîne.
               (?=.*[A-Z]) : Doit contenir au moins une lettre majuscule.
               (?=.*[a-z]) : Doit contenir au moins une lettre minuscule.
               (?=.*\d) : Doit contenir au moins un chiffre.
               (?=.*[@$!%*?&]) : Doit contenir au moins un caractère spécial parmi @$!%*?&.
               [A-Za-z\d@$!%*?&]{8,} : Doit être constitué uniquement de lettres majuscules, lettres minuscules, chiffres et caractères spéciaux spécifiés, et doit avoir une longueur minimale de 8 caractères.
               $ : Fin de la chaîne.
          */
          if (!isset($mdp) || !preg_match($regexMdp, $mdp) ) {

               $info .= alert("Le mot de passe n'est pas valide kiki.", "danger");
          }
          if(!isset($_POST['confirmMdp']) || $_POST['confirmMdp'] !== $mdp){
               $info .= alert("Veuillez vérifier la correspondance du mot de passe", "danger");
          }

          if (!isset($civility) || !in_array($civility, ['h', 'f'])) {

               $info .= alert("La civilité n'est pas valide.", "danger");
           }

          // (var_dump((int) date('Y')));

          $year1 = ((int) date('Y')) - 13; //2012 ok attention date() transforme en string (vardump le confirme)
          $year2 = ((int) date('Y')) - 90; //1935

          $birthdayYear = explode('-',$_POST['birthday']); // on va tester l'entree saisie de l'user. explode sort une string séparée par des tirets, et ensuite met dans un tableau les donnees annee mois jour. 

          //var_dump((int)$birthdayYear[0]);
// on teste plus jeune que 1935 et plus vieux que 2012 en testant la premiere donnée année du tableau birthdayYear

        if (!isset($_POST['birthday']) ||  (int) $birthdayYear[0] > $year1 || (int) $birthdayYear[0] < $year2 ){
             $info .= alert("La date de naissance n'est pas valide", "danger");
        }


        //   $month = (date('m'));
        //   $date = (date('d'));
          
        //   // date limite supérieure
        //   $dateLimitSup = $year1 . "-" . $month . "-" . $date;

        //   //date limite inférieure

        //   $year2 = ((int) date('Y')) - 90;
        //   $dateLimitInf = $year2 . "-" . $month . "-" . $date;

        //   if (!isset($birthday) || ($birthday >  $dateLimitSup && $birthday < $dateLimitInf)) {
        //        $info .= alert("La date de naissance n'est pas valide", "danger");
        //   }

          if (!isset($address) || strlen($address) < 5 ||  strlen($address) > 50) {

               $info .= alert("L'adresse n'est pas valide.", "danger");
           }
           if (!isset($zip) ||  !preg_match('/^[0-9]{5}$/', $zip)) { // Vérifie si le code postal contient 5 chiffres et que ca commence par un chiffre
   
               $info .= alert("Le code postal n'est pas valide.", "danger");
           }
           if (!isset($city) || strlen($city) > 50 || preg_match($regex, $city)) {
   
               $info .= alert("Le champs ville n'est pas valide ", "danger");
           }
           if (!isset($country) || strlen($country) < 5 ||  strlen($country) > 50 || preg_match($regex, $country)) {
   
               $info .= alert("Le champ pays doit contenir entre 5 et 50 caractéres.", "danger");
           }

           elseif (empty($info)) {
            // de base on peut affecter les variables aux $POST names à cet endroit 

            // $lastName = trim($_POST['lastName']);
            // $firstName = trim($_POST['firstName']);
            // $pseudo = trim($_POST['pseudo']);
            // $email = trim($_POST['email']);
            // $phone = trim($_POST['phone']);
            // $mdp = $_POST['mdp'];
            // $confirmMdp = $_POST['confirmMdp'];
            // $civility = trim($_POST['civility']);
            // $birthday = trim($_POST['birthday']);
            // $address = trim($_POST['address']);
            // $zip = trim($_POST['zip']);
            // $city = trim($_POST['city']);
            // $country = trim($_POST['country']);





               // verifier si l'adresse mail existe dans la BDD
               // verifier si le pseudo existe dans la BDD

               $emailExist = checkEmailUser($email);// cette variable stocke l'utilisateur qui possède l'email renseigné en argument dans la fonction checkEmailUser 
               //si l'email n'existe pas dans la Bdd la variable stock false
               //debug($emailExist); pour voir le contenu 
               //die; die arrete les instructions

               $pseudoExist = checkPseudo($pseudo);
               $userExist = checkUser($pseudo, $email);

               if ($emailExist) {
                    $info = alert("Cette adresse mail est deja utilisée" , "danger");
               }elseif
                    ($pseudoExist){
                    $info .= alert("Le pseudo est déjà existant","danger");
               }

               if ($userExist) { // on fait une requete simultanée pour trouver sur le meme tuple la correspondance alors qu'une condition $emailExist && $pseudoExist
                    $info .= alert("Vous avez déjà un compte","danger");
               }
               elseif (empty($info)) {
                    $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
                     // Cette fonction PHP crée un hachage sécurisé d'un mot de passe en utilisant un algorithme de hachage fort : génère une chaîne de caractères unique à partir d'une entrée. C'est un mécanisme unidirectionnel dont l'utilité est d'empêcher le déchiffrement d'un hash. Lors de la connexion, il faudra comparer le hash stocké dans la base de données avec celui du mot de passe fourni par l'internaute.
                         // PASSWORD_DEFAULT : constante indique à password_hash() d'utiliser l'algorithme de hachage par défaut actuel c'est le plus recommandé car elle garantit que le code utilisera toujours le meilleur algorithme disponible sans avoir besoin de modifications.
                    addUser($lastName, $firstName, $pseudo, $email,  $phone, $mdpHash, $civility, $birthday, $address, $zip, $city, $country);
                    // inscriptionUsers($lastName, $firstName, $pseudo,  $email, $phone, $mdpHash, $civility, $birthday, $address, $zip, $city, $country);

                    $info = alert("Vous êtes inscrit Vous pouvez vous connecter. <a href='authentification.php' class='text-danger fw-bold'>ici</a>",'success');
               }
           }

    }



}








?>

<!-- <main style="background:url(assets/img/5818.png) no-repeat; background-size: cover; background-attachment: fixed;"> -->
    <main>
    <div class="w-75 m-auto p-5" style="background: rgba(20, 20, 20, 0.9);">
        <h2 class="text-center mb-5 p-3">Créer un compte</h2>
        <?php
            debug($_POST);

            echo $info;


        ?>

        <form action="" method="post" class="p-5">
            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label for="lastName" class="form-label mb-3">Nom</label>
                    <input type="text" class="form-control fs-5" id="lastName" name="lastName">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="firstName" class="form-label mb-3">Prenom</label>
                    <input type="text" class="form-control fs-5" id="firstName" name="firstName">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-5">
                    <label for="pseudo" class="form-label mb-3">Pseudo</label>
                    <input type="text" class="form-control fs-5" id="pseudo" name="pseudo">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="email" class="form-label mb-3">Email</label>
                    <input type="text" class="form-control fs-5" id="email" name="email" placeholder="exemple.email@exemple.com">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="phone" class="form-label mb-3">Téléphone</label>
                    <input type="text" class="form-control fs-5" id="phone" name="phone">
                </div>

            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label for="mdp" class="form-label mb-3">Mot de passe</label>
                    <input type="password" class="form-control fs-5" id="mdp" name="mdp" placeholder="Entrer votre mot de passe">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="confirmMdp" class="form-label mb-3">Confirmation mot de passe</label>
                    <input type="password" class="form-control fs-5 mb-3" id="confirmMdp" name="confirmMdp" placeholder="Confirmer votre mot de passe ">
                    <input type="checkbox" onclick="myFunction()"> <span class="text-danger">Afficher/masquer le mot de passe</span>
                </div>


            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label class="form-label mb-3">Civilité</label>
                    <select class="form-select fs-5" name="civility">
                        <option value="h">Homme</option>
                        <option value="f">Femme</option>
                    </select>
                </div>
                <div class="col-md-6 mb-5">
                    <label for="birthday" class="form-label mb-3">Date de naissance</label>
                    <input type="date" class="form-control fs-5" id="birthday" name="birthday">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 mb-5">
                    <label for="address" class="form-label mb-3">Adresse</label>
                    <input type="text" class="form-control fs-5" id="address" name="address">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="zip" class="form-label mb-3">Code postale</label>
                    <input type="text" class="form-control fs-5" id="zip" name="zip">
                </div>
                <div class="col-md-5">
                    <label for="city" class="form-label mb-3">Cité</label>
                    <input type="text" class="form-control fs-5" id="city" name="city">
                </div>
                <div class="col-md-4">
                    <label for="country" class="form-label mb-3">Pays</label>
                    <input type="text" class="form-control fs-5" id="country" name="country">
                </div>
            </div>
            <div class="row mt-5">
                <button class="w-25 m-auto btn btn-danger btn-lg fs-5" type="submit">S'inscrire</button>
                <p class="mt-5 text-center">Vous avez dèjà un compte ! <a href="authentification.php" class=" text-danger">connectez-vous ici</a></p>
            </div>
        </form>
    </div>



</main>



<?php


require_once "inc/footer.inc.php"

?>