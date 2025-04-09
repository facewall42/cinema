<?php

require_once "inc/functions.inc.php";

//debug($_GET);
//debug($_SESSION['client']); // permet de verifier la session client créée avec session_start() et qui la rappelle
//debug($_SESSION['panier']); 


//print_r($_POST);
//print_r($_GET);
//var_dump($_GET);

if (!isset($_SESSION['client'])) {
    //on fait la redirection vers la page de connexion
    header("location:authentication.php");
    // un exit serait conseillé....
};

require_once "inc/header.inc.php"; // obligé le placer apres la fonction header
?>
<div class="mx-auto p-2 row flex-column align-items-center">
    <h2 class="text-center mb-5">Bonjour
        <?php echo ($_SESSION['client']['firstName']) // afficher le pseudo 
        ?>
    </h2>
    <div class="cardFilm">
        <div class="image">
            <?php
            if ($_SESSION['client']['civility'] == 'h') { //afficher l'image h
            ?>
                <img src="<?= RACINE_SITE ?>assets/img/avatar_h.png" alt="Image avatar homme de l'utilisateur">
            <?php } else { //afficher l'image f
            ?>
                <img src="<?= RACINE_SITE ?>assets/img/avatar_f.png" alt="Image avatar femme de l'utilisateur">
            <?php } ?>
            <!-- condition ternaire identique mais plus concise : 
                <img src="assets/img  < ?= $_SESSION['client']['civility'] == 'f' ? 'avatar_f.png' : 'avatar_h.png' ;?> " alt="Image avatar de l'utilisateur"> -->


            <div class="details">
                <div class="center ">

                    <table class="table">
                        <tr>
                            <th scope="row" class="fw-bold">Nom :
                            </th>
                            <td><?php echo ($_SESSION['client']['lastName']) ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Prenom :

                            </th>
                            <td><?php echo ($_SESSION['client']['firstName']) ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Pseudo :
                            </th>
                            <td colspan="2"><?php echo ($_SESSION['client']['pseudo']) ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Email :

                            </th>
                            <td colspan="2"><?php echo ($_SESSION['client']['email'])
                                            ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Tel :

                            </th>
                            <td colspan="2"> <?php echo ($_SESSION['client']['phone']) ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Adresse :

                            </th>
                            <td colspan="2"><?php echo ($_SESSION['client']['address']) ?></td>

                        </tr>

                    </table>
                    <a href="" class="btn mt-5">Modifier vos informations

                    </a>
                </div>
            </div>
        </div>
    </div>
</div>























<?php
require_once "inc/footer.inc.php";

?>