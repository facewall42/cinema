<?php
require_once "inc/functions.inc.php";


$info = '';
if (isset($_GET) && !empty($_GET)) {

    if (isset($_GET['id_category'])) {
      
        $idCategory = htmlentities($_GET['id_category']);

        if (is_numeric($idCategory)) {
        
            $cat = showCatviaId($idCategory);

            if (($cat['id_category'] != $idCategory )  || empty($idCategory) ) {

                header('location:index.php');

            }else {


                $v = filmbycategory($idCategory);

                $message = "Cette catégorie contient : ";

                if (!$v) {

                    $info = alert("Désolé ! cette catégorie ne contient aucun film", "danger");

                }

            }
        }else {
        header('location:index.php');
        }

    }elseif (isset($_GET['action']) && $_GET['action'] == 'voirplus' ) {
    $v = allfilm();
    $message = "Le nombre total de films est : ";
    }

}else {
    $v = filmBydate();
    $message = "Le nombre de films sortie en dernier est : ";
}

require_once "inc/header.inc.php";

?>

<div class="films">
    <h2 class="fw-bolder fs-1 mx-5 text-center"><?=$message .count($v)?></h2>
    <div class="row">
        <?php
        echo $info;
        foreach ($v as $key => $value) {
        ?>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
            <div class="card">
                <img src="<?=RACINE_SITE?>assets/img/<?=$value['image']?>" alt="" >
                <div class="card-body">
                    <h3><?=$value['title']?></h3>     
                    <h4><?=$value['director']?></h4>
                    <p><span class="fw-bolder"><?=substr($value['synopsis'], 0,90). '...'?></span></p>
                    <a href="<?=RACINE_SITE?>showFilm.php?id_film=<?=$value['id_film']?>"class="btn">Voir plus</a>                            
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="col-12 text-center">
          <?= count($v) == 0 || isset($_GET['action']) && $_GET['action'] == 'voirplus' ? '<a href="'.RACINE_SITE.'index.php" class="btn p-4 fs-3"> Retourner à l\'accueil </a>' : '<a href="'.RACINE_SITE.'?action=voirplus" class="btn p-4 fs-3"> Accéder à tout les films </a>' ?>
        </div>
    </div>
</div>

<?php
require_once "inc/footer.inc.php";
?>