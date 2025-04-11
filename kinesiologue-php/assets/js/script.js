// Permet d'activer la skip-link avec Alt+1 POUR L'ACCESSIBILITE DIRECTE AU CONTENU PRINCIPAL
document.addEventListener("keydown", (e) => {
    if (e.altKey && e.key === "1") {
        e.preventDefault();
        document.querySelector(".skip-link").focus();
    }
});

// Pré-réglages pour l'audio d'ambiance

let audio = document.getElementById("myAudio");
audio.volume = 0.08; // Définir le volume par défaut à 8%

function setVolume(volume) {
    audio.volume = volume; // Ajuster le volume
}

function playAudio() {
    if (audio.paused) {
        audio.play();
    } else {
        audio.pause();
    }
}

//************************************************************************
// Gestion affichage vidéo progressif autoplay enclenché

const video = document.getElementById("background-video");

function addElement(classe) {
    classe.classList.add("active");
}

function removeElement(classe) {
    classe.classList.remove("active");
}

// Démarre la vidéo au chargement de la page si video presente
if (video) {
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            addElement(video);
        }, 1300); // Délai correspondant à data-aos-delay
    });
    // Fait disparaître la vidéo à la fin de la lecture
    video.addEventListener("ended", function () {
        removeElement(video);
    });
    // Événements provoquant la lecture : click et scroll
    document.addEventListener("click", function () {
        if (video.paused) {
            addElement(video);
            video.play();
        }
    });
    // Fonction debounce pour ne pas sursolliciter
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
    // Gestionnaire d'événement scroll avec debounce
    const handleScroll = debounce(function () {
        if (video.paused) {
            addElement(video);
            video.play();
        }
    }, 100); // 100 ms de délai

    document.addEventListener("scroll", handleScroll);
}
// Explication du debounce
// Le debounce est une technique utilisée pour limiter le nombre d'exécutions d'une fonction, surtout dans le cas d'événements fréquents comme scroll ou resize. Cela permet d'éviter que la fonction ne soit appelée trop souvent, ce qui peut affecter les performances.
// Fonction debounce :
// Elle prend deux arguments : func (la fonction à exécuter) et wait (le temps d'attente en millisecondes).
// Elle utilise un setTimeout pour retarder l'exécution de la fonction.
// Si l'événement est déclenché à nouveau avant la fin du délai, le setTimeout précédent est annulé (clearTimeout) et un nouveau est démarré.
// Application au scroll :
// La fonction handleScroll est enveloppée dans le debounce.
// Elle ne sera exécutée que si l'utilisateur arrête de faire défiler la page pendant au moins 100 ms (ou le délai que vous avez défini).
// Choix du délai :
// 100 ms : C'est un délai raisonnable pour un événement comme scroll. Vous pouvez l'ajuster en fonction de vos besoins.
// Si vous choisissez un délai trop court, le debounce n'aura pas beaucoup d'effet.
// Si vous choisissez un délai trop long, l'utilisateur pourrait remarquer un léger retard dans l'exécution de la fonction.

// Résultat
// Avec cette implémentation, l'événement scroll ne déclenchera la lecture de la vidéo que si l'utilisateur arrête de faire défiler la page pendant au moins 100 ms. Cela évite de surcharger le navigateur avec des appels répétés à video.play().
// ***********************************************************************
// // Fonctions de gestion d'affichage du menu burger en mode smartphone (max 567px)
// var menuToggle = document.getElementById("menuToggle");
// var menuList = document.querySelector(".menu-list");
// var menuItem = document.querySelectorAll(".menu-item");

// function toggleMenu() {
//     menuToggle.classList.toggle("active");
//     menuList.classList.toggle("active");
// }

// function menuSmartphoneListener() {
//     menuToggle.addEventListener("click", toggleMenu);
//     menuItem.forEach((item, index) => {
//         if (index !== 1 && index != 3) {
//             // Ignore les éléments (index 1 et 3 "Mes pratiques" et questions)
//             item.addEventListener("click", toggleMenu);
//         }
//     });
// }

// // Gérer le rafraîchissement du menu au passage de la largeur > 567px
// function smartphoneEvents() {
//     if (window.matchMedia("(max-width: 567px)").matches) {
//         menuSmartphoneListener();
//     } else if (window.matchMedia("(width: 568px)").matches) {
//         menuList.classList.remove("active");
//         menuToggle.classList.remove("active");
//         location.reload();
//     }
// }

// Fonctions de gestion d'affichage du menu burger en mode smartphone (max 567px)
var menuToggle = document.getElementById("menuToggle");
var menuList = document.querySelector(".menu-list");
var menuItem = document.querySelectorAll(".menu-item");

// Fonction pour réinitialiser complètement le menu au format desktop
function resetMenuToDesktopState() {
    // Fermeture du menu burger
    menuList.classList.remove("active");
    menuToggle.classList.remove("active");

    // Réinitialisation des styles spécifiques au mobile
    menuList.style.transform = "";
    menuList.style.transition = "";

    // Suppression des écouteurs d'événements mobile
    menuToggle.removeEventListener("click", toggleMenu);
    menuItem.forEach((item, index) => {
        if (index !== 1 && index != 3) {
            item.removeEventListener("click", toggleMenu);
        }
    });
}

function toggleMenu() {
    menuToggle.classList.toggle("active");
    menuList.classList.toggle("active");
}

function menuSmartphoneListener() {
    // Ajout des écouteurs pour la version mobile
    menuToggle.addEventListener("click", toggleMenu);
    menuItem.forEach((item, index) => {
        if (index !== 1 && index != 3) {
            item.addEventListener("click", toggleMenu);
        }
    });
}

// Gestion responsive améliorée
function handleResponsiveMenu() {
    if (window.matchMedia("(max-width: 567px)").matches) {
        // Mode mobile
        if (!menuToggle.hasEventListener) {
            menuSmartphoneListener();
            menuToggle.hasEventListener = true;
        }
    } else {
        // Mode desktop
        resetMenuToDesktopState();
        menuToggle.hasEventListener = false;
    }
}

// Optimisation du resize avec debounce
let resizeTimer;
window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(handleResponsiveMenu, 100);
});

// Initialisation
handleResponsiveMenu();

// Écouteurs pour le menu en fonction du format media
//smartphoneEvents();
// window.addEventListener("resize", smartphoneEvents);

//Fonction pour gerer l'iframe externe BREVO 20 minutes offertes

function openCustomWindow(url) {
    // Vérifier si l'URL est valide
    if (!url || typeof url !== "string") {
        console.error("URL invalide");
        return;
    } else {
        let newWindow;
        if (url.includes("20-min-offertes")) {
            // Ouvrir une nouvelle fenêtre avec la page personnalisée
            newWindow = window.open("./20_minutes_offertes.php", "_blank");
        } else {
            newWindow = window.open("./rendez-vous.php", "_blank");
        }
        // Vérifier si la fenêtre a été ouverte avec succès
        if (newWindow) {
            // Attendre que la fenêtre soit chargée
            newWindow.onload = function () {
                // Charger l'URL dans l'iframe
                const contentFrame =
                    newWindow.document.getElementById("contentFrame");
                if (contentFrame) {
                    contentFrame.src = url;
                } else {
                    console.error(
                        "L'élément iframe 'contentFrame' est introuvable."
                    );
                }
            };
        } else {
            console.error("Impossible d'ouvrir une nouvelle fenêtre.");
        }
    }
}
