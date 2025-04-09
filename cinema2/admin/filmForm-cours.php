<?php

$regex_acteurs = '/.\/./';

//Explications: 
//    .* : correspond à n'importe quel nombre de caractères (y compris zéro caractère), sauf une nouvelle ligne.
//     \/ : correspond au caractère /. Le caractère / doit être précédé d'un backslash \ car il est un caractère spécial en expression régulière. Le backslash est appelé caractère d'échappement et il permet de spécifier que le caractère qui suit doit être considéré comme un caractère ordinaire.
//     .* : correspond à n'importe quel nombre de caractères (y compris zéro caractère), sauf une nouvelle ligne.

if (!isset($director) || strlen($director) < 2  || preg_match($regex_chiffre, $director)) {

    $info .= alert("Le champ Réalisateur n'est pas valide", "danger");
}

if (!isset($actors) ||  strlen($actors) < 3 || preg_match($regex_chiffre, $actors) || !preg_match($regex_acteurs, $actors)) { // valider que l'utilisateur a bien inséré le symbole '/' : chaîne de caractères qui contient au moins un caractère avant et après le symbole /.

    $info .= alert("Le champ acteurs n'est pas valide, il faut séparer les acteurs avec le symbole", "danger");
}
