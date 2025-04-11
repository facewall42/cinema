<?php
session_start(); // on appelle la fonction session_start() pour pouvoir utiliser les variables de session
// constante pour définir le chemin du site :
define("RACINE_SITE", "http://localhost/php_evaluation_bourgeois/");
// Constante du serveur
define("DBHOST", "localhost");
// constante de l'utilisateur de la BDD du serveur en local => root
define("DBUSER", "root");
// constante pour le mot de passe de serveur en local => pas de mot de passe
define("DBPASS", "");
// Constante pour le nom de la BDD
define("DBNAME", "php_evaluation_bourgeois");



// 2 Fonctions utilitaires : 
// Fonction d'alert
function alert(string $contenu, string $class): string
{
    return "<div class=\"alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5\" role=\"alert\">
    $contenu
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
}

// Fonction de debug
function debug($mavariable)
{
    echo "<pre class=\"alert alert-info\">";
    var_dump($mavariable);
    echo "</pre>";
}

// Connexion a la base de donnees (selon site cinéma de Sahar mais revue par moi)
function connexionBdd(): PDO
{
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // Désactive l'émulation des requêtes préparées
        PDO::ATTR_TIMEOUT            => 5, // Timeout de 5 secondes
    ];

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=utf8mb4',
        DBHOST,
        DBNAME
    );

    try {
        return new PDO($dsn, DBUSER, DBPASS, $options);
    } catch (PDOException $e) {
        // methode qui evite un die (un peu brutal) et affiche l'erreur
        throw new PDOException(
            "Impossible de se connecter à la base de données. Veuillez réessayer plus tard.",
            0,
            $e
        );
    }
}

// Création de la table annonces (selon site cinéma de Sahar)
function createTableAnnonces(): void
{
    // Connexion à la BDD et création de la table
    $cnx = connexionBdd();
    $sql = "CREATE TABLE IF NOT EXISTS advert(
                                            id_advert INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
                                            photo VARCHAR(250) NOT NULL, 
                                            title VARCHAR(100) NOT NULL, 
                                            description TEXT NOT NULL, 
                                            postal_code VARCHAR(5) NOT NULL, 
                                            city VARCHAR(100) NOT NULL, 
                                            type ENUM('location', 'vente') NOT NULL, 
                                            price FLOAT NOT NULL, 
                                            reservation_message TEXT NULL
                                                )";

    $request2 = $cnx->exec($sql);
}
// Création de la table annonces , si elle n'existe pas elle sera implémentée
createTableAnnonces();

// création de la fonction addAdvert qui permet de faire une requête SQL INSERT (selon site cinéma de Sahar)

function addAdvert($photo, $title, $description, $postal_code, $city, $type, $price, $reservation_message): void
{
    $cnx = connexionBdd();
    $sql = "INSERT INTO advert (photo, title, description, postal_code, city, type, price, reservation_message) 
    VALUES (:photo, :title, :description, :postal_code, :city, :type, :price, :reservation_message)";
    $data = [
        ":photo" => $photo,
        ":title" => $title,
        ":description" => $description,
        ":postal_code" => $postal_code,
        ":city" => $city,
        ":type" => $type,
        ":price" => $price,
        ":reservation_message" => $reservation_message
    ];

    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    $request = $cnx->prepare($sql);
    $request->execute($data);
}

// requete de recupération des annonces 
function getAdverts(): array
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM advert";
    $request = $cnx->query($sql);
    return $request->fetchAll();
}
// requete de recupération des annonces par id
function getAdvert(int $id): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM advert WHERE id_advert = :id";
    $request = $cnx->prepare($sql);

    $request->execute(array(
        ':id' => $id,
    ));
    $result = $request->fetch();
    return $result;
}
// requete de mise à jour des annonces
function updateReservation($id_annonce, $message)
{
    $cnx = connexionBdd();
    $sql = "UPDATE advert SET reservation_message = :message WHERE id_advert = :id";
    $request = $cnx->prepare($sql);
    // comme on utilise 2 parametres, on peut aussi faire des bindValue
    $request->bindValue(':message', $message, PDO::PARAM_STR);
    $request->bindValue(':id', $id_annonce, PDO::PARAM_INT);
    return $request->execute();
}
