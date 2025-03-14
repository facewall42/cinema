<?php
session_start();

define("RACINE_SITE", "http://localhost/EXO_PHP/");
define("DBHOST", "localhost");
define("DBUSER","root");
define("DBPASS",""); 
define("DBNAME", "club_faycal");

// Fonction alert ///////////////////////////////////////////////////////////////

function alert(string $contenu, string $class) : string {
    return "<div class=\"alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5\" role=\"alert\">
    $contenu
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
}

// Fonction pour debugger //////////////////////////////////////////////////////////

function debug ($var) {
    echo '<pre class= "border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5">';
        var_dump($var);
    echo '</pre>';
}

// Condition pour la déconnexion de l'utilisateur (bouton déconnexion) ////////////////////
if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    // unset ou destroy si pas de "panier" à conserver
    unset($_SESSION['client']); 
    // on supprime l'indice 'client' de la session pour se déconnecter / cette fonction détruit les éléments du tableau $_SESSION['client'].
    header('location:'.RACINE_SITE.'index.php');
}

// Fonction pour la connexion à la base de données /////////////////////////////////////////

function connexionBdd() : object {
                $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8";
                    try{
                        $pdo = new PDO($dsn, DBUSER, DBPASS); 
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
                        // echo "Je suis connecté à la BDD";
                    }
                    catch(PDOException $e){
                        die("Erreur : " .$e->getMessage()); // die permet d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getmessage de l'objet $e
                    }
    return $pdo;
}
// CREATION TABLE JOUEURS *************************************************************
function createTableGamers()  : void {
    $cnx = connexionBdd();
    $sql1 = "CREATE TABLE IF NOT EXISTS joueurs(id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, nom VARCHAR(50), prenom VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, mdp VARCHAR(255) NOT NULL)";
    $request1 = $cnx->exec($sql1);
    if ($request1 !== false) {
        echo "La table 'joueurs' a été créée ou existe déjà.";
    } else {
        echo "Erreur lors de la création de la table.";
    }
}
createTableGamers();

// Fonction AJOUT d'un JOUEUR ***********************************************************

function addGamer(string $lastName, string $firstName, string $email, string $mdp) : void {
    $data = [
        'nom' => $lastName,
        'prenom' => $firstName,
        'email' => $email,
        'mdp' => $mdp
    ];
    foreach($data as $key => $value){
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    $cnx = connexionBdd();
    $sql = "INSERT INTO joueurs (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp) ";
    $request = $cnx->prepare($sql);
    $request->execute($data);
}

// Fonctions de vérification du joueur à la saisie :***************************************

function checkEmailUser(string $email) : mixed { 
    $cnx = connexionBdd();
    $sql = "SELECT email FROM joueurs WHERE email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':email' => $email
    ));
    $result = $request->fetch(); // transforme l'objet qu'on récupère en tableau !
    return $result;
}

function checkNameEmailUser(string $name, string $email) : mixed { 
    $cnx = connexionBdd();
    $sql = "SELECT * FROM joueurs WHERE (nom = :nom AND email = :email)"; 
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':nom' => $name,
        ':email' => $email
    ));
    $result = $request->fetch(); // transforme l'objet qu'on récupère en tableau !
    return $result;
}

// Fonctions recuperation des joueurs*************************************************

function allGamers() : mixed {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM joueurs";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // on veut tous les joueurs (on récupère toutes les lignes à la fois), donc on utilise fetchAll()
    return $result;
}

function showGamer(int $id) : mixed {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM joueurs WHERE id_joueur = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id,
    ));
    $result = $request->fetch();
    return $result;
}

// Fonction suppression de joueur *****************************************************

function deleteGamer($id) :void {
    $cnx = connexionBdd();
    $sql = "DELETE FROM joueurs WHERE id_joueur = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
}

?>