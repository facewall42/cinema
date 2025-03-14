<!-- fichier qui contient les fonctions php à utiliser dans notre site -->
<?php

session_start(); //lance la session 
//////////////////////////////////// constante pour définir le chemin du site /////////////////////////////////////////////////////////

 // constante qui définit les dossiers dans lesquels se situe le site pour pouvoir déterminer des chemins absolus à partir de localhost. Ainsi nous écrivons tous les chemins (exp : src, href ) en absolu avec cette constante

 define('RACINE_SITE', 'http://localhost/site_cinema/');
 
##################################### Fonction pour debugger #############################

function debug($var){
        echo '<pre class="border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5">';
            var_dump($var);
        echo '</pre>';
}

##################################### Fonction d'alerte #############################

function alert(string $contenu, string $class) : string {
    return
        "<div class=\"alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5\" role=\"alert\">
                $contenu
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
        </div>";

}


function stringToArray(string $string ) :array{
    
    $array = explode('/', trim($string, '/')); // Je transforme ma chaîne de caractères en tableau et je supprime les / autour de la chaîne de caractères 
    return $array; // ma fonction retourne un tableau

}

###################################### Fonction pour la deconnexion ################################
// on n'est pas obligé de creer la fonction et juste mettre la condition 

function logOut(){
    if (isset($_GET['action']) && $_GET['action'] == "deconnexion") {
        unset($_SESSION['client']); // unset ne detruit que l'indice client de la session 
// session destroy detruit les 2 clés utilisateur et panier.... 
        header('location:'.RACINE_SITE.'index.php');
    }
}
logOut();

##################################### Fonction pour la connexion à la BDD #############################

// On va utiliser l'extension PHP Data Objects (PDO), elle définit une excellente interface pour accéder à une base de données depuis PHP et d'exécuter des requêtes SQL .
// Pour se connecter à la BDD avec PDO il faut créer une instance de cet Objet (PDO) qui représente une connexion à la base, pour cela il faut se servir du constructeur de la classe
// Ce constructeur demande certains paramètres:
// On déclare des constantes d'environnement qui vont contenir les informations à la connexion à la BDD

        // constante du serveur => localhost
        define("DBHOST", "localhost");

        // constante de l'utlisateur de la BDD du serveur en local => root

        define("DBUSER", "root");

        // contante pour le mot de pase de serveur en local => pas de mot de passe
        define("DBPASS", "");

        // constante pour le nom de la BDD

        define("DBNAME", "cinema");


    function connexionBdd() {

            //DSN (Data Source Name)
           // $dsn = mysql:host=localhost;dbname=cinema;charset=utf8;
            $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8";

            //Grâce à PDO on peut lever une exception (une erreur) si la connexion à la BDD ne se réalise pas(exp: suite à une faute au niveau du nom de la BDD) et par la suite si cette erreur est captée, on lui demande d'afficher une erreur

            try {// dans le try on vas instancier PDO, c'est créer un objet de la classe PDO (un élément de PDO)
                // avec la variable dsn et les constantes d'environnement

                $pdo = new PDO($dsn, DBUSER, DBPASS);
                

            //On définit le mode d'erreur de PDO sur Exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // FETCH_ASSOC fait que juste necessaire fetch()


            } catch(PDOException $e) {  // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objet de la classe en question qui va stocker cette erreur

                die("Erreur : " . $e->getMessage()); // die permet d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getMessage de l'objet $e
            }

            //le catch sera exécuté dès lors que l'on aura un problème dans le try

            return $pdo;  //ici on utilise un return car on récupère l'objet de la fonction que l'on vas appelé  dans plusieurs autre fonctions

    }


     ################################# Création des tables  ###########################
    //Table cree la table commande

    function createTableOrders(){

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
    // createTableOrders();
    // foreignKey('orders', 'user_id', 'users', 'id_user');

    //-----------------------------Table catégories----------------------------------

        function createTableCategories(){

            $cnx = connexionBdd();

            $sql = "CREATE TABLE IF NOT EXISTS categories (
                id_category INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(50) NOT NULL,
                description TEXT NULL
                )";

                $request = $cnx->exec($sql);
        }

        // createTableCategories();


        // exercice de crea d'une deuxieme table---------------

        function createTableFilms2(){

            $cnx = connexionBdd();

            $sql = "CREATE TABLE IF NOT EXISTS films2 (
                id_film INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                category_id INT(11) NOT NULL,
                title VARCHAR(100) NOT NULL,
                director VARCHAR(100) NOT NULL,
                actors VARCHAR(100) NOT NULL,
                ageLimit VARCHAR(5) NULL,
                duration TIME NOT NULL,
                synopsis TEXT NOT NULL,
                date DATE NOT NULL,
                image VARCHAR(250) NOT NULL,
                price FLOAT NOT NULL,
                stock BIGINT NOT NULL

                )";

                $request = $cnx->exec($sql);
        }
       // createTableFilms2();
