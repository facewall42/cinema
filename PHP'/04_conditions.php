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
           
<h1>Les conditions en PHP</h1>
<p class="col-md-12 fs-4"> Les conditions sont un chapitre clé en PHP comme dans les autres langages de programmation. Par exemple, lorsque l'on fera une page de connexion, on aura la condition suivante : Si l'adresse existe dans la BDD et SI le mdp correspond à l'adresse, l'utilisateur est connecté SINON il reste sur la page avec un message d'erreur </p>

            </section>
    </header><!-- fin header -->
    
<main class="container px-5">

<div class="col-sm-12">
<h2>Condition simple "if", "else"</h2>
<?php
    $a = 10;
    $b = 5;
    $c = 2;

    if ($a > $b){ // Si la condition est vraie alors on exécute le code suivant
        echo "<p class=\"alert alert-success\">\"a\" qui contient $a est strictement supérieur à \"b\" qui vaut $b</p>";
    } else{ // Sinon on exécute celui-ci
        echo "<p class=\"alert alert-danger\">\"b\" qui contient $b est strictement supérieur à \"a\" qui vaut $a</p>";
    }

    if ($a > $c){ // Si la condition est vraie alors on exécute le code suivant
        echo "<p class=\"alert alert-success\">\"a\" qui contient $a est strictement supérieur à \"c\" qui vaut $c</p>";
    } else{ // Sinon on exécute celui-ci
        echo "<p class=\"alert alert-danger\">\"c\" qui contient $c est strictement supérieur à \"a\" qui vaut $a</p>";
    }?>

    <h2>Condition multiple "if", "else if", "else"</h2>
    <p>Grâce à une condition multiple, on peut vérifier si "a" est strictement égal à 8, dans un second temps si "a" est différent de 10 et enfin si aucune de ces conditions n'est vrai</p>
    <?php
        if ($a === 8){ // Si la condition est vraie alors on exécute le code suivant
            echo "<p class=\"alert alert-danger\">\"a\" est égal à 8.</p>";
        } else if($a !== 10){ // Sinon si, on exécute celui-ci
            echo "<p class=\"alert alert-danger\">\"a\" est différent de $a.</p>";
        } else{ // Sinon on exécute celui-ci
            echo "<p class=\"alert alert-success\">\"a\" est égal à $a.</p>";
        }

    if ($a == 7){
        echo "a = 7 strictement";
    }
        elseif ($a != 10){
            echo "a diff de 10";
        } else{
            echo "a diff de 7 et egal a 10";
        }
        ?>

<h2>Conditions ternaire</h2>
            <?php
                // la condtion ternaire est une autre syntaxe pour écrire un "if", "else"
                echo ($a === 10) ? "<p class=\"alert alert-success\">\"a\" est égal à $a</p>" : "<p class=\"alert alert-danger\">\"a\" est différent de 10</p>"; // Dans la ternaire le "?" remplace le "if" et le ":" remplace le "else".
            ?>

            <h2>Condition simple "AND", "&&"</h2>
            <?php
                if ($a > $b && $b > $c){ // Si la condition est vraie alors on exécute le code suivant
                    echo "<p class=\"alert alert-success\">\"a\" qui contient $a est strictement supérieur à 'b' qui vaut $b et 'b' est strictement supérieur à \"c\" qui vaut $c</p>";
                } else{ // Sinon on exécute celui-ci
                    echo "<p class=\"alert alert-danger\">Une des deux conditions est fausse</p>";
                }
            ?>
            <p>Comme en JS, la condition avec "<span>&&</span>" attend forcément que chaque condition soit "true". Si une des conditions est fausse alors le script continuera au "else" ou n'affichera rien.</p>
            <h2>Condition simple "OR", "||"</h2>
            <?php 
                if ($a == 9 || $b > $c){ // Si la condition est vraie alors on exécute le code suivant
                    echo "<p class=\"alert alert-success\">Une des deux conditions est vraie alors le code renvoie \"true\" et le \"if\" s'exécute.</p>";
                } else{ // Sinon on exécute celui-ci
                    echo "<p class=\"alert alert-danger\">Aucune des conditions n'est vraie.</p>";
                }
            ?>

