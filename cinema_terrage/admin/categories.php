
<?php
require_once "../inc/functions.inc.php";

$info = "";

if (!isset($_SESSION['client'])) { // si une session n'existe pas avec un identiafaint user je me redérige vers la page de connexion

    header('location:' . RACINE_SITE . 'authentication.php');
    
}else {

    if ($_SESSION['client']['role'] == "ROLE_USER" ) {

        header('location:' . RACINE_SITE . 'profil.php');
    }
}

if (!empty($_POST)) {
    
    
    // On vérifie si un champs est vide 

    $verif = true;
    foreach ($_POST as $key => $value) {

        if (empty(trim($value))) {

            $verif = false;
        }
    }
    if ($verif === false) {

        $info = alert("Veuillez renseigner tout les champs", "danger");

    }else{

        if (!isset($_POST['name']) || strlen($_POST['name'])< 3 || preg_match("/[0-9]/", $_POST['name'])) {

            $info = alert("Le champ nom de la catégorie n'est pas valide", "danger");
            
        }
        if (!isset($_POST['description']) || strlen($_POST['description']) < 20 ) {

            $info .= alert("Le champ description de la catégorie n'est pas valide", "danger");
            
        }
        elseif($info == ""){

            // stockage des données à insérées dans des variables

            $name = trim(htmlspecialchars($_POST['name']));
            $description = trim(htmlspecialchars($_POST['description']));

           
            $categoryBdd = showCategory($name);

            if ($categoryBdd) {
               
                $info = alert("La catégorie existe déjà", "danger");

            }else {

                if (isset($_GET) && $_GET['action'] == 'update' &&  !empty($_GET['id_category'])) {

                    $id_category = htmlentities($_GET['id_category']);
                    updateCategory($id_category, $name, $description);
                    header('location: categories.php');

                }else{

                    addCategory($name, $description);
                    header('location: categories.php');

                }  

            }



        }


    }



}



require_once "../inc/header.inc.php" ;
?>

<div class="row mt-5" style="padding-top: 8rem;">
    <div class="col-sm-12 col-md-6 mt-5">
        <h2 class="text-center fw-bolder mb-5 text-danger">Gestion des catégories</h2>

     
            <?=$info?>
       
        <form action="" method="post" class="back">

            <div class="row">
                <div class="col-md-8 mb-5">
                    <label for="name" class="text-light">Nom de la catégorie</label>
             
                    <input type="text" id="name" name="name" class="form-control" value=""> 
                 
                </div>
                <div class="col-md-12 mb-5">
                    <label for="description" class="text-light">Description</label>
                    <textarea id="description"  name="description" class="form-control" rows="10"></textarea>
                </div>

            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-danger p-3"></button>
            </div>
        </form>
    </div>

    <div class="col-sm-12 col-md-6 d-flex flex-column mt-5 pe-3">  
       
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
                
                        <tr>
                            <td></td>
                            <td></td> 
                            <td></td> 
                            
                            <td class="text-center"><a href=""><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href=""><i class="bi bi-pen-fill"></i></a></td>
                            
                        </tr>
               

            </tbody>

        </table>

</div>


<?php
require_once "../inc/footer.inc.php";