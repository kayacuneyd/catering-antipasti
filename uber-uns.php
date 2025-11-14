<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="de" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Über Catering Antipasti | Hasan Geray</title>
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
<body class="font-sans text-olive bg-verona">
<?php include __DIR__ . '/includes/header.php'; ?>

<main>
    <?php
    render_page_hero([
        'eyebrow' => 'Team & Story',
        'title' => 'Über uns',
        'description' => 'Seit über 25 Jahren bringen wir die Aromen Italiens nach Baden-Württemberg – immer mit Fokus auf Qualität, Persönlichkeit und einem klaren Verständnis für Markenauftritte.',
        'container_classes' => 'container mx-auto px-4 max-w-4xl',
    ]);
    ?>
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="prose prose-lg mx-auto text-seagray">
                <p class="text-xl leading-relaxed">
                    Seit über 25 Jahren bringe ich die Aromen Italiens nach Baden-Württemberg.
                    Meine Reise begann in den Küchen von Olio und Pane e Vino, führte mich
                    durch die historische Weinhalle 1896 und mündet heute in Catering Antipasti.
                </p>

                <h2 class="font-serif text-3xl text-sangiovese mt-8 mb-4">
                    Unsere Philosophie
                </h2>
                <p class="leading-relaxed">
                    Antipasti sind mehr als Vorspeisen – sie sind der Beginn einer Convivialità,
                    des gemeinsamen Genießens. Jedes Event ist für mich eine Leinwand, auf der ich
                    Geschmack, Tradition und Gastfreundschaft male.
                </p>

                <h2 class="font-serif text-3xl text-sangiovese mt-8 mb-4">
                    Unser Versprechen
                </h2>
                <ul class="space-y-3">
                    <li>✓ Authentische italienische Rezepte mit regionalen Zutaten</li>
                    <li>✓ Persönlicher Service vom Chef höchstpersönlich</li>
                    <li>✓ Flexible Menüs für 20 bis 1000 Gäste</li>
                    <li>✓ 48-Stunden-Angebot-Garantie</li>
                </ul>

                <div class="mt-10">
                    <button type="button"
                            class="bg-sangiovese text-cream px-6 py-3 rounded-lg hover:bg-sangiovese/90 transition-all inline-flex items-center gap-2"
                            onclick="whatsappInquiry({ subject: 'Info zu Catering Antipasti' })">
                        <?php echo whatsapp_icon('h-5 w-5'); ?>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
</body>
</html>
