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

$action = $_POST['action'] ?? 'create';
$lang = $_POST['lang'] ?? 'de';
$type = $_POST['type'] ?? 'preset';

$menus = read_json_file('data/menus.json', ['de' => ['preset' => [], 'categories' => []], 'en' => ['preset' => [], 'categories' => []]]);
if (!isset($menus[$lang])) {
    $menus[$lang] = ['preset' => [], 'categories' => []];
}

if ($type === 'preset') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $itemsRaw = trim($_POST['items'] ?? '');
    if ($name === '' || $itemsRaw === '') {
        redirect_with_message('menu-new.php?lang=' . $lang . '&type=preset', 'İsim ve öğeler zorunludur.', 'error');
    }
    $items = array_filter(array_map('trim', preg_split('/\r?\n/', $itemsRaw)));
    $entry = ['name' => $name, 'description' => $description, 'items' => array_values($items)];

    if ($action === 'update') {
        $index = (int) ($_POST['index'] ?? -1);
        if ($index < 0 || !isset($menus[$lang]['preset'][$index])) {
            redirect_with_message('menus.php?lang=' . $lang, 'Menü bulunamadı.', 'error');
        }
        $menus[$lang]['preset'][$index] = $entry;
    } else {
        $menus[$lang]['preset'][] = $entry;
    }
} else {
    if ($action === 'update') {
        $key = $_POST['key'] ?? '';
    } else {
        $key = slugify($_POST['key'] ?? '');
    }
    $label = trim($_POST['label'] ?? '');
    $itemsRaw = trim($_POST['items'] ?? '');
    if ($key === '' || $label === '' || $itemsRaw === '') {
        redirect_with_message('menu-new.php?lang=' . $lang . '&type=category', 'Tüm alanlar zorunludur.', 'error');
    }
    $lines = array_filter(array_map('trim', preg_split('/\r?\n/', $itemsRaw)));
    $items = [];
    foreach ($lines as $line) {
        [$title, $desc] = array_pad(explode('|', $line, 2), 2, '');
        $title = trim($title);
        $desc = trim($desc);
        if ($title === '') {
            continue;
        }
        $items[] = ['name' => $title, 'description' => $desc];
    }
    if (empty($items)) {
        redirect_with_message('menu-new.php?lang=' . $lang . '&type=category', 'En az bir öğe girmelisiniz.', 'error');
    }
    $menus[$lang]['categories'][$key] = ['label' => $label, 'items' => $items];
}

write_json_file('data/menus.json', $menus);
log_activity('menus:save', strtoupper($type) . " | {$lang}");

redirect_with_message('menus.php?lang=' . $lang . '&type=' . $type, 'Menü kaydedildi.');
