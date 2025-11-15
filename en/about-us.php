<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Catering Antipasti | Chef Hasan Geray</title>
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
    <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body class="font-sans text-olive bg-verona">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <?php
    render_page_hero([
        'eyebrow' => 'Team & Story',
        'title' => 'About us',
        'description' => 'For more than 25 years we have carried the flavours of Italy through Baden-Württemberg – with a focus on quality, personality and on-brand experiences.',
        'container_classes' => 'container mx-auto px-4 max-w-5xl',
    ]);
    ?>
    <section class="py-16 bg-verona/40">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="prose prose-lg mx-auto text-seagray">
                <p class="text-xl leading-relaxed">
                    For more than 25 years I have been bringing the flavours of Italy to Baden-Württemberg.
                    From Olio and Pane e Vino to the historic Weinhalle 1896, every station shaped the vision behind Catering Antipasti.
                </p>

                <h2 class="font-serif text-3xl text-sangiovese mt-8 mb-4">
                    Our philosophy
                </h2>
                <p class="leading-relaxed">
                    Antipasti are the prelude to conviviality. Each event is a canvas where we pair heritage with modern hospitality
                    to create moments guests remember.
                </p>

                <h2 class="font-serif text-3xl text-sangiovese mt-8 mb-4">
                    What we promise
                </h2>
                <ul class="space-y-3 list-none">
                    <li>Authentic Italian recipes with seasonal produce</li>
                    <li>Personal service from Chef Hasan</li>
                    <li>Flexible menus for 20 to 1000 guests</li>
                    <li>Quote within 48 hours</li>
                </ul>

                <div class="mt-10">
                    <button type="button"
                            class="bg-sangiovese text-cream px-6 py-3 rounded-lg hover:bg-sangiovese/90 transition-all inline-flex items-center gap-2"
                            onclick="whatsappInquiry({ subject: 'About Catering Antipasti' })">
                        <?php echo whatsapp_icon('h-5 w-5'); ?>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html>