//--------------------------------------------------------------------------------------------

    // Table films
        function createTableFilms(){

            $cnx = connexionBdd();

            $sql = " CREATE TABLE IF NOT EXISTS films (
                    id_film INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    category_id INT(11) NOT NULL,
                    title VARCHAR(100) NOT NULL,
                    director VARCHAR(100) NOT NULL,
                    actors VARCHAR(100) NOT NULL,
                    ageLimit VARCHAR(5) NULL,
                    duration TIME NOT NULL,
                    synopsis TEXT NOT NULL,
                    date DATE NOT NULL,
                    image VARCHAR(250) NOT NULL,
                    price Float NOT NULL,
                    stock BIGINT NOT NULL
                    )";
            $request = $cnx ->exec($sql);

       }
    //    createTableFilms();

    // Table users

     function createTableUsers(){

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

        //  createTableUsers();


                    ################################# Création des clés étrangères  ###########################

                    // ALTER TABLE ORDERS ADD FOREIGN KEY (Customer_SID) REFERENCES CUSTOMER (SID);

        // $tableF : table où on va créer la clé étrangère
        // $tableP : table à partir de laquelle on récupère la clé primaire
        // $keyF : la clé étrangère
        // $keyP :  la clé primaire


        function foreignKey( string $tableF, string $keyF, string $tableP, string $keyP) {

            $cnx = connexionBdd();
            $sql ="ALTER TABLE $tableF ADD FOREIGN KEY ($keyF) REFERENCES $tableP ($keyP)";
            // $sql ="ALTER TABLE films ADD FOREIGN KEY (category_id) REFERENCES categories (id_category)";
            $request = $cnx->exec($sql);
        }


        // Création de la clé étrangère dans la table films
        // foreignKey('films', 'category_id', 'categories', 'id_category');

//----------------------------exercice de raccordement de film2 avec fonction similaire -----------------------
        function foreignKey2( string $tableFK, string $keyFK, string $tablePK, string $keyPK) {

            $cnx = connexionBdd();
            $sql ="ALTER TABLE $tableFK ADD FOREIGN KEY ($keyFK) REFERENCES $tablePK ($keyPK)";
            $request = $cnx->exec($sql);
        }
       // foreignKey('films2', 'category_id', 'categories', 'id_category');

//---------------------------------------------------------------------------------------------------------------


/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                UTILISATEURS                 ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/
          ################################# Fonctons du CRUD pour les utilisateurs ###########################

           // Inscription

function addUser(string $lastName, string $firstName, string $pseudo, string $email,  string $phone, string $mdp, string $civility, string $birthday, string $address, string $zip, string $city, string $country) : void{
    
    // Créer un tableau associatif avec les noms des colonnes de la table users comme clés
    // Les noms des clés du tableau $data correspondent aux noms des colonnes dans la base de données.
    // attention le parametre $mdp dans le prototypage doit aller chercher le mdpHashé
            
            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'pseudo' => $pseudo,
                'mdp' => $mdp,
                'email' => $email,
                'phone' => $phone,
                'civility' => $civility,
                'birthday' => $birthday,
                'address' => $address,
                'zip' => $zip,
                'city' => $city,
                'country' => $country
            ];

             //echapper les données et les traiter contre les failles JS (XSS)
// La boucle va gerer chaque champs :  //$data['lastName'] = htmlspecialchars($lastName) ...
 /* 
            htmlspecialchars est une fonction qui convertit les caractères spéciaux en entités HTML, cela est utilisé afin d'empêcher l'exécution de code HTML ou JavaScript : les attaques XSS (Cross-Site Scripting) injecté par un utilisateur malveillant en échappant les caractères HTML potentiellement dangereux . Par défaut, htmlspecialchars échappe les caractères suivants :

            & (ampersand) devient &amp;
            < (inférieur) devient &lt;
            > (supérieur) devient &gt;
            " (guillemet double) devient &quot;

        */
/*
            ENT_QUOTES : est une constante en PHP  qui convertit les guillemets simples et doubles. => ' (guillemet simple) devient &#039; 
            'UTF-8' : Spécifie que l'encodage utilisé est UTF-8.
        */

             foreach ($data as $key => $value) {
                $data[$key] =htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                

               // $data[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8'); visiblement cest deprecated ???lol
            }
    
    
    $cnx = connexionBdd();
    $sql = "INSERT INTO users
            (lastName, firstName, pseudo, email, phone, mdp, civility, birthday, address, zip, city, country) VALUES (:lastName, :firstName, :pseudo, :email, :phone, :mdp, :civility, :birthday, :address, :zip, :city, :country)";

            // (?,?,?,?,?,?,?,?,?,?,?,?) variante des (:

            /* Les requêtes préparées sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez au SGBD de répéter toutes les phases analyse/ interpretation / exécution de la requête (gain de performance). Les requêtes préparées sont aussi utilisées pour nettoyer les données et se prémunir des injections de type SQL.

                    1- On prépare la requête avec INSERT INTO .......
                    2- On lie le marqueur à la requête
                    3- On exécute la requête

            */
            $request = $cnx->prepare($sql); //prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur :firstName qui est vide et attend une valeur.
            //LA REQUEST SUIVANTE EST REDONDANTE AVEC $DATA ! 
            // $request->execute(array( 
            //     // Le tableau associatif contient les valeurs échappées à insérer dans la base de données, associées aux paramètres nommés de la requête préparée.
            //     ':firstName' => $data['firstName'],
            //     ':lastName' => $data['lastName'],
            //     ':pseudo' => $data['pseudo'],
            //     ':mdp' => $data['mdp'],
            //     ':email' => $data['email'],
            //     ':phone' => $data['phone'],
            //     ':civility' => $data['civility'],
            //     ':birthday' => $data['birthday'],
            //     ':address' => $data['address'],
            //     ':zip' => $data['zip'],
            //     ':city' => $data['city'],
            //     ':country' => $data['country'],
            // )); 
            // execute() permet d'exécuter toute la requête préparée avec prepare().
            $request->execute($data);
}

      


       //----------------------A VIRER -----------------------------------------------------------------------------------

     /*   function inscriptionUsers(string $lastName, string $firstName, string $pseudo, string $email,  string $phone, string $mdp, string $civility, string $birthday, string $address, string $zip, string $city, string $country) : void{

            /* Les requêtes préparées sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez au SGBD de répéter toutes les phases analyse/ interpretation / exécution de la requête (gain de performance). Les requêtes préparées sont aussi utilisées pour nettoyer les données et se prémunir des injections de type SQL.

                    1- On prépare la requête
                    2- On lie le marqueur à la requête
                    3- On exécute la requête

            */
            // Créer un tableau associatif avec les noms des colonnes comme clés
            // Les noms des clés du tableau $data correspondent aux noms des colonnes dans la base de données.
            /*
            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'pseudo' => $pseudo,
                'mdp' => $mdp,
                'email' => $email,
                'phone' => $phone,
                'civility' => $civility,
                'birthday' => $birthday,
                'address' => $address,
                'zip' => $zip,
                'city' => $city,
                'country' => $country
            ];

            //echapper les données et les traiter contre les failles JS (XSS)
            foreach ($data as $key => $value) {
                $data[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
            }
            /* 
            htmlspecialchars est une fonction qui convertit les caractères spéciaux en entités HTML, cela est utilisé afin d'empêcher l'exécution de code HTML ou JavaScript : les attaques XSS (Cross-Site Scripting) injecté par un utilisateur malveillant en échappant les caractères HTML potentiellement dangereux . Par défaut, htmlspecialchars échappe les caractères suivants :

            & (ampersand) devient &amp;
            < (inférieur) devient &lt;
            > (supérieur) devient &gt;
            " (guillemet double) devient &quot;*/

        /*
            ENT_QUOTES : est une constante en PHP  qui onvertit les guillemets simples et doubles. => ' (guillemet simple) devient &#039; 
            'UTF-8' : Spécifie que l'encodage utilisé est UTF-8.
        
            $cnx = connexionBdd();

            // on prépare la requête
            $sql = "INSERT INTO users
            (lastName, firstName, pseudo, email, phone, mdp, civility, birthday, address, zip, city, country) VALUES (:lastName, :firstName, :pseudo, :email, :phone, :mdp, :civility, :birthday, :address, :zip, :city, :country)";

            $request = $cnx->prepare($sql); //prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur :firstName qui est vide et attend une valeur.
            // $requet est à cette ligne  encore un objet PDOstatement .
            $request->execute(array( 
                // Le tableau associatif contient les valeurs échappées à insérer dans la base de données, associées aux paramètres nommés de la requête préparée.
                ':firstName' => $data['firstName'],
                ':lastName' => $data['lastName'],
                ':pseudo' => $data['pseudo'],
                ':mdp' => $data['mdp'],
                ':email' => $data['email'],
                ':phone' => $data['phone'],
                ':civility' => $data['civility'],
                ':birthday' => $data['birthday'],
                ':address' => $data['address'],
                ':zip' => $data['zip'],
                ':city' => $data['city'],
                ':country' => $data['country'],
            ));// execute() permet d'exécuter toute la requête préparée avec prepare().

        } */

