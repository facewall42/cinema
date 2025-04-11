<?php
require_once('inc/init.inc.php');

$alert = "";
$h1 = 'Liste des employes';
$paragraphe = 'Ici vous pouvez voir la liste des employes';



//partie gestion du GET initialisé dans l'action supprimer&id car & ajoute l'"id" 

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'supprimer') {
    // verifier que l'id est un entier positif
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    //debug($id);
    if ($id > 0) {
        $result = $pdoEntreprise->prepare("DELETE FROM employes WHERE id_employes = :id ");
        $result->execute(array(
            ":id" => $id
        ));

        if ($result->rowCount() > 0) {
            //l'employe a bien ete supprime
            $alert = '<div class="alert alert-success mt-3 text-center "><p>Employé supprimé avec succès !</p></div>';
            header('refresh:4, URL=employes.php');
        } else {
            $alert = '<div class="alert alert-danger mt-3 text-center "><p>Aucun Employé trouvé </p></div>';
        }
    }
}

//connexion a la base entreprise et table employes
$request =  $pdoEntreprise->query("SELECT * FROM employes");
$listeEmployes = $request->fetchAll(); // on veut tous les utilisateurs (on récupère toutes les lignes à la fois), donc on utilise fetchAll(), car fetch() ne donne qu'un élement et le fetch assoce est deja implemente
//debug($result);

//limitation aux 10 derniers employés par defaut : évite une requete supplementaire
$derniersEmployes = array_slice($listeEmployes, -10);
// ecoute si appui sur voir plus viewmore
if (isset($_GET) && !empty($_GET) && (isset($_GET['action']) && $_GET['action'] == 'viewmore')) {
    $employes =  $listeEmployes;
} else {
    $employes = $derniersEmployes;
}

require_once('inc/header.inc.php');
?>
<div class="row">
    <section class="col-12">
        <?= $alert ?>
        <h2>La direction</h2>
        <?php if (isset($_GET['action']) && $_GET['action'] == 'viewmore') {
            echo ('');
        } else {
            echo ('<div class="alert alert-primary mt-3 text-center col-4"><a href="?action=viewmore" class="btn p-1 fs-6"> Voir plus d\'employés </a></div>');
        } ?>

        <!-- Lien pour voir plus de films -->
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Genre</th>
                    <th>Service</th>
                    <th>Salaire</th>
                    <th>Date d'embauche</th>
                    <th>Consulter</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>

                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($employes as $employe) {
                ?>
                    <tr>
                        <!-- On affiche le nom de l'employé -->
                        <td><?= ucfirst($employe['nom']) ?></td>

                        <!-- On affiche le prénom de l'employé -->
                        <td><?= ucfirst($employe['prenom']) ?></td>

                        <!-- On affiche le genre avec une condition ternaire pour transformer "f" ou "h" en texte lisible -->
                        <td><?= $employe['sexe'] == 'f' ? 'Femme' : 'Homme' ?>
                        </td>

                        <!-- On affiche le service dans lequel travaille l'employé -->
                        <td><?= $employe['service'] ?></td>

                        <!-- On affiche le salaire -->
                        <td><?= $employe['salaire'] ?></td>

                        <!-- On affiche la date d'embauche, formatée en jj-mm-aaaa -->
                        <td>
                            <?php
                            // On transforme la date au format souhaité (français) grâce aux fonctions strtotime() et date()
                            // strtotime() convertit la date au format timestamp (secondes depuis le 1er janvier 1970)
                            /* 
                                La fonction date() est une fonction prédéfinie en PHP qui permet de formater une date selon le format souhaité.
                                Le premier argument est une chaîne de caractères qui indique le format d'affichage désiré (attention, elle est sensible à la casse),
                                et le second argument est un timestamp sur lequel appliquer ce format.

                                La fonction strtotime() est également une fonction prédéfinie. Elle permet de convertir une date sous forme de chaîne de caractères 
                                (en général au format 'YYYY-MM-DD') en timestamp Unix (c'est-à-dire un nombre représentant le nombre de secondes depuis le 1er janvier 1970).

                                Grâce à strtotime(), on peut donc reformater une date textuelle en un format lisible pour l'utilisateur, en l'associant à la fonction date().
                            */

                            $date = date('d-m-Y', strtotime($employe['date_embauche']));
                            echo ($date);
                            ?>
                        </td>
                        <td><a href="employe.php?id=<?= $employe['id_employes'] ?>"><i class="fa-solid fa-eye"></i></a></td>
                        <td><a href="modifEmploye.php?id=<?= $employe['id_employes'] ?>"><i class="fa-solid fa-pen"></i></a></td>
                        <td><a href="?action=supprimer&id=<?= $employe['id_employes'] ?>"><i class="fa-solid fa-trash"></i></a></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>
</div>


<?php
require_once('inc/footer.inc.php');
?>