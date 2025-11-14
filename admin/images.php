<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$galleryDir = admin_upload_path('gallery');
$files = glob($galleryDir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE) ?: [];
$relativeFiles = array_map(static fn($path) => str_replace(ADMIN_PROJECT_ROOT, '', $path), $files);
sort($relativeFiles);

$success = show_success_message();
$error = show_error_message();

$page_title = 'Görsel Galerisi';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<?php if ($success): ?>
    <div class="flash-message mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-900" data-autoclose="4000">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="flash-message mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-900" data-autoclose="4000">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="rounded-2xl bg-white p-6 shadow space-y-4">
    <h3 class="text-xl font-semibold text-gray-900">Yeni Görseller Yükle</h3>
    <form method="POST" action="images-upload.php" enctype="multipart/form-data" class="space-y-3">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="file" name="images[]" multiple accept="image/*" class="w-full rounded-lg border border-gray-200 px-4 py-3">
        <button class="rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3 font-semibold text-white">Yükle</button>
    </form>
</div>

<div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <?php foreach ($relativeFiles as $file): ?>
        <div class="rounded-2xl bg-white shadow overflow-hidden flex flex-col">
            <img src="../<?= htmlspecialchars($file) ?>" class="h-48 object-cover" alt="Galeriden görsel">
            <div class="p-4 flex items-center justify-between text-sm">
                <span class="text-gray-500 truncate mr-2"><?= htmlspecialchars($file) ?></span>
                <form method="POST" action="images-upload.php" onsubmit="return confirm('Görseli silmek istiyor musunuz?');">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="file" value="<?= htmlspecialchars(basename($file)) ?>">
                    <button class="rounded-lg bg-red-50 px-3 py-1 text-red-700">Sil</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($relativeFiles)): ?>
        <div class="rounded-2xl border border-dashed border-gray-200 p-10 text-center text-gray-500">Henüz görsel yüklenmedi.</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
