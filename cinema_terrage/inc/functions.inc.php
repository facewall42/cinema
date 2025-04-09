<?php
session_start();
//////////////////////// Constante pour définir le chemin du site ///////////////


define("RACINE_SITE", "http://cinema_terrage/");


/////////////////////////// Fonction alert /////////////////////////
function alert(string $contenu, string $class): string
{
    return
        "<div class=\"alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5\" role=\"alert\">
              
            $contenu
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
        
    </div>";
}

/////////////////////////// Fonction pour debuger /////////////////////////

function debug($var)
{

    echo '<pre class= "border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5">';
    var_dump($var);
    echo '</pre>';
}






/////////////////////////// Condition pour la déconnexion de l'utilisateur /////////////////////////
if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {

    unset($_SESSION['client']); // on supprime l'indice 'client' de la session  pour se déconnecter / cette fonction détruit les élément du tableau $_SESSION['client']

    // session_destroy();// La fonction session_destroy détruit toutes les données de la session déjà établie. Cette fonction détruit la session sur le serveur 
    header('location:' . RACINE_SITE . 'index.php');
}


///////////////////// Fonction pour la connexion à la BB ////////////////////

/*
    On va utiliser l'extension PHP Data Objects (PDO), elle définit une excellente interface pour accéder à une base de données depuis PHP et d'exécuter des requêtes SQL .Pour se connecter à la BDD avec PDO il faut créer une instance de cet Objet (PDO) qui représente une connexion à la base de donnée,  pour cela il faut se servir du constructeur de la classe
    Ce constructeur demande certains paramètres:
    On déclare des constantes d'environnement qui vont contenir les informations à la connexion à la BDD
*/


// // constante du serveur 
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
    //$dsn = mysql:host=localhost;dbname=entreprise;charset=utf8;
    $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";

    //Grâce à PDP on peut lever une exception (une erreur) si la connexion à la BDD ne se réalise pas(exp: suite à une faute au niveau du nom de la BDD) et par la suite si cette erreur est capté on lui demande d'afficher une erreur

    try { // dans le try on va instancier PDO, c'est créer un objet de la classe PDO (un élment de PDO)
        // Dans la variable dsn les constatntes d'environnement
        // $pdo = new PDO('mysql:host=localhost;dbname=entreprise;charset=utf8','root','');
        $pdo = new PDO($dsn, DBUSER, DBPASS);
        //On définit le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // POUR SAHAR:  cet atribut est à rajouter après le premier fetch en bas 
        //On définit le mode de "fetch" par défaut
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // je vérifie la connexion avec ma BDD avec un simple echo
        // echo "Je suis connecté à la BDD";
    } catch (PDOException $e) {  // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objetde la clase en question qui vas stocker cette erreur

        die("Erreur : " . $e->getMessage()); // die d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getmessage de l'objet $e
    }

    //le catch sera exécuter dès lors on aura un problème da le try

    return $pdo;
}
// À partir d'ici on est connecté à la BDD et la variable $pdo est l'objet qui représente la connexion à la BDD, cette variable va nous servir à effectuer les requêtes SQL et à interroger la base de données 


// debug($pdo);
//debug(get_class_methods($pdo)); // permet d'afficher la liste des méthodes présentes dans l'objet $pdo.






//////////////////////////////// Table catégories //////////////////
function createTableCategories(): void
{

    $cnx = connexionBdd();

    $sql =  "CREATE TABLE IF NOT EXISTS categories(
                id_categorie INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(50) NOT NULL,
                description TEXT NULL)   
            ";
    $request = $cnx->exec($sql);
}
// createTableCategories();

//////////////////////////////// Table films //////////////////
function createTableFilms(): void
{

    $cnx = connexionBdd();
    $sql =  "CREATE TABLE IF NOT EXISTS films(
                id_film INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                category_id INT(11) NOT NULL,
                title VARCHAR(100) NOT NULL,
                director VARCHAR(100) NOT NULL,
                actors VARCHAR(100) NOT NULL,
                ageLimit VARCHAR(5) NOT NULL,
                duration TIME NOT NULL,
                synopsis TEXT NOT NULL,
                image VARCHAR(100) NOT NULL,
                price FLOAT NOT NULL,
                stock BIGINT NOT NULL
                )";
    $request = $cnx->exec($sql);
}

// createTableFilms();

function createTableUsers(): void
{

    $cnx = connexionBdd();

    $sql = " CREATE TABLE IF NOT EXISTS users (
                id_user INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                firstName VARCHAR(50),
                lastName VARCHAR(50) NOT NULL,
                pseudo VARCHAR(50) NOT NULL,
                mdp VARCHAR(255) NOT NULL,
                email VARCHAR(100) NOT NULL,
                phone VARCHAR(30) NOT NULL,
                civility ENUM('f', 'h') NOT NULL,
                birthday date NOT NULL,
                address VARCHAR(50) NOT NULL,
                zip VARCHAR(50) NOT NULL,
                city VARCHAR(50) NOT NULL,
                country VARCHAR(50),
                role ENUM('ROLE_USER','ROLE_ADMIN') DEFAULT 'ROLE_USER' 
             )";
    $request = $cnx->exec($sql);
}

// createTableUsers();

################################# Création des clés étrangères  ###########################

//  ALTER TABLE films ADD FOREIGN KEY category_id REFERENCES categories id_categorie -> remplacé par id_category

function foreignKey(string $tableFK, string $keyFK, string $tablePK, string $keyPK): void
{

    $cnx = connexionBdd();
    $sql = " ALTER TABLE $tableFK ADD FOREIGN KEY ($keyFK) REFERENCES $tablePK ($keyPK)";

    $request = $cnx->exec($sql);
}

/// Création de la clé étrangère dans la table films 
// je modifie id_categorie en id_category ici pour que ca corresponde à ma table categories
foreignKey('films', 'category_id', 'categories', 'id_category');


/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                UTILISATEURS                 ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/


//////////////////////////// Fonction d'ajout d'un utilisateur ///////////////////////

function addUser(string $lastName, string $firstName, string $pseudo, string $email, string $phone, string $mdp, string $civility, string $birthday, string $address, string $zip, string $city, string $country): void
{

    // Créer un tableau associatif avec les noms des colonnes de la table users comme clés
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
    // $data['firstName'] = htmlspecialchars($firstName)


    foreach ($data as $key => $value) {

        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        /* 
            htmlspecialchars est une fonction qui convertit les caractères spéciaux en entités HTML, cela est utilisé afin d'empêcher l'exécution de code HTML ou JavaScript : les attaques XSS (Cross-Site Scripting) injecté par un utilisateur malveillant en échappant les caractères HTML /////////////potentiellement dangereux . Par défaut, htmlspecialchars échappe les caractères suivants :

            & (ampersand) devient &amp;
            < (inférieur) devient &lt;
            > (supérieur) devient &gt;
            " (guillemet double) devient &quot;

            ENT_QUOTES : est une constante en PHP  qui convertit les guillemets simples et doubles. 
            => ' (guillemet simple) devient &#039; 
            'UTF-8' : Spécifie que l'encodage utilisé est UTF-8.

            */
    }

    $cnx = connexionBdd();


    /* Les requêtes préparer sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez au SGBD de répéter toutes les phases analyse/ interpretation / exécution de la requête (gain de performance). Les requêtes préparées sont aussi utilisées pour nettoyer les données et se prémunir des injections de type SQL.

                    1- On prépare la requête
                    2- On lie le marqueur à la requête
                    3- On exécute la requête 

    */

    $sql = "INSERT INTO users (lastName, firstName, pseudo, email, phone, mdp, civility, birthday, address, zip, city, country) VALUES (:lastName, :firstName, :pseudo, :email, :phone, :mdp, :civility, :birthday, :address, :zip, :city, :country)";
    //(?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)

    $request = $cnx->prepare($sql);  //prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur :firstName qui est vide et attend une valeur.
    // $request->execute(array(
    //     ':lastName' =>$data['lastName'],
    //     ':firstName' =>$data['firstName'],
    //     ':pseudo' =>$data['pseudo'],
    //     ':email' =>$data['email'],
    //     ':phone' =>$data['phone'],
    //     ':mdp' =>$data['mdp'],
    //     ':civility' =>$data['civility'],
    //     ':birthday' =>$data['birthday'],
    //     ':address' =>$data['address'],
    //     ':zip' =>$data['zip'],
    //     ':city' =>$data['city'],
    //     ':country' =>$data['country']

    // ));

    $request->execute($data);
}

function checkEmailUser(string $email): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT email FROM users WHERE email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':email' => $email
    ));
    $result = $request->fetch();

    return $result;
}

function checkPseudoUser(string $pseudo): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT pseudo FROM users WHERE pseudo = :pseudo";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo
    ));
    $result = $request->fetch();

    return $result;
}

function checkUser(string $pseudo, string $email): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users WHERE pseudo = :pseudo AND email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo,
        ':email' => $email
    ));
    $result = $request->fetch();

    return $result;
}

// Fonction pour récupérer tout les utilisateurs
function allUsers(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // on récupére toute les lignes à la fois
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

function deleteUser(int $id): void
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM users WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':id' => $id

    ));
}

