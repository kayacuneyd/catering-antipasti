<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$lang = $_GET['lang'] ?? 'de';
$type = $_GET['type'] ?? 'preset';
$menus = read_json_file('data/menus.json', []);
$langMenus = $menus[$lang] ?? ['preset' => [], 'categories' => []];

if ($type === 'preset') {
    $index = (int) ($_GET['index'] ?? -1);
    if (!isset($langMenus['preset'][$index])) {
        redirect_with_message('menus.php?lang=' . $lang, 'Menü bulunamadı.', 'error');
    }
    $entry = $langMenus['preset'][$index];
} else {
    $key = $_GET['key'] ?? '';
    if ($key === '' || !isset($langMenus['categories'][$key])) {
        redirect_with_message('menus.php?lang=' . $lang . '&type=category', 'Kategori bulunamadı.', 'error');
    }
    $entry = $langMenus['categories'][$key];
}

$page_title = ($type === 'category' ? 'Kategori' : 'Menü') . ' Düzenle';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="rounded-2xl bg-white p-6 shadow">
    <form method="POST" action="menu-save.php" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="lang" value="<?= htmlspecialchars($lang) ?>">
        <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
        <?php if ($type === 'preset'): ?>
            <input type="hidden" name="index" value="<?= $index ?>">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Menü Adı</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($entry['name'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Açıklama</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 px-4 py-3"><?= htmlspecialchars($entry['description'] ?? '') ?></textarea>
            </div>
        <?php else: ?>
            <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Görünen Başlık</label>
                <input type="text" name="label" required value="<?= htmlspecialchars($entry['label'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
        <?php endif; ?>
        <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Öğeler</label>
            <textarea name="items" rows="8" class="w-full rounded-lg border border-gray-300 px-4 py-3"><?php
                $items = $entry['items'] ?? [];
                $lines = [];
                foreach ($items as $item) {
                    if (is_array($item)) {
                        $name = trim($item['name'] ?? '');
                        $desc = trim($item['description'] ?? '');
                        $lines[] = $desc !== '' ? ($name . ' | ' . $desc) : $name;
                    } else {
                        $lines[] = $item;
                    }
                }
                echo htmlspecialchars(implode("\n", array_map('trim', $lines)));
            ?></textarea>
        </div>
        <button class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-lg font-semibold text-white">Güncelle</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
