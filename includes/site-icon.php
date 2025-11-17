<?php
/**
 * Outputs a favicon link tag using the configured site logo.
 */
if (!defined('SITE_ICON_EMITTED')) {
    $icon_path = SITE_LOGO;
    if (!empty($icon_path)) {
        echo '<link rel="icon" href="' . htmlspecialchars($icon_path, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    }
    define('SITE_ICON_EMITTED', true);
}
