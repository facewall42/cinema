<?php
// =============================================
// 1. CONFIGURATION DE BASE
// =============================================
// Désactive l'affichage des erreurs en production
// error_reporting(0);
// ini_set('display_errors', 0);

// Force le fuseau horaire Paris
date_default_timezone_set('Europe/Paris');

// =============================================
// 2. PARAMÈTRES DE CACHE
// =============================================
// Cache navigateur (5 minutes pour les pages en mode production)
// header('Cache-Control: public, max-age=300');
// header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 300) . ' GMT');


// =============================================
// 3. CONSTANTES UTILES
// =============================================
define('SITE_URL', 'https://kinesiologue-paris-vincennes.fr');
define('ASSETS_PATH', '/assets');
define('UPLOAD_DIR', __DIR__ . '/../uploads');

// =============================================
// 4. CONNEXION À LA BDD (si vous en avez une)
// =============================================
// try {
//     $pdo = new PDO(
//         'mysql:host=localhost;dbname=votre_bdd;charset=utf8',
//         'votre_utilisateur',
//         'votre_motdepasse',
//         [
//             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//         ]
//     );
// } catch (PDOException $e) {
//     error_log('Erreur BDD : ' . $e->getMessage());
//     die('Un problème est survenu. Merci de réessayer plus tard.');
// }

// =============================================
// 5. FONCTIONS GLOBALES
// =============================================
function sanitize_input($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function get_page_title($page_name)
{
    $titles = [
        'accueil' => 'Kinésiologue Paris | Stéphanie Mousset',
        'contact' => 'Contact | Cabinet de kinésiologie Paris'
    ];
    return $titles[$page_name] ?? SITE_URL;
}

// Configuration de base
// Masque les erreurs PHP aux visiteurs (essentiel pour la sécurité)
// Définit le bon fuseau horaire pour les dates

// Gestion du cache
// 3600 = 1 heure de cache pour les pages PHP
// À adapter selon la fréquence de mise à jour de chaque page

// Constantes pratiques
// SITE_URL : Évite de répéter l'URL complète partout
// ASSETS_PATH : Chemin relatif vers vos CSS/JS
// UPLOAD_DIR : Sécurise le stockage des fichiers uploadés

// Connexion BDD (optionnel)
// Configuration type pour MySQL/MariaDB
// Gestion propre des erreurs (ne s'affichent pas aux visiteurs)

// Fonctions globales
// sanitize_input() : Protège contre les injections XSS
// get_page_title() : Centralise la gestion des balises <title>