///////////////////////////////////////////////// Une fonction pour verifier si un email existe dans la BDD //////////////////////////////////////



function checkEmailUser(string $email) : mixed{
    $cnx = connexionBdd();
    $sql = "SELECT email FROM users WHERE email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(':email' => $email));

    $result = $request->fetch();

    // $result = $request->fetch(PDO::FETCH_ASSOC); //fetch assoc pas necessaire voir ligne 84 ? declaration du PDO fetch transforme un objet en tableau. 
    
    return $result;}

    //Le paramètre  PDO::FETCH_ASSOC permet de transformer l'objet en un array ASSOCIATIF.On y trouve en indices le nom des champs de la requête SQL.
    /**
     * Pour informatrion, on peut mettre dans les parenthése de fecth()
     *  PDO::FETCH_NUM pour obtenir un tableau aux indices numèrique
     * PDO::FETCH_OBJ pour obtenir un dernier objet
     * ou encore des () vides pour obtenir un mélange de tableau associatif et indéxé
     */


function checkPseudo(string $pseudo) :mixed{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM users WHERE pseudo = :pseudo";
    $request = $cnx->prepare($sql);
    $request->execute(array(':pseudo' => $pseudo));
    $result = $request->fetch();
    return $result;
    // On peut éviter de mettre cette constante comme paramètre de la mèthode fetch() à chaque fois en la définissant dans la connexion de la BDD par défaut (dans le try de la connexion à la BDD -> voir fonction connexionBdd())
}
// on selecte * donc on a tout y compris le mdp. 
function checkUser(string $pseudo, string $email) : mixed{
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
////////////////////////////////////fonction pour récuperer tout les utilisateur///////////////////////////////

function allUsers() :mixed{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users";
    $request = $cnx->query($sql); //query suffit pour recuperer les données plutot que la methode prepare
    $result = $request->fetchAll(); // fetchAll() récupère tout les résultats dans la reqûête et les sort sous forme d'un tableau à 2 dimensions
    return $result;
}

////////////////////////////////////fonction pour récuperer tout les utilisateur///////////////////////////////

function deletUser(int $id_user):void{
    $cnx = connexionBdd();
    $sql ="DELETE FROM users WHERE id_user = :id_user  ";
    $request = $cnx->prepare($sql);
    $request->execute(array(":id_user" => $id_user));
}

#######################"Fonction du CRUD pour les categories###############################


function showCat(int $name):mixed{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE name = :name";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':name' => $name
    ));
    $result = $request->fetch();
    return $result;
}
function showCatviaID(int $name):mixed{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_category = :id_category";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_category' => $name
    ));
    $result = $request->fetch();
    return $result;
}




