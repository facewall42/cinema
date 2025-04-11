<?php
require_once('inc/init.inc.php');

$h1 = 'Annonces Immobilières';
$paragraphe = 'Tous nos biens immobiliers';
$annonces = getAdverts();

require_once('inc/header.inc.php');
?>

<div class="container">
    <div class="row">
        <?php foreach ($annonces as $annonce):
            // Détermine si l'annonce est réservée en verifiant si la colonne 'reservation_message' n'est pas vide
            $estReservee = !empty($annonce['reservation_message']);
            // Classe CSS et style de l'image en fonction de la réservation
            $classeCarte = $estReservee ? 'border-secondary bg-light position-relative' : '';
            // Style de l'image, on utilise une condition ternaire pour appliquer le filtre si l'annonce est reservée
            $styleImage = $estReservee ? 'filter: grayscale(70%); opacity: 0.5;' : '';
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 <?= $classeCarte ?>">
                    <!-- Ajoute le badge "Réservé" si l'annonce est reservée -->
                    <?php if ($estReservee): ?>
                        <span class="position-absolute top-50 start-50 translate-middle badge rounded-pill bg-danger">
                            Réservé
                            <span class="visually-hidden">Annonce réservée</span>
                        </span>
                    <?php endif; ?>

                    <img src="<?= $annonce['photo'] ?>"
                        class="card-img-top"
                        alt="<?= htmlspecialchars($annonce['title']) ?>"
                        style="height: 200px; object-fit: cover; <?= $styleImage ?>">

                    <div class="card-body">
                        <h3 class="card-title"><?= htmlspecialchars(strtoupper($annonce['title'])) ?></h3>
                        <h4 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($annonce['city']) ?></h4>
                        <p class="card-text">
                            <span class="fw-bold">Résumé:</span>
                            <?= htmlspecialchars(substr($annonce['description'], 0, 50)) ?>...
                        </p>
                        <!-- Ajoute le message de reservation si l'annonce est reservée -->
                        <?php if ($estReservee): ?>
                            <div class="alert alert-warning py-1 mb-3">
                                <small>Cette annonce est réservée</small>
                            </div>
                        <?php endif; ?>

                        <a href="./annonce.php?action=view&id_annonce=<?= $annonce['id_advert'] ?>" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once('inc/footer.inc.php');
