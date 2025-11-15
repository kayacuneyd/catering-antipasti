<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$blog = read_json_file('data/blog-posts.json', ['de' => [], 'en' => []]);
$lang = $_GET['lang'] ?? 'de';
$posts = $blog[$lang] ?? [];

$success = show_success_message();
$error = show_error_message();

$page_title = 'Blog Yönetimi';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
        <p class="text-sm text-gray-500">Dil</p>
        <div class="flex gap-3 mt-2">
            <a class="rounded-lg px-4 py-2 font-semibold <?= $lang === 'de' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-700' ?>" href="?lang=de">🇩🇪 Deutsch</a>
            <a class="rounded-lg px-4 py-2 font-semibold <?= $lang === 'en' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-700' ?>" href="?lang=en">🇬🇧 English</a>
        </div>
    </div>
    <a href="blog-new.php?lang=<?= $lang ?>" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3 font-semibold text-white shadow-lg">+ Yeni Yazı</a>
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

<div class="mt-6 grid gap-6">
    <?php foreach ($posts as $index => $post): ?>
        <div class="rounded-2xl bg-white p-6 shadow flex flex-col gap-4 md:flex-row md:items-stretch md:justify-between">
            <div class="flex-1">
                <p class="text-xs uppercase tracking-widest text-gray-400"><?= htmlspecialchars($post['category'] ?? 'Kategori') ?></p>
                <h3 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($post['title'] ?? '') ?></h3>
                <p class="text-sm text-gray-500 mt-1">Yayın: <?= htmlspecialchars($post['date'] ?? '') ?></p>
                <p class="text-gray-600 mt-3 max-w-2xl">
                    <?= htmlspecialchars($post['excerpt'] ?? '') ?>
                </p>
                <?php if (!empty($post['tags']) && is_array($post['tags'])): ?>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <?php foreach ($post['tags'] as $tag): ?>
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-600">#<?= htmlspecialchars($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex flex-col gap-3 items-end">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?= htmlspecialchars($post['image']) ?>" alt="" class="rounded-xl border w-36 h-32 object-cover">
                <?php endif; ?>
                <div class="flex gap-3">
                    <a href="blog-edit.php?lang=<?= $lang ?>&index=<?= $index ?>" class="rounded-lg border border-gray-200 px-4 py-2 font-semibold text-gray-700">Düzenle</a>
                    <form method="POST" action="blog-delete.php" onsubmit="return confirm('Bu yazıyı silmek istediğinize emin misiniz?');">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="lang" value="<?= $lang ?>">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button class="rounded-lg bg-red-50 px-4 py-2 font-semibold text-red-700">Sil</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($posts)): ?>
        <div class="rounded-2xl border border-dashed border-gray-200 p-10 text-center text-gray-500">Bu dilde henüz yazı yok.</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
