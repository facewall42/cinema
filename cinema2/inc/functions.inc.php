<?php
session_start();
// constante pour définir le chemin du site

define("RACINE_SITE", "http://localhost/cinema2/");

///////////////////////////////////////// Fonction alert ///////////////////////////////////////////////////////////////

function alert(string $contenu, string $class): string
{
    return "<div class=\"alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5\" role=\"alert\">
    $contenu
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
}


////////////////////////////////////////////// Fonction pour debugger //////////////////////////////////////////////////////////

function debug($var)
{

    echo '<pre class= "border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5">';

    var_dump($var);

    echo '</pre>';
}
//////// FONCTION POUR CONVERTIR LA STRING EN TABLEAUX POUR LES ACTEURS////////////////////////////////
function stringToArray(string $string): array
{

    $array = explode('/', trim($string, '/')); // Je transforme ma chaîne de caractères en tableau et je supprime les / autour de la chaîne de caractères 
    return $array; // ma fonction retourne un tableau

}

////////////////////////////////////////////// Condition pour la déconnexion de l'utilisateur (bouton déconnexion) //////////////////////////////////////////////////////////


if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    // tout dépend de l'objectif du site 
    // pour un site ecommerce : attention au panier ! Le panier doit rester rempli quand l'utilisateur revient sur le site une 2nde fois
    // donc on utilise unset()
    // pour un site communautaire / blog : on utlise destroy()

    unset($_SESSION['client']);
    // on supprime l'indice 'client' de la session pour se déconnecter / cette fonction détruit les éléments du tableau $_SESSION['client'].

    // Puis notre utilisateur est alors déconnecté, donc on va le renvoyer vers par exemple, la page d'authentification

    // session_destroy();
    // La fonction session_destroy détruit toutes les données de la session déjà établie. Cette fonction détruit la session sur le serveur

    header('location:' . RACINE_SITE . 'index.php');
}


////////////////////////////////////////////// Fonction pour la connexion à la base de données //////////////////////////////////////////////////////////


// On va utiliser l'extension PHP Data Objects (PDO), elle définit une excellente interface pour accéder à une base de données depuis PHP et d'exécuter des requêtes SQL.
// Pour se connecter à la BDD avec PDO il faut créer une instance de cet Objet (PDO) qui représente une connexion à la base de données, pour cela il faut se servir du constructeur de la classe
// Ce constructeur demande certains paramètres:
// On déclare des constantes d'environnement qui vont contenir les information à la connexion à la BDD




// Constante du serveur
define("DBHOST", "localhost");

// // constante de l'utilisateur de la BDD du serveur en local => root
define("DBUSER", "root");

// // constante pour le mot de passe de serveur en local => pas de mot de passe
define("DBPASS", "");

// // Constante pour le nom de la BDD
define("DBNAME", "cinema");





function connexionBdd(): object
{


    //DSN (Data Source Name):

    //$dsn = mysql:host=localhost;dbname=cinema;charset=utf8;
    $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";

    //Grâce à PDP on peut lever une exception (une erreur) si la connexion à la BDD ne se réalise pas(exp: suite à une faute au niveau du nom de la BDD) et par la suite si cette erreur est capté on lui demande d'afficher une erreur

    try { // dans le try on va instancier PDO, c'est créer un objet de la classe PDO (un élment de PDO)
        // Sans la variable dsn les constantes d'environnement
        // $pdo = new PDO('mysql:host=localhost;dbname=entreprise;charset=utf8','root','');
        $pdo = new PDO($dsn, DBUSER, DBPASS);
        //On définit le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // POUR SAHAR:  cet atribut est à rajouter après le premier fetch en bas 
        //On définit le mode de "fetch" par défaut
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // grâce à fetch_assoc, on récupère l'objet (qu'on ne peut pas afficher comme ça), puis fetch le transforme en tableau, qu'on peut afficher !
        // je vérifie la connexion avec ma BDD avec un simple echo

        // echo "Je suis connecté à la BDD";
    } catch (PDOException $e) {  // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objet de la clase en question qui va stocker cette erreur

        die("Erreur : " . $e->getMessage()); // die d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getmessage de l'objet $e
    }

    //le catch sera exécuter dès lors on aura un problème da le try
    return $pdo;
}





