<?php
/**
 * Global site configuration.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$settings_path = dirname(__DIR__) . '/data/settings.json';
$settings_data = [];
if (is_readable($settings_path)) {
    $decoded = json_decode(file_get_contents($settings_path), true);
    if (is_array($decoded)) {
        $settings_data = $decoded;
    }
}

define('SITE_NAME', $settings_data['site_title'] ?? 'Catering Antipasti');
define('SITE_EMAIL', $settings_data['contact_email'] ?? 'info@catering-antipasti.de');
define('ADMIN_EMAIL', $settings_data['contact_email'] ?? 'hasan@catering-antipasti.de');
define('SITE_URL', 'https://catering-antipasti.de');
define('WHATSAPP_NUMBER', $settings_data['whatsapp'] ?? '+4915123456789');
define('MAINTENANCE_MODE', !empty($settings_data['maintenance_mode']));
$logo_public_path = '';
if (!empty($settings_data['logo_path'])) {
    $logo_public_path = '/' . ltrim($settings_data['logo_path'], '/');
}
define('SITE_LOGO', $logo_public_path);

$footer_logo_public_path = $logo_public_path;
if (!empty($settings_data['footer_logo_path'])) {
    $footer_logo_public_path = '/' . ltrim($settings_data['footer_logo_path'], '/');
}
define('SITE_FOOTER_LOGO', $footer_logo_public_path);
require_once __DIR__ . '/palette-defaults.php';

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

    return '<svg aria-hidden="true" class="' . $class_attr . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">'
        . '<path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>'
        . '</svg>';
}

/**
 * Render a consistent hero section used across static pages.
 *
 * @param array{
 *     eyebrow?: string,
 *     title?: string,
 *     description?: string,
 *     body?: string,
 *     section_classes?: string,
 *     container_classes?: string,
 *     eyebrow_classes?: string,
 *     title_classes?: string,
 *     description_classes?: string
 * } $options
 */
function render_page_hero(array $options = []): void
{
    $defaults = [
        'section_classes' => 'bg-vineyard text-cream py-20',
        'container_classes' => 'container mx-auto px-4 max-w-5xl',
        'eyebrow_classes' => 'uppercase tracking-[0.4em] text-xs text-verona mb-3',
        'title_classes' => 'font-serif text-5xl mb-6',
        'description_classes' => 'text-cream/90 text-lg max-w-3xl',
    ];

    $settings = array_merge($defaults, $options);
    $section_classes = htmlspecialchars($settings['section_classes'], ENT_QUOTES, 'UTF-8');
    $container_classes = htmlspecialchars($settings['container_classes'], ENT_QUOTES, 'UTF-8');
    $eyebrow_classes = htmlspecialchars($settings['eyebrow_classes'], ENT_QUOTES, 'UTF-8');
    $title_classes = htmlspecialchars($settings['title_classes'], ENT_QUOTES, 'UTF-8');
    $description_classes = htmlspecialchars($settings['description_classes'], ENT_QUOTES, 'UTF-8');

    $eyebrow = $settings['eyebrow'] ?? '';
    $title = $settings['title'] ?? '';
    $description = $settings['description'] ?? '';
    $body = $settings['body'] ?? '';

    echo '<section class="' . $section_classes . '">';
    echo '<div class="' . $container_classes . '">';

    if ($eyebrow !== '') {
        echo '<p class="' . $eyebrow_classes . '">' . htmlspecialchars($eyebrow, ENT_QUOTES, 'UTF-8') . '</p>';
    }

    if ($title !== '') {
        echo '<h1 class="' . $title_classes . '">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h1>';
    }

    if ($description !== '') {
        echo '<p class="' . $description_classes . '">' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '</p>';
    }

    if (!empty($body)) {
        echo $body;
    }

    echo '</div>';
    echo '</section>';
}

function site_color_palettes(): array
{
    static $palettes = null;
    if ($palettes !== null) {
        return $palettes;
    }

    $defaults = palette_default_presets();
    $base = array_merge(['active' => 'classic'], $defaults);
    $path = dirname(__DIR__) . '/data/palettes.json';
    $stored = [];
    if (is_readable($path)) {
        $decoded = json_decode(file_get_contents($path), true);
        if (is_array($decoded)) {
            $stored = $decoded;
        }
    }

    $merged = array_merge($base, $stored);
    foreach ($defaults as $name => $colors) {
        if (isset($merged[$name]) && is_array($merged[$name])) {
            $merged[$name] = array_merge($colors, $merged[$name]);
        } else {
            $merged[$name] = $colors;
        }
    }

    $palettes = $merged;
    return $palettes;
}

function site_active_palette_name(): string
{
    static $name = null;
    if ($name !== null) {
        return $name;
    }

    global $settings_data;
    $palettes = site_color_palettes();
    $candidate = $settings_data['active_palette'] ?? ($palettes['active'] ?? 'classic');
    if (!isset($palettes[$candidate])) {
        $candidate = 'classic';
    }

    $name = $candidate;
    return $name;
}

function site_active_palette_colors(): array
{
    $palettes = site_color_palettes();
    $active = site_active_palette_name();
    if (isset($palettes[$active]) && is_array($palettes[$active])) {
        return $palettes[$active];
    }

    $defaults = palette_default_presets();
    return $defaults['classic'] ?? [];
}

function hex_to_rgb_triplet(string $hex): string
{
    $normalized = ltrim($hex, '#');
    if (strlen($normalized) === 3) {
        $normalized = $normalized[0] . $normalized[0]
            . $normalized[1] . $normalized[1]
            . $normalized[2] . $normalized[2];
    }

    $int = hexdec($normalized);
    $r = ($int >> 16) & 0xFF;
    $g = ($int >> 8) & 0xFF;
    $b = $int & 0xFF;

    return $r . ' ' . $g . ' ' . $b;
}
