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

$lang = $_POST['lang'] ?? 'de';
$index = (int) ($_POST['index'] ?? -1);

$blog = read_json_file('data/blog-posts.json', []);
if (isset($blog[$lang][$index])) {
    array_splice($blog[$lang], $index, 1);
    write_json_file('data/blog-posts.json', $blog);
    log_activity('blog:delete', (string) $index);
}

redirect_with_message('blog.php?lang=' . $lang, 'Blog yazısı silindi.');
