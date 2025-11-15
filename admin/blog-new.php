<?php
require_once __DIR__ . '/includes/auth.php';
$lang = $_GET['lang'] ?? 'de';
$page_title = 'Yeni Blog Yazısı';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="rounded-2xl bg-white p-6 shadow">
    <form method="POST" action="blog-save.php" class="space-y-6" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="lang" value="<?= htmlspecialchars($lang) ?>">

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-gray-600">Başlık</label>
                <input type="text" name="title" required class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" id="title-input">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Slug</label>
                <input type="text" name="slug" required pattern="[a-z0-9-]+" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" id="slug-input">
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="text-sm font-semibold text-gray-600">Tarih</label>
                <input type="date" name="date" required class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" value="<?= date('Y-m-d') ?>">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Kategori</label>
                <input type="text" name="category" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Durum</label>
                <select name="status" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3">
                    <option value="published">Yayınlandı</option>
                    <option value="draft">Taslak</option>
                </select>
            </div>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Kısa Özet</label>
            <textarea name="excerpt" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3"></textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">İçerik (paragrafları boş satır ile ayırın)</label>
            <textarea name="content" rows="10" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3"></textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Etiketler (virgülle ayırın)</label>
            <input type="text" name="tags" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3">
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-gray-600">Kapak Görseli</label>
                <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 bg-white">
                <p class="text-xs text-gray-400 mt-2">JPG, PNG veya WebP, maksimum 5MB. Yükleme sırasında otomatik optimize edilir.</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Görsel Alternatif Metni</label>
                <input type="text" name="image_alt" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-3" placeholder="Örn. Team Catering Setup">
            </div>
        </div>

        <button class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-lg font-semibold text-white">Yazıyı Kaydet</button>
    </form>
</div>

<script>
const titleInput = document.getElementById('title-input');
const slugInput = document.getElementById('slug-input');
if (titleInput && slugInput) {
    titleInput.addEventListener('input', () => {
        const slug = titleInput.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugInput.value = slug;
    });
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
