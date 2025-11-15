<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: blog.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    redirect_with_message('blog.php', 'Oturum doğrulaması başarısız.', 'error');
}

$blog = read_json_file('data/blog-posts.json', ['de' => [], 'en' => []]);
$lang = $_POST['lang'] ?? 'de';
if (!isset($blog[$lang])) {
    $blog[$lang] = [];
}

$title = trim($_POST['title'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$date = trim($_POST['date'] ?? '');
$category = trim($_POST['category'] ?? '');
$excerpt = trim($_POST['excerpt'] ?? '');
$contentRaw = trim($_POST['content'] ?? '');
$tagsRaw = trim($_POST['tags'] ?? '');
$status = $_POST['status'] ?? 'published';
$imageAlt = trim($_POST['image_alt'] ?? '');

if ($title === '' || $slug === '' || $date === '' || $contentRaw === '') {
    redirect_with_message('blog.php?lang=' . $lang, 'Zorunlu alanları doldurun.', 'error');
}

$paragraphs = array_filter(array_map('trim', preg_split('/\n{2,}/', $contentRaw)));
$tags = array_filter(array_map('trim', explode(',', $tagsRaw)));

$existingImage = null;
if (($action = $_POST['action'] ?? 'create') === 'update') {
    $index = (int) ($_POST['index'] ?? -1);
    if ($index >= 0 && isset($blog[$lang][$index])) {
        $existingImage = $blog[$lang][$index]['image'] ?? '';
    }
}

$newImagePath = $existingImage ?: '';

$removeRequested = !empty($_POST['image_remove']);
if ($removeRequested && $existingImage) {
    delete_uploaded_file($existingImage);
    $newImagePath = '';
}

if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_NO_FILE) {
    $upload = handle_upload('featured_image', ['jpg', 'jpeg', 'png', 'gif', 'webp'], 5);
    if (!$upload['success']) {
        redirect_with_message('blog.php?lang=' . $lang, $upload['error'] ?? 'Görsel yüklenemedi.', 'error');
    }

    $uploadDir = admin_upload_path('blog');
    $targetPath = $uploadDir . '/' . $upload['target_name'];
    if (!save_optimized_image($upload['tmp_path'], $targetPath, 1600, 1200)) {
        redirect_with_message('blog.php?lang=' . $lang, 'Görsel işlenemedi.', 'error');
    }

    if ($existingImage && !$removeRequested) {
        delete_uploaded_file($existingImage);
    }

    $newImagePath = 'assets/uploads/blog/' . $upload['target_name'];
}

$entry = [
    'title' => $title,
    'slug' => $slug,
    'date' => $date,
    'category' => $category,
    'excerpt' => $excerpt,
    'content' => array_values($paragraphs),
    'tags' => array_values($tags),
    'status' => $status,
    'image' => $newImagePath,
    'image_alt' => $imageAlt,
];

if ($action === 'update') {
    $index = (int) ($_POST['index'] ?? -1);
    if ($index < 0 || !isset($blog[$lang][$index])) {
        redirect_with_message('blog.php?lang=' . $lang, 'Yazı bulunamadı.', 'error');
    }
    $blog[$lang][$index] = $entry;
} else {
    array_unshift($blog[$lang], $entry);
}

write_json_file('data/blog-posts.json', $blog);
log_activity('blog:save', $slug);

redirect_with_message('blog.php?lang=' . $lang, 'Blog yazısı kaydedildi.');
