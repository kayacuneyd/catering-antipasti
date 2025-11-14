<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: menus.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    redirect_with_message('menus.php', 'Oturum doğrulaması başarısız.', 'error');
}

$lang = $_POST['lang'] ?? 'de';
$type = $_POST['type'] ?? 'preset';

$menus = read_json_file('data/menus.json', []);
if (!isset($menus[$lang])) {
    redirect_with_message('menus.php?lang=' . $lang . '&type=' . $type, 'Kayıt bulunamadı.', 'error');
}

if ($type === 'preset') {
    $index = (int) ($_POST['index'] ?? -1);
    if ($index >= 0 && isset($menus[$lang]['preset'][$index])) {
        array_splice($menus[$lang]['preset'], $index, 1);
    }
} else {
    $key = $_POST['key'] ?? '';
    unset($menus[$lang]['categories'][$key]);
}

write_json_file('data/menus.json', $menus);
log_activity('menus:delete', strtoupper($type) . " | {$lang}");

redirect_with_message('menus.php?lang=' . $lang . '&type=' . $type, 'Silindi.');