<h2>Condition simple "AND", "&&"</h2>
            <?php
                if ($a > $b && $b > $c){ // Si la condition est vraie alors on exécute le code suivant
                    echo "<p class=\"alert alert-success\">\"a\" qui contient $a est strictement supérieur à 'b' qui vaut $b et 'b' est strictement supérieur à \"c\" qui vaut $c</p>";
                } else{ // Sinon on exécute celui-ci
                    echo "<p class=\"alert alert-danger\">Une des deux conditions est fausse</p>";
                }
            ?>
            <p>Comme en JS, la condition avec "<span>&&</span>" attend forcément que chaque condition soit "true". Si une des conditions est fausse alors le script continuera au "else" ou n'affichera rien.</p>
            <h2>Condition simple "OR", "||"</h2>
            <?php 
                if ($a == 9 || $b > $c){ // Si la condition est vraie alors on exécute le code suivant
                    echo "<p class=\"alert alert-success\">Une des deux conditions est vraie alors le code renvoie \"true\" et le \"if\" s'exécute.</p>";
                } else{ // Sinon on exécute celui-ci
                    echo "<p class=\"alert alert-danger\">Aucune des conditions n'est vraie.</p>";
                }
            ?>
            <p>Lorsque l'on utilise "<span>OR</span>" "<span>||</span>", on attend que seule une des deux conditions soit vraie.</p>
            <h2>Condition simple "XOR"</h2>
            <p>Alors que "<span>OR</span>" s'exécute si une des conditions est vraie, le "<span>XOR</span>" quand à lui ne s'exécute pas si les deux conditions sont bonnes ou si elles sont fausses. Seul une des conditions peut être "true".</p>
            <?php
                if ($a == 10 XOR $b == 5){ // Si la condition est vraie alors on exécute le code suivant
                    echo "<p class=\"alert alert-success\">Une des deux conditions est vraie alors le code renvoie \"true\" et le \"if\" s'exécute.</p>";
                } else{ // Sinon on exécute celui-ci
                    echo "<p class=\"alert alert-danger\">Aucune des conditions n'est vraie ou toutes conditions sont vraies alors le \"else\" s'exécute.</p>";
                }
            ?>
            <h2>Condition multiple "if", "else if", "else"</h2>
            <p>Grâce à une condition multiple, on peut vérifier si "a" est strictement égal à 8, dans un second temps si "a" est différent de 10 et enfin si aucune de ces conditions n'est vrai</p>
            <?php
                if ($a === 8){ // Si la condition est vraie alors on exécute le code suivant
                    echo "<p class=\"alert alert-danger\">\"a\" est égal à 8.</p>";
                } else if($a !== 10){ // Sinon si, on exécute celui-ci
                    echo "<p class=\"alert alert-danger\">\"a\" est différent de $a.</p>";
                } else{ // Sinon on exécute celui-ci
                    echo "<p class=\"alert alert-success\">\"a\" est égal à $a.</p>";
                }
            ?>
            <h2>Conditions ternaire</h2>
            <?php
                // la condtion ternaire est une autre syntaxe pour écrire un "if", "else"
                echo ($a === 10) ? "<p class=\"alert alert-success\">\"a\" est égal à $a</p>" : "<p class=\"alert alert-danger\">\"a\" est différent de 10</p>"; // Dans la ternaire le "?" remplace le "if" et le ":" remplace le "else".
            ?>
            <h2>Opérateurs "==", "==="</h2>
            <p>L'opérateur "<span>==</span>" permet de comparer une valeur égalité de valeur, alors que l'opérateur "<span>===</span>" permet de comparer de façon stricte (égalité de valeur et de type)</p>
            <?php
                $varA = 1; // INT
                $varB = '1'; // STRING
                // == 
                if ($varA == $varB){ // Condition vraie car 1 et '1' sont équivalents
                    echo "<p class=\"alert alert-success\">\"varA\" et \"varB\" sont de même valeur.</p>";
                } else{
                    echo "<p class=\"alert alert-danger\">\"varA\" et \"varB\" ne sont pas de même valeur.</p>";
                }
                // ===
                if ($varA === $varB){ // Condition fausse car 1 et '1' sont équivalents mais ne sont pas du même type
                    echo "<p class=\"alert alert-success\">\"varA\" et \"varB\" sont de même valeur.</p>";
                } else{
                    echo "<p class=\"alert alert-danger\">\"varA\" et \"varB\" ne sont pas de même type.</p>";
                }
            ?>
            <h2>Condition avec opérateur combiné "<=>"</h2>
            <?php
                $a = 11; 
                $b = 5;
                echo "<p class=\"alert alert-primary\">".'($a <=> $b) = '.($a <=> $b)."</p>"; // Affiche 1
                $b = 11;
                echo "<p class=\"alert alert-primary\">".'($a <=> $b) = '.($a <=> $b)."</p>"; // Affiche 0
                $b = 12;
                echo "<p class=\"alert alert-primary\">".'($a <=> $b) = '.($a <=> $b)."</p>"; // Affiche -1
                /* 
                * Ici l'opérateur combiné compare à la fois le "<", "=" et ">" en retournant respectivement la valeur 1, 0 et -1
                * "<" ==> -1 si a < b 
                * "=" ==> 0 si a = b
                * ">" ==> 1 si a > b 
                */
                $a = 50;
                $b = 29;
                if(($a <=> $b) == 1){
                    echo "<p class=\"alert alert-primary\">\"a\" est supérieur à \"b\". ".'($a <=> $b) = '.($a <=> $b)."</p>";
                } else if(($a <=> $b) == 0){
                    echo "<p class=\"alert alert-primary\">\"a\" est égal à \"b\". ".'($a <=> $b) = '.($a <=> $b)."</p>";
                } else if(($a <=> $b) == -1){
                    echo "<p class=\"alert alert-primary\">\"a\" est inférieur à \"b\". ".'($a <=> $b) = '.($a <=> $b)."</p>";
                }
            ?>
            <h2>Condition avec "switch"</h2>
            <?php 
                // La condition switch est une autre syntaxe pour écrire un if else if else quand on veut comparer une variable à une multitude de valeurs 
                $langue = 'chinois';
                switch ($langue) {
                    case 'français':
                        echo "<p class=\"alert alert-primary\">Bonjour ! (langue = $langue)</p>";
                        break;
                    case 'italien':
                        echo "<p class=\"alert alert-primary\">Ciao ! (langue = $langue)</p>";
                        break;
                    case 'espagnol':
                        echo "<p class=\"alert alert-primary\">Hola ! (langue = $langue)</p>";
                        break;
                    default:
                        echo "<p class=\"alert alert-primary\">Nǐ hǎo ! (langue = $langue)</p>";
                        break;
                }
                // switch avec l'opérateur de combinaison

                switch ($a <=> $b) {
                    case -1 :  
                        echo 'a est plus petit que b';
                    break; // "break" est obligatoire pour quitter le witcgh une fois un "case " est exécuté
                     case 0 :
                         echo 'a est égal à b' ;
                    break;
                    case 1 :
                         echo 'a est plus grand que b';
                    break;
                
              }
            ?>
        </div>
<</div>


?>
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