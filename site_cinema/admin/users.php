<?php
require_once "../inc/functions.inc.php";
$users = allUsers();
//debug($users);

if (isset($_GET['action']) && isset($_GET['id'])){ // le GET id vient des lignes > 102 et 103 les td des boutons derole
    if ( !empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id'])){
        $idUser = htmlspecialchars($_GET['id']);
        $user = showUser($idUser);

        if($user['role'] == "ROLE_ADMIN"){
// mise a jour du role en utilisateur
            updateRole("ROLE_USER", $idUser);}
        else {
//// mise a jour du role en admin
            updateRole("ROLE_ADMIN", $idUser);
        }
        }
header("location:users.php");
    }





// if (isset($_GET) && isset($_GET['action']) && isset($_GET['id_user'])) {
    
//     if ($_GET['action']=='delete' && !empty($_GET['id_user'])) {
//         $idUser = htmlentities($_GET['id_user']);
//         deletUser($idUser);
//         debug(deletUser($idUser));
//     }
    
//     if ($_GET['action']=='update' && !empty($_GET['id_user'])) {
//         $idUser = htmlentities($_GET['id_user']);
//         $user = showUser($idUser);
        
//         if ($user['role'] == 'ROLE_ADMIN') {
//             updateRole('ROLE_USER', $idUser);
//             header("location:".RACINE_SITE."admin/users.php");
            
//         } else {
//             updateRole('ROLE_ADMIN', $idUser);
//             header("location:".RACINE_SITE."admin/users.php");
//         }
        
//     }
// }


//gestion de l'accessibilité des pages admin
// if (empty($_SESSION['user'])) {
//     header('location:'.RACINE_SITE.'authentification.php');
// } else {
//     if ($_SESSION['user']['role'] == 'ROLE_USER') {
//         header('location:'.RACINE_SITE.'index.php');
//     }
// }

if (!isset($_SESSION['client'])){ // si une session existe avec un identifiant user je me redirige vers la page profile
    header('location'.RACINE_SITE.'authentification.php');
};


require_once "../inc/header.inc.php";

?>

<div class="d-flex flex-column m-auto mt-5 table-responsive">   
         <!-- tableau pour afficher toutles films avec des boutons de suppression et de modification -->
        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des utilisateurs</h2>
        <table class="table  table-dark table-bordered mt-5">
            <thead>
                    <tr>
                    <!-- th*7 -->
                        <th>ID</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Civility</th>
                        <th>Address</th>
                        <th>Zip</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Rôle</th>
                        <th>Supprimer</th>
                        <th>Modifier Le rôle</th>
                    </tr>
            </thead>
            <tbody>
             <?php  foreach($users as $user) { // je boucle sur le tableau $users  et je recupere chaque utilisateur dans la variable $user
                
                    ?>
                     <tr>
                    <!-- il faut utiliser la fonction html_entity_decode() sur les valeur récupérées uniquement si  -->
                    <td><?= $user['id_user']?></td>
                    <td><?= ucfirst($user['firstName'])?></td> // met en majuscule le premier caractere
                    <td><?= ucfirst($user['lastName'])?></td>
                    <td><?= $user['pseudo']?></td>
                    <td><?= $user['email']?></td>
                    <td><?= $user['phone']?></td>
                    <td><?= $user['civility']?></td>
                    <td><?= $user['address']?></td>
                    <td><?= $user['zip']?></td>
                    <td><?= $user['city']?></td>
                    <td><?= $user['country']?></td>
                    <td><?= $user['role']?></td>
                                             
                    <td class="text-center"><a href="users.php?action=delete&id=<?= $user['id_user']?>" class=" btn btn-info"> <?= ($user['role']=== "ROLE_ADMIN")?'Rôle_user' : 'Rôle_admin';?></a></td>
                    <td class="text-center"><a href="users.php?action=update&id=<?= $user['id_user']?>" class=" btn btn-info"> <?= ($user['role']=== "ROLE_ADMIN")?'Rôle_user' : 'Rôle_admin';?></a></td>
                    <!-- ?action=update&id= $user['id_user'] on met dans la supervariable GET action=update et id de l'user, on fait pareil pour delete -->
                    
                  
                </tr>
              <?php } ?>
   
            </tbody>
        </table>
         
    </div>



    <!-- tableau precedent pour afficher tous les films avec des boutons de suppression et de modification ANCIENNE VERSION -->

 <div class="d-flex flex-column m-auto mt-5 table-responsive">   
          
            <h2 class="text-center fw-bolder mb-5 text-danger">Liste des utilisateurs</h2>
            <table class="table  table-dark table-bordered mt-5">
                <thead>
                <tr>
                
                    <th>ID</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Civility</th>
                    <th>Address</th>
                    <th>Zip</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Rôle actuel</th>
                    <th>Supprimer</th>
                    <th>Modifier Le rôle</th>
                </tr>
                </thead>
            <tbody>

               <?php
                    foreach ($users as $key => $user) {

                ?>
                <tr>
                    <td><?= $user['id_user']?></td>
                    <td><?= ucfirst($user['firstName'])?></td> // met en majuscule le premier caractere
                    <td><?= ucfirst($user['lastName'])?></td>
                    <td><?= $user['pseudo']?></td>
                    <td><?= $user['email']?></td>
                    <td><?= $user['phone']?></td>
                    <td><?= $user['civility']?></td>
                    <td><?= $user['address']?></td>
                    <td><?= $user['zip']?></td>
                    <td><?= $user['city']?></td>
                    <td><?= $user['country']?></td>
                    <td><?= $user['role']?></td>
                    <td class="text-center"><a href="?action=delete&id_user=<?= $user['id_user']?>"><i class="bi bi-trash3-fill"></i></a></td>
                    <td class="text-center"><a href="?action=update&id_user=<?= $user['id_user']?>" class="btn btn-danger"><?=$user['role'] == 'ROLE_ADMIN' ?'ROLE_USER' : 'ROLE_ADMIN'?></a></td>
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