<?php
$pdoEntreprise = new PDO(
    'mysql:host=localhost;dbname=entreprise', // Définition du type de SGBD, de l’hôte (ici localhost) et du nom de la BDD
    'root',                                    // Nom d’utilisateur pour se connecter à la BDD
    '',                                        // Mot de passe pour se connecter (vide ici en local)
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,                        // Affichage des erreurs sous forme d'avertissements (warnings)
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',                // Encodage des échanges avec la BDD en UTF-8
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,                // Mode de récupération des résultats : tableau associatif
    )
);


/* 
    Explication :
    - "new" est un mot-clé en PHP qui permet d'instancier un nouvel objet.
    - L’objet instancié ici est PDO (PHP Data Object), un objet qui permet la connexion à une base de données.
    - Dans la première chaîne de connexion (ligne 7), on précise le type de base (MySQL), l’hôte (localhost), et le nom de la BDD.
    - La deuxième ligne correspond au nom d’utilisateur pour la connexion (ici "root").
    - La troisième ligne indique le mot de passe (vide ici car on est en local).
    - Le tableau associatif passé en quatrième paramètre permet de :
        - Afficher les erreurs en tant qu'avertissements (pratique pour le développement)
        - Définir l’encodage des caractères en UTF-8 dès l’ouverture de la connexion
        - Récupérer les données sous forme de tableau associatif par défaut (plus lisible)

    Cette variable de connexion est souvent placée dans un fichier séparé, par exemple init.inc.php, qui servira de fichier d'initialisation.
    On pourra ensuite inclure ce fichier dans toutes les pages qui nécessitent une connexion à la BDD.

    Il est essentiel d’utiliser cette variable ($pdoEntreprise) à chaque fois qu’on souhaite interagir avec la base de données.
*/

function debug($mavariable)
{
    echo "<pre class=\"alert alert-info\">";
    var_dump($mavariable);
    echo "</pre>";
}
