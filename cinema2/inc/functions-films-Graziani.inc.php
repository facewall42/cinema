#### Afficher tous les films
function allFilms(): mixed
{
$pdo = connexionBDD();
$sql = "SELECT
films.id AS id, ## changer en films.id_film et Enlever le AS id
categories.nom AS genre, ## changer par categories.name AS genre
title,
director,
actors,
ageLimit,
duration,
synopsis,
date,
image,
price,
stock
FROM films
INNER JOIN categories ON films.categorie_id = categories.id ## changer par categories.categorie_id
ORDER BY title ASC";
$request = $pdo->query($sql);
$result = $request->fetchAll();
return $result;
}

#### Vérifier si le film existe déjà
function filmExist(string $title): mixed
{
$pdo = connexionBDD();
$sql = "SELECT title FROM films WHERE title = :title";
$request = $pdo->prepare($sql);
$request->bindValue(':title', $title, PDO::PARAM_STR);
$request->execute();
$result = $request->fetch();
return $result;
}

#### Afficher un film
function showFilm(int $id): mixed
{
$pdo = connexionBDD();
$sql = "SELECT * FROM films WHERE id = :id"; ### changer par films.id_film
$request = $pdo->prepare($sql);
$request->execute(array(':id' => $id));
$result = $request->fetch();
return $result;
}
#### Supprimer un film
function deleteFilm(int $id): void
{
$pdo = connexionBDD();
$sql = "DELETE FROM films WHERE id = :id"; ## changer en id_film
$request = $pdo->prepare($sql);
$request->execute(array(
":id" => $id
));
}

#### Mettre à jour un film
function updateFilm(int $id, int $idCategorie, string $title, string $director, string $actors, string $ageLimit, string $duration, string $synopsis, string $date, string $image, float $price, int $stock): void
{
$pdo = connexionBDD();
$sql = "UPDATE films SET categorie_id = :idCategorie, title = :title, director = :director, actors = :actors, ageLimit = :ageLimit, duration = :duration, synopsis = :synopsis, date = :date, image = :image, price = :price, stock = :stock WHERE id = :id"; ## changer en id_film et categorie_id par category_id
$request = $pdo->prepare($sql);
// $request->execute(array(
// ":idCategorie" => $idCategorie,
// ":title" => $title,
// ":director" => $director,
// ":actors" => $actors,
// ":ageLimit" => $ageLimit,
// ":duration" => $duration,
// ":synopsis" => $synopsis,
// ":date" => $date,
// ":image" => $image,
// ":price" => $price,
// ":stock" => $stock,
// ":id" => $id
// ));
$request->bindValue(':idCategorie', $idCategorie, PDO::PARAM_INT);
$request->bindValue(':title', $title, PDO::PARAM_STR);
$request->bindValue(':director', $director, PDO::PARAM_STR);
$request->bindValue(':actors', $actors, PDO::PARAM_STR);
$request->bindValue(':ageLimit', $ageLimit, PDO::PARAM_STR);
$request->bindValue(':duration', $duration, PDO::PARAM_STR);
$request->bindValue(':synopsis', $synopsis, PDO::PARAM_STR);
$request->bindValue(':date', $date, PDO::PARAM_STR);
$request->bindValue(':image', $image, PDO::PARAM_STR);
$request->bindValue(':price', $price);
$request->bindValue(':stock', $stock, PDO::PARAM_INT);
$request->bindValue(':id', $id, PDO::PARAM_INT);
$request->execute();
}