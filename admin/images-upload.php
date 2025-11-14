<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: images.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    redirect_with_message('images.php', 'Oturum doğrulaması başarısız.', 'error');
}

$galleryDir = admin_upload_path('gallery');

if (($_POST['action'] ?? '') === 'delete') {
    $file = basename($_POST['file'] ?? '');
    if ($file) {
        $path = $galleryDir . '/' . $file;
        if (file_exists($path)) {
            unlink($path);
            log_activity('images:delete', $file);
        }
    }
    redirect_with_message('images.php', 'Görsel silindi.');
}

if (empty($_FILES['images'])) {
    redirect_with_message('images.php', 'Dosya seçilmedi.', 'error');
}

$totalUploaded = 0;
foreach ((array) $_FILES['images']['name'] as $idx => $_) {
    if ($_FILES['images']['error'][$idx] !== UPLOAD_ERR_OK) {
        continue;
    }
    $tmp = $_FILES['images']['tmp_name'][$idx];
    $name = $_FILES['images']['name'][$idx];
    $size = $_FILES['images']['size'][$idx];

    if ($size > 5 * 1024 * 1024) {
        continue;
    }

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
        continue;
    }

    $target = $galleryDir . '/' . slugify(pathinfo($name, PATHINFO_FILENAME)) . '-' . time() . '-' . $idx . '.' . $ext;
    if (move_uploaded_file($tmp, $target)) {
        $totalUploaded++;
    }
}

if ($totalUploaded) {
    log_activity('images:upload', (string) $totalUploaded);
    redirect_with_message('images.php', $totalUploaded . ' görsel yüklendi.');
}

redirect_with_message('images.php', 'Görsel yüklenemedi.', 'error');
