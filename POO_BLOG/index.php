<?php
include_once 'config/config.php';
include_once 'Model/Database.php';
include_once 'Model/Article.php';

$database = new Database();
$pdo = $database->connect();
$articleModel = new Article($pdo);

// Ecoute des actions du routeur :
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
// RECUP METHODE GET DE show article :
$id_article = isset($_GET['id']) ? $_GET['id'] : null;

// RECUP METHODE POST DE create et update :
$contenu = isset($_POST['contenu']) ? $_POST['contenu'] : null;
$titre = isset($_POST['titre']) ? $_POST['titre'] : null;
$photo = isset($_FILES['photo']) ? $_FILES['photo'] : null;
// TESTS sur la validité du post
if ($photo['error'] == 0) {
    $photo = $photo['name'];
    move_uploaded_file($photo['tmp_name'], 'public/assets/images/' . $photo);
}
if ($titre == null || $contenu == null || $photo == null) {
    echo 'Veuillez remplir tous les champs';;
    include_once 'Templates/home.php';
} else {
    echo 'Tous les champs sont remplis';
    $articleModel->createArticle($titre, $contenu, $photo);
    include_once 'Templates/home.php';
}

// PARTIE ROUTER : 

switch ($action) {
    case 'home':
        $articles = $articleModel->getLastSixArticles();
        include_once 'Templates/home.php';

        break;
    case 'list':
        $articles = $articleModel->getAllArticles();
        include_once 'Templates/home.php';
        break;
    case 'show':
        $article = $articleModel->getArticlebyId($id_article);
        include_once 'Templates/article_detail.php';
        break;
    case 'create':
        include_once 'Templates/update_create.php';
        break;

    // ESSAIS DE CODAGE MAIS NON DEMANDE
    //case 'store': // ne marche pas car on n'arrive pas au store
    // case 'update':
    //     $article = $articleModel->getArticlebyId($id_article);
    //     include_once 'Templates/update_create.php';
    //     break;
    // case 'edit':
    //     $articleModel->updateArticle($id_article, $titre, $contenu, $photo);
    //     include_once 'Templates/home.php';
    //     break;

    case 'delete':
        $articleModel->deleteArticle($id_article);
        include_once 'Templates/home.php';
        break;
    // FIN DU CODE NON EPROUVE
    default:
        // echo '404 Page not found';
        include_once 'Templates/oups.php';
        break;
}
