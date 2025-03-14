// Fonction pour l'affichage du mot de passe
function myFunction() {
    var x = document.getElementById("confirmMdp");
    var y = document.getElementById("mdp");
    // var z = document.getElementsByClassName("mdp");
    if (x.type === "password" && y.type === "password" && z.type === "password") {
         x.type = "text";
         y.type = "text";
        //  z.type === "text"
    } else {
         x.type = "password";
         y.type = "password";
        //  z.type === "password"
    }
}