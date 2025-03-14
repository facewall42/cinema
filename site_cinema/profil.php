<?php
require_once "inc/functions.inc.php";

// if(empty($_SESSION['user']) ) {

//     header("location:".RACINE_SITE."authentification.php");

// }

require_once "inc/header.inc.php";
debug($_SESSION)
?>
<div class="mx-auto p-2 row flex-column align-items-center">
    <h2 class="text-center mb-5">Bonjour <?=$_SESSION['user']['firstName']?> </h2>
 	<div class="cardfilm">
        <div class="image">
         <img src="assets/img/<?=$_SESSION['user']['civility']== 'h' ? 'avatar_h.png' : 'avatar_f.png' ?>" alt="Image avat">
            <div class="details">
            <div class="center ">
                
                <table class="table">
                          <tr>
                                <th scope="row" class="fw-bold">Nom</th>
                                <td><?=$_SESSION['user']['lastName']?></td>
                               
                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Prenom</th>
                                <td><?=$_SESSION['user']['firstName']?></td>
                                
                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Pseudo</th>
                                <td colspan="2"><?=$_SESSION['user']['pseudo']?></td>
                                
                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">email</th>
                                <td colspan="2"><?=$_SESSION['user']['email']?></td>
                                
                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Tel</th>
                                <td colspan="2"><?=$_SESSION['user']['phone']?></td>
                                
                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Adresse</th>
                                <td colspan="2"><?=$_SESSION['user']['address']?> <?=$_SESSION['user']['zip']?> <?=$_SESSION['user']['city']?> <?=$_SESSION['user']['country']?></td>
                                
                            </tr>

                </table>
                <a href="?action=modif" class="btn mt-5">Modifier vos informations</a>


            </div>
        </div>

    </div>

    <?php
    if (isset($_GET) && $_GET['action']=="modif") {
    ?>
        <form action=""></form>
        
    <?php
    }
    ?>
    
    

<?php
require_once "inc/footer.inc.php";
?>