function allcat() :mixed{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // fetchAll() récupère tout les résultats dans la reqûête et les sort sous forme d'un tableau à 2 dismensions
    return $result;
}


function addCategories($name ,$description):void{
    $cnx = connexionBdd();
    $sql ="INSERT INTO categories (name, description) VALUES (:name , :description)";
    $request = $cnx->prepare($sql);
    $request->execute(array(":name" => $name , ":description" => $description));
}


function deletcat(int $idcat):void{
    $cnx = connexionBdd();
    $sql ="DELETE FROM categories WHERE id_category = :id  ";
    $request = $cnx->prepare($sql);
    $request->execute(array(":id" => $idcat));
}







function updateRole(string $role, int $id) :void{
    $cnx = connexionBdd();
    $sql = "UPDATE users SET role = :role WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':role' => $role,
        ':id_user' => $id
    ));
}


function showUser(int $id) :mixed {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM users WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_user' => $id
    ));
    $result = $request->fetch();
    return $result;
}



function update(int $idcat, string $name, string $description):void{
    $cnx = connexionBdd();
    $sql ="UPDATE categories SET name = :name , description = :description WHERE id_category = :id_user";
    $request = $cnx->prepare($sql);
    $request->execute(array(":id_user" => $idcat , ":name" => $name , ":description" => $description));
}

########################## film ##############################

