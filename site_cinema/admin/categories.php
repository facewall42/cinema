<?php
require_once "../inc/functions.inc.php";




if (empty($_SESSION['user'])) {
    header('location:'.RACINE_SITE.'authentification.php');
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header('location:'.RACINE_SITE.'index.php');
    }
}




$cat = allcat();

//suppression et modification d'une categorie

if(isset($_GET['action']) && isset($_GET['id_category'])){
    // Suppression catégories // 
    if(!empty($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['id_category'])){
        $idCategory = htmlentities($_GET['id_category']);
        deletcat($idCategory);
        header("location:dashboard.php?categories_php");
    } else if(!empty($_GET['action']) && $_GET['action'] == 'update' && !empty($_GET['id_category'])){
    // Update catégories //
        $idCategory = htmlentities($_GET['id_category']);
        $category = showCatviaID($idCategory);
    } else{
        header("location:dashboard.php?categories_php");
    }
}

//--------------------------
// La superglobale $_POST
//---------------------------

// debug($_POST); 
/*
$_POST est une superglobal qui permet de récupérer les données saisies dans un formulaire.

//  Comme il s'agit d'une superglobale, $_POST est donc un tableau (array), et il est disponible dans tous les contextes du script, y compris au sein des fonctions (pas besoin de faire "global"$_POST").
Le tableau $_POST se remplit de la manière suivante :
$_POST = array(
    'name1' => 'valeur1',
    'nameN => 'valeurN'
);
où les "name1"  et "nameN" correspondent aux attributs "name" du formulaire, et où "valeur1" et "valeurN" correspondent aux valeurs saisies par l'internaute.
*/

$info = ""; // Variable qui recevra les messages d'alerte, déclaration dans le script en général avec une valeur vide pour ne pas engendrer d'erreur sur la page 

if(!empty($_POST)){ // petit rappel : empty() vérifie si une variable est vide :  0, '', NULL, false // avec !empty() on vérifie si la superglobal est n'est pas vide // si $_POST n'est pas vide , c'est que $_POST est rempli, donc que le formulaire a été envoyé. Notez que l'on peut l'envoyer avec des champs vides, les valeurs de $_POST étant alors des strings vides.
// Vérification de tous les champs récupérés avec $_POST
$verif = true; // Variable servant à vérifier si les champs sont remplis, (déclaration en "true")
foreach($_POST as $key => $values){ // boucle pour vérifier le tableau $_POST
    if(empty(trim($values))){ // Si valeurs => vides ou valeur => vide; $verif = false
        $verif = false;
    }
}
if(!$verif){ // Vérification de la valeur final de $verif // Si $verif = false => stockage message erreur dans $info
    $info = alert("Tous les champs sont requis", "danger");
} else{
    // Si tout est renseigné, commencement validation des champs
    // Stockage valeurs dans variables en vérifiant qu'il n'y a pas de chaînes de caractères vides
    $nameCategory = trim($_POST['name']);
    $descriptionCategory = trim($_POST['description']);

    // Validation des données
    if(strlen($nameCategory) < 3 || preg_match('/[0-9]+/', $nameCategory)){
        // Expression régulière [0-9]+ recherche une séquence d'un ou plusieurs chiffres dans la chaîne de caractères, fonction preg_match() renvoie 1 si la correspondance est trouvé sinon elle renvoie 0 
        $info = alert("Champs \"nom\" de la catégorie invalide", "danger");
    }
    if(strlen($descriptionCategory) < 50){
        $info .= alert("Champs \"description\" de la catégorie invalide, veuillez renseigner davantage d'informations", "danger");
    }
    if(empty($info)){
        $nameCategory = strip_tags($nameCategory);
        $descriptionCategory = strip_tags($descriptionCategory);
        
        if(!empty($_GET['action']) && $_GET['action'] == 'update' && !empty($_GET['id_category'])){
            $idCategory = htmlentities($_GET['id_category']);
            update($idCategory, $nameCategory, $descriptionCategory); // Mise à jour avec fonction updateCategory()
            header("location:categories.php");
        } else{
            addCategories($nameCategory, $descriptionCategory);
            header("location:categories.php"); // méthode permettant d'envoyer des requêtes HTTP donc rafraîchie et supprime les données enregistrées
        }
    }
}
}
require_once "../inc/header.inc.php";
?>
<div class="row mt-5" style="padding-top: 8rem;">
    <div class="col-sm-12 col-md-6 mt-5">
        <h2 class="text-center fw-bolder mb-5 text-danger">Gestion des catégories</h2>
        <?=$info?>
       
        <form action="" method="post" class="back">

            <div class="row">
                <div class="col-md-8 mb-5">
                    <label for="name">Nom de la catégorie</label>
                    <!-- <input type="text" id="name" name="name" class="form-control" value="<? //isset($category) ? $category['name']:'' ?>"> -->
                    <input type="text" id="name" name="name" class="form-control" value="<?= $category['name'] ?? '' ?>">

                </div>
                <div class="col-md-12 mb-5">
                    <label for="description">Description</label>
                    <textarea id="description"  name="description" class="form-control" rows="10"><?= isset($category) ? $category['description']:'' ?></textarea>
                </div>

            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-danger p-3"><?= isset($category) ? 'Modifier une categories':'Ajouter une catègories' ?></button>
            </div>
        </form>
    </div>

    <div class="col-sm-12 col-md-6 d-flex flex-column mt-5 pe-3">  
        <!-- tableau pour afficher toute les catégories avec des boutons de suppression et de modification -->
        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des catégories</h2>

        <table class="table table-dark table-bordered mt-5 " >
            <thead>
                    <tr>
                    <!-- th*7 -->
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Supprimer</th>
                        <th>Modifier</th>
                    </tr>
            </thead>
            <tbody> 
                        <?php
                            foreach ($cat as $key => $cats) {
                        ?>
                        <tr>
                            <td><?= $cats['id_category']?></td>
                            <td><?= html_entity_decode(ucfirst($cats['name']))?></td>
                            <td><?= html_entity_decode($cats['description'])?></td>
                            <td><a href="?action=delete&id_category=<?= $cats['id_category']?>"><i class="bi bi-trash3-fill"></i></a></td>
                            <td><a href="?action=update&id_category=<?= $cats['id_category']?>"><i class="bi bi-pen-fill"></i></a></td>
                        </tr>
                        <?php        
                            }
                        ?>
            </tbody>
        </table>
</div>
<?php
require_once "../inc/footer.inc.php";
?>