<!doctype html>
<html lang="fr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Cours PHP - Les conditions</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.png">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top" >
        <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="logo php"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="index.php">Introduction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="02_bases.php">Les bases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="03_variables_constantes.php">Les variables et les constantes</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="04_conditions.php">Les conditions en PHP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="05_boucles.php">Les boucles en PHP</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="06_inclusions.php">Les importations des fichier</a>
                    </li>
                    
                </ul>
        
            </div>
        </div>
    </nav>
    <header class="p-5 m-4 bg-light rounded-3 border ">
            <section class="container py-5">
                <h1>Les boucles en PHP</h1>
                <p class="col-md-12 fs-4">Les boucles (aussi appelées structures itératives) sont un moyen de répéter plusieurs fois un même morceau de code. Une boucle est donc une répétition, comme on a pu le voir en JS</p>
            </section>
    </header><!-- fin header -->
    
    <main class="container-fluid px-5">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h2>Boucle "while"</h2>
                    <p>La boucle "<span>while</span>" est, comme en JS, une boucle permettant d'exécuter un code "TANT QUE" la condition d'entrée n'a pas été remplie</p>
                    <?php
                        $a = 0; // Initialisation de la variable $a à 0 => valeur de départ pour la boucle 
                        while($a < 5){ // Boucle TANT QUE $a est strictement inférieur à 5
                            echo "<p class=\"alert alert-primary\">Tour n°{$a}</p>"; // Affichage du nombre de tour
                            $a++; // Incrémentation de la variable $a afin que la condition d'entrée devienne "false" à un moment donné 
                        }
                        echo "<p>Exercice : Afficher les années de 1920 à 2025</p>";

//********************************* */ Exercice
                        // À l'aide d'une boucle "while", afficher les années de 1920 à 2023 dans un menu déroulant.

                        $startingYear = 1920;
                      
                            echo'<form>
                            <select class="form-select form-select-lg" name="" id="">';

                            while($startingYear <= 2025){
                            echo"<option value = \"$startingYear\">$startingYear</option>";
                            $startingYear++;
                            }
                            
                            echo '</select></form>';

// ********************************************************************
                        // echo "<p>Méthode 1</p>";
                        // $year = 1920;

                        // echo "<form><select name=\"année\">";

                        // while($year < 2024){
                        //     echo "<option value=\"$year\">{$year}</option>";
                        //     $year++;
                        // }

                        // echo "</select></form>";
                    ?>

<!-- *******************************2eme methode **************-->


                    <form action="#" class="mt-3">
                        <select class="form-select form-select-lg" name="" id="">
                        <?php
                            $annee = 2025;
                            while($annee > 1919) {
                                ?>
                                <option value="
                                    <?= $annee ; ?>">
                                    <?= $annee;?>
                                </option>
                            <?php
                            $annee--;
                            }
                            ?>
                        </select>
                    </form>
                            <!-- ?php echo se resume à ?= -->
                                <!-- <option value="
                                <?php echo $annee ; ?>">
                                <?php echo $annee;?>
                            </option> -->

<!--********************************* CODE AMELIORE *****************************-->

                    <form action="traitement.php" method="POST" class="mt-3">
                        <select class="form-select form-select-lg" name="annee" id="annee">
                        <?php
                        $annee = 2029;
                            while ($annee > 1919) {
                                $selected = ($annee == 2025) ? 'selected' : ''; // Pré-sélectionne 2025
                                echo "<option value='$annee' $selected>$annee</option>";
                                $annee--;
                            }
                        ?>
                        </select>
                    <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
                    </form>


<!-- ***************************<p>Méthode 2</p>
                    <form>
                        <select name="annee">
                        <?php
                            $annee = 1920;
                            while($annee <= 2023) {
                            echo "<option value=\"$annee\">$annee</option>";
                            $annee++;
                            }
                        ?>
                        </select> ***************************************-->

                    </form>
                    <p>Exercice bonus : Afficher les années de 2023 à 1920</p>
                    <p>Méthode 1</p>
                    <form>
                        <select name="year">
                    <?php
                        // Exercice bonus : faire la même chose en décrémentant, de 2023 à 1920
                        $year2 = 2023;
                        while($year2 >= 1920) {
                            echo "<option value=\"$year2\">$year2</option>";
                            $year2--; // Décrémentation de la variable $year2 afin que la condition d'entrée devienne "false" à un moment donné 
                        }
                    ?>
                        </select>
                    </form>
                    <p>Méthode 2</p>
                    <?php $year3 = 2023;?>
                    <form action="#">
                        <select name="<?php echo $year3;?>">
                            <?php
                                while($year3 >= 1920){
                            ?>
                            <option value="<?php echo $year3;?>"><?php echo $year3;?></option>
                            <option value="<?php echo $year3;?>"><?= $year3;?></option>
                            <?php
                                $year3--; 
                                }
                            ?>
                        </select>
                    </form>
                    <p>Méthode 3</p>
                    <?php $year4 = 2023;?>
                    <form action="#">
                        <select name="<?= $year4;?>">
                            <?php
                                while($year4 >= 1920){
                            ?>
                            <option value="<?= $year4;?>"><?= $year4;?></option>
                            <?php
                                $year4--; 
                                }
                            ?>
                        </select>
                    </form>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h2>Boucle "do", "while"</h2>
                    <p>Cette boucle fonctionne avec la même instruction que la boucle "<span>while</span>". Cependant pour cette boucle, la condition est testée à la fin et pas au début</p>
                    <p>La boucle "<span>do</span>" "<span>while</span>" a la particularité de s'exécuter au moins une fois puis TANT QUE la condition de fin est vraie</p>
                    <?php
                        $i = 0; // Déclaration et initialisation de la variable 
                        do{ // Ici on exécute d'abord cette première partie avant même de regarder la condition
                            echo "<p class=\"alert alert-primary\">$i</p>"; // Affiche la valeur de $i
                            $i++; // Incrémentation
                        } while($i > 100) // Condition, si elle est true, le code s'arrête ici sinon la boucle s'exécute jusqu'à ce que la condition soit vraie
                    ?>
                </div>
                <div class="col-sm-12 col-md-6 mt-5">
                    <h2>Boucle "for"</h2>
                    <p>La boucle "<span>for</span>", comme toutes les boucles, sert à répéter un morceau de code TANT QUE la condition n'est pas respecté. Sa structure est cependant différente : </p>
                    <ol>
                        <li><span>Initialisation de la variable</span></li>
                        <li><span>Condition de sortie</span></li>
                        <li><span>Incrémentation de la variable</span></li>
                    </ol>
                        <?php
                        for ($i=0; $i <15 ; $i++) { // je lance ma boucle for avec les options citées au dessus 
                            echo "<p>Tour n° $i</p>"; // Dans les accolades, je précise le code à répéter
                        }
                        ?>

                    <?php
                        for($u = 1; $u <= 5; $u++){ // Lancement d'une boucle "for" avec les options ci-dessus 
                            echo "<p class=\"alert alert-primary\">Tour n°{$u}</p>";
                        }

                        echo "<p>Exercice : Créer formulaire de sélection de date de naissance</p>";


