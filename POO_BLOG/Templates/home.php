<?php

include_once 'header.php';


//var_dump($articles);
//echo (count($articles));
?>

<h1 class="my-4 text-center">Bienvenue sur le Blog</h1>
<?php switch (count($articles)):
    case 0: ?>
        <h2 class="mb-4 text-center">Aucun article</h2>
    <?php break;
    case 6: ?>
        <h2 class="mb-4 text-center">Les derniers articles</h2>
    <?php break;
    default: ?>
        <h2 class="mb-4 text-center">Tous les articles</h2>
<?php endswitch; ?>


<div class="container">
    <div class="row">
        <?php foreach ($articles as $article):
            //var_dump($article);
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($article['photo']): ?>
                        <img src="public/assets/images/<?= $article["photo"]; ?>" alt="Photo de l'article" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $article["titre"]; ?></h5>
                        <p class="card-text"><?= $article["contenu"]; ?>...</p>
                        <a href="index.php?action=show&id=<?= $article["id"]; ?>" class="btn btn-primary">Lire l'article</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
include_once 'footer.php';
?>