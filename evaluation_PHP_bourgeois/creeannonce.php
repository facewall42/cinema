<?php
require_once "./inc/init.inc.php";

//-------Initialisation variable info pour bugs de saisie-------------------------------------------------------
$info = "";
$verif = false;
$h1 = 'Annonce Immobilière';
$paragraphe = 'Ajouter une annonce immobilière';

// Contrôle du formulaire et appel de la fonction d'ajout d'annonce
if (!empty($_POST)) {
    $verif = true;

    // Vérification des champs obligatoires
    foreach ($_POST as $key => $value) {
        if ($key !== 'photo' && empty(trim($value))) {
            $verif = false;
        }
    }

    if ($verif === false) {
        $info = alert("Veuillez renseigner tous les champs", "danger");
    } else {
        // Validation des champs
        // Titre
        if (strlen(trim($_POST['title'])) < 5) {
            $info .= alert("Le titre doit contenir au moins 5 caractères", "danger");
            $verif = false;
        }

        // Description
        if (strlen(trim($_POST['description'])) < 20) {
            $info .= alert("La description doit contenir au moins 20 caractères", "danger");
            $verif = false;
        }

        // Code postal
        if (!preg_match('/^[0-9]{5}$/', trim($_POST['postal_code']))) {
            $info .= alert("Le code postal doit contenir exactement 5 chiffres", "danger");
            $verif = false;
        }

        // Ville
        if (preg_match('/[0-9]/', trim($_POST['city']))) {
            $info .= alert("La ville ne doit pas contenir de chiffres", "danger");
            $verif = false;
        }

        // Prix
        if (!is_numeric(trim($_POST['price'])) || trim($_POST['price']) <= 0) {
            $info .= alert("Le prix doit être un nombre positif", "danger");
            $verif = false;
        }

        // Photo
        $photo_uploadee = false;
        $photo_chemin = '';

        if (!empty($_FILES['photo']['name'])) {
            $typesAutorises = ['image/jpeg', 'image/png', 'image/gif'];
            $max_taille = 2 * 1024 * 1024; // 2 Mo

            // Vérification du type et taille
            if (!in_array($_FILES['photo']['type'], $typesAutorises)) {
                $info .= alert("Le fichier doit être une image (JPG, PNG ou GIF)", "danger");
                $verif = false;
            } elseif ($_FILES['photo']['size'] > $max_taille) {
                $info .= alert("L'image ne doit pas dépasser 2 Mo", "danger");
                $verif = false;
            } else {
                // Génération d'un nom unique
                $photo_nom = uniqid() . '_' . basename($_FILES['photo']['name']);
                $photo_chemin = 'assets/img/' . $photo_nom;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_chemin)) {
                    $photo_uploadee = true;
                    $photo = 'assets/img/' . $photo_nom; // Chemin relatif pour la BDD
                } else {
                    $info .= alert("Erreur lors du téléchargement de l'image", "danger");
                    $verif = false;
                }
            }
        } else {
            $info .= alert("Veuillez sélectionner une photo", "danger");
            $verif = false;
        }
    }

    if ($verif && empty($info)) {
        // Récupération des valeurs
        $titre = strtoupper(trim($_POST['title']));
        $description = trim($_POST['description']);
        $code_postal = trim($_POST['postal_code']);
        $ville = trim($_POST['city']);
        $prix = trim($_POST['price']);
        $type = trim($_POST['type']);

        // Appel de la fonction d'ajout
        addAdvert($photo, $titre, $description, $code_postal, $ville, $type, $prix, '');
        $info = alert("Ajout réussi, voir votre annonce <a href='./annonces.php' class='text-success fw-bold'>ici</a>", 'success');
    }
}

require_once "./inc/header.inc.php";
?>

<main>
    <?= $info ?>
    <!-- Formulaire d'ajout d'annonce -->
    <form action="" method="post" class="mb-5" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-6">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
            <div class="col-6">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="10"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="postal_code" class="form-label mb-3">Code postal</label>
                <input type="text" class="form-control fs-5" id="postal_code" name="postal_code" value="<?= htmlspecialchars($_POST['postal_code'] ?? '') ?>">
            </div>
            <div class="col-4">
                <label for="city" class="form-label mb-3">Ville</label>
                <input type="text" class="form-control fs-5" id="city" name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
            </div>
            <div class="col-4">
                <label for="type" class="form-label mb-3">Type</label>
                <select class="form-select" id="type" name="type">
                    <option value="location" <?= (isset($_POST['type']) && $_POST['type'] === 'location' ? 'selected' : '') ?>>location</option>
                    <option value="vente" <?= (isset($_POST['type']) && $_POST['type'] === 'vente' ? 'selected' : '') ?>>vente</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 mb-5">
                <label for="price">Prix</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                    <span class="input-group-text">€</span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-primary p-3 w-25">Ajouter une annonce</button>
        </div>
    </form>

    <?php
    require_once "./inc/footer.inc.php";
    ?>