<?php
require_once "../inc/functions.inc.php";

if (empty($_SESSION['user'])) {
    header('location:'.RACINE_SITE.'authentification.php');
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header('location:'.RACINE_SITE.'index.php');
    }
}

$info = "";
$allcat = allcat();

if (isset($_GET) && isset($_GET['action']) && isset($_GET['id_film']) && !empty($_GET['action']) && !empty($_GET['id_film'] )) {
    $idFilm = htmlentities($_GET['id_film']);
    $film = showfilmviaID($idFilm);
}

if (!empty($_POST)) {
    
    $verif = true;
    foreach ($_POST as $key => $value) {

        if(empty(trim($value) )) {
            $verif = false;
        }
    }


    // la superglobale $_FILES a un indice "image" qui correspond au "name" de l'input type="file" du formulaire, ainsi qu'un indice "name" qui contient le nom du fichier en cours de téléchargement.
    if (!empty($_FILES['image']['name'])) { //si le nom du fichier en cours de téléchargement n'est pas vide, alors c'est qu'on est en train de télécharger une photo

        $image = 'img/'.$_FILES['image']['name'];  // $image contient le chemin relatif de la photo et sera enregistré en BDD. On utilise ce chemin pour les "src" des balises <img>.
        
        copy($_FILES['image']['tmp_name'],'../assets/'.$image );
      
        // on enregistre le fichier image qui se trouve à l'adresse contenue dans $_FILES['image']['tmp_name'] vers la destination qui est le dossier "img" à l'adresse "../asstes/nom_du_fichier.jpg".
    }
    if($verif == false || empty($image)){
        $info = alert("Veuillez renseigner tout les champs", "danger");
    }else {

// on vérifie l'image : 
            // $_FILES['image']['name'] Nom
            // $_FILES ['image']['type'] Type
            // $_FILES ['image']['size'] Taille
            // $_FILES ['image']['tmp_name'] Emplacement temporaire
            // $_FILES ['image']['error'] Erreur si oui/non l'image a été réceptionné

if($_FILES['image']['error'] != 0 || $_FILES['image']['size'] == 0 || !isset($_FILES['image']['type'])){

            $info .= alert("L'image n'est pas valide","danger");


        }
        
            $idcat = trim($_POST['categories']);
            $title = trim($_POST['title']);
            $director = trim($_POST['director']);
            $actors = trim($_POST['actors']);
            $age = trim($_POST['ageLimit']);
            $duration = trim($_POST['duration']);
            $date = trim($_POST['date']);
            $price = trim($_POST['price']);
            $stock = trim($_POST['stock']);
            $synopsis = trim($_POST['synopsis']);
        
        
        if (!isset($title) || strlen($title) < 2) {
            $info .= alert("le champ titre n'est pas valide ", "danger");
        }

        if(strlen($director) < 2 || preg_match('/[0-9]+/', $director)){
            // longueur > 1 / 
            $info .= alert("Champ Réalisateur non valide", "danger");
        }

        //Explications: 
        //    .* : correspond à n'importe quel nombre de caractères (y compris zéro caractère), sauf une nouvelle ligne.
        //     \/ : correspond au caractère /. Le caractère / doit être précédé d'un backslash \ car il est un caractère spécial en expression régulière. Le backslash est appelé caractère d'échappement et il permet de spécifier que le caractère qui suit doit être considéré comme un caractère ordinaire.
        //     .* : correspond à n'importe quel nombre de caractères (y compris zéro caractère), sauf une nouvelle ligne.

        if( !isset($actors) ||  strlen($actors) < 3 || preg_match('/[0-9]+/', $actors) || !preg_match('/.*\/.*/', $actors) ){ // valider que l'utilisateur a bien inséré le symbole '/' : chaîne de caractères qui contient au moins un caractère avant et après le symbole /.
            
            $info .= alert("Le champs acteurs n'est pas valide, il faut séparer les acteurs avec le symbole","danger");   
        }

        if (!isset($idcat) || showCatviaID($idcat) == false) {
            $info .= alert("Le la catégorie n'est pas correcte","danger");   
        }

        if (!isset($duration)) {
            $info .= alert("la durée n'est pas valide", "danger");
        }
       
        if (!isset($date)) {
            $info .= alert("la date de sortie n'est pas valide", "danger");
        }
              
        if (!isset($price) || !is_numeric($price)) {
            $info .= alert("le prix n'est pas valide", "danger");
        }

        if (!isset($synopsis) || strlen($synopsis) < 20) {
            $info .= alert("le champs synopsis n'est pas valide", "danger");
        }

        if (!isset($stock)) {
            $info .= alert("le résumé doit dépasser 50 caractére", "danger");
        }
                
        if (!isset($image)) {
            $info .= alert("le champs image n'est pas valide", "danger");
        }

        if (!isset($age)) {
            $info .= alert("le champs nom de l'age limite n'est pas valide", "danger");

        }elseif (empty($info)) {

            if (isset($_GET) && isset($_GET['action']) && isset($_GET['id_film']) && !empty($_GET['action']) && !empty($_GET['id_film'] && $_GET['action'] == 'update')) {

                $idfilm = htmlentities($_GET['id_film']);

                updateFilm($idfilm ,$idcat ,$title ,$director ,$actors ,$age ,$duration ,$synopsis ,$date ,$image , $price, $stock);
                header("location:".RACINE_SITE."admin/gestion_film.php");
                $info .= alert("c'est valide", "success");
        
            }else {
            

            if (verifFilm($title , $date)) {//si le film existe dans la bdd
                $info .= alert("le film existe deja", "danger");
            }else {
                addfilm($idcat ,$title ,$director ,$actors ,$age ,$duration ,$synopsis ,$date ,$price ,$stock, $image );
                $info .= alert("c'est valide", "success");
                
            }
        }
    }
}
}

