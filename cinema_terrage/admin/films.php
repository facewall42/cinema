
<?php
require_once "../inc/functions.inc.php";

if (!isset($_SESSION['client'])) { // si une session n'existe pas avec un identiafaint user je me redérige vers la page de connexion

    header('location:' . RACINE_SITE . 'authentication.php');
    
}else {

    if ($_SESSION['client']['role'] == "ROLE_USER" ) {

        header('location:' . RACINE_SITE . 'profil.php');
    }
}

if (isset($_GET['action'])&& isset($_GET['id_film'])) {

    $idFilm = htmlentities($_GET['id_film']);
    
    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id_film']) ) {
           
        deleteFilm($idFilm);

    }
  
}



require_once "../inc/header.inc.php" ;


$films = allFilms();
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
                   $category = showCategoryViaId($film['category_id']);
                //    $categoryName = $category['name'];

                   //Gérer l'affichage de la durée
                       
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
                                     <li><?=$actor?></li>
                                    <?php
                                }
                                ?>
                                </ul>
                            </td>
                            <td> <?= $film['ageLimit'] ?></td>
                            <td> <?= $category['name']?></td>
                            <td> <?= $duration?></td>
                            <td> <?= $film['price'] ?>€</td>
                            <td> <?= $film['stock'] ?></td>
                            <td> <?=substr($film['synopsis'],0, 50) ?>...</td>
                            <td> <?= $film['date'] ?></td>
                            <td class="text-center"><a href="?action=delete&id_film=<?= $film['id_film'] ?>"><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href="filmForm.php?action=update&id_film=<?= $film['id_film'] ?>"><i class="bi bi-pen-fill"></i></a></td>
                           
                        </tr>


                    <?php
                }




                ?>


            </tbody>
            

    </table>


</div>
<?php
require_once "../inc/footer.inc.php";