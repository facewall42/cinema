<?php
    $title = "Fonctions";
    $titreH1 = "Fonctions en PHP";
    $paragraphe = "Fonctions";
    require_once ("inc/header.inc.php");
?>
<main class="container px-5 border border-dark">
    <div class="row">
        <h2 class="mt-5">1 - Les fonctions prédéfinies </h2>
        <ul>
            <li> Une fonction prédéfine permet de réaliser un traitrement spécifique prédéterminé dans le language PHP</li>
        </ul>
        <div class="col-sm-12 mt-5">
            <h3 class="text-primary text-center mb-5">Les fonctions prédéfinies des chaînes de caractères </h3>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <ul>
                        <!-- https://www.php.net/manual/en/function.rtrim.php -->
                        <li><span>substr()</span> : permet d'extraire une partie d'une chaîne de caractères</li>
                        <li><span>strpos()</span>: permet de récuperer la position d'un caractère dans une chaîne de caractères</li>
                        <li><span>strlen()</span> : permet de récupérer la taille d'une chaîne de carctères</li>
                        <li><span>substr_replace()</span> : permet de remplacer un segment de la chaîne</li>
                        <li><span>substr_ireplace()</span>: version insensible à la casse de str_replace()</li>
                        <li><span>str_contains()</span> : permet de vérifier si la chaîne contient un mot particulier</li>
                        <li><span>str_starts_with()</span> : permet de vérifier si une chaîne commence par une sous-chaîne donnée</li>                                   
                    </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <ul>
                        <li><span>str_ends_with()</span> : permet de vérifier si une chaîne se termine par une sous-chaîne donnée</li>
                        <li><span>trim()</span> : permet de supprimer les espaces avant et après une chaîne de caractères</li>
                        <li><span>strtolower()</span> : permet de retourner la chaîne en minuscule</li>
                        <li><span>strtoupper()</span> : permet de retourner la chaîne en majuscules</li>
                        <li><span>ucfirst()</span> : permet de mettre le premier caractère en majuscule. </li>
                        <li><span>lcfirst()</span> : permet de mettre le premier caractère en minuscule. </li>
                    </ul>
                </div>
            </div>
            <?php
                $machaine = "bonjour j'aime le PHP !!";
                echo "$machaine <br>";
                // Affiche d'un caractère d'une chaîne de caractères
                echo $machaine[3] . '<br>'; // Affiche la lettre "j"
                // Modifier un caractère d'une chaîne de caractères
                $machaine[0] = "B";
                echo $machaine[0] . '<br>'; // Changement de la lettre "B" majuscule en "b" minuscule
                // Extraire une partie d'une chaîne de caractères
                $newString = substr($machaine, 0, 9); // Cette fonction prend en paramètres la variable, le point de départ et la longueur que l'on souhaite obtenir
                echo "$newString <br>"; 

                // Exercice : Récupérer une partie du texte de l'indice 0 jusqu'à 40 et remplacer la avec le code suivant : ...<a href="#">Lire la suite</a> //

                $texte = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus, rerum quis doloremque doloribus ex omnis iure pariatur velit voluptatibus reprehenderit. Repudiandae sed harum explicabo, dolor eius eaque error quibusdam esse!
                Voluptatem nobis enim architecto nesciunt perferendis dignissimos, excepturi aspernatur commodi distinctio eum, modi at dolores esse, consequatur quis rerum cum beatae. Recusandae ducimus eos nesciunt eius facilis cumque ut molestiae!
                Ex a voluptatum corporis repudiandae neque molestiae consequatur in ratione dicta ad laudantium, officiis quisquam velit cum ab assumenda officia fugiat tenetur, soluta dignissimos corrupti natus voluptates. Blanditiis, sapiente numquam.
                Blanditiis minus illum magni ad architecto ex pariatur mollitia eos iusto neque necessitatibus, officiis voluptas consequatur possimus. Inventore ipsam nam voluptas, quasi dolores harum ullam, consequuntur, illum quas mollitia ab?";
               
               /*
                $subText = substr($texte, 0, 41);
               echo "<p>$subText  YOUPI...<a href\"#\">Lire la suite</a></p>";
               
                $nvxtext = substr($texte, 0, 41);
                // $newText2 = "...<a href=\"#\">Lire la suite</a>";
                echo "<p>$nvxtext ...<a href=\"#\">Lire la suite</a></p>";*/

                // /!\ Attention les espaces sont comptés comme des caractères dans la chaîne
                 $newText3 = substr_replace($texte, '...<a href="#">Lire la suite</a>', 0, 40);
                // echo $newText3


                // Récupérer la position d'un caratère dans une chaîne de caractères 
                echo "La position de la lettre \"H\" dans la phrase est : " . strpos($machaine, "H") ."<br>"; // Position H = 19
                // /!\ Attention la fonction est case sensitive, elle fait attention à la casse des lettres : si l'on met la lettre "h" en minuscule rien ne s'affichera
                var_dump(strpos($machaine,"H"));
                echo '<br>';
            


                // Récupérer la taille d'une chaîne de caratères
                echo strlen($machaine) . "<br>";

                // Remplacer une partie de la chaîne
                $machaine = str_replace('PHP', 'JS', $machaine); // Paramètres de la fonction : chaîne de caratères à changer, chaîne de caratères de remplacement et la variable à manipuler
                echo "$machaine <br>";
                // Ici aussi la fonction est sensible à la casse, on ne change pas la valeur si il y a une différence entre la valeur cherchée et stockée
                // Il existe une autre fonction qui ne fait pas de distinction entre les lettres majuscules et minuscules dans les chaînes de caractères
                $machaine = str_ireplace('BONJOUR', 'Hello', $machaine);
                echo "$machaine <br>"; 

                // Vérifier si la chaîne contient un mot particulier 
                var_dump(str_contains($machaine, 'JS')); // Paramètres : variable contenant la chaîne, mot à vérifier dans la variable
                // str_contains() permet de vérifier si la chaîne contient un mot en particulier, cependant elle est sensible à la casse
                // résultat en boolean "true" ou "false"
                echo "<br>";

                // Vérifier si la chaîne commence par ce que l'on passe dans les paramètres
                var_dump(str_starts_with($machaine, 'Hel')); // sensible à la casse // Permet de vérifier si la chaîne commence par un mot inséré en 2ème paramètre
                echo "<br>";

                // Vérifier si la chaîne se termine par ce que vous lui passez dans les paramètres 
                var_dump(str_ends_with($machaine, '!')); // sensible à la casse // Permet de vérifier si la chaîne se termine par un mot insérer en 2ème paramètre
                echo "<br>";

                // Supprimer les espaces en début et fin de chaîne
                $testString = "!        Une phrase beaucoup trop longue avec des espaces inutiles au début et à la fin      !";
                echo "$testString <br>";
                echo strlen($testString) . " : Nombre de caractères <br>";

                $newTrim = trim($testString);
                echo "$newTrim <br>";
                echo strlen($newTrim) . " : Nombre de caractères <br>";
                $newTrim = trim($testString, '!');
                echo "$newTrim <br>";

            ?>
        </div>
        <div class="col-sm-12 mt-5">
            <h3 class="text-primary text-center mb-5">Les fonctions prédéfinies des tableaux </h3>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <ul>
                        <li><span>array_push()</span> : permet d'ajouter plusieurs valeurs à la fin d'un tableau</li>
                        <li class="alert alert-warning">Si on veut ajouter une seule valeur à la fin on utilise la syntaxe : <strong>$tableau[] = valeur_à_ajouter</strong> </li>
                        <li><span>array_unshift</span>: permet d'ajouter une valeur au début d'un tableau</li>
                        <li><span>array_pop</span>: permet de supprimer la dernière valeur d'un tableau</li>
                        <li><span>array_shift</span>: permet de supprimer la première valeur d'un tableau</li>
                        <li><span>unset()</span>: permet de supprimer un élément d'un tableau</li>
                        <li><span>shuffle</span>: permet de mélanger et réorganiser un tableau</li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <ul>
                        <li><span>array_chunk</span>: permet de diviser un tableau en plusieurs parties et avec un nombre de valeurs à définir</li>
                        <li><span>count() / sizeof()</span> : permet de retourner la taille du tableau passée en paramètre.</li>
                        <li><span>in_array()</span>: permet de vérifier qu'une valeur est présente dans un tableau.</li>
                        <li><span>array_key_exists()</span> : permet de vérifier si une clé existe dans un tableau.</li>
                        <li><span>explode()</span> : permet de transformer une chaîne de caractères en tableau</li>
                        <li><span>implode()</span> : permet de transformer un tableau en chaîne de caractères.</li>
                        <li><span>array_slice()</span> :  permet de récuperer une partie d'un tableau </li>
                    </ul>
                </div>
            </div>
            <?php
                    $tableau = ['Rouge', 'Bleu', 'Rose', 'Violet'];
                    echo'<pre>';
                    var_dump($tableau);
                    echo'</pre>';

                    echo "<h2>Ajouter des valeurs à la fin </h2>";

                   array_push($tableau, 'Vert','noir'); // dans les paramétres on met la variable qui contient le tableau ensuite les valeurs à ajouter
                    echo'<pre>';
                    var_dump($tableau);
                    echo'</pre>';

                    echo "<h2>Ajouter des valeurs au début</h2>";
                    array_unshift($tableau,'Gris', 'Jaune');
                    echo'<pre>';
                    var_dump($tableau);
                    echo'</pre>';

                    echo "<h2>Supprimer la dernière valeur du tableau</h2>";

                    $valeurSupprimerFin = array_pop($tableau); // Supprime la valeur et je peux la stocker dans une variable 

                    echo'<pre>';
                    var_dump($tableau);// tableau après suppressioin de la dernière valeur
                    echo'</pre>';
                    echo'<pre>';
                    var_dump($valeurSupprimerFin);// La couleur supprimée à la fin du tableau
                    echo'</pre>';

                    echo "<h2>Supprimer la première valeur du tableau</h2>";
                    $valeurSupprimerDebut = array_shift($tableau);

                    echo'<pre>';
                    var_dump($tableau);// tableau après suppressioin de la première valeur
                    echo'</pre>';
                    echo'<pre>';
                    var_dump($valeurSupprimerDebut);// La couleur supprimée au début du tableau
                    echo'</pre>';

                    echo "<H2>Mélanger un tableau</h2>";

                    shuffle($tableau);
                    echo'<pre>';
                    var_dump($tableau);
                    echo'</pre>';

                    echo "<h2>Diviser un tableau en plusieurs partie</h2>";
                    $tableau2 = array_chunk($tableau,3, true); // En ajoutant true  dans les paramètres, je garde les même indices au valeurs du tableau d'origine
                    echo'<pre>';
                    var_dump($tableau2);
                    echo'</pre>';

                    # Compter les éléments dans un tableau

                    $nbr1 = count($tableau);
                    $nbr2 = sizeof($tableau);

                    var_dump($nbr2);

                    # Vérifier une valeur dans un tableau

                    $result = in_array('Bleu', $tableau); // cette fonction est sensible à la casse 
                    echo'<pre>';
                    var_dump($result);
                    echo'</pre>';

                    # Vérfifier une clé dans un tableau 
                    $result = array_key_exists(2, $tableau);
                    echo'<pre>';
                    var_dump($result);
                    echo'</pre>';

                    # Créer un tableau à partir de deux tableaux

                    $couleur = ['Magenta', 'Orange','Turquoise'];

                    $all = [...$tableau, ...$couleur]; // On décompose chacun des tableaux avec l'opérateur de décomposition(...)
                    echo'<pre>';
                    var_dump($all);// La variable $all contient le nouveau tableau indexé créé à partir des deux tableaux
                    echo'</pre>';

                    //Je n'aurais pas le meme résultat avec cette syntaxe
                    
                    $all = [$tableau,$couleur];
                    echo'<pre>';
                    var_dump($all);// resultat: un tableau multidimensionnel
                    echo'</pre>';

                    # Transformer une chaîne de caratére en tableau
                    $maChaine2 = 'Je me transforme en tableau';
                    $chaineEnTableau = explode(' ', $maChaine2 ); // Les paramètres : le caractére de séparation dans la chaîne, et la variable de la chaîne à scinder
                    echo'<pre>';
                    var_dump($chaineEnTableau);
                    echo'</pre>';
                    echo "<H2>utilisation de str_split('\$machaine2')</h2>";
                    # Transformer une chaîne de caractères en tableau par caractere
                    $tableau555 = str_split($maChaine2);
                    echo'<pre>';
                    var_dump($tableau555);
                    echo'</pre> <br>';

                    # Transformer un tableau en chaîne de caractère
                    
                    $monTab = ['Salut', 'je', 'viens', 'du', 'tableau', '!'];
                    $tableauEnChaine = implode(' ', $monTab); // Les paramètres : le caractére de séparation dans la chaîne et la variable du tableau à fusionner 
                    echo'<pre>';
                    var_dump($tableauEnChaine);
                    echo'</pre>';
                    echo$tableauEnChaine;

                    # Récupérer une partie d'un tableau *************************************

                    $monArray = [
                         'a' => 10,
                         'b' => 20,
                         'c' => 30,
                         'd' => 40,
                         'e'=> 50
                    ];

                    $nvArray = array_slice($monArray, 1,2);

                    echo'<pre>';
                    var_dump($nvArray);
                    echo'</pre>';
               ?>
        </div>
        <div class="col-sm-12 mt-5">
            <h3 class="text-primary text-center mb-5">Les fonctions <span>isset()</span> et <span>empty()</span></h3>    
            <ul>
                <li class="alert alert-success">Ces fonctions sont utiles lorsque vous souhaitez effectuer une validation de données.</li>
            </ul>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h4 class="text-success text-center">isset()</h4>
                    <ul>
                        <li>La fonction <span>isset()</span> détermine si une variable existe.</li>
                        <li>La fonction vérifie si la variable est définie, et non NULL </li>
                        <li>La fonction retourne true quand la variable testé est définie ou elle ne contient pas la valeur NULL</li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h4 class="text-success text-center">empty()</h4>
                    <ul>
                        <li>La fonction <span>empty()</span> vérifie si une variable est vide.</li>
                        <li>La fonction retourne true si la variable testée est égale à : 
                            <ul>
                                <li><span>""</span> (une chaîne vide)</li> 
                                <li><span>0</span> (0 en tant qu'entier)</li>
                                <li><span>"0"</span> (0 en tant que chaîne de caractères)</li>
                                <li><span>NULL</span></li>
                                <li><span>false</span></li>
                                <li><span>array()</span> (un tableau vide)</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <?php
                $var1 = 0;
                $var2 = "";

                echo "<p class=\"alert alert-primary w-25\">isset(\$var1)</p>";
                // $var1
                if(isset($var1)){ // if true return
                    echo "\$var1 existe et est non NULL <br>";
                } else{
                    echo "\$var1 n'existe pas ou est NULL <br>";
                };
                
                // $var2
                echo "<p class=\"alert alert-primary w-25\">empty(\$var2)</p>";
                if (empty($var2)){ // if true return
                    echo "\$var2 est vide (0, string vide, NULL, false, non définie) <br>";
                } else{
                    echo "\$var2 n'est pas vide (0, string vide, NULL, false, non définie) <br>";
                }
                
                // Différence entre "isset()" et "empty()", si on suppprime les déclarations des variables $var1 et $var2 : "empty()" reste "true" car $var2 n'est pas définie, "isset()" devient "false" car $var1 n'est pas définie
                /*
                * Utilisation : 
                * "empty()" : pour valider et vérifier si les champs d'un formulaire sont remplis.
                * "isset()" : pour verifier l'existance d'une variable avant de l'utiliser
                */
            ?>
        </div>
    </div>
    <div class="row">
        <h2 class="mt-5">2 - Fonctions Utilisateurs </h2>
        <ul>
            <li>Les fonctions utilisateurs sont des morceaux de code écrits dans des accolades et portant un nom.</li>
            <li>On appelle une fonction au besoin pour exécuter le code qui s'y trouve.</li>
            <li>Il est d'usage de créer des fonctions pour ne pas se répéter quand on veut exécuter plusieurs fois le même traitement. On parle alors de "factoriser" son code.</li>
        </ul>
        <?php
            function separation(){ // Déclaration d'une fonction avec le mot clé "function" suivi du nom de la fonction d'une paire de "()" qui peuvent accueillir des paramètres ultérieurs
                echo "<hr>";
            };
            separation(); // Pour exécuter une fonction donc le code qui s'y trouve (nom fonction + "()" => "functionName()")

            // Fonctions avec paramètres et return // 

            // Fonction sans return 
            function hello1($prenom, $nom){ // $prenom et $nom => paramètres de la fonction, permettent de recevoir une valeur
                echo "<p class=\"alert alert-info\">Hello $nom $prenom !</p>";
            }
            hello1("kaïss", "BADI"); // si la fonction attend des valeurs, il faut obligatoirement donner ces valeurs 

            // Same function with return 

            function hello2($prenom, $nom){
                return "<p class=\"alert alert-info\">Hello $nom $prenom !</p>"; // return permet de sortir la phrase inscrite dans le code et de la renvoyer à l'endroit où la fonction est appelée 
                // Après le "return" toutes les instructions ne seront pas exécuter 
            }
            echo hello2("jean","michel"); // echo obligatoire pour afficher la fonction avec return

            // On peut remplacer les arguments par des variables provenant d'un formulaire par ex
            $prenom1 = "be";
            $nom1 = "ju";
            echo hello2($prenom1, $nom1); // Les 2 arguments sont variables et peuvent recevoir n'importe quelle valeur 

            $prenom1 = "Sa";
            $nom1 = "fe";
            echo hello2($prenom1, $nom1);

            // Exercice : Écrire une fonction qui multiplie un nombre 1 par un nombre 2 fournis lors de l'appel. Cette fonction retourne le résultat de la multiplication. Afficher le résultat
            // echo "<div class=\"col-sm-12\">";
            echo "<p class=\"alert alert-secondary text-center\">Exercice</p>";
            // echo "</div>";

            // Méthode 1 "return"
            echo "<div class=\"col-sm-12 col-md-6\">";
            echo "<p class=\"alert alert-success text-center\">Méthode 1 \"return\"</p>";


            function calculateExo1($nb1, $nb2){
                $multiplication = $nb1 * $nb2;
                return "<p>$nb1 * $nb2 = $multiplication</p>";
            }
            echo calculateExo1(23, 10);
            echo "<code>function calculateExo1(\$nb1, \$nb2){ <br>
                \$multiplication = \$nb1 * \$nb2; <br>
                return \$nb1 * \$nb2 = \$multiplication; <br>
            } <br>
            echo calculateExo1(23, 10);</code>";
            echo "</div>";



            // Fonction avec paramètres optionnels //
            echo "<p class=\"alert alert-secondary text-center\">Fonction avec paramètres optionnels</p>";
            // Certains paramètres peuvent ne pas être passés. Une valeur est fournie lors de la déclaration.
            

            echo "<p class=\"alert alert-success text-center\">Méthode 1</p>";
            function hello3($prenom, $nom ,$bonjour = "Hi"){
                echo "<p class=\"alert alert-info\">$bonjour $nom $prenom !</p>";
            }
            hello3(prenom :"ka", nom: "ba", bonjour: "Hello");

            // Méthode 2
            echo "<p class=\"alert alert-success text-center\">Méthode 2</p>";
            function hello4($prenom, $nom, $bonjour = "Hi"){
                echo "<p class=\"alert alert-info\">$bonjour $nom $prenom !</p>";
            }
            hello4("Yro", "Red");
        ?>
    </div>
    <div class="row">
        <h2 class="my-5">3- Portée des variables dans les fonctions</h2>
        <div class="col-sm-12 col-md-4">
            <h3 class="text-primary text-center mb-5">Variable locale</h3>
            <p>Les variables déclarées dans vos scripts ne sont pas accessibles dans vos fonctions et inversement.</p>
            <?php
            define("A", "je suis une constante"); // define une constante qui sera utilisable partout
                $a = 5;
                function maFonction(){
                    $b = 3;
                    echo A; //affichera le contenu de A car c'est une constante de scope global
                    //echo $a; // Affiche undefined $a car non définie dans la fonction
                    echo "<p class=\"alert alert-success\">La variable \$b = $b</p>"; // Ici on se trouve dans l'espace locale de la fonction, cette variable est donc "locale"
                }
                maFonction();
                echo "<p class=\"alert alert-success\">La variable \$a = $a</p>";
                //echo "<p class=\"alert alert-success\">La variable \$b = $b</p>"; // Affiche undefined $b car non définie en dehors de la fonction
            ?>
        </div>
        <div class="col-sm-12 col-md-4">
            <h3 class="text-primary text-center mb-5">Variable globale</h3>
            <p>Les variables déclarées dans le script peuvent être accessible dans les fonctions à condition d'être déclarées avec le mot clé "<span>global</span>".</p>
            <?php
                $a = 10;
        
                function maFonction2(){
                    global $a; // Permet  à la variable d'aller à l'intérieur de la fonction afin de pouvoir l'exploiter
                    $b = 6;
                    echo "<p class=\"alert alert-success\">La variable \$a = $a</p>"; // Affiche 10
                    echo "<p class=\"alert alert-success\">La variable \$b = $b</p>"; // Affiche 6
                    $a = 8;
                }
                maFonction2();
                echo "<p class=\"alert alert-success\">La variable \$a = $a</p>"; // Affiche 8
            ?>
        </div>
        <div class="col-sm-12 col-md-4">
            <h3 class="text-primary text-center mb-5">Variable statique</h3>
            <p>Les variables d'une fonction sont réinitialisées après chaque appel de cette fonction.</p>
            <p>Si l'on veut conserver la valeur précédente, il faut déclarer la variable comme "<span>static</span>"</p>
            <?php
            
                function maFonction3(){
                    
                    static $a = 9;
                    $a++;
                    echo "<p class=\"alert alert-success\">La variable \"static\" \$a = $a</p>"; // Affiche 10
                }
                maFonction3(); // Affiche 10
                maFonction3(); // Affiche 11
                maFonction3(); // Affiche 12
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2 class="my-5">4- Typage des paramètres dans les fonctions</h2>
            <ul>
                <li>Dans nos fonction on peut ajouter des contraintes de type sur les arguments et sur les valeurs de retour des fonctions</li>
                <li>Le typage permet un debug du code plus rapide, si on ne transmet pas le bon type de paramètres à notre fonction ou si elle ne retourne pas le bon type; une erreur se déclenchera au niveau de la fonction. Sinon, l'on peut avoir une cascade d'erreurs non détectées et retournant un résultat faux.</li>
            </ul>
            <?php
                function prix(int $value) : void{ // La fonction attend un entier en argument (int $value) et ne retourne rien "void"
                    echo "<p class=\"alert alert-info\">Cet objet coûte $value €</p>";
                }
                prix(5); // Affiche la chaîne de caractères avec la substitution de la variable à l'intérieur
                // prix("Zaahid"); // L'appel avec une chaîne de caractères déclenche un Typeerror car la fonction attends un nombre entier en tant que paramètre

                function cout(int|string $value) : void{
                    echo "<p class=\"alert alert-info\">Cet objet coûte $value €</p>";
                }
                cout("six");
                cout("Red");

                echo "<p class=\"alert alert-secondary text-center\">Exercice</p>";
                // Exercice : faire une fonction qui fait une division de 2 nombres avec un return en utilisant le typage (int)
                function division(int $nb1, int $nb2){
                    $div = $nb1 / $nb2;
                    return $div;
                }
                echo "<p class=\"alert alert-secondary text-center\">La division est égale à : " . division(80, 5) . "</p>";
                echo "<p class=\"alert alert-success text-center\">Correction Sahar</p>";
                function division2(int $nb1, int $nb2) :int{ // doit retourner un float pas un int a cause de la division . Parcontre on peut sortir un string
                    return $nb1 / $nb2;
                }
                echo "<p class=\"alert alert-secondary text-center\">La division est égale à : " . division2(9, 2) . "</p>";


                // declaration de fonction :
                function creer_utilisateur( string $prenom, string $nom, string $email, string $mot_de_passe, bool $est_admin = false, ?string $telephone = null ) :array {
                    // creation d'un tableau associatif pour stocker les donnees . Attention le mot de passe doit normalement etre hashé
                    $utilisateur = [
                        'prenom' => $prenom,
                        'nom' => $nom,
                        'email' => $email,
                        'mot_de_passe' => $mot_de_passe,
                        'est_admin' => $est_admin,
                        'telephone' => $telephone
                    ];

                    return $utilisateur;
                }
  

                // 1- Appel avec tous les paramètres :
                $utilisateur1 = creer_utilisateur( prenom :"Hawa",
                nom : "KONE",
                  email : "hawa@email.com",
                   mot_de_passe:"123456",
                    est_admin:true,
                     telephone:"0650711468");

                     echo '<pre>';
                     var_dump($utilisateur1);
                     echo '</pre>';

            // 2 appel sans les parametres optionnels
            $utilisateur2 = creer_utilisateur( prenom :"Roger",
            nom : "DAVIES",
              email : "roger@email.com",
               mot_de_passe:"654123");
               echo '<pre>';
               var_dump($utilisateur2);
               echo '</pre>';
            
            ?>
        </div>
    </div>
</main>
<?php
    require_once ("inc/footer.inc.php");
?>