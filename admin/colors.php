<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

$palettes = get_palettes();
$success = show_success_message();
$error = show_error_message();

$availablePalettes = array_filter($palettes, 'is_array');
$currentPalette = $_GET['palette'] ?? ($palettes['active'] ?? 'classic');
if (!isset($availablePalettes[$currentPalette])) {
    $currentPalette = $palettes['active'] ?? 'classic';
}

$currentColors = $availablePalettes[$currentPalette];

$colorDescriptions = [
    'olive' => 'Başlıklar ve ana metin',
    'sangiovese' => 'CTA butonları ve linkler',
    'verona' => 'Açık arka planlar',
    'terracotta' => 'İkincil vurgu ve border',
    'seagray' => 'Alt metinler',
    'vineyard' => 'Koyu alanlar',
    'cream' => 'Karton / kart arka planı'
];

$page_title = 'Renk Yönetimi';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<?php if ($success): ?>
    <div class="flash-message mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-900" data-autoclose="5000">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="flash-message mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-900" data-autoclose="5000">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow p-6">
    <form method="GET" class="flex flex-col gap-4 md:flex-row md:items-center">
        <div class="flex-1">
            <label class="text-sm text-gray-500">Palet seç</label>
            <select name="palette" class="w-full rounded-lg border border-gray-300 px-4 py-2">
                <?php foreach ($availablePalettes as $name => $_): ?>
                    <option value="<?= htmlspecialchars($name) ?>" <?= $name === $currentPalette ? 'selected' : '' ?>><?= htmlspecialchars(ucfirst($name)) ?><?= ($palettes['active'] ?? '') === $name ? ' (Aktif)' : '' ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-white">Göster</button>
    </form>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-5">
    <div class="lg:col-span-3 space-y-6">
        <form method="POST" action="colors-save.php" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="palette" value="<?= htmlspecialchars($currentPalette) ?>">

            <div class="rounded-2xl bg-white p-6 shadow">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Düzenlenen palet</p>
                        <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars(ucfirst($currentPalette)) ?></h2>
                    </div>
                    <?php if (($palettes['active'] ?? '') === $currentPalette): ?>
                        <span class="rounded-full bg-green-100 px-4 py-1 text-sm font-semibold text-green-800">Aktif</span>
                    <?php else: ?>
                        <button name="make_active" value="1" class="rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Bu paleti aktif yap</button>
                    <?php endif; ?>
                </div>
                <div class="space-y-4">
                    <?php foreach ($currentColors as $colorKey => $value): ?>
                        <div class="flex flex-col gap-2 rounded-xl border border-gray-100 p-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars(ucfirst($colorKey)) ?></p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($colorDescriptions[$colorKey] ?? '') ?></p>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="color" name="colors[<?= htmlspecialchars($colorKey) ?>]" value="<?= htmlspecialchars($value) ?>" class="h-12 w-12 rounded-lg border border-gray-200 p-1">
                                <input type="text" name="hex[<?= htmlspecialchars($colorKey) ?>]" value="<?= htmlspecialchars($value) ?>" class="rounded-lg border border-gray-300 px-4 py-2 font-mono text-sm">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex flex-col gap-3 md:flex-row">
                <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 text-lg font-semibold text-white shadow-lg">Renkleri Kaydet</button>
            </div>
        </form>
    </div>
    <div class="lg:col-span-2">
        <div class="rounded-2xl bg-white shadow overflow-hidden">
            <div class="p-6 bg-gray-900 text-white">
                <p class="text-sm opacity-70">Canlı Önizleme</p>
                <p class="text-2xl font-bold preview-heading" style="color: <?= htmlspecialchars($currentColors['olive']) ?>;">İtalyan Sofrasının Renkleri</p>
                <p class="text-sm mt-2 text-gray-300 preview-text" style="color: <?= htmlspecialchars($currentColors['seagray']) ?>;">Değişiklikleri kaydetmeden önce görün.</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="rounded-xl border preview-card" style="background: <?= htmlspecialchars($currentColors['verona']) ?>; border-left: 6px solid <?= htmlspecialchars($currentColors['terracotta']) ?>;">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold preview-card-heading">Butik Menü</h3>
                        <p class="text-sm text-gray-500 preview-card-text">Özenle seçilmiş aperitivo deneyimleri.</p>
                        <button type="button" class="mt-4 text-sm font-semibold preview-card-cta" style="color: <?= htmlspecialchars($currentColors['sangiovese']) ?>;">Detayları Gör →</button>
                    </div>
                </div>
                <div class="rounded-xl p-4 preview-footer" style="background: <?= htmlspecialchars($currentColors['vineyard']) ?>; color: <?= htmlspecialchars($currentColors['cream']) ?>;">
                    <p class="font-semibold">Footer Önizlemesi</p>
                    <p class="text-sm opacity-80">Tüm touchpointlerde aynı renk kimliği.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const colorInputs = document.querySelectorAll('input[type="color"]');
colorInputs.forEach((colorInput) => {
    colorInput.addEventListener('input', (event) => {
        const key = event.target.name.replace('colors[', '').replace(']', '');
        const hexInput = document.querySelector(`input[name="hex[${key}]"]`);
        if (hexInput) hexInput.value = event.target.value.toUpperCase();
        updatePreview();
    });
});

document.querySelectorAll('input[name^="hex["]').forEach((hexInput) => {
    hexInput.addEventListener('input', (event) => {
        const key = event.target.name.replace('hex[', '').replace(']', '');
        const colorInput = document.querySelector(`input[name="colors[${key}]"]`);
        if (colorInput) colorInput.value = event.target.value;
        updatePreview();
    });
});

function updatePreview() {
    const colors = {};
    document.querySelectorAll('input[name^="colors["]').forEach((input) => {
        const key = input.name.replace('colors[', '').replace(']', '');
        colors[key] = input.value;
    });

    document.querySelector('.preview-heading').style.color = colors.olive;
    document.querySelector('.preview-text').style.color = colors.seagray;
    const card = document.querySelector('.preview-card');
    card.style.background = colors.verona;
    card.style.borderLeftColor = colors.terracotta;
    document.querySelector('.preview-card-heading').style.color = colors.olive;
    document.querySelector('.preview-card-text').style.color = colors.seagray;
    document.querySelector('.preview-card-cta').style.color = colors.sangiovese;
    const footer = document.querySelector('.preview-footer');
    footer.style.background = colors.vineyard;
    footer.style.color = colors.cream;
}
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