// À partir d'ici on est connecté à la BDD et la variable $pdo est l'objet qui représente la connexion à la BDD, cette variable va nous servir à effectuer les requêtes SQL et à interroger la base de données 

// debug($pdo);
//debug(get_class_methods($pdo)); // permet d'afficher la liste des méthodes présentes dans l'objet $pdo.





// // // // // // // // // // // Table catégories // // // // // // // // // // // // // // 



function createTableCategories(): void
{ // cette fonction va juste créer une table dans la base de données, elle ne retourne rien

    // notre connexion
    $cnx = connexionBdd();
    // notre requête
    $sql = "CREATE TABLE IF NOT EXISTS categories(
                                                id_categorie INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                                name VARCHAR(50) NOT NULL,
                                                description TEXT NULL
                                                
                                                
                                                
                                                )";

    $request = $cnx->exec($sql);
}

// createTableCategories();




//// //// //// //// //// //// //// //// Table films //// //// //// //// //// //// //// //// 



function createTableFilms(): void
{

    $cnx = connexionBdd();

    $sql2 = "CREATE TABLE IF NOT EXISTS films(
                                            id_film INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, category_id INT(11) NOT NULL, title VARCHAR(100) NOT NULL, director VARCHAR(100) NOT NULL, actors VARCHAR(100) NOT NULL, ageLimit VARCHAR(5) NULL, duration TIME NOT NULL, synopsis TEXT NOT NULL, date DATE NOT NULL, image VARCHAR(250) NOT NULL, price FLOAT NOT NULL, stock BIGINT NOT NULL
    
                                                )";

    $request2 = $cnx->exec($sql2);
}


// createTableFilms();



//// //// //// //// //// //// //// //// Table users //// //// //// //// //// //// //// //// 



function createTableUsers(): void
{

    $cnx = connexionBdd();

    $sql3 = "CREATE TABLE IF NOT EXISTS users(
                                            id_user INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, firstName VARCHAR(50), lastName VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, mdp VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, phone VARCHAR(30) NOT NULL, civility ENUM('f', 'h') NOT NULL, birthday DATE NOT NULL, address VARCHAR(50) NOT NULL, zip VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(50), role ENUM('ROLE_USER','ROLE_ADMIN') DEFAULT 'ROLE_USER'
    
                                            )";

    $request3 = $cnx->exec($sql3);
}


// createTableUsers();




########################################## Création des clés étrangères #################################################


// ALTER TABLE films ADD FOREIGN KEY category_id REFERENCES categories id_categorie

function foreignKey(string $tableFK, string $keyFK, string $tablePK, string $keyPK): void
{
    $cnx = connexionBdd();
    $sql = "ALTER TABLE $tableFK ADD FOREIGN KEY ($keyFK) REFERENCES $tablePK ($keyPK)";

    $request = $cnx->exec($sql);
}


//////////////////////////////////////// Création de la clé étrangère dans la table films ////////////////////////////////////////

// On actualise une fois le rendu du site, ce qui appele 1 fois la fonction, puis on commente ici pour éviter que la fonction soit réappelée à chaque actualisation du site web
// foreignKey('films', 'category_id', 'categories', 'id_categorie');



/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                UTILISATEURS                 ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/

////////////////////////////////////////////////// Fonction ajout d'un utilisateur //////////////////////////////////////////////////


