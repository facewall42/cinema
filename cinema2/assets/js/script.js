// Fonction pour l'affichage du mot de passe
function myFunction() {
    let x = document.querySelector("#mdp");
    let y = document.querySelector("#confirmMdp");
    console.log(x);

    if (x.type === "password" || y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}
