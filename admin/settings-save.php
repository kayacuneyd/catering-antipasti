<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: settings.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    redirect_with_message('settings.php', 'Oturum doğrulaması başarısız.', 'error');
}

$settings = get_settings();

$settings['site_title'] = trim($_POST['site_title'] ?? '');
$settings['site_description'] = trim($_POST['site_description'] ?? '');
$settings['contact_email'] = trim($_POST['contact_email'] ?? '');
$settings['phone'] = trim($_POST['phone'] ?? '');
$settings['whatsapp'] = trim($_POST['whatsapp'] ?? '');
$settings['address'] = trim($_POST['address'] ?? '');
$settings['social_facebook'] = trim($_POST['social_facebook'] ?? '');
$settings['social_instagram'] = trim($_POST['social_instagram'] ?? '');
$settings['analytics_id'] = trim($_POST['analytics_id'] ?? '');
$settings['maintenance_mode'] = isset($_POST['maintenance_mode']);

save_settings($settings);
log_activity('settings:update', 'general');

redirect_with_message('settings.php', 'Ayarlar kaydedildi.');
