<?php
require_once "../inc/functions.inc.php";


$users = allUsers();
// debug($users);

if (!isset($_SESSION['client'])) { // si une session n'existe pas avec un identiafaint user je me redérige vers la page de connexion

    header('location:' . RACINE_SITE . 'authentication.php');

}else {

    if ($_SESSION['client']['role'] == "ROLE_USER" ) {

        header('location:' . RACINE_SITE . 'profil.php');
    }
}



if (isset($_GET['action'])&& isset($_GET['id'])) {

    $idUser = htmlspecialchars($_GET['id']);
    
    $user = showUser($idUser);

    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id']) ) {

        
       
        if ($user['role'] =="ROLE_ADMIN") {

                // je change le rôle en ROLE_USER
                updateRole("ROLE_USER", $idUser );
            
        }else {

            // je change le rôle en ROLE_ADMIN
            updateRole("ROLE_ADMIN", $idUser );
        }
    }
    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id']) ) {
           
        if ($user['role'] != "ROLE_ADMIN") {

             deleteUser($idUser);
        }

    }

    header("location:users.php");
   
}

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
            <?php
            foreach ($users as $user) { // je boucle sur le tableau $users et je récupére chaque utilisateur dans la variable $user
            ?>

                <tr>
                    
                    <td><?= $user['id_user'] ?></td>
                    <td><?=ucfirst( $user['firstName']) ?></td><!-- une majuscule sur la prmère lettre-->
                    <td><?= $user['lastName'] ?></td>
                    <td><?= ucfirst($user['pseudo']) ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone'] ?></td>
                    <td><?= $user['civility'] ?></td>
                    <td><?= $user['address'] ?></td>
                    <td><?= $user['zip'] ?></td>
                    <td><?= $user['city'] ?></td>
                    <td><?= $user['country'] ?></td>
                    <td><?= $user['role'] ?></td>

                    <td class="text-center"><a href="users.php?action=delete&id=<?= $user['id_user'] ?>"><i class="bi bi-trash3"></i></a></td>
                    <td class="text-center"><a href="users.php?action=update&id=<?= $user['id_user'] ?>" class=" btn btn-info"><?= ($user['role'] === "ROLE_ADMIN")? 'Rôle_user' : 'Rôle_admin';?></a></td>

                </tr>

            <?php
            }

            ?>



        </tbody>
    </table>

</div>


<?php
require_once "../inc/footer.inc.php";
