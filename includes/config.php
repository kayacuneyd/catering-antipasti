<?php
/**
 * Global site configuration.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SITE_NAME', 'Catering Antipasti');
define('SITE_EMAIL', 'info@catering-antipasti.de');
define('ADMIN_EMAIL', 'hasan@catering-antipasti.de');
define('SITE_URL', 'https://catering-antipasti.de');
define('WHATSAPP_NUMBER', '+4915123456789');

$current_page = basename($_SERVER['PHP_SELF']);
$is_english = strpos($_SERVER['REQUEST_URI'], '/en/') !== false;
$lang = $is_english ? 'en' : 'de';

/**
 * Lightweight translation helper.
 */
function t(string $key): string
{
    global $lang;

    $translations = [
        'de' => [
            'nav_home' => 'Startseite',
            'nav_menu' => 'Menüs',
            'nav_references' => 'Referenzen',
            'nav_about' => 'Über Uns',
            'nav_blog' => 'Blog',
            'nav_contact' => 'Kontakt',
            'nav_whatsapp' => 'WhatsApp',
            'footer_legal' => 'Impressum',
            'footer_privacy' => 'Datenschutz',
            'footer_quicklinks' => 'Schnelllinks',
            'footer_contact' => 'Kontakt',
            'footer_legal_heading' => 'Rechtliches',
            'footer_contact_info' => 'Catering Antipasti<br>Chef Hasan Geray<br>Tübingen, Deutschland',
            'footer_copyright' => '© 2024 Catering Antipasti. Alle Rechte vorbehalten.',
            'cta_whatsapp' => 'Direkt per WhatsApp anfragen',
            'cookie_title' => 'Cookies & Services',
            'cookie_text' => 'Wir nutzen Cookies und Drittanbieter-Tools, um unseren Service zu verbessern. Sie können Ihre Auswahl jederzeit anpassen.',
            'cookie_accept_all' => 'Alle akzeptieren',
            'cookie_only_essential' => 'Nur notwendige',
            'cookie_manage' => 'Cookie-Zustimmung verwalten',
        ],
        'en' => [
            'nav_home' => 'Home',
            'nav_menu' => 'Menus',
            'nav_references' => 'References',
            'nav_about' => 'About Us',
            'nav_blog' => 'Blog',
            'nav_contact' => 'Contact',
            'nav_whatsapp' => 'WhatsApp',
            'footer_legal' => 'Imprint',
            'footer_privacy' => 'Privacy Policy',
            'footer_quicklinks' => 'Quick Links',
            'footer_contact' => 'Contact',
            'footer_legal_heading' => 'Legal',
            'footer_contact_info' => 'Catering Antipasti<br>Chef Hasan Geray<br>Tübingen, Germany',
            'footer_whatsapp' => 'Chat on WhatsApp',
            'cta_whatsapp' => 'Reach out via WhatsApp',
            'footer_copyright' => '© 2024 Catering Antipasti. All rights reserved.',
            'cookie_title' => 'Cookies & services',
            'cookie_text' => 'We use cookies and selected tools to improve our service. You can update your preference at any time.',
            'cookie_accept_all' => 'Accept all',
            'cookie_only_essential' => 'Essential only',
            'cookie_manage' => 'Manage cookie consent',
        ],
    ];

    return $translations[$lang][$key] ?? $key;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function whatsapp_icon(string $classes = 'h-5 w-5'): string
{
    $class_attr = htmlspecialchars($classes, ENT_QUOTES, 'UTF-8');

    return '<svg aria-hidden="true" class="' . $class_attr . '" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">'
        . '<path fill="currentColor" d="M16 3C9.38 3 3.86 8.53 3.86 15.14c0 2.64.78 5.06 2.14 7.13L3 29l6.7-2c1.94 1.05 4.18 1.64 6.3 1.64 6.62 0 12.14-5.53 12.14-12.14C28.14 8.53 22.62 3 16 3zm0 2.14c5.53 0 10 4.47 10 10s-4.47 10-10 10c-2.03 0-3.98-.62-5.64-1.74l-.43-.28-3.97 1.15 1.16-3.86-.28-.43a9.86 9.86 0 01-1.71-5.84c0-5.53 4.47-10 10-10zm-4.62 4.5a.7.7 0 00-.44.21c-.15.16-.6.58-.6 1.41 0 .83.61 1.64.7 1.76.09.12 1.2 1.9 2.86 2.7 1.39.69 1.87.76 2.2.67.34-.09 1.08-.45 1.23-.88.15-.42.15-.79.11-.87-.04-.09-.18-.13-.36-.2-.19-.09-1.13-.53-1.31-.59-.18-.06-.3-.09-.42.08-.12.16-.48.6-.6.72-.12.13-.22.15-.4.06-.19-.09-.8-.3-1.52-.94-.57-.5-.95-1.13-1.06-1.32-.12-.2-.01-.3.08-.39.09-.09.19-.22.29-.32.09-.11.13-.17.19-.28.06-.12.04-.24 0-.32-.04-.09-.42-1.05-.58-1.44-.16-.39-.32-.34-.44-.34z"/>'
        . '</svg>';
}
