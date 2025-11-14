<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="de" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datenschutzerklärung | Catering Antipasti</title>
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
    <?php
    render_page_hero([
        'eyebrow' => 'Rechtliches',
        'title' => 'Datenschutzerklärung',
        'description' => 'Hier finden Sie alle Informationen zur Verarbeitung Ihrer personenbezogenen Daten, zu Kontaktwegen sowie zu Ihren Rechten.',
        'container_classes' => 'container mx-auto px-4 max-w-4xl',
    ]);
    ?>
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="prose prose-lg mx-auto text-seagray">
                <h2>1. Datenschutz auf einen Blick</h2>
                <p>
                    Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren personenbezogenen Daten passiert,
                    wenn Sie unsere Website besuchen.
                </p>

                <h2>2. Datenerfassung auf unserer Website</h2>
                <p>
                    Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen Kontaktdaten können Sie dem Impressum entnehmen.
                </p>

                <h3>Kontaktformular</h3>
                <p>
                    Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage
                    und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.
                </p>

                <h2>3. Hosting</h2>
                <p>
                    Unsere Website wird bei einem externen Dienstleister gehostet. Die personenbezogenen Daten, die auf unserer Website erfasst werden,
                    werden auf den Servern des Hosters gespeichert.
                </p>

                <h2>4. Ihre Rechte</h2>
                <p>
                    Sie haben jederzeit das Recht unentgeltlich Auskunft über Herkunft, Empfänger und Zweck Ihrer gespeicherten personenbezogenen Daten zu erhalten.
                    Sie haben außerdem ein Recht, die Berichtigung oder Löschung dieser Daten zu verlangen.
                </p>

                <h2>5. WhatsApp</h2>
                <p>
                    Für direkte Anfragen bieten wir einen WhatsApp-Kontakt an. Die Nutzung von WhatsApp erfolgt freiwillig.
                    Bitte übermitteln Sie darüber keine sensiblen Daten. Weitere Informationen zum Datenschutz von WhatsApp finden Sie unter
                    <a href="https://www.whatsapp.com/legal/privacy-policy" target="_blank" rel="noopener">https://www.whatsapp.com/legal/privacy-policy</a>.
                </p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
</body>
</html>
