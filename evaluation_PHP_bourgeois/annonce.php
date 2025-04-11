<?php
require_once('inc/init.inc.php');

$h1 = 'Annonces Immobilières';
$paragraphe = 'Détail de l\'annonce';
$info = '';

if (!isset($_GET['id_annonce'])) {
    header('Location: annonces.php');
    exit;
}

// Récupération de l'annonce
$annonce = getAdvert($_GET['id_annonce']);

// Traitement du formulaire de réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_message'])) {
    $messageReservation = trim($_POST['reservation_message']);

    if (!empty($messageReservation)) {
        // Mise à jour de la réservation en BDD
        if (updateReservation($_GET['id_annonce'], $messageReservation)) {
            $info = alert("Votre demande de réservation a bien été enregistrée", "success");
            // Rechargement des données de l'annonce
            $annonce = getAdvert($_GET['id_annonce']);
        } else {
            $info = alert("Une erreur est survenue lors de l'enregistrement", "danger");
        }
    } else {
        $info = alert("Veuillez saisir un message de réservation", "warning");
    }
}

require_once('inc/header.inc.php');
?>

<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card h-100">
                <img src="<?= $annonce['photo'] ?>" class="card-img-top" alt="<?= htmlspecialchars($annonce['title']) ?>" style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars(strtoupper($annonce['title'])) ?></h3>
                    <h4 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($annonce['city']) ?></h4>

                    <div class="mb-3">
                        <span class="fw-bold">Description:</span>
                        <p class="card-text"><?= htmlspecialchars($annonce['description']) ?></p>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <p class="card-text"><span class="fw-bold">Prix:</span> <?= htmlspecialchars($annonce['price']) ?> €</p>
                        </div>
                        <div class="col-md-4">
                            <p class="card-text"><span class="fw-bold">Type:</span> <?= htmlspecialchars($annonce['type']) ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="card-text"><span class="fw-bold">Code postal:</span> <?= htmlspecialchars($annonce['postal_code']) ?></p>
                        </div>
                    </div>

                    <!-- Section Réservation -->
                    <div class="mt-4 border-top pt-3">
                        <h5 class="mb-3">État de réservation</h5>

                        <?php if (!empty($annonce['reservation_message'])): ?>
                            <!-- Afficher le message de réservation existant -->
                            <div class="alert alert-info">
                                <p class="fw-bold">Message de réservation :</p>
                                <p><?= htmlspecialchars($annonce['reservation_message']) ?></p>
                            </div>
                        <?php else: ?>
                            <!-- Afficher le formulaire de réservation -->
                            <form method="post" class="mt-3">
                                <div class="mb-3">
                                    <label for="reservation_message" class="form-label">Message de réservation</label>
                                    <textarea class="form-control" id="reservation_message" name="reservation_message" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Je réserve</button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4">
                        <a href="./annonces.php" class="btn btn-primary">Retour à la liste des annonces</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('inc/footer.inc.php');
