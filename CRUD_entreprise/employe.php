<?php
require_once('inc/init.inc.php');
$alert = "";
$h1 = ' Employe';
$paragraphe = "Ici vous pouvez voir l'employé";

if ($_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    $result = $pdoEntreprise->prepare("SELECT * FROM employes WHERE id_employes = :id ");
    $result->execute(array(
        ":id" => $id
    ));
    $employe = $result->fetch();
    if ($employe == false) { //pas de correspondance d'id avec la base
        header("location : employes.php");
    }
} else { // si on n'a pas de valeur d'id dans l'url
    header("location : employes.php");
}
//debug($employe);

require_once('inc/header.inc.php');
?>
<div class="card mb-3">
    <h3 class="card-header"><?= $employe['prenom'] . " " . strtoupper($employe['nom']) ?> </h3>
    <div class="card-body">
        <h5 class="card-title">Service : <?= $employe['service']  ?></h5>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">Date d'embauche : <?= date('d-m-Y', strtotime($employe['date_embauche'])) ?></li>
        <li class="list-group-item">Salaire : <?= $employe['salaire'] ?></li>
        <li class="list-group-item">Genre : <?= $employe['sexe'] == 'f' ? 'Femme' : 'Homme' ?></li>
    </ul>
    <div class="card-body">
        <a href="modifEmploye.php?id=<?= $employe['id_employes'] ?>">Modifier l'employé</a>
    </div>
    <div class="card-footer text-muted">
        Ancienneté : <?= date('Y') - date('Y', strtotime($employe['date_embauche'])) ?> ans
    </div>
</div>


<?php
require_once('inc/footer.inc.php');
?>