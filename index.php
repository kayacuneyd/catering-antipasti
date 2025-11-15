<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="de" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Antipasti Tübingen | Italienisches Catering Stuttgart</title>
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
    <section class="relative flex h-screen items-center justify-center bg-cover bg-center backdrop-blur-sm"
             style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/images/hero-bg.jpg');">
        <div class="max-w-4xl px-4 text-center text-white">
            <h1 class="font-serif text-5xl md:text-7xl mb-6 leading-tight">
                Italienische Eleganz,<br>schwäbische Herzlichkeit
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-verona">
                25+ Jahre Catering-Erfahrung in Tübingen & Stuttgart
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">

                <a href="kontakt.php"
                   class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white border-2 border-white px-8 py-4 rounded-lg text-lg transition-all">
                    Anfrage stellen
                </a>
                <button type="button"
                        class="bg-white text-olive px-8 py-4 rounded-lg text-lg transition-all hover:bg-verona inline-flex items-center justify-center gap-2"
                        onclick="whatsappInquiry({ subject: 'Allgemeine Catering-Anfrage' })">
                    <?php echo whatsapp_icon('h-5 w-5'); ?>
                    <span>WhatsApp</span>
                </button>
            </div>
        </div>
    </section>

    <section class="py-20 bg-verona text-center">
        <div class="container mx-auto px-4 max-w-5xl ready-highlight__content">
            <div class="mb-10 inline-flex items-center gap-3 bg-white/10 px-6 py-2 rounded-full text-sm ready-badge">
                <span class="w-2 h-2 rounded-full bg-terracotta animate-ping"></span>
                <span class="border border-solid border-vineyard px-4 py-2 rounded-lg">48-Stunden-Angebot & persönliche Betreuung</span>
            </div>
            <h2 class="font-serif text-4xl mb-4">
                Bereit für Ihr nächstes Event?
            </h2>
            <div class="mx-auto mb-8 h-1 w-24 rounded-full bg-terracotta/80"></div>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Ob Sie ein C-Level-Offsite, eine Hochzeit oder einen Markenlaunch planen: Wir orchestrieren Küche,
                Service und Ablauf dramaturgisch durchdacht und verankern Ihre Botschaften im gesamten Erlebnis.
                Kontaktieren Sie uns für ein unverbindliches Angebot – wir liefern Ideen, Ablaufpläne und Budget in einem Dokument.
            </p>
            <div class="text-xl mb-8 max-w-2xl mx-auto">
                Unser Team begleitet Sie von der ersten Idee über Moodboards und Menüproben bis zum letzten Espresso
                am Eventtag – mit klaren Timings und persönlicher Betreuung von Hasan Geray.
            </div>
            <div class="flex flex-wrap gap-6 justify-center mb-10">
                <div class="ready-stat">
                    <span class="text-4xl font-serif">25+</span>
                    <span>Jahre Erfahrung</span>
                </div>
                <div class="ready-stat">
                    <span class="text-4xl font-serif">120</span>
                    <span>Events jährlich</span>
                </div>
                <div class="ready-stat">
                    <span class="text-4xl font-serif">98%</span>
                    <span>Weiterempfehlung</span>
                </div>
            </div>
            
        </div>
    </section>

    <section class="py-20 bg-verona">
        <div class="container mx-auto px-4 max-w-5xl">
            <h2 class="font-serif text-4xl text-center text-olive mb-12">
                Unsere Leistungen
            </h2>
            <p class="text-xl text-center text-seagray max-w-3xl mx-auto mb-12">
                Modulare Leistungspakete – von Strategie und Ablaufregie bis zur Umsetzung vor Ort.
            </p>
            <?php
            $services = [
                [
                    'title' => 'Business Catering',
                    'text' => 'Workshops, Offsites und Führungskräftedialoge mit klarer Dramaturgie.',
                    'bullets' => ['Brandgerechte Buffetgestaltung', 'On-site Küchencrew'],
                    'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Hochzeiten & Feiern',
                    'text' => 'Mehrgängige Menüs, Flying Buffet und Aperitivo-Bar für besondere Momente.',
                    'bullets' => ['Signature Aperitivo-Station', 'Dessertinseln & Live-Cooking'],
                    'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Weinverkostungen',
                    'text' => 'Geführte Tastings mit Sommelier-Begleitung und abgestimmten Antipasti.',
                    'bullets' => ['Handverlesene Winzer', 'Sensorische Moderation'],
                    'image' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Produktlaunches',
                    'text' => 'Inszenierte Food-Storys inklusive Branding, Technik und Projektsteuerung.',
                    'bullets' => ['CI-konforme Displays', 'Storytelling & Scripts'],
                    'image' => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Private Dining',
                    'text' => 'Chef’s Table-Erlebnisse und intime Jubiläen im kleinen Kreis.',
                    'bullets' => ['Live vor Ort gekocht', 'Menu Cards & Floristikpartner'],
                    'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Beratung & Logistik',
                    'text' => 'Planung, Mietmöbel und Timings – wir denken den Ablauf ganzheitlich.',
                    'bullets' => ['360° Projektsteuerung', 'Netzwerk aus Eventpartnern'],
                    'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&q=80',
                ],
            ];
            ?>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 max-w-5xl mx-auto">
                <?php foreach ($services as $service): ?>
                    <div class="service-card rounded-2xl shadow-lg min-h-[320px]">
                        <div class="service-card__background" style="background-image: url('<?php echo htmlspecialchars($service['image'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
                        <div class="service-card__overlay"></div>
                        <div class="service-card__content p-8 flex flex-col gap-4">
                            <h3 class="font-serif text-2xl text-white mb-1">
                                <?php echo htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                            <p class="text-xl text-white/80">
                                <?php echo htmlspecialchars($service['text'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            <ul class="text-sm text-white/90 space-y-1">
                                <?php foreach ($service['bullets'] as $bullet): ?>
                                    <li>• <?php echo htmlspecialchars($bullet, ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
</body>
</html>
