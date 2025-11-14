<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

function menu_defaults(): array
{
    return [
        'de' => ['preset' => [], 'categories' => []],
        'en' => ['preset' => [], 'categories' => []]
    ];
}

$menus = read_json_file('data/menus.json', menu_defaults());
$lang = $_GET['lang'] ?? 'de';
$type = $_GET['type'] ?? 'preset';

$langMenus = $menus[$lang] ?? ['preset' => [], 'categories' => []];

$success = show_success_message();
$error = show_error_message();

$page_title = 'Menü Yönetimi';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
        <select name="lang" class="rounded-lg border border-gray-300 px-4 py-2">
            <option value="de" <?= $lang === 'de' ? 'selected' : '' ?>>🇩🇪 Deutsch</option>
            <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>🇬🇧 English</option>
        </select>
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-white">Değiştir</button>
    </form>
    <div class="flex gap-3">
        <a href="?lang=<?= $lang ?>&type=preset" class="rounded-lg px-4 py-2 font-semibold <?= $type === 'preset' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-700' ?>">Menüler</a>
        <a href="?lang=<?= $lang ?>&type=category" class="rounded-lg px-4 py-2 font-semibold <?= $type === 'category' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-700' ?>">Kategoriler</a>
    </div>
</div>

<?php if ($success): ?>
    <div class="flash-message mt-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-900" data-autoclose="4000">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="flash-message mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-900" data-autoclose="4000">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="mt-6 flex justify-end">
    <a href="menu-new.php?lang=<?= $lang ?>&type=<?= $type ?>" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3 font-semibold text-white shadow-lg">
        + Yeni <?= $type === 'preset' ? 'Menü' : 'Kategori' ?>
    </a>
</div>

<div class="mt-4 space-y-4">
    <?php if ($type === 'preset'): ?>
        <?php foreach ($langMenus['preset'] as $index => $menu): ?>
            <div class="rounded-2xl bg-white p-6 shadow">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400">Preset Menü</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($menu['name'] ?? 'İsimsiz') ?></h3>
                        <p class="text-gray-600 mt-1"><?= htmlspecialchars($menu['description'] ?? '') ?></p>
                        <p class="text-sm text-gray-400 mt-2"><?= count($menu['items'] ?? []) ?> öğe</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="menu-edit.php?lang=<?= $lang ?>&type=preset&index=<?= $index ?>" class="rounded-lg border border-gray-200 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-50">Düzenle</a>
                        <form method="POST" action="menu-delete.php" onsubmit="return confirm('Menüyü silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="lang" value="<?= $lang ?>">
                            <input type="hidden" name="type" value="preset">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button class="rounded-lg bg-red-50 px-4 py-2 font-semibold text-red-700">Sil</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($langMenus['preset'])): ?>
            <div class="rounded-2xl border border-dashed border-gray-200 p-10 text-center text-gray-500">Henüz menü yok.</div>
        <?php endif; ?>
    <?php else: ?>
        <?php foreach ($langMenus['categories'] as $key => $category): ?>
            <div class="rounded-2xl bg-white p-6 shadow">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400">Kategori</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($category['label'] ?? $key) ?></h3>
                        <p class="text-sm text-gray-500 mt-1">Kimlik: <?= htmlspecialchars($key) ?></p>
                        <p class="text-sm text-gray-400 mt-2"><?= count($category['items'] ?? []) ?> öğe</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="menu-edit.php?lang=<?= $lang ?>&type=category&key=<?= urlencode($key) ?>" class="rounded-lg border border-gray-200 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-50">Düzenle</a>
                        <form method="POST" action="menu-delete.php" onsubmit="return confirm('Kategoriyi silmek istediğinizden emin misiniz?');">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="lang" value="<?= $lang ?>">
                            <input type="hidden" name="type" value="category">
                            <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
                            <button class="rounded-lg bg-red-50 px-4 py-2 font-semibold text-red-700">Sil</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($langMenus['categories'])): ?>
            <div class="rounded-2xl border border-dashed border-gray-200 p-10 text-center text-gray-500">Henüz kategori yok.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
