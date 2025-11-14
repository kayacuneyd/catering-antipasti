<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$settings = get_settings();
$success = show_success_message();
$error = show_error_message();

$page_title = 'Genel Ayarlar';
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

<div class="rounded-2xl bg-white p-6 shadow">
    <form method="POST" action="settings-save.php" class="space-y-8">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <section class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-900">Site Bilgileri</h3>
            <label class="block">
                <span class="text-sm font-semibold text-gray-600">Site Başlığı</span>
                <input type="text" name="site_title" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3">
            </label>
            <label class="block">
                <span class="text-sm font-semibold text-gray-600">Site Açıklaması</span>
                <textarea name="site_description" rows="3" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            </label>
        </section>

        <section class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-900">İletişim</h3>
            <label class="block">
                <span class="text-sm font-semibold text-gray-600">E-posta</span>
                <input type="email" name="contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3">
            </label>
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-semibold text-gray-600">Telefon</span>
                    <input type="text" name="phone" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3">
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-gray-600">WhatsApp</span>
                    <input type="text" name="whatsapp" value="<?= htmlspecialchars($settings['whatsapp'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3">
                </label>
            </div>
            <label class="block">
                <span class="text-sm font-semibold text-gray-600">Adres</span>
                <textarea name="address" rows="3" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"><?= htmlspecialchars($settings['address'] ?? '') ?></textarea>
            </label>
        </section>

        <section class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-900">Sosyal Medya</h3>
            <label class="block">
                <span class="text-sm font-semibold text-gray-600">Facebook</span>
                <input type="url" name="social_facebook" value="<?= htmlspecialchars($settings['social_facebook'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3">
            </label>
            <label class="block">
                <span class="text-sm font-semibold text-gray-600">Instagram</span>
                <input type="url" name="social_instagram" value="<?= htmlspecialchars($settings['social_instagram'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3">
            </label>
        </section>

        <section class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-900">Gelişmiş</h3>
            <label class="block">
                <span class="text-sm font-semibold text-gray-600">Google Analytics ID</span>
                <input type="text" name="analytics_id" value="<?= htmlspecialchars($settings['analytics_id'] ?? '') ?>" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3">
            </label>
            <label class="flex items-center gap-3">
                <input type="checkbox" name="maintenance_mode" value="1" <?= !empty($settings['maintenance_mode']) ? 'checked' : '' ?> class="h-5 w-5 rounded border-gray-300">
                <span class="text-sm text-gray-600">Bakım modu aktif</span>
            </label>
        </section>

        <button class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-lg font-semibold text-white">Ayarları Kaydet</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