function addUser(
    string $lastName,
    string $firstName,
    string $pseudo,
    string $email,
    string $phone,
    string $mdp,
    string $civility,
    string $birthday,
    string $address,
    string $zip,
    string $city,
    string $country
): void { // cette fonction va prendre en paramètre les variables du formulaire

    // On crée un tableau associatif avec les noms des colonnes de la table users comme clés
    $data = [
        'lastName' => $lastName,
        'firstName' => $firstName,
        'pseudo' => $pseudo,
        'email' => $email,
        'phone' => $phone,
        'mdp' => $mdp,
        'civility' => $civility,
        'birthday' => $birthday,
        'address' => $address,
        'zip' => $zip,
        'city' => $city,
        'country' => $country
    ];

    // Echapper les données et les traiter contre les failles JS

    // $data['lastName'] = htmlspecialchars($lastName)
    // $data['firstName'] = htmlspecialchars($lastName)
    // on va pas continuer comme ça en le faisant "en dur", on va plutôt utiliser une boucle

    foreach ($data as $key => $value) {

        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        /* 
                htmlspecialchars est une fonction qui convertit les caractères spéciaux en entités HTML, cela est utilisé afin d'empêcher l'exécution de code HTML ou JavaScript : les attaques XSS (Cross-Site Scripting) injecté par un utilisateur malveillant en échappant les caractères HTML /////////////potentiellement dangereux . Par défaut, htmlspecialchars échappe les caractères suivants :

                & (ampersand) devient &amp;
                < (inférieur) devient &lt;
                > (supérieur) devient &gt;
                " (guillemet double) devient &quot;
        */

        //////////////////////////////////// htmlspecialchars n'échappe pas les simples quotes de base, du coup on met en paramètre ENT_QUOTES aussi ! //////////////////////////////

        // ENT_QUOTES : est une constante en PHP  qui convertit les guillemets simples et doubles. 
        // => ' (guillemet simple) devient &#039; 
        // 'UTF-8' : Spécifie que l'encodage utilisé est UTF-8.

        // htmlentities() prend en compte les simples quotes de base, alors que htmlspecialchars ne le fait pas. Bon à savoir.

    }

    $cnx = connexionBdd();
    $sql = "INSERT INTO users (lastName, firstName, pseudo, email, phone, mdp, civility, birthday, 
    address, zip, city, country) VALUES (:lastName, :firstName, :pseudo, :email, :phone, :mdp, :civility, :birthday, 
    :address, :zip, :city, :country) ";
    // (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ----> Des fois, sur internet, on peut trouver cette notation pour les VALUES

    $request = $cnx->prepare($sql);

    //prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur :firstName qui est vide et attend une valeur.


    /* Les requêtes préparees sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez au SGBD de répéter toutes les phases analyse/ interpretation / exécution de la requête (gain de performance). Les requêtes préparées sont aussi utilisées pour nettoyer les données et se prémunir des injections de type SQL.

                    1- On prépare la requête
                    2- On lie le marqueur à la requête
                    3- On exécute la requête 

*/

    // $request->execute(array(
    //     // on prend les valeurs qui sont protégées, bien sûr !
    //     ':lastName' => $data['lastName'], 
    //     ':firstName' => $data['firstName'], 
    //     ':pseudo' => $data['pseudo'], 
    //     ':email' => $data['email'], 
    //     ':phone' => $data['phone'], 
    //     ':mdp' => $data['mdp'], 
    //     ':civility' => $data['civility'], 
    //     ':birthday' => $data['birthday'], 
    //     ':address' => $data['address'], 
    //     ':zip' => $data['zip'], 
    //     ':city' => $data['city'], 
    //     ':country' => $data['country']
    // ));

    // ce tableau ci-dessus, c'est la même chose que ci-dessous SUPER IMPORTANT POUR COMPRENDRE le marqueur :lastName qui se comporte comme un pointeur

    $request->execute($data);
}


function checkEmailUser(string $email): mixed
{ // soit on récupère un tableau avec un seul champ (mais c'est bien un tableau), soit on récupère un booléen qui donne false

    $cnx = connexionBdd();
    $sql = "SELECT email FROM users WHERE email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':email' => $email
    ));

    $result = $request->fetch(); // transforme l'objet qu'on récupère en tableau !

    return $result; // car on veut le tableau

}

function checkPseudoUser(string $pseudo): mixed
{ // soit on récupère un tableau avec un seul champ (mais c'est bien un tableau), soit on récupère un booléen qui donne false

    $cnx = connexionBdd();
    $sql = "SELECT pseudo FROM users WHERE pseudo = :pseudo";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo
    ));

    $result = $request->fetch(); // transforme l'objet qu'on récupère en tableau !
    return $result; // car on veut le tableau

}

function checkPseudoEtEmailUser(string $pseudo, string $email): mixed
{ // soit on récupère un tableau avec un seul champ (mais c'est bien un tableau), soit on récupère un booléen qui donne false

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users WHERE (pseudo = :pseudo AND email = :email)"; // on peut aussi mettre SELECT pseudo, email
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo,
        ':email' => $email
    ));

    $result = $request->fetch(); // transforme l'objet qu'on récupère en tableau !
    return $result; // car on veut le tableau

}

