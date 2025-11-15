<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="de" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt | Catering Antipasti</title>
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
</head>
<body class="font-sans text-olive bg-verona min-h-screen">
<?php include __DIR__ . '/includes/header.php'; ?>

<main>
    <?php ob_start(); ?>
    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-8">
        <button type="button"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-5 py-3 text-white font-semibold hover:bg-white/20 transition-all"
                onclick="whatsappInquiry({ subject: 'Kontaktanfrage', details: 'Bitte melden Sie sich zurück.' })">
            <?php echo whatsapp_icon('h-5 w-5'); ?>
            <span>Direkt per WhatsApp</span>
        </button>
    </div>
    <?php $contact_hero_body = ob_get_clean(); ?>
    <?php
    render_page_hero([
        'eyebrow' => 'Kontakt',
        'title' => 'Direkt bei Hasan Geray anfragen',
        'description' => 'Wir melden uns innerhalb von 48 Stunden bei Ihnen mit einer individuellen Empfehlung.',
        'body' => $contact_hero_body,
        'container_classes' => 'container mx-auto px-4 max-w-5xl',
        'description_classes' => 'text-cream/90 text-lg',
    ]);
    ?>

    <section class="py-16 bg-verona/40">
        <div class="container mx-auto px-4 max-w-3xl">
            <form id="contact-form" class="bg-white p-8 rounded-lg shadow-lg">
                <?php if (isset($_GET['menu'])): ?>
                    <div class="mb-6 p-4 bg-verona rounded-lg">
                        <p class="text-sm text-seagray mb-2">Ausgewähltes Menü:</p>
                        <p class="font-semibold text-olive"><?php echo htmlspecialchars($_GET['menu'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <input type="hidden" name="selected_menu" value="<?php echo htmlspecialchars($_GET['menu'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                <?php endif; ?>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-olive mb-2">Name *</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 border border-seagray rounded-lg focus:outline-none focus:border-sangiovese">
                    </div>
                    <div>
                        <label class="block text-olive mb-2">E-Mail *</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-3 border border-seagray rounded-lg focus:outline-none focus:border-sangiovese">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-olive mb-2">Telefon</label>
                        <input type="tel" name="phone"
                               class="w-full px-4 py-3 border border-seagray rounded-lg focus:outline-none focus:border-sangiovese">
                    </div>
                    <div>
                        <label class="block text-olive mb-2">Veranstaltungsdatum</label>
                        <input type="date" name="event_date"
                               class="w-full px-4 py-3 border border-seagray rounded-lg focus:outline-none focus:border-sangiovese">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-olive mb-2">Art der Veranstaltung *</label>
                    <select name="event_type" required
                            class="w-full px-4 py-3 border border-seagray rounded-lg focus:outline-none focus:border-sangiovese">
                        <option value="">Bitte wählen</option>
                        <option value="business">Business Catering</option>
                        <option value="wedding">Hochzeit</option>
                        <option value="private">Private Feier</option>
                        <option value="wine">Weinverkostung</option>
                        <option value="other">Sonstiges</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-olive mb-2">Anzahl der Gäste</label>
                    <input type="number" name="guest_count" min="10"
                           class="w-full px-4 py-3 border border-seagray rounded-lg focus:outline-none focus:border-sangiovese">
                </div>

                <div class="mb-6">
                    <label class="block text-olive mb-2">Ihre Nachricht *</label>
                    <textarea name="message" rows="6" required
                              class="w-full px-4 py-3 border border-seagray rounded-lg focus:outline-none focus:border-sangiovese"></textarea>
                </div>

                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="custom_menu_items" id="custom-menu-items">

                <div class="mb-6">
                    <label class="flex items-start gap-3">
                        <input type="checkbox" name="privacy" required class="mt-1">
                        <span class="text-sm text-seagray">
                            Ich habe die <a href="datenschutz.php" class="text-sangiovese underline">Datenschutzerklärung</a>
                            gelesen und stimme der Verarbeitung meiner Daten zu.
                        </span>
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                            class="flex-1 bg-sangiovese text-cream py-4 rounded-lg text-lg hover:bg-sangiovese/90 transition-all">
                        Anfrage senden
                    </button>
                    <button type="button"
                            class="flex-1 bg-white text-olive border border-terracotta py-4 rounded-lg text-lg hover:bg-verona transition-all inline-flex items-center justify-center gap-2"
                            onclick="sendWhatsappFromForm()">
                        <?php echo whatsapp_icon('h-5 w-5'); ?>
                        <span>WhatsApp</span>
                    </button>
                </div>

                <div id="form-response" class="mt-6 hidden"></div>
            </form>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
<script>
function serializeFormToWhatsapp() {
    var form = document.getElementById('contact-form');
    if (!form) {
        return null;
    }
    var data = new FormData(form);
    var parts = [];
    if (data.get('name')) parts.push('Name: ' + data.get('name'));
    if (data.get('email')) parts.push('E-Mail: ' + data.get('email'));
    if (data.get('phone')) parts.push('Telefon: ' + data.get('phone'));
    if (data.get('event_date')) parts.push('Datum: ' + data.get('event_date'));
    if (data.get('event_type')) parts.push('Event: ' + data.get('event_type'));
    if (data.get('guest_count')) parts.push('Gäste: ' + data.get('guest_count'));
    if (data.get('selected_menu')) parts.push('Menü: ' + data.get('selected_menu'));
    if (data.get('custom_menu_items')) parts.push('Individuelle Auswahl:\n' + data.get('custom_menu_items'));
    if (data.get('message')) parts.push('\nNachricht:\n' + data.get('message'));
    return parts.join('\n');
}

function sendWhatsappFromForm() {
    var summary = serializeFormToWhatsapp();
    if (typeof whatsappInquiry === 'function') {
        whatsappInquiry({
            subject: 'Kontaktformular',
            details: summary || ''
        });
    }
}

document.getElementById('contact-form').addEventListener('submit', async function (event) {
    event.preventDefault();
    var form = this;
    var formData = new FormData(form);
    var submitBtn = form.querySelector('button[type="submit"]');
    var responseDiv = document.getElementById('form-response');

    submitBtn.disabled = true;
    submitBtn.textContent = 'Wird gesendet...';

    try {
        var response = await fetch('api/send-email.php', {
            method: 'POST',
            body: formData
        });
        var result = await response.json();
        responseDiv.classList.remove('hidden');
        if (result.success) {
            responseDiv.className = 'mt-6 p-4 bg-green-100 text-green-800 rounded-lg';
            responseDiv.textContent = result.message;
            form.reset();
            sessionStorage.removeItem('customMenu');
        } else {
            responseDiv.className = 'mt-6 p-4 bg-red-100 text-red-800 rounded-lg';
            responseDiv.textContent = result.message;
        }
    } catch (error) {
        responseDiv.classList.remove('hidden');
        responseDiv.className = 'mt-6 p-4 bg-red-100 text-red-800 rounded-lg';
        responseDiv.textContent = 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.';
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Anfrage senden';
    }
});
</script>
</body>
</html>
