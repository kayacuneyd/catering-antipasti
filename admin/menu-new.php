<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$lang = $_GET['lang'] ?? 'de';
$type = $_GET['type'] ?? 'preset';
$page_title = 'Yeni ' . ($type === 'category' ? 'Kategori' : 'Menü');
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="rounded-2xl bg-white p-6 shadow">
    <form method="POST" action="menu-save.php" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="lang" value="<?= htmlspecialchars($lang) ?>">
        <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

        <?php if ($type === 'preset'): ?>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Menü Adı</label>
                <input type="text" name="name" required class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Açıklama</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 px-4 py-3"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Öğeler (her satır bir öğe)</label>
                <textarea name="items" rows="6" class="w-full rounded-lg border border-gray-300 px-4 py-3" placeholder="İsim | opsiyonel açıklama"></textarea>
                <p class="text-xs text-gray-400 mt-2">Opsiyonel açıklama eklemek için "Yemek Adı | açıklama" yazabilirsiniz.</p>
            </div>
        <?php else: ?>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Kategori Anahtarı (slug)</label>
                <input type="text" name="key" pattern="[a-z0-9-]+" required class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Görünen Başlık</label>
                <input type="text" name="label" required class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
            <?php
            $categoryItems = [['name' => '', 'description' => '']];
            include __DIR__ . '/partials/category-items-fields.php';
            ?>
            <p class="text-xs text-gray-400">En az bir öğe girmeniz gerekir. Her öğe kendine ait başlık ve opsiyonel açıklamadan oluşur.</p>
        <?php endif; ?>

        <button class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-lg font-semibold text-white">Kaydet</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
