<?php
if (!isset($page_title)) {
    $page_title = 'Admin Paneli';
}
$settings = get_settings();
$adminName = current_admin_username();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> • Catering Antipasti Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/admin.css?v=<?= time() ?>">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen lg:flex">
        <aside class="bg-gray-900 text-white w-full lg:w-64 p-6 space-y-8 shadow-xl">
            <div>
                <p class="text-sm uppercase tracking-widest text-gray-400">Admin Panel</p>
                <h1 class="text-2xl font-bold">Catering Antipasti</h1>
                <?php if (!empty($settings['site_title'])): ?>
                    <p class="text-gray-400 text-sm mt-1"><?= htmlspecialchars($settings['site_title']) ?></p>
                <?php endif; ?>
            </div>
            <nav class="space-y-2">
                <?php
                    $nav = [
                        'index.php' => 'Dashboard',
                        'colors.php' => 'Renkler',
                        'menus.php' => 'Menüler',
                        'blog.php' => 'Blog',
                        'images.php' => 'Görseller',
                        'logo.php' => 'Logo',
                        'settings.php' => 'Ayarlar'
                    ];
                    $current = basename($_SERVER['PHP_SELF']);
                ?>
                <?php foreach ($nav as $file => $label): ?>
                    <a href="<?= $file ?>" class="block px-4 py-2 rounded-lg font-semibold transition <?= $current === $file ? 'bg-white/15 text-white' : 'text-gray-300 hover:bg-white/10' ?>">
                        <?= htmlspecialchars($label) ?>
                    </a>
                <?php endforeach; ?>
            </nav>
            <div class="text-sm text-gray-400">
                <p>👤 <?= htmlspecialchars($adminName) ?></p>
                <a href="logout.php" class="inline-flex items-center gap-2 text-red-200 hover:text-white mt-2 font-semibold">Çıkış Yap →</a>
            </div>
        </aside>
        <main class="flex-1">
            <header class="bg-white shadow-sm">
                <div class="mx-auto max-w-6xl px-6 py-6">
                    <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($page_title) ?></h2>
                </div>
            </header>
            <div class="mx-auto max-w-6xl px-6 py-8">