function allUsers(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // on veut tous les utilisateurs (on récupère toutes les lignes à la fois), donc on utilise fetchAll(), car fetch() ne donne qu'un élement
    return $result;
}

function showUser(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users WHERE id_user = :id";
    $request = $cnx->prepare($sql);

    $request->execute(array(

        ':id' => $id,

    ));

    $result = $request->fetch();
    return $result;
}


function updateRole(string $role, int $id): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE users SET role = :role WHERE id_user = :id";
    $request = $cnx->prepare($sql);

    $request->execute(array(

        ':role' => $role,
        ':id' => $id

    ));
}

function deleteUser($id): void
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM users WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
}
//*********************************************** ?????*/
function showCat(int $name): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE name = :name";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':name' => $name
    ));
    $result = $request->fetch();
    return $result;
}
//***************************************************??? */
function showCategory(string $id): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_category = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":id" => $id
    ));
    $result = $request->fetch();
    return $result;
}

function addCategory(string $name, string $description)
{
    $data = [
        'name' => $name,
        'description' => $description
    ];
    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $cnx = connexionBdd();
    $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
    $request = $cnx->prepare($sql);
    $request->execute($data);
}

function deleteCategory($id): void
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM categories WHERE id_category = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
}

// fonction un peu redondante avec all Users
function allCategories(): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories ORDER by name";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // on veut tous les utilisateurs (on récupère toutes les lignes à la fois), donc on utilise fetchAll(), car fetch() ne donne qu'un élement
    return $result;
}

// fonction pour la modification des descriptions et nom des categories :

function updateCategory(string $description, string $name, int $id): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE categories SET description = :description, name = :name  WHERE id_category = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':description' => $description,
        ':name' => $name,
        ':id' => $id

    ));
}

// ------------------FILMS -----------------------------------

function showFilm(string $idparam): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE id_film = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":id" => $idparam
    ));
    $result = $request->fetch();
    return $result;
}

function allFilms(): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();
    return $result;
}

function checkFilm($title, $date)
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE title = :id_category AND date = :date";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_category' => $title,
        ':date' => $date
    ));
    $result = $request->fetch();
    return $result;
}

function addFilm($idcat, $title, $director, $actors, $age, $duration, $synopsis, $date, $price, $stock, $image)
{
    $cnx = connexionBdd();
    $sql = "INSERT INTO films (category_id ,title, director ,actors ,ageLimit , duration ,synopsis ,date ,image ,price ,stock  ) VALUES (:category_id ,:title, :director ,:actors ,:ageLimit , :duration ,:synopsis ,:date ,:image ,:price ,:stock )";
    $data = [
        ":category_id" => $idcat,
        ":title" => $title,
        ":director" => $director,
        ":actors" => $actors,
        ":ageLimit" => $age,
        ":duration" => $duration,
        ":synopsis" => $synopsis,
        ":date" => $date,
        ":price" => $price,
        ":stock" => $stock,
        ":image" => $image
    ];
    // Appliquer htmlentities uniquement aux chaînes de caractères, sur les numeric c'est pas la peine
    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    $request = $cnx->prepare($sql);
    $request->execute($data);
}

function deleteFilm(int $id): void
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM films WHERE id_film = :id  ";
    $request = $cnx->prepare($sql);
    $request->execute(array(":id" => $id));
}




