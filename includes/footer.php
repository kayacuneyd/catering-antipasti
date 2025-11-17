<?php
require_once __DIR__ . '/config.php';
$footer_logo = SITE_FOOTER_LOGO;
$footer_logo_exists = false;
if ($footer_logo !== '') {
    $footer_logo_path = dirname(__DIR__) . $footer_logo;
    $footer_logo_exists = is_file($footer_logo_path);
}
?>
<footer class="bg-vineyard text-white py-12">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid gap-8 md:grid-cols-3 mb-8">
            <div>
                <?php if ($footer_logo_exists): ?>
                    <a href="<?php echo $is_english ? 'index.php' : 'index.php'; ?>" class="inline-flex mb-6">
                        <img src="<?php echo htmlspecialchars($footer_logo, ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8'); ?>"
                             class="h-32 w-auto object-contain">
                    </a>
                <?php endif; ?>
                <p class="text-xl text-white/90 leading-relaxed">
                    <?php echo t('footer_contact_info'); ?><br>
                    <a href="mailto:<?php echo SITE_EMAIL; ?>" class="hover:text-sangiovese">
                        <?php echo SITE_EMAIL; ?>
                    </a>
                </p>
                <a href="<?php echo sprintf('https://wa.me/%s', preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER)); ?>"
                   target="_blank" rel="noopener"
                   class="mt-4 inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm text-white hover:bg-white/20 transition-all">
                    <?php echo whatsapp_icon('h-4 w-4'); ?>
                    <span><?php echo t('nav_whatsapp'); ?></span>
                </a>
            </div>
            <div>
                <h4 class="font-serif text-xl mb-4"><?php echo t('footer_quicklinks'); ?></h4>
                <ul class="space-y-2 text-white/80">
                    <li><a href="menu.php" class="hover:text-sangiovese"><?php echo t('nav_menu'); ?></a></li>
                    <li><a href="<?php echo $is_english ? 'references.php' : 'referenzen.php'; ?>"
                           class="hover:text-sangiovese"><?php echo t('nav_references'); ?></a></li>
                    <li><a href="<?php echo $is_english ? 'about-us.php' : 'uber-uns.php'; ?>"
                           class="hover:text-sangiovese"><?php echo t('nav_about'); ?></a></li>
                    <li><a href="<?php echo $is_english ? 'blog.php' : 'blog.php'; ?>"
                           class="hover:text-sangiovese"><?php echo t('nav_blog'); ?></a></li>
                    <li><a href="<?php echo $is_english ? 'contact.php' : 'kontakt.php'; ?>"
                           class="hover:text-sangiovese"><?php echo t('nav_contact'); ?></a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-serif text-xl mb-4"><?php echo t('footer_legal_heading'); ?></h4>
                <ul class="space-y-2 text-white/80">
                    <li><a href="<?php echo $is_english ? 'imprint.php' : 'impressum.php'; ?>"
                           class="hover:text-sangiovese"><?php echo t('footer_legal'); ?></a></li>
                    <li><a href="<?php echo $is_english ? 'privacy.php' : 'datenschutz.php'; ?>"
                           class="hover:text-sangiovese"><?php echo t('footer_privacy'); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/20 pt-6 text-center text-white/90 text-sm">
            <p class="text-xl"><?php echo '© ' . date('Y') . ' ' . t('footer_copyright'); ?></p>
            <p class="mt-2 text-xs text-white/80">
                Built by <a href="https://kayacuneyt.com" target="_blank" rel="noopener" class="underline">Cüneyt Kaya</a> in Kornwestheim
            </p>
            <button type="button" data-cookie-manage
                    class="mt-3 text-xs text-white/80 underline underline-offset-4">
                <?php echo t('cookie_manage'); ?>
            </button>
        </div>
    </div>
</footer>

<div id="cookie-banner" class="cookie-banner hidden" role="dialog" aria-live="polite">
    <div class="cookie-banner__body">
        <p class="text-xl cookie-banner__title"><?php echo t('cookie_title'); ?></p>
        <p class="text-xl cookie-banner__text"><?php echo t('cookie_text'); ?></p>
        <div class="cookie-banner__actions">
            <button type="button" id="cookie-accept-all" class="cookie-btn cookie-btn--primary">
                <?php echo t('cookie_accept_all'); ?>
            </button>
            <button type="button" id="cookie-accept-essential" class="cookie-btn cookie-btn--secondary">
                <?php echo t('cookie_only_essential'); ?>
            </button>
        </div>
    </div>
</div>