require_once "../inc/header.inc.php";

?>
<main>
    <h2 class="text-center fw-bolder mb-5 text-danger"><?= isset($film) ? 'Modifier le film':'Ajouter un film' ?></h2>

    <?php
    echo $info;
    ?>
<form action="" method="post" class="back" enctype="multipart/form-data">
    <!-- il faut isérer une image pour chaque film, pour le traitement des images et des fichiers en PHP on utilise la surperglobal $_FILES -->
    <div class="row">
        <div class="col-md-6 mb-5">
            <label for="title">Titre de film</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= $film['title'] ?? '' ?>">
        </div>
        <div class="col-md-6 mb-5">
            <label for="image">Photo</label>
            <br>
            <input type="file" name="image" id="image" >
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-5">
            <label for="director">Réalisateur</label>
            <input type="text" class="form-control" id="director" name="director" value="<?= $film['director'] ?? '' ?>" >
        </div>
        <div class="col-md-6">
            <label for="actors">Acteur(s)</label>
            <input type="text" class="form-control" id="actors" name="actors" value="<?= $film['actors'] ?? '' ?>"  placeholder="séparez les noms d'acteurs avec un /">
        </div>
    </div>

    <div class="row">
        <!-- raccouci bs5 select multiple -->
        <div class="mb-3">
            <label for="ageLimit" class="form-label">Àge limite</label>
            <select multiple class="form-select form-select-lg" name="ageLimit" id="ageLimit">
                <option value="10"<?php if(isset($film['ageLimit'])&& $film['ageLimit'] == 10 ) echo 'selected'?>>10</option>
                <option value="13"<?php if(isset($film['ageLimit'])&& $film['ageLimit'] == 13 ) echo 'selected'?>>13</option>
                <option value="16"<?php if(isset($film['ageLimit'])&& $film['ageLimit'] == 16 ) echo 'selected'?>>16</option>
            </select>
        </div>
    </div>
    <div class="row">
        <label for="categories">Genre du film</label>

        <!--  Ici c'est les catégories qui sont déjà stockés dans la BDD et qu'on va récupérer à partir dela BDD -->
        <?php
        foreach ($allcat as $key => $value) {
        ?>
            <div class="form-check col-sm-12 col-md-4 ">
                <input class="form-check-input" type="radio" name="categories" id="<?= $value['name']?>" value="<?= $value['id_category']?>" <?=isset($film['category_id']) && $film['category_id'] == $value['id_category'] ? 'checked' : '' ?>>

                <label class="form-check-label" for="<?= $value['name']?>"><?= $value['name']?></label>
            </div>
        <?php
        }
        ?>

    </div>
    <div class="row">
        <div class="col-md-6 mb-5">
            <label for="duration">Durée du film</label>
            <input type="time" class="form-control" id="duration" name="duration" value="<?= $film['duration'] ?? '' ?>" >
        </div>

        <div class="col-md-6 mb-5">

            <label for="date">Date de sortie</label>
            <input type="date" name="date" id="date" class="form-control" value="<?= $film['date'] ?? '' ?>" >
        </div>
    </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price"  aria-label="Euros amount (with dot and two decimal places)" value="<?= $film['price'] ?? '' ?>">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min ="0"  value="<?= $film['stock'] ?? '' ?>"> <!--pas de stock négativ donc je rajoute min="0"-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="synopsis">Synopsis</label>
                <textarea type="text" class="form-control" id="synopsis" name="synopsis" rows="10"><?= $film['synopsis'] ?? '' ?></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger p-3 w-25"><?= isset($film) ? 'Modifier le film':'Ajouter un film' ?></button>
        </div>


    </form>
        
</main>

<?php
require_once "../inc/footer.inc.php";
?>