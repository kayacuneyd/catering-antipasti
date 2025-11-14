<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: colors.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    redirect_with_message('colors.php', 'Oturum doğrulaması başarısız.', 'error');
}

$paletteName = trim($_POST['palette'] ?? '');
if ($paletteName === '') {
    $paletteName = 'custom-' . date('His');
}

$colorKeys = ['olive', 'sangiovese', 'verona', 'terracotta', 'seagray', 'vineyard', 'cream'];
$submitted = $_POST['colors'] ?? [];
$hexInputs = $_POST['hex'] ?? [];

$finalColors = [];
foreach ($colorKeys as $key) {
    $value = $submitted[$key] ?? $hexInputs[$key] ?? '';
    $value = strtoupper(trim($value));
    if ($value === '') {
        redirect_with_message('colors.php', ucfirst($key) . ' rengi eksik.', 'error');
    }
    if ($value[0] !== '#') {
        $value = '#' . $value;
    }
    if (!preg_match('/^#[0-9A-F]{6}$/i', $value)) {
        redirect_with_message('colors.php', ucfirst($key) . ' için geçerli bir HEX değeri girin.', 'error');
    }
    $finalColors[$key] = strtoupper($value);
}

$palettes = get_palettes();
$palettes[$paletteName] = $finalColors;

if (isset($_POST['make_active'])) {
    $palettes['active'] = $paletteName;
}

save_palettes($palettes);

if (($palettes['active'] ?? '') === $paletteName) {
    update_custom_css_colors($finalColors);
    $settings = get_settings();
    $settings['active_palette'] = $paletteName;
    save_settings($settings);
}

log_activity('colors:update', 'Palette: ' . $paletteName);

redirect_with_message('colors.php?palette=' . urlencode($paletteName), 'Renkler kaydedildi.');
