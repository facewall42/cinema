    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- bootswatch cdn 'yeti'-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.5/dist/yeti/bootstrap.min.css">

        <title>Entreprise - Accueil</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg bg-primary sticky-top" data-bs-theme="dark">
            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor02">
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="index.php">Insertion des employes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="employes.php">Les employés</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="modifEmploye.php">Modifier</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <header class="p-5 mb-4 bg-light rounded-3">
            <section class="container-fluid py-5">
                <h1 class="display-5 fw-bold"><?= $h1 ?></h1>
                <p class="col-md-8 fs-4"><?= $paragraphe ?></p>

            </section>
        </header>
        <main class="container py-5">