// Fonction pour l'affichage du mot de passe dans le premier champ mdp
function myFunction() {
    var x = document.getElementById("confirmMdp");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
