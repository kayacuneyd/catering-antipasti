<?php
require_once __DIR__ . '/config.php';

$logo_url = SITE_LOGO;
$logo_exists = false;
if ($logo_url !== '') {
    $logo_file = dirname(__DIR__) . $logo_url;
    $logo_exists = is_file($logo_file);
}

if ($is_english) {
    $menu_links = [
        'home' => 'index.php',
        'menu' => 'menu.php',
        'references' => 'references.php',
        'about' => 'about-us.php',
        'blog' => 'blog.php',
        'contact' => 'contact.php',
    ];
    $language_toggle = [
        'de' => [
            'index.php' => '../index.php',
            'menu.php' => '../menu.php',
            'about-us.php' => '../uber-uns.php',
            'contact.php' => '../kontakt.php',
            'imprint.php' => '../impressum.php',
            'privacy.php' => '../datenschutz.php',
            'blog.php' => '../blog.php',
            'references.php' => '../referenzen.php',
            'blog-article.php' => '../blog.php',
        ][$current_page] ?? '../index.php',
        'en' => 'index.php',
    ];
} else {
    $menu_links = [
        'home' => 'index.php',
        'menu' => 'menu.php',
        'references' => 'referenzen.php',
        'about' => 'uber-uns.php',
        'blog' => 'blog.php',
        'contact' => 'kontakt.php',
    ];
    $language_toggle = [
        'de' => 'index.php',
        'en' => [
            'index.php' => 'en/index.php',
            'menu.php' => 'en/menu.php',
            'uber-uns.php' => 'en/about-us.php',
            'kontakt.php' => 'en/contact.php',
            'impressum.php' => 'en/imprint.php',
            'datenschutz.php' => 'en/privacy.php',
            'referenzen.php' => 'en/references.php',
            'blog.php' => 'en/blog.php',
            'blog-artikel.php' => 'en/blog.php',
        ][$current_page] ?? 'en/index.php',
    ];
}

$frontend_palettes = array_filter(site_color_palettes(), 'is_array');
$active_palette_name = site_active_palette_name();
$active_palette_colors = site_active_palette_colors();

if (!defined('SITE_PALETTE_EMITTED')) {
    $css_variables = [];
    foreach ($active_palette_colors as $token => $hex) {
        $css_variables[] = '--color-' . $token . ': ' . hex_to_rgb_triplet($hex) . ';';
    }

    echo '<style id="site-palette-vars">:root{' . implode('', $css_variables) . '}</style>';
    echo '<script id="site-palette-data">';
    $jsonFlags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
    $paletteJson = json_encode($frontend_palettes, $jsonFlags);
    $activeJson = json_encode($active_palette_name, $jsonFlags);
    echo 'window.COLOR_PALETTES = ' . $paletteJson . ';';
    echo 'document.documentElement.dataset.paletteDefault = ' . $activeJson . ';';
    echo 'window.ACTIVE_PALETTE = ' . $activeJson . ';';
    echo '</script>';
    define('SITE_PALETTE_EMITTED', true);
}

?>
<header class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4 max-w-7xl">
        <div class="flex items-center justify-between">
            <a href="<?php echo $menu_links['home']; ?>" class="nav-logo flex items-center font-serif text-2xl text-sangiovese">
                <?php if ($logo_exists): ?>
                    <img src="<?php echo htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8'); ?>"
                         alt="<?php echo htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8'); ?>"
                         class="nav-logo__img w-auto object-contain">
                <?php else: ?>
                    <?php echo SITE_NAME; ?>
                <?php endif; ?>
            </a>
            <ul class="hidden lg:flex items-center gap-6 xl:gap-8">
                <li>
                    <a href="<?php echo $menu_links['home']; ?>"
                       class="hover:text-sangiovese transition-colors">
                        <?php echo t('nav_home'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $menu_links['menu']; ?>"
                       class="hover:text-sangiovese transition-colors">
                        <?php echo t('nav_menu'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $menu_links['references']; ?>"
                       class="hover:text-sangiovese transition-colors">
                        <?php echo t('nav_references'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $menu_links['about']; ?>"
                       class="hover:text-sangiovese transition-colors">
                        <?php echo t('nav_about'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $menu_links['blog']; ?>"
                       class="hover:text-sangiovese transition-colors">
                        <?php echo t('nav_blog'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $menu_links['contact']; ?>"
                       class="bg-sangiovese text-cream px-6 py-2 rounded-lg hover:bg-sangiovese/90 transition-all">
                        <?php echo t('nav_contact'); ?>
                    </a>
                </li>
                <li class="flex items-center gap-2 text-sm">
                    <a href="<?php echo $language_toggle['de']; ?>"
                       class="<?php echo $lang === 'de' ? 'font-semibold text-sangiovese' : 'text-seagray'; ?>">
                        DE
                    </a>
                    <span>|</span>
                    <a href="<?php echo $language_toggle['en']; ?>"
                       class="<?php echo $lang === 'en' ? 'font-semibold text-sangiovese' : 'text-seagray'; ?>">
                        EN
                    </a>
                </li>
            </ul>
            <button class="lg:hidden text-olive" type="button" onclick="toggleMobileMenu()" aria-expanded="false" aria-controls="mobile-menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <ul id="mobile-menu" class="mt-4 hidden flex-col space-y-3 lg:hidden rounded-2xl border border-olive/10 bg-white/95 p-4 shadow-xl backdrop-blur">
            <li>
                <a href="<?php echo $menu_links['home']; ?>" class="block py-2">
                    <?php echo t('nav_home'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_links['menu']; ?>" class="block py-2">
                    <?php echo t('nav_menu'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_links['references']; ?>" class="block py-2">
                    <?php echo t('nav_references'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_links['about']; ?>" class="block py-2">
                    <?php echo t('nav_about'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_links['blog']; ?>" class="block py-2">
                    <?php echo t('nav_blog'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_links['contact']; ?>" class="block py-2">
                    <?php echo t('nav_contact'); ?>
                </a>
            </li>
        </ul>
    </nav>
</header>