function updateFilm(int $id_film, int $category_id, string $title, string $director, string $actors, string $ageLimit, string $duration, string $synopsis, string $date, string $image, float $price, int $stock): void
{
    $film = [
        'id_film' => $id_film,
        'category_id' => $category_id,
        'title' => $title,
        'director' => $director,
        'actors' => $actors,
        'ageLimit' => $ageLimit,
        'duration' => $duration,
        'synopsis' => $synopsis,
        'date' => $date,
        'image' => $image,
        'price' => $price,
        'stock' => $stock
    ];
    // Appliquer htmlentities uniquement aux chaînes de caractères
    foreach ($film as $key => $value) {
        if (is_string($value)) {
            $film[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
        }
    }
    //----Pour une meilleure gestion des erreurs, le mode exception de PDO est activé et  l'exécution de la requête est enveloppée  dans un bloc try-catch :
    try {
        $cnx = connexionBdd();
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer les exceptions PDO et afficher les erreurs PDO de manière plus claire.
        //----------------------------------------------------------------------------
        $sql = "UPDATE films SET category_id = :category_id,title = :title,director = :director,actors = :actors,ageLimit = :ageLimit, duration =:duration,synopsis =:synopsis,date = :date, image = :image,price = :price, stock = :stock WHERE id_film = :id_film";
        // ---------Préparation et exécution de la requête
        $request = $cnx->prepare($sql);
        $request->execute($film); // Passer directement le tableau $film

    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du film : " . $e->getMessage();
        //-------- Enregistrer l'erreur dans les logs
        error_log("Erreur PDO : " . $e->getMessage());
    }
}

function filmByDate()
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films ORDER BY date DESC LIMIT 6";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();
    return $result;
}

function filmByCategory($id): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE category_id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
    $result = $request->fetchAll();
    return $result;
}
// calcul du montant total obsolete car on le fait dans le panier

// function calculMontant(array $tab)
// {
//     $montantTotal = 0;
//     foreach ($tab as $key) {
//         $montantTotal += $key['price'] * $key['quantity'];
//     }
//     return $montantTotal;
// }


function ajouterAuPanier($idFilm, $quantite, $title, $price, $image)
{
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = []; // Initialiser le panier s'il n'existe pas
    }

    if (isset($_SESSION['panier'][$idFilm])) {
        // Si le film est déjà dans le panier, augmenter la quantité
        $_SESSION['panier'][$idFilm]['quantity'] += $quantite;
    } else {
        // Sinon, ajouter le film au panier
        $_SESSION['panier'][$idFilm] = [
            'title' => $title,
            'price' => $price,
            'quantity' => $quantite,
            'image' => $image
        ];
    }
}

function createTableOrders()
{

    $cnx = connexionBdd();
    $sql = " CREATE TABLE IF NOT EXISTS orders (
         id_order INT PRIMARY KEY AUTO_INCREMENT,
         user_id INT NOT NULL,
         price FLOAT,
         created_at DATETIME,
         is_paid ENUM('0', '1')
    )";
    $request = $cnx->exec($sql);
}
createTableOrders();

function createTableOrderDetails()
{

    $pdo = connexionBdd();
    $sql = " CREATE TABLE IF NOT EXISTS order_details (
         order_id INT NOT NULL,
         film_id INT NOT NULL,
         price_film FLOAT NOT NULL,
         quantity INT NOT NULL
        
    )";
    $request = $pdo->exec($sql);
}
createTableOrderDetails();
// création une seule fois de la clé secondaire avec foreignKey('orders', 'user_id', 'users', 'id_user');

// création une seule fois de la clé secondaire sur order_details foreignKey('order_details', 'order_id', 'orders', 'id_order');

// fonction de creation de commande
function addOrder(int $user_id, float $price, string $created_at, string $is_paid): ?bool
{

    $cnx = connexionBdd();
    $sql = "INSERT INTO orders(user_id, price, created_at, is_paid) VALUES (:user_id, :price, :created_at, :is_paid)";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':user_id'     => $user_id,
        ':price'       => $price,
        ':created_at'  => $created_at,
        ':is_paid'     => $is_paid

    ));
    if ($request) {
        return true;
    }
}

function lastId(): array
{
    $pdo = connexionBdd();
    $sql = "SELECT MAX(id_order) AS lastId FROM orders";
    $request = $pdo->query($sql);
    $result = $request->fetch();
    return $result;
}

function addOrderDetails(int $orderId, int $filmId, float $filmPrice, int $quantity): void
{

    $pdo = connexionBdd();
    $sql = "INSERT INTO order_details(order_id, film_id, price_film, quantity) VALUES (:order_id, :film_id, :price_film,:quantity)";
    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':order_id'     => $orderId,
        ':film_id'      => $filmId,
        ':price_film'   => $filmPrice,
        ':quantity'     => $quantity,
    ));
}
