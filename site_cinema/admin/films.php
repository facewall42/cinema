<?php


require_once "../inc/functions.inc.php";

if(empty($_SESSION['user']) ) {

    header("location:".RACINE_SITE."authentification.php");

}else{

if ( $_SESSION['user']['role'] == 'ROLE_USER') {

    header("location:".RACINE_SITE."index.php");
}

}
    $films = allFilm();






    if (isset($_GET) && isset($_GET['action']) && isset($_GET['id_film'])) {
    
        if ($_GET['action']=='delete' && !empty($_GET['id_film'])) {
            $idfilm = htmlentities($_GET['id_film']);
            deletfilm($idfilm);
            header("location:".RACINE_SITE."admin/films.php");
        }
    }









require_once "../inc/header.inc.php";
?>

<div class="d-flex flex-column m-auto mt-5">

    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>
    <a href="gestion_film.php" class="btn align-self-end"> Ajouter un film</a>
    <table class="table table-dark table-bordered mt-5 " >
            <thea>
                    <tr >
                    <!-- th*7 -->
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Affiche</th>
                        <th>Réalisateur</th>
                        <th>Acteurs</th>
                        <th>Àge limite</th>
                        <th>Genre</th>
                        <th>Durée</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Synopsis</th>
                        <th>Date de sortie</th>
                        <th>Supprimer</th>
                        <th> Modifier</th>
                    </tr>
            </thea>
            <tbody>

                <?php

                foreach($films as $key => $film){
                    //Avant l'affichage des données il fautr formater quelques une:


                   $actors= stringToArray($film['actors']); // je transforme la chaîne de caratcétre récupérée à partrir de l'élément $film['actors'] du tableau $film en un tableau avec la fonction stringToArray()

                    // la catégorie du film
                   $category = showCatviaID($film['category_id']);
                   $categoryName = $category['name'];

                   //Gérer l'affichage de la durée
                        // $objet = new NomDeLaClasse();
                        $date_time = new DateTime($film['duration']); // nous créeons un nouvel objet DateTime en passant  la valeur de l'input de type time  en tant que paramètre
                        $duration = $date_time->format('H:i');// Nous utilisons ensuite la méthode format() pour extriare l'heure et les minutes au format 'H:i'


                        ?>
                        <tr>

                            <!-- Je récupére les valeus de mon tabelau $film dans des td -->
                            <td><?= $film['id_film'] ?></td>
                            <td> <?= $film['title'] ?></td>
                            <td> <img src="<?=RACINE_SITE."assets/img/". $film['image'] ?>" alt="affiche du film" class="img-fluid"></td>
                            <td> <?= $film['director'] ?></td>
                            <td>
                                <ul>
                                <?php
                                foreach($actors as $key => $actor){
                                    ?>
                                    <li><?= $actor;?></li>
                                    <?php
                                }
                                ?>
                                </ul>
                            </td>
                            <td> <?= $film['ageLimit'] ?></td>
                            <td> <?= $categoryName ?></td>
                            <td> <?= $duration?></td>
                            <td> <?= $film['price'] ?>€</td>
                            <td> <?= $film['stock'] ?></td>
                            <td> <?=substr($film['synopsis'],0, 50) ?>...</td>
                            <td> <?= $film['date'] ?></td>
                            <td class="text-center"><a href="?action=delete&id_film=<?= $film['id_film'] ?>"><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href="gestion_film.php?action=update&id_film=<?= $film['id_film'] ?>"><i class="bi bi-pen-fill"></i></a></td>

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