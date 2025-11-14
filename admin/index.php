<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$menus = read_json_file('data/menus.json', []);
$blog = read_json_file('data/blog-posts.json', []);
$settings = get_settings();
$palettes = get_palettes();

$menuCount = 0;
foreach ($menus as $lang => $groups) {
    if (isset($groups['preset']) && is_array($groups['preset'])) {
        $menuCount += count($groups['preset']);
    }
}

$blogCount = 0;
foreach ($blog as $lang => $posts) {
    $blogCount += is_array($posts) ? count($posts) : 0;
}

$galleryDir = admin_upload_path('gallery');
$images = glob($galleryDir . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE) ?: [];

$page_title = 'Dashboard';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
    <div class="rounded-2xl bg-white shadow p-6">
        <p class="text-sm text-gray-500">Toplam Menü</p>
        <p class="text-4xl font-bold text-gray-900 mt-2"><?= $menuCount ?></p>
    </div>
    <div class="rounded-2xl bg-white shadow p-6">
        <p class="text-sm text-gray-500">Blog Yazıları</p>
        <p class="text-4xl font-bold text-gray-900 mt-2"><?= $blogCount ?></p>
    </div>
    <div class="rounded-2xl bg-white shadow p-6">
        <p class="text-sm text-gray-500">Galeri Görselleri</p>
        <p class="text-4xl font-bold text-gray-900 mt-2"><?= count($images) ?></p>
    </div>
</div>

<div class="mt-10 grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl bg-white shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktif Renk Paleti</h3>
        <p class="text-sm text-gray-500 mb-4"><?= htmlspecialchars($palettes['active'] ?? 'classic') ?></p>
        <div class="grid grid-cols-3 gap-3">
            <?php $activeColors = $palettes[$palettes['active'] ?? 'classic'] ?? []; ?>
            <?php foreach ($activeColors as $name => $hex): ?>
                <div class="rounded-lg border border-gray-100 p-3 flex flex-col items-center gap-2 text-sm text-gray-600">
                    <span class="w-12 h-12 rounded-full border" style="background: <?= htmlspecialchars($hex) ?>"></span>
                    <span class="font-semibold text-gray-800"><?= htmlspecialchars($name) ?></span>
                    <span class="font-mono text-xs text-gray-500"><?= htmlspecialchars($hex) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="rounded-2xl bg-white shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Hızlı Bağlantılar</h3>
        <div class="space-y-3">
            <a href="menus.php" class="block rounded-xl border border-gray-200 px-4 py-3 hover:border-gray-400 transition">Menü Yönetimi</a>
            <a href="blog.php" class="block rounded-xl border border-gray-200 px-4 py-3 hover:border-gray-400 transition">Blog Yönetimi</a>
            <a href="settings.php" class="block rounded-xl border border-gray-200 px-4 py-3 hover:border-gray-400 transition">Genel Ayarlar</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
