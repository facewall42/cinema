// Fonction pour l'affichage du mot de passe
function myFunction() {
    var x = document.getElementById("mdp");
    if (x.type === "password") {
         x.type = "text";
    } else {
         x.type = "password";
    }
}