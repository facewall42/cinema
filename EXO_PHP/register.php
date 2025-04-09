<?php

require_once "inc/ft_functions.inc.php";

if (isset($_SESSION['client'])) { // si une session existe avec un identifiant user, je me redirige vers la page de profil
    header("location:profil.php");
}

$info = ""; // variable dans laquelle on va stocker les erreurs

if (!empty($_POST)) {

    $verif = true;

    foreach ($_POST as $key => $value) { // je prend les valeurs de mon tableau en le parcourant

        if (empty(trim($value))) { // si une de ces valeurs est vide, je passe verif en false
            $verif = false;
        }
    }

    if ($verif === false) {
        $info = alert("Veuillez renseigner tous les champs", "danger");
    } else {

        if (!isset($_POST['lastName']) || strlen(trim($_POST['lastName'])) < 2 || strlen(trim($_POST['lastName'])) > 50) {
            $info .= alert("Le champ nom n'est pas valide", "danger");
        }
        if (!isset($_POST['firstName']) || strlen(trim($_POST['firstName'])) > 50) {
            $info .= alert("Le champ prénom n'est pas valide", "danger");
        }
        if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 3 || strlen(trim($_POST['email'])) > 100 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $info .= alert("Le champ email n'est pas valide", "danger");
        }

        $regexMdp = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!isset($_POST['mdp']) || !preg_match($regexMdp, $_POST['mdp'])) {
            $info .= alert("Le champ mot de passe n'est pas valide", "danger");
        }
        if (!isset($_POST['confirmMdp']) || $_POST['mdp'] !== $_POST['confirmMdp']) {
            $info .= alert("La confirmation et le mot de passe doivent être identiques", "danger");
        }
        if (empty($info)) { // = "si on a pas de message d'erreur"
            // on récupère les valeurs de nos champs et on les stocke dans des variables
            $nom = trim($_POST['lastName']);
            $prenom = trim($_POST['firstName']);
            $email = trim($_POST['email']);
            $mdp = trim($_POST['mdp']); // attention, on ne met pas le mdp en dur comme ça dans la bdd, avant : il faut le "hasher"
            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
            // debug($mdpHash);
            // debug($mdp);

            $emailExist = checkEmailUser($email);
            // debug($emailExist);
            $userExist = checkNameEmailUser($nom, $email);
            // debug($userExist);
            // die;

            if ($emailExist) { // on vérifie si l'email existe dans la BDD //En gros on va : "SELECT * FROM users WHERE (email = email input du formulaire)"  
                $info = alert("Ce mail n'est pas disponible", "danger");
            }
            if ($userExist) { // on vérifie si l'email ET le pseudo correspondent au même utilisateur
                $info = alert("Vous avez déjà un compte", "danger");
            } elseif (empty($info)) {
                addGamer($nom, $prenom, $email, $mdpHash);
                $info = alert("Vous êtes bien inscrit, vous pouvez vous connecter <a href='authentication.php' class='text-danger fw-bold'>ici</a>", 'success');
            }
        }
    }
}
require_once "inc/header.inc.php";
?>

<main>
    <div class="w-75 m-auto p-5" style="background: rgba(20, 20, 20, 0.9);">
        <h2 class="text-center mb-5 p-3">Créer un compte</h2>
        <?php
        echo $info;
        // echo alert("test creation de compte", "success");
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
                    <label for="email" class="form-label mb-3">Email</label>
                    <input type="text" class="form-control fs-5" id="email" name="email" placeholder="exemple.email@exemple.com">
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
            <div class="row mt-5">
                <button class="w-25 m-auto btn btn-danger btn-lg fs-5" type="submit">S'inscrire</button>
                <p class="mt-5 text-center">Vous avez dèjà un compte ! <a href="authentication.php" class=" text-danger">connectez-vous ici</a></p>
            </div>
        </form>
    </div>
</main>
<?php

require_once "inc/footer.inc.php";
?>