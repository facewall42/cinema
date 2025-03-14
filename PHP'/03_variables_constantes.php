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
    <title>Cours PHP - Variables constantes</title>
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
                <h1 class="display-5 fw-bold">Les bases du PHP</h1>
            </section>
    </header><!-- fin header -->
    <main class="container px-5">
        <?php 
                echo "<h2>Les variables utilisateurs / affectation / concaténation</h2>";

             
                $number = 127; // on declare la variable number et affecte la valeur 127
                echo 'Ma variable $number vaut : '. $number . '<br>';
                echo "Ma variable \$number vaut : ".$number. '<br>' ;

                // gettype() donne le type de variable :
                echo " le type de variable de \$number est : ".gettype($number).'<br>';

             
                $double = 1.5;
                echo "Ma variable \$double vaut : ".$double.'<br>';
                echo " le type de variable de \$double est : ".gettype($double).'<br>';

             

                $chaine = 'une chaine de caracteres entre simples quotes';
                echo "Ma variable \$chaine vaut : ".$chaine.'<br>';
                echo " le type de variable de \$chaine est : ".gettype($chaine).'<br>';

             

                $chaine2 = '127';
                echo "Ma variable \$chaine2 vaut : ".$chaine2.'<br>';
                echo " le type de variable de \$chaine2 est : ".gettype($chaine2).'<br>';

             
// attention la syntaxe entre backquotes ne sert que pour executer une commande shell:

                $chaine3entrebackquotes = `Une chaine de caractère entre deux backquotes`;
                echo 'Ma variable $chaine3entrebackquotes vaut : ' .$chaine3entrebackquotes. '<br>';
                echo 'Le type de ma variable $chaine3entrebackquotes est : ' . gettype($chaine3entrebackquotes) . '<br>';

                echo `le type de variable $chaine3entrebackquotes entre backquote vaut {$chaine3entrebackquotes}`. '<br>';

               /* pour executer du bash et l'afficher :*/
                echo "mettre une commande de shell entre backquotes execute la commande, comme ls: ". `ls`.'<br>';

                // Concatenation, affectation combinée :
                // concatenation avec l'operateur ".=" pour les chaines de caractères
                $prenom = "Thomas";
                echo $prenom.'<br>';
                echo $prenom.=" Bauer".'<br>';
                echo $prenom.'<br>';

                $age = 30;
                echo'<p>Bonjour '.$prenom.'tu as '.$age .' ans</p>';
               

// on insere des variables dans le html avec *************************************************************************

$bleu ="primary";
$blanc ="white";
$rouge ="danger";

               echo " <div class='.d-flex justify-content-center bg-dark p-5 m-auto m-5 rounded'. style='.width: 40%;'.>
              <div class='bg-$bleu text-center fw-bold'. style='.width: 50px; height: 80px; line-height: 80px'.>
                 
              </div>
              <div class='bg-$blanc text-center fw-bold'. style='.width: 50px; height: 80px; line-height: 80px'.>
                  
              </div>
              <div class='bg-$rouge text-center fw-bold'. style='.width: 50px; height: 80px; line-height: 80px'.>
                  
              </div>

          </div>";


          echo "<h2 class='mt-5'> Opérateurs numériques </h2>";


    $a = 10;
    $b = 2;
    //10   //2
    echo " $a + $b = " . $a + $b . "<br>"; // affiche 12  
    echo " $a - $b = " . $a - $b . "<br>"; // affiche 8
    echo " $a * $b = " . $a * $b . "<br>"; // affiche 20
    echo " $a / $b = " . $a / $b . "<br>"; // affiche 5
    echo " $a % $b = " . $a % $b . "<br>"; // affiche 0

    ############

  //Incrémenter et décrémenter
  echo "<br>";
  $i = 0;
  $i++; // 
  echo $i;
  echo "<br>";
  $i--;
  echo $i;
       

  echo '<h2 class="mt-5"> Les variables prédéfinies : super-globale </h2>';

  echo $_SERVER["HTTP_HOST"].'<br>';
  /* 
  echo '<pre>'.'<br>';
  var_dump($_SERVER);
  echo '</pre>'; */


  // Je veux afficher le contenu de ma super_global  $_SERVER["HTTP_HOST"] dans une chaine de caractère: 
  $message = " Le nom de domaine à partir duquel j'affiche ma page c'est :  <strong> {$_SERVER["HTTP_HOST"]}</strong> <br>";
  echo $message; // J'utilise les accolades pour intégrer ma variable $_SERVER["HTTP_HOST"]  dans une chaine de caractère

  echo '<h2 class"mt-5">Transtypage des variables</h2>';
  $string1 = '100';
  var_dump($string1);
  echo'<br>';
  $string1 = (int)'100';

  var_dump($string1); // le type change
  echo'<br>';

  $string2 = (float)'12.5';
   var_dump($string2);
   echo'<br>';
   $string3 = (int)'12.5';
   var_dump($string3);
   echo'<br>';
   echo'<br>';
   $float = 12.5;
   $float = (string)12.5;
   var_dump($float);


   echo '<h2 class="mt-5"> Constante utilisateurs </h2>';

   # Avec la fonction prédéfinie define()

   // le nom de la constante : "CHAINE", la valeur de la constante : "la valeur de la constante CHAINE";

   define('CHAINE','la valeur de la constante CHAINE');
   echo CHAINE .'<br>';
   define('ENTIER', 30);
  //  define('ENTIER', '30');
   echo ENTIER .'<br>';
  //  echo gettype(ENTIER); 

   //je veux récupèrer la valeur de  ma constante dans une chaine de caractères
   echo "J'ai ENTIER ans"; // Pas d'interprétation de la constante ENTIER et l'affichage de sa valeur
   echo'<br>';
   echo "J'ai ". ENTIER ." ans <br>"; // Avec les constantes on ne peut pas utiliser le mécanisme de la subtitution des variables


    #Constante avec le mot const
    const SEMAINE = 52;
    const HEBDOMADAIRE = 35;
    const MOIS = 12;
 
    const HEURES = SEMAINE/MOIS * HEBDOMADAIRE;
    echo HEURES ;
    echo'<br>';

// pour affecter a une constante une valeur issue d'une fonction :
    define("NBR_AU_PIF", rand(1,10));
    echo NBR_AU_PIF;
    echo'<br>';

    echo '<h2 class="mt-5"> constantes prédéfinies / magiques </h2>';

    echo PHP_VERSION;
    echo'<br>';
    echo PHP_MAJOR_VERSION;
    echo'<br>';
    echo __LINE__;
    echo'<br>';
    echo __DIR__;
    echo'<br>';

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