// *********************Exercice : Créer en PHP un formulaire de sélection de date de naissance (jour - mois - année)
                        
                        echo "<form class='mt-3 col-3'> 

                                <label for='jourNaissance'>Jours</label>
                                <select class='form-select form-select-lg' name='jour'>";

                                for($days = 0; $days <= 31; $days++){
                                echo "<option value='$days'>{$days}</option>";
                                }                                
                                echo "</select>";

                                echo "<label for='moisNaissance'>Mois</label> <select class='form-select form-select-lg' name='mois'>";
                                
                                for($months = 0; $months <= 12; $months++){
                                    echo "<option value='$months'>{$months}</option>";
                                }
                                echo "</select>";

                                echo "<label for='annéeNaissance'> Année </label>
                                <select class='form-select form-select-lg' name='année'>";

                                for($annees = 1970; $annees < 2026; $annees++){
                                echo "<option value='$annees'>{$annees}</option>";
                                }    
                        
                        echo "</select> </form> <br>";

// version precedente du cours***********************************************************
                        echo "<form><label for=\"years-select\">Année</label><select name=\"année\">";
                        for($years = 1920; $years < 2024; $years++){
                            echo "<option value=\"$years\">{$years}</option>";
                        }
                        echo "</select>";

                        echo "<label for=\"days-select\">Jours</label>
                        <select name=\"jour\">";
                        for($days = 0; $days <= 31; $days++){
                            echo "<option value=\"$days\">{$days}</option>";
                        }
                        echo "</select>";

                        echo "<label for=\"months-select\">Mois</label><select name=\"mois\">";
                        for($months = 0; $months <= 12; $months++){
                            echo "<option value=\"$months\">{$months}</option>";
                        }
                        echo "</select></form>";

// ******************EXERCICE *********************************************************
                        
                        echo "<p>Exercice : Créer un tableau qui affiche 0 à 9 sur une seule ligne</p>"; 

                        echo "<div class='table-responsive'>
                        <table class='table table-bordered mt-5'>
                        <caption>Liste des chiffres</caption>
                        <thead class = bg-primary>
                            <tr>";
                            for($num = 1; $num < 11; $num++){
                                echo "<th scope='col'>Colonne numéro $num</th>";
                                }                                
                        echo "</tr></thead>";
                            
                        echo"<tbody>
                            <tr>";
                            for($num = 0; $num < 10; $num++){
                                echo "<td class='text-center'>$num</td>";
                            }  

                        echo "</tr></tbody></table> </div>";
    
//********************** Solution 1 :
                        echo 
                        "<table class=\"table table-bordered mt-5\">
                        <tr>";

                        for($i=1; $i<=10; $i++){
                        echo"<td>Colonne numéro $i </td>";   
                        }
                        echo "</tr> <tr>";
                        for($i=0; $i<10; $i++){
                        echo"<td> $i </td>";   
                        }

                        echo "</tr>
                        </table>";
                    ?>
                </div>
//********************************************************************************** */            
                <div class="col-sm-12 col-md-6 mt-5">

                    <h2>Boucle "foreach"</h2>
                    <p>La boucle foreach sert à parcourir un tableau (array() ou []). On verra cette boucle plus en détails dans la page dédiée aux array().</p>
                    <p class="alert alert-danger">Attention. Lorsque que vous faites une boucle, vérifiez votre condition de sortie ainsi que l'incrémentation de votre variable. Sans incrémentation, vous aurez une boucle infinie.</p>
                    <p class="alert alert-secondary">A force d'utiliser les boucles, il sera de plus en plus logique de choisir telle ou telle boucle pour tel ou tel usage.</p>
                </div>
            </div>
    </main>
    <footer>
        <div class="d-flex justify-content-evenly align-items-center bg-dark text-white p-3">
        <a class="nav-link" target="_blank" href="https://www.php.net/manual/fr/langref.php">Doc PHP</a>
        <a class="nav-link" href="01_index.php"><img src="assets/img/logo.png" alt="logo php"></a>
        <a class="nav-link" target="_blank" href="https://devdocs.io/php/">DevDocs</a>
        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>
</html>
