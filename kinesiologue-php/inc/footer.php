<footer role="contentinfo">
    <div class="therapist-footer">
        <div class="footer-container">
            <!-- Bloc Contact -->
            <div class="contact-block">
                <h3>Prendre contact</h3>
                <div class="contact-items">
                    <a href="tel:0659634755" class="contact-link">
                        <img src="./assets/pics/pictos/smartphone.svg" alt="" aria-hidden="true">
                        06 59 63 47 55
                    </a>
                    <a href="mailto:contact@kinesiologue-paris-vincennes.fr" class="contact-link">
                        <img src="./assets/pics/pictos/email.svg" alt="" aria-hidden="true">
                        Envoyer un email
                    </a>
                    <a href="#" class="contact-link highlight"
                        onclick="openCustomWindow('https://meet.brevo.com/stephanie-mousset')">
                        <img src="./assets/pics/pictos/calendar.svg" alt="" aria-hidden="true">
                        Prendre rendez-vous
                    </a>
                </div>
            </div>

            <!-- Bloc Adresse -->
            <div class="address-block">
                <h3>Le cabinet</h3>
                <address>
                    <a href="https://www.google.com/maps/place/St%C3%A9phanie+Mousset,+kin%C3%A9siologue+Paris+11/@48.8521044,2.3861885,17z/data=!3m1!4b1!4m6!3m5!1s0x47e6736742a789a7:0xaca5cc8b9d272e5d!8m2!3d48.8521044!4d2.3861885!16s%2Fg%2F11x1zq3ccs?entry=ttu&g_ep=EgoyMDI1MDQwMi4xIKXMDSoASAFQAw%3D%3D"
                        class="address-link">
                        <img src="./assets/pics/pictos/address.svg" alt="" aria-hidden="true">
                        <span>21 rue Titon<br>75011 Paris<br>RDC à gauche</span>
                    </a>
                </address>
            </div>

            <!-- Bloc Réseaux -->
            <div class="social-block">
                <h3>Suivez-moi</h3>
                <div class="social-links">
                    <!-- <a href="#"><img src="./assets/pics/pictos/fb.svg" alt="Facebook"></a> -->
                    <a href="https://www.instagram.com/kinesiologie_paris/#"><img
                            src="./assets/pics/pictos/insta.svg" alt="Instagram"></a>
                    <!-- <a href="#"><img src="./assets/pics/pictos/linkedin.svg" alt="LinkedIn"></a> -->
                </div>
            </div>


        </div>
        <!-- Mentions légales -->
        <div class="legal-block">
            <div class="legal-links">
                <a href="./mentions-legales.php">Mentions légales</a>
                <a href="./deontologie.php">Code de déontologie</a>
                <a href="./mentions-legales.php">Confidentialité</a>
            </div>
            <p class="copyright">© 2025 Stéphanie Mousset - Tous droits réservés</p>
        </div>
    </div>
</footer>

<script src="./assets/js/script.js"></script>

<?php
// Ajout des scripts si besoin
if ((isset($scripts)) && !empty($scripts)) {
    if (in_array("elfsight", $scripts)) {
        // Elfsight Google Reviews | Untitled Google Reviews Widget
        echo '<script src="https://static.elfsight.com/platform/platform.js" async defer></script>';
    }
    if (in_array("aos", $scripts)) {
        // scripts AOS effets defilement :
        echo '<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>';
        echo '<script>AOS.init();</script>';
    }
}
?>
</body>

</html>