<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$lang = $_GET['lang'] ?? 'de';
$index = (int) ($_GET['index'] ?? -1);
$blog = read_json_file('data/blog-posts.json', ['de' => [], 'en' => []]);
$posts = $blog[$lang] ?? [];

if (!isset($posts[$index])) {
    redirect_with_message('blog.php?lang=' . $lang, 'Yazı bulunamadı.', 'error');
}

$post = $posts[$index];
$page_title = 'Blog Yazısını Düzenle';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="rounded-2xl bg-white p-6 shadow">
    <form method="POST" action="blog-save.php" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="lang" value="<?= htmlspecialchars($lang) ?>">
        <input type="hidden" name="index" value="<?= $index ?>">

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-gray-600">Başlık</label>
                <input type="text" name="title" required class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" value="<?= htmlspecialchars($post['title'] ?? '') ?>">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Slug</label>
                <input type="text" name="slug" required pattern="[a-z0-9-]+" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" value="<?= htmlspecialchars($post['slug'] ?? '') ?>">
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="text-sm font-semibold text-gray-600">Tarih</label>
                <input type="date" name="date" required class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" value="<?= htmlspecialchars($post['date'] ?? date('Y-m-d')) ?>">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Kategori</label>
                <input type="text" name="category" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" value="<?= htmlspecialchars($post['category'] ?? '') ?>">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Durum</label>
                <select name="status" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3">
                    <?php $status = $post['status'] ?? 'published'; ?>
                    <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Yayınlandı</option>
                    <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Taslak</option>
                </select>
            </div>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Kısa Özet</label>
            <textarea name="excerpt" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3"><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">İçerik</label>
            <textarea name="content" rows="10" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3"><?= htmlspecialchars(implode("\n\n", $post['content'] ?? [])) ?></textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Etiketler</label>
            <input type="text" name="tags" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" value="<?= htmlspecialchars(implode(', ', $post['tags'] ?? [])) ?>">
        </div>

        <button class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-lg font-semibold text-white">Güncelle</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
