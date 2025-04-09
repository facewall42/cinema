<?php

require_once 'config/config.php';
class Database
{
    private $pdo;

    public function connect()
    {
        try {
            $this->pdo = new PDO(

                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            //PDO::ATTR_DEFAULT_FETCH_MODE	PDO::FETCH_ASSOC	Résultats en tableau associatif.
            //Définit le mode de récupération par défaut des résultats de requêtes SQL pour qu'ils soient retournés sous forme de tableaux associatifs (["colonne" => "valeur"]).
            //// Avec FETCH_ASSOC
            // $row = $stmt->fetch(); // Retourne ["id" => 1, "nom" => "Alice"]
            //echo $row["nom"]; // "Alice"

        } catch (PDOEXception $e) {
            die("Error:" . $e->getMessage());
        }
        return $this->pdo;
    }
}
