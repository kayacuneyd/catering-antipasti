<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: logo.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    redirect_with_message('logo.php', 'Oturum doğrulaması başarısız.', 'error');
}

$result = handle_upload('logo', ['png', 'jpg', 'jpeg', 'svg', 'webp'], 4);
if (!$result['success']) {
    redirect_with_message('logo.php', $result['error'], 'error');
}

$targetDir = admin_upload_path('branding');
$targetPath = $targetDir . '/' . $result['target_name'];
if (!move_uploaded_file($result['tmp_path'], $targetPath)) {
    redirect_with_message('logo.php', 'Dosya taşınamadı.', 'error');
}

$relative = 'assets/uploads/branding/' . $result['target_name'];
$settings = get_settings();
$old = $settings['logo_path'] ?? '';
if ($old && $old !== $relative && file_exists(admin_path($old))) {
    @unlink(admin_path($old));
}
$settings['logo_path'] = $relative;
save_settings($settings);

log_activity('logo:update', $relative);
redirect_with_message('logo.php', 'Logo güncellendi.');
