<?php
require_once __DIR__ . '/config.php';

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

$whatsapp_link = sprintf(
    'https://wa.me/%s',
    preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER)
);
?>
<header class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <a href="<?php echo $menu_links['home']; ?>" class="font-serif text-2xl text-sangiovese">
                <?php echo SITE_NAME; ?>
            </a>
            <ul class="hidden md:flex items-center space-x-8">
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
                    <a href="<?php echo $whatsapp_link; ?>" target="_blank" rel="noopener"
                       class="hover:text-sangiovese transition-colors">
                        <?php echo t('nav_whatsapp'); ?>
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
            <button class="md:hidden text-olive" type="button" onclick="toggleMobileMenu()">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <ul id="mobile-menu" class="mt-4 hidden flex-col space-y-3 md:hidden">
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
                <a href="<?php echo $whatsapp_link; ?>" target="_blank" rel="noopener" class="block py-2">
                    <?php echo t('nav_whatsapp'); ?>
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
