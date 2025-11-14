<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$settings = get_settings();
$logoPath = $settings['logo_path'] ?? '';
$success = show_success_message();
$error = show_error_message();

$page_title = 'Logo Yönetimi';
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

<div class="rounded-2xl bg-white p-6 shadow space-y-6">
    <div>
        <h3 class="text-xl font-semibold text-gray-900">Mevcut Logo</h3>
        <p class="text-sm text-gray-500">SVG, PNG veya WebP önerilir.</p>
    </div>
    <?php if ($logoPath && file_exists(admin_path($logoPath))): ?>
        <div class="flex flex-col gap-3 rounded-xl border border-gray-100 p-6">
            <img src="../<?= htmlspecialchars($logoPath) ?>" alt="Mevcut Logo" class="h-24 object-contain">
            <p class="text-xs text-gray-400">Dosya: <?= htmlspecialchars($logoPath) ?></p>
        </div>
    <?php else: ?>
        <div class="rounded-xl border border-dashed border-gray-300 p-10 text-center text-gray-500">Henüz logo yüklenmedi.</div>
    <?php endif; ?>

    <form method="POST" action="logo-upload.php" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <label class="block">
            <span class="text-sm font-semibold text-gray-600">Yeni Logo Dosyası</span>
            <input type="file" name="logo" accept=".png,.jpg,.jpeg,.svg,.webp" required class="mt-2 w-full rounded-lg border border-gray-200 px-4 py-3">
        </label>
        <button class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-lg font-semibold text-white">Yükle</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
