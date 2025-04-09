<?php

require_once "../inc/ft_functions.inc.php";

$gamers = allGamers();
// debug($users);

require_once "../inc/header.inc.php";

?>

<div class="d-flex flex-column m-auto mt-5 table-responsive">
    <!-- tableau pour afficher tous les gamers avec des boutons de suppression -->
    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des utilisateurs</h2>
    <table class="table table-dark table-bordered mt-5">
        <thead>
            <tr>
                <!-- th*7 -->
                <th>ID</th>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($gamers as $gamer) { // $gamers = tableau et $gamer = chaque utilisateur
                // je boucle sur le tableau $gamers et je récupère chaque utilisateur dans la variable $gamer
            ?>
                <tr>
                    <td><?= $gamer['id'] ?></td>
                    <td><?= ucfirst($gamer['prenom']) ?></td>
                    <td><?= $gamer['nom'] ?></td>
                    <td><?= $gamer['email'] ?></td>

                    <td class="text-center"><a href="users.php?action=delete&id=<?= $gamer['id'] ?>"><i class="bi bi-trash3"></i></a></td>
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