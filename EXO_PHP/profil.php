<?php
require_once "inc/ft_functions.inc.php";

// if(empty($_SESSION['user']) ) {

//     header("location:".RACINE_SITE."authentication.php");

// }

require_once "inc/header.inc.php";
debug($_SESSION);
$_GET['action'] = isset($_GET['action']) ? $_GET['action'] : null;
?>
<div class="mx-auto p-2 row flex-column align-items-center">
    <h2 class="text-center mb-5">Bonjour <?= $_SESSION['client']['prenom'] ?> </h2>
    <div class="cardfilm">
        <div>
            <div class="details">
                <div class="center ">
                    <table class="table">
                        <tr>
                            <th scope="row" class="fw-bold">Nom</th>
                            <td><?= $_SESSION['client']['nom'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Prenom</th>
                            <td><?= $_SESSION['client']['prenom'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">email</th>
                            <td colspan="2"><?= $_SESSION['client']['email'] ?></td>
                        </tr>
                    </table>
                    <a href="?action=modif" class="btn mt-5">Modifier vos informations</a>
                </div>
            </div>
        </div>

        <?php
        if (isset($_GET) && $_GET['action'] == "modif") {
        ?>
            <form action=""></form>
        <?php
        }
        ?>
        <?php
        require_once "inc/footer.inc.php";
        ?>