function addfilm($idcat ,$title ,$director ,$actors ,$age ,$duration ,$synopsis ,$date ,$price ,$stock , $image){
    $cnx = connexionBdd();
    $sql ="INSERT INTO films (category_id ,title, director ,actors ,ageLimit , duration ,synopsis ,date ,image ,price ,stock  ) VALUES (:category_id ,:title, :director ,:actors ,:ageLimit , :duration ,:synopsis ,:date ,:image ,:price ,:stock )";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":category_id" => $idcat,
        ":title" => $title , 
        ":director" => $director,
        ":actors" => $actors , 
        ":ageLimit" => $age,
        ":duration" => $duration , 
        ":synopsis" => $synopsis,
        ":date" => $date ,
        ":price" => $price,
        ":stock" => $stock,
        ":image" => $image
        
        // ":image" => $image, 

    
    ));
}



function deletfilm(int $id):void{
    $cnx = connexionBdd();
    $sql ="DELETE FROM films WHERE id_film = :id  ";
    $request = $cnx->prepare($sql);
    $request->execute(array(":id" => $id));
}




function updateFilm(int $id_film,int $category_id,string $title,string $director,string $actors,string $ageLimit,string $duration,string $synopsis,string $date,string $image,float $price,int $stock):void{
    $film = [
      'id_film'=> $id_film,
      'category_id'=>$category_id,
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
  foreach($film as $key => $value){
      $film[$key] = htmlentities($value,ENT_QUOTES,'UTF-8');
  }
    $cnx=connexionBdd();
    $sql = "UPDATE films SET category_id = :category_id,title = :title,director = :director,actors = :actors,ageLimit = :ageLimit, duration =:duration,synopsis =:synopsis,date = :date, image = :image,price = :price, stock = :stock WHERE id_film = :id_film";
    $request = $cnx->prepare($sql);
    $request ->execute(array(
                                ":id_film" => $film['id_film'],
                                ":category_id" => $film['category_id'],
                                ":title"=> $film['title'], 
                                ":director"=>$film['director'], 
                                ":actors"=>$film['actors'], 
                                ":ageLimit"=>$film['ageLimit'],
                                ":duration"=>$film['duration'],
                                ":synopsis"=>$film['synopsis'],
                                ":date"=>$film['date'],
                                ":image"=>$film['image'],
                                ":price"=>$film['price'],
                                ":stock"=>$film['stock']

    ));
  }

function allfilm() :mixed{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); // fetchAll() récupère tout les résultats dans la reqûête et les sort sous forme d'un tableau à 2 dismensions
    return $result;
}

function verifFilm($title ,$date){
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE title = :id_category AND date = :date";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_category' => $title,
        ':date'=> $date
    ));
    $result = $request->fetch();
    return $result;
}

function showfilmviaID(int $name):mixed{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE id_film = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $name
    ));
    $result = $request->fetch();
    return $result;
}

function filmByDate(){
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films ORDER BY date DESC LIMIT 6";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();
    return $result;
}

function filmbycategory($id) :mixed{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM films WHERE category_id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
    $result = $request->fetchAll();
    return $result;
}
// calcul du montant total

function calculmontant(array $tab){
    $montantTotal = 0;
    foreach ($tab as $key) {
        $montantTotal += $key['price'] * $key['quantity'];
    }
    return $montantTotal;
}


function addOrder(int $user_id, float $price, string $created_at, string $is_paid) :bool {

    $pdo = connexionBdd();
     $sql = "INSERT INTO orders(user_id, price, created_at, is_paid) VALUES (:user_id, :price, :created_at, :is_paid)";
     $request = $pdo->prepare($sql);
     $request->execute(array( 
          ':user_id'     =>$user_id,
          ':price'       =>$price, 
          ':created_at'  =>$created_at, 
          ':is_paid'     =>$is_paid
         
          ));
        if($request){
            return true;
        }else return false;
}


function lastId(): array{
    $pdo = connexionBdd();
    $sql = "SELECT MAX(id_order) AS lastId FROM orders";
    $request= $pdo->query($sql);
    $result= $request->fetch();
    return $result;

}

function addOrderDetails(int $orderId, int $filmId, float $filmPrice, int $quantity) :void{

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

function createTableOrderDetails(){

    $pdo = connexionBdd();
    $sql = " CREATE TABLE IF NOT EXISTS order_details (
         order_id INT NOT NULL,
         film_id INT NOT NULL,
         price_film FLOAT NOT NULL,
         quantity INT NOT NULL
        
    )";
    $request = $pdo->exec($sql);

}
// createTableOrderDetails();
// foreignKey('order_details','film_id','films','id_film');

?>
