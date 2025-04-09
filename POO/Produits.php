<?php
// class Produits
// {
//     private $nom;
//     private $prix;
//     private $quantite;

//     public function __construct($nom, $prix, $quantite)
//     {
//         $this->nom = $nom;
//         $this->prix = $prix;
//         $this->quantite = $quantite;
//     }
//     public function afficherDetails()
//     {
//         echo "Nom: " . $this->nom . "<br>";
//         echo "Prix: " . $this->prix . "<br>";
//         echo "Quantité: " . $this->quantite . "<br>";
//     }
// }
//$produits01 = new Produits();



// En PHP, $this est un mot-clé spécial qui représente l'instance courante de la classe (l'objet en cours de manipulation). Il permet d'accéder aux propriétés et méthodes de l'objet depuis ses propres méthodes.

// À quoi sert $this ?
// Accéder aux propriétés de l'objet :
// Dans une classe, les propriétés (comme $nom, $prix, $quantite) sont déclarées comme private. Pour y accéder ou les modifier depuis une méthode, on utilise $this->nomPropriete.

// Appeler d'autres méthodes de la classe :
// Si une méthode a besoin d'en appeler une autre de la même classe, on utilise $this->nomMethode().

// Distinguer les variables locales des propriétés :
// Si un paramètre de méthode a le même nom qu'une propriété (exemple : $nom dans le constructeur), $this permet de les différencier.

// Exemple avec la classe Produits
class Produits
{
    private $nom;    // Propriété privée
    private $prix;   // Propriété privée
    private $quantite; // Propriété privée

    // Constructeur
    public function __construct($nom, $prix, $quantite)
    {
        // $this->nom fait référence à la propriété $nom de l'objet
        // $nom est le paramètre passé au constructeur
        $this->nom = $nom;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    // Méthode utilisant $this pour accéder aux propriétés
    public function afficherDetails() //on peut aussi utiliser les parametres entre parentheses : afficher (nom prix quantite ) si on n'a pas de constructeur et utiliser this comme dans le constructeur dans le code ci dessous avant les echo. du coup cela affecte les valeurs 
    {
        echo "Nom: " . $this->nom . "<br>";       // Accès à $nom via $this
        echo "Prix: " . $this->prix . "<br>";      // Accès à $prix via $this
        echo "Quantité: " . $this->quantite . "<br>";
    }
}
// Comment $this est conçu ?
// $this est implicite : Il n'a pas besoin d'être déclaré, PHP le fournit automatiquement dans le contexte d'une méthode.

// Uniquement dans les méthodes d'instance : Il ne fonctionne pas dans les méthodes statiques (où on utilise self:: à la place).

// Référence à l'objet courant : Quand vous appelez $objet->methode(), $this pointe vers $objet.

// Exemple concret
// php
// Copy
// $produit1 = new Produits("Laptop", 999.99, 10);
// $produit1->afficherDetails();
// Quand afficherDetails() est appelé, $this représente $produit1.

// $this->nom va chercher la valeur "Laptop" stockée dans $produit1.

// Erreurs courantes sans $this
// php

// public function afficherDetails() {
//     echo "Nom: " . $nom; // ERREUR ! PHP cherche une variable $nom locale.
// }
// → Sans $this, PHP ne sait pas que $nom est une propriété de l'objet.

// Résumé
// $this est obligatoire pour manipuler les propriétés/méthodes internes.

// Il agit comme un pointeur vers l'objet courant.

// Son utilisation est une bonne pratique pour clarifier le code et éviter des bugs.
$produits01 = new Produits("chaussures", 50, 10);
$produits01->afficherDetails();
//variante
$produits01->afficherDetails("chaussures", 50, 10);

// echo $produits01->nom; comme la propriete est private on ne peut y acceder
// echo $produits01->prix;
// echo $produits01->quantite;

// Exactement ! Comme les propriétés ($nom, $prix, $quantite) sont déclarées private dans la classe Produits, vous ne pouvez pas y accéder directement depuis l'extérieur de la classe (comme dans votre exemple). C'est l'un des principes de l'encapsulation en POO.

// Pourquoi private empêche l'accès direct ?
// Sécurité : Évite de modifier les données sans contrôle.

// Contrôle : Oblige à passer par des méthodes (comme des getters/setters) pour lire/modifier les valeurs.

// Solution : Utiliser des méthodes publiques (getters)
// Pour accéder aux propriétés private, ajoutez des méthodes publiques comme getNom(), getPrix(), etc.

// Exemple modifié :

// class Produits {
//     private $nom;
//     private $prix;
//     private $quantite;

//     public function __construct($nom, $prix, $quantite) {
//         $this->nom = $nom;
//         $this->prix = $prix;
//         $this->quantite = $quantite;
//     }

//     // Getter pour $nom
//     public function getNom() {
//         return $this->nom;
//     }

//     // Getter pour $prix
//     public function getPrix() {
//         return $this->prix;
//     }

//     // Getter pour $quantite
//     public function getQuantite() {
//         return $this->quantite;
//     }
// }

// Comment l'utiliser ?

// $produit01 = new Produits("Laptop", 999.99, 5);

// // Accès via les getters
// echo $produit01->getNom();     // Affiche "Laptop"
// echo $produit01->getPrix();    // Affiche 999.99
// echo $produit01->getQuantite(); // Affiche 5
// // Bonus : Ajouter des setters (pour modifier les valeurs)

// public function setPrix($nouveauPrix) {
//     if ($nouveauPrix > 0) { // Validation
//         $this->prix = $nouveauPrix;
//     }
// }

// Utilisation :

// $produit01->setPrix(899.99); // Modifie le prix

// Pourquoi cette approche ?
// Contrôle : Vous pouvez valider les données avant modification (ex : prix positif).
// Flexibilité : Vous pouvez changer le fonctionnement interne sans impacter le code qui utilise la classe.
// Sécurité : Les propriétés critiques ne sont pas modifiables n'importe comment.
