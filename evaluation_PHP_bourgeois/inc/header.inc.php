<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootswatch cdn 'yeti'-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.5/dist/yeti/bootstrap.min.css">

    <title> Annonces Immobilières</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-success sticky-top flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link fw-bold text-light" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-light" href="annonces.php">Toutes les annonces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-light" href="creeannonce.php">Ajouter une annonce</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <header class="p-5 mb-4 bg-success rounded-3">
        <section class="container-fluid text-center text-light">
            <h1 class="display-6 fw-bold "><?= $h1 ?></h1>
            <p class="col-lg-8 mx-auto fs-6 "><?= $paragraphe ?></p>

        </section>
    </header>
    <main class="container py-5">