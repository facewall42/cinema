<?php
include_once 'Model/Database.php';
class Article
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    // Requete de recup des 6 derniers articles
    public function getLastSixArticles()
    {
        $sql = "SELECT * FROM articles ORDER BY date_creation DESC LIMIT 6";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllArticles()
    {
        $sql = "SELECT * FROM articles ORDER BY date_creation DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticlebyId($id)
    {
        $sql = "SELECT * FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createArticle($titre, $contenu, $photo)
    {
        $sql = "INSERT INTO articles (titre, contenu, photo) VALUES (:titre, :contenu, :photo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':photo', $photo);
        $stmt->execute();
    }

    public function deleteArticle($id)
    {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function updateArticle($id, $titre, $contenu, $photo)
    {
        $sql = "UPDATE articles SET titre = :titre, contenu = :contenu, photo = :photo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':photo', $photo);
        $stmt->execute();
    }
}
