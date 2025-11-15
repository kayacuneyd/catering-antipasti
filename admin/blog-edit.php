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
    <form method="POST" action="blog-save.php" class="space-y-6" enctype="multipart/form-data">
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

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-gray-600">Kapak Görseli</label>
                <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 bg-white">
                <p class="text-xs text-gray-400 mt-2">Yeni bir görsel yüklerseniz mevcut olanın yerini alır.</p>
                <?php if (!empty($post['image'])): ?>
                    <div class="mt-4">
                        <img src="<?= htmlspecialchars($post['image']) ?>" alt="" class="rounded-xl border w-full max-h-52 object-cover">
                        <label class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="image_remove" value="1">
                            <span>Mevcut görseli kaldır</span>
                        </label>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Görsel Alternatif Metni</label>
                <input type="text" name="image_alt" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3"
                       value="<?= htmlspecialchars($post['image_alt'] ?? '') ?>" placeholder="Örn. Flying buffet setup">
            </div>
        </div>

        <button class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-lg font-semibold text-white">Güncelle</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