/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                CATEGORIES                ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/

function showCategory(string $name): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE name = :name";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":name" => $name

    ));
    $result = $request->fetch();
    return $result;
}

function addCategory(string $name, string $description): void
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

function updateCategory(int $id, string $name, string $description): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE categories  SET name = :name, description = :description WHERE id_category = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':id' => $id,
        ':name' => $name,
        ':description' => $description
    ));
}

//////////////////////////////////////// Une fonction pour récupérer toutes les catégories //////////////////////////////////////////////

function allCategories(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories"; // requête d'insertion que je stock dans une variable
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // j'utilise fetchAll() pour récupérer toute les ligne à la fois 
    return $result; // ma fonction retourne un tableau ave les données récupérer de la BDD
}
function showCategoryViaId(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":id" => $id
    ));
    $result = $request->fetch();
    return $result;
}





function verifFilm(string $title, string $date): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE title = :title AND date = :date";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':title' => $title,
        ':date' => $date
    ));
    $result = $request->fetch();
    return $result;
}

function addFilms(string $title, string $director, string $actors, string $ageLimit, string $duration, string $synopsis, string $date, float $price, int $stock, string $image, int $id_category): void
{

    $cnx = connexionBdd();

    $data = [
        'title' => $title,
        'director' => $director,
        'actors' => $actors,
        'ageLimit' => $ageLimit,
        'duration' => $duration,
        'synopsis' => $synopsis,
        'date' => $date,
        'price' => $price,
        'stock' => $stock,
        'image' => $image,
        'category_id' => $id_category

    ];

    // echapper les données et les traiter contre les failles JS (XSS) 
    foreach ($data as $key => $value) {

        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $sql = "INSERT INTO films (title,  director,  actors,  ageLimit,  duration,  synopsis,  date,  price, stock,  image, category_id) VALUES (:title,  :director,  :actors,  :ageLimit,  :duration,  :synopsis,  :date,  :price, :stock,  :image, :category_id)"; // requête d'insertion que je stock dans une variable
    $request = $cnx->prepare($sql); // je prépare ma fonction et je l'exécute
    $request->execute($data);
}

function allFilms(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM films"; // requête d'insertion que je stock dans une variable
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // j'utilise fetchAll() pour récupérer toute les ligne à la fois 
    return $result; // ma fonction retourne un tableau avec les données récupérer de la BDD
}

function stringToArray(string $string): array
{

    $array = explode('/', trim($string, '/')); // Je transforme ma chaîne de caractére en tableau et je supprime les / autour de la chaîne de caractére 
    return $array; // ma fonction retourne un tableau

}

function deleteFilm(int $id): void
{

    $cnx = connexionBdd();
    $sql = "DELETE FROM films WHERE id_film = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
}


function showFilmViaId(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE id_film = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
    $result = $request->fetch();
    return $result;
}

function updateFilm(string $title, string $director, string $actors, string $ageLimit, string $duration, string $synopsis, string $date, float $price, int $stock, string $image, int $id_category, int $id_film): void
{

    $cnx = connexionBdd();

    $data = [
        'title' => $title,
        'director' => $director,
        'actors' => $actors,
        'ageLimit' => $ageLimit,
        'duration' => $duration,
        'synopsis' => $synopsis,
        'date' => $date,
        'price' => $price,
        'stock' => $stock,
        'image' => $image,
        'category_id' => $id_category,
        'id_film' => $id_film

    ];

    // echapper les données et les traiter contre les failles JS (XSS) 
    foreach ($data as $key => $value) {

        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $sql = "UPDATE films SET title = :title,  director = :director,  actors = :actors,  ageLimit = :ageLimit,  duration = :duration,  synopsis = :synopsis,  date = :date,  price = :price, stock = :stock ,  image =  :image, category_id = :category_id WHERE id_film = :id_film"; // requête d'insertion que je stock dans une variable

    $request = $cnx->prepare($sql); // je prépare ma fonction et je l'exécute
    $request->execute(array(
        ':title' => $data['title'],
        ':director' => $data['director'],
        ':actors' => $data['actors'],
        ':ageLimit' => $data['ageLimit'],
        ':duration' => $data['duration'],
        ':synopsis' => $data['synopsis'],
        ':date' => $data['date'],
        ':price' => $data['price'],
        ':stock' => $data['stock'],
        ':image' => $data['image'],
        ':category_id' => $data['category_id'],
        ':id_film' => $data['id_film']

    ));
}


function filmByDate(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM films ORDER BY date DESC LIMIT 6";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();
    return $result;
}

function filmsByCategory($id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE  category_id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
    $result = $request->fetchAll();
    return $result;
}
