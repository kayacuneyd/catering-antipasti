<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/menus.php';
?>
<!DOCTYPE html>
<html lang="de" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Italienische Catering-Menüs | Catering Antipasti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        olive: '#5C4A3C',
                        sangiovese: '#D4704A',
                        verona: '#F5E6D3',
                        terracotta: '#E8B944',
                        seagray: '#7A8C8E',
                        vineyard: '#3A5A40'
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Work Sans', 'sans-serif']
                    }
                }
            }
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Work+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/custom.css">
    <?php include __DIR__ . '/includes/site-icon.php'; ?>
</head>
<body class="font-sans text-olive bg-verona">
<?php include __DIR__ . '/includes/header.php'; ?>

<main>
    <?php
    render_page_hero([
        'eyebrow' => 'Menüs',
        'title' => 'Unsere Menüs',
        'description' => 'Wählen Sie aus kuratierten Empfehlungen oder kombinieren Sie individuelle Lieblingsgerichte. Alle Zusammenstellungen sind flexibel und werden gemeinsam mit Ihnen finalisiert.',
    ]);
    ?>
    <section class="py-16 bg-verona/40">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="flex justify-center gap-4 mb-12">
                <button type="button"
                        onclick="showMenuType('preset')"
                        id="btn-preset"
                        class="menu-type-btn active px-8 py-3 rounded-lg text-lg transition-all bg-sangiovese text-cream">
                    Fertige Menüs
                </button>
                <button type="button"
                        onclick="showMenuType('custom')"
                        id="btn-custom"
                        class="menu-type-btn px-8 py-3 rounded-lg text-lg transition-all bg-verona text-olive">
                    Eigenes Menü erstellen
                </button>
            </div>

            <div id="preset-menus" class="menu-section">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <?php foreach ($preset_menus as $menu): ?>
                        <div class="bg-white p-8 rounded-lg shadow-lg flex flex-col gap-6">
                            <div>
                                <h3 class="font-serif text-2xl text-sangiovese mb-2">
                                    <?php echo htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </h3>
                                <p class="text-sm text-seagray">
                                    <?php echo htmlspecialchars($menu['description'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            </div>

                            <ul class="space-y-2 flex-1">
                                <?php foreach ($menu['items'] as $item): ?>
                                    <li class="text-olive">✓ <?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="flex flex-col gap-3 border-t border-seagray/30 pt-4 text-sm text-seagray">
                                <p class="text-xl">Preise stimmen wir individuell nach Personenanzahl und Serviceumfang ab.</p>
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <a href="kontakt.php?menu=<?php echo urlencode($menu['name']); ?>"
                                       class="request-proposal-btn">
                                        <span>Anfragen</span>
                                        <span class="request-proposal-btn__icon" aria-hidden="true">→</span>
                                    </a>
                                    <button type="button"
                                            class="menu-card-whatsapp text-sm text-sangiovese underline-offset-2 hover:underline"
                                            data-name="<?php echo htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                            data-items='<?php echo htmlspecialchars(json_encode($menu['items'], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>'
                                            onclick="whatsappPresetMenu(this.dataset.name, JSON.parse(this.dataset.items))">
                                        <?php echo whatsapp_icon('h-4 w-4'); ?>
                                        <span>WhatsApp</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="custom-menu" class="menu-section hidden">
                <div class="max-w-4xl mx-auto bg-verona p-8 rounded-lg">
                    <h3 class="font-serif text-3xl text-center text-sangiovese mb-8">
                        Stellen Sie Ihr eigenes Menü zusammen
                    </h3>

                    <div class="space-y-8">
                        <?php foreach ($menu_categories as $key => $category): ?>
                            <div class="category-section">
                                <h4 class="font-serif text-2xl text-olive mb-4 border-b-2 border-terracotta pb-2">
                                    <?php echo htmlspecialchars($category['label'], ENT_QUOTES, 'UTF-8'); ?>
                                </h4>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <?php foreach ($category['items'] as $item): ?>
                                        <label class="flex items-center gap-3 p-4 bg-white rounded-lg hover:shadow-md cursor-pointer transition-all">
                                            <input type="checkbox"
                                                   name="menu[]"
                                                   value="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                                   data-category="<?php echo htmlspecialchars($category['label'], ENT_QUOTES, 'UTF-8'); ?>"
                                                   onchange="updateMenuSelection()"
                                                   class="w-5 h-5 text-sangiovese">
                                            <div class="flex-1">
                                                <div class="font-semibold text-olive">
                                                    <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </div>
                                                <?php if (!empty($item['description'])): ?>
                                                    <div class="text-sm text-seagray">
                                                        <?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div id="menu-summary" class="mt-8 p-6 bg-white rounded-lg hidden">
                        <h4 class="font-serif text-xl text-sangiovese mb-2">Ihre Auswahl:</h4>
                        <p class="text-sm text-seagray mb-4">Wir melden uns mit einem individuellen Vorschlag zurück.</p>
                        <ul id="selected-items-list" class="space-y-2 mb-6"></ul>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button"
                                    class="flex-1 bg-sangiovese text-cream px-8 py-4 rounded-lg hover:bg-sangiovese/90 transition-all text-lg"
                                    onclick="proceedToInquiry()">
                                Anfrage senden
                            </button>
                            <button type="button"
                                    class="flex-1 bg-white text-olive border border-terracotta px-8 py-4 rounded-lg hover:bg-verona transition-all text-lg flex items-center justify-center gap-2"
                                    onclick="whatsappCustomMenu()">
                                <?php echo whatsapp_icon('h-5 w-5'); ?>
                                <span>WhatsApp</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
<script src="assets/js/menu-builder.js"></script>
</body>
</html>
