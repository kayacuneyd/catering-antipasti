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
        'container_classes' => 'container mx-auto px-4 max-w-5xl',
    ]);
    ?>
    <section class="py-16 bg-verona/40">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid gap-12 lg:grid-cols-[1.4fr_1fr] items-center">
                <div class="prose prose-lg text-seagray max-w-none">
                    <p class="text-xl leading-relaxed">
                        Was 1997 als kleines Pop-up mit Oliven, eingelegtem Gemüse und frischem Focaccia begann,
                        entwickelte sich Schritt für Schritt zu einer vollwertigen Catering-Manufaktur.
                        Stationen wie Olio, Pane e Vino oder die Weinhalle 1896 in Stuttgart haben nicht nur
                        unser Handwerk geformt, sondern auch unser Verständnis für Gastlichkeit, Markenauftritte und verlässliche Abläufe.
                    </p>
                    <p>
                        Heute begleiten wir Unternehmen bei Produkteinführungen, Hochzeiten in den Weinbergen rund um Tübingen
                        oder private Geburtstage in der Scheune nebenan. Unser Team arbeitet bewusst klein – so bleiben Entscheidungen
                        schnell, Zutaten frisch eingekauft und jede Tafel persönlich betreut.
                    </p>

                    <h2 class="font-serif text-3xl text-sangiovese mt-10 mb-4">Unsere Philosophie</h2>
                    <p>
                        Antipasti sind für uns das Versprechen eines geselligen Abends. Deshalb entstehen alle Kompositionen in unserer
                        eigenen Cucina, mit viel Handarbeit und einer klaren Haltung: lieber weniger Zutaten, dafür beste Qualität vom Markt
                        in Reutlingen oder direkt aus Apulien.
                    </p>

                    <div class="grid gap-4 md:grid-cols-2 mt-10">
                        <div class="rounded-2xl bg-white/80 p-6 shadow-sm">
                            <p class="text-sm uppercase tracking-[0.3em] text-olive/80 mb-2">Handwerk</p>
                            <p class="text-base leading-relaxed">Jede Focaccia und jede eingelegte Artischocke entsteht in unserer Küche – ohne Convenience-Produkte.</p>
                        </div>
                        <div class="rounded-2xl bg-white/80 p-6 shadow-sm">
                            <p class="text-sm uppercase tracking-[0.3em] text-olive/80 mb-2">Service</p>
                            <p class="text-base leading-relaxed">Chef Hasan ist bei jedem Event vor Ort, koordiniert den Ablauf und begrüßt Gäste persönlich.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="rounded-3xl overflow-hidden shadow-2xl ring-1 ring-verona/40">
                        <img src="assets/images/hero-bg.jpg" alt="Hasan Geray bereitet Antipasti vor"
                             class="w-full h-96 object-cover object-center">
                    </div>
                    <div class="rounded-2xl bg-white/90 p-6 shadow-lg">
                        <p class="text-sm text-seagray uppercase tracking-[0.4em] mb-2">Zahlen</p>
                        <p class="text-3xl font-serif text-sangiovese">1.200+</p>
                        <p class="text-seagray">Events seit der Gründung – von Boutique-Events bis zu 1.000 Gästen.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <p class="uppercase tracking-[0.4em] text-xs text-seagray">Timeline</p>
                <h2 class="font-serif text-4xl text-olive mt-3 mb-4">Stationen, die uns geprägt haben</h2>
                <p class="text-seagray">Jedes Kapitel brachte neue Rezepte, Lieferanten und Lieblingskunden – hier ein kurzer Blick hinter die Kulissen.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <article class="rounded-3xl border border-verona/60 bg-verona/30 p-6 shadow-sm">
                    <p class="text-sm text-seagray uppercase tracking-[0.4em]">1997</p>
                    <h3 class="font-serif text-2xl text-sangiovese mt-2 mb-3">Olio & Pane e Vino</h3>
                    <p class="text-seagray">Erste Pop-up-Tastings, Aufbau eines Liefernetzwerks in Italien und Deutschland.</p>
                </article>
                <article class="rounded-3xl border border-verona/60 bg-verona/30 p-6 shadow-sm">
                    <p class="text-sm text-seagray uppercase tracking-[0.4em]">2008</p>
                    <h3 class="font-serif text-2xl text-sangiovese mt-2 mb-3">Weinhalle 1896</h3>
                    <p class="text-seagray">Veranstaltungen mit bis zu 600 Gästen, Fokus auf Marken-Launches und Private Dining.</p>
                </article>
                <article class="rounded-3xl border border-verona/60 bg-verona/30 p-6 shadow-sm">
                    <p class="text-sm text-seagray uppercase tracking-[0.4em]">Heute</p>
                    <h3 class="font-serif text-2xl text-sangiovese mt-2 mb-3">Catering Antipasti</h3>
                    <p class="text-seagray">Mobiles Team zwischen Stuttgart, Tübingen und Schwarzwald – immer mit persönlichem Gastgeber.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="py-16 bg-verona/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid gap-10 md:grid-cols-2">
                <div class="space-y-6">
                    <div class="rounded-3xl overflow-hidden h-72 shadow-xl">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80"
                             alt="Italienische Antipasti am Tisch" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-3xl overflow-hidden h-72 shadow-xl">
                        <img src="assets/images/team-event.jpg"
                             alt="Team bei einer Veranstaltung" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="prose prose-lg text-seagray max-w-none">
                    <h2 class="font-serif text-3xl text-olive">Menschen hinter dem Buffet</h2>
                    <p>
                        Unsere Crew besteht aus Köch:innen, Event-Spezialist:innen und Servicepersonal, das seit Jahren eingespielt ist.
                        Wir sprechen Deutsch, Englisch und Türkisch – und verstehen vor allem die Sprache von Marken, die etwas Besonderes inszenieren möchten.
                    </p>
                    <ul class="space-y-3 list-none">
                        <li>Kuratiertes Team zwischen 6 und 12 Personen je nach Eventgröße</li>
                        <li>Eigne Ausstattung: Buffets, mobile Küchen, saisonale Dekoration</li>
                        <li>Nachhaltige Planung mit regionalen Lieferketten und wenig Food Waste</li>
                    </ul>

                    <div class="mt-10">
                        <button type="button"
                                class="bg-sangiovese text-cream px-6 py-3 rounded-lg hover:bg-sangiovese/90 transition-all inline-flex items-center gap-2"
                                onclick="whatsappInquiry({ subject: 'Team & Angebot' })">
                            <?php echo whatsapp_icon('h-5 w-5'); ?>
                            <span>WhatsApp</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
</body>
</html>
