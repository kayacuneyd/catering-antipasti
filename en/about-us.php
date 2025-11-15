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
            <div class="grid gap-12 lg:grid-cols-[1.4fr_1fr] items-center">
                <div class="prose prose-lg text-seagray max-w-none">
                    <p class="text-xl leading-relaxed">
                        What started in 1997 as a tiny pop-up with olives, grilled vegetables and warm focaccia has grown
                        into a boutique catering studio. Stations such as Olio, Pane e Vino and later the Weinhalle 1896 in Stuttgart
                        shaped how we work today: craftsmanship first, reliable logistics and a team that understands brand experiences.
                    </p>
                    <p>
                        We support product launches, vineyard weddings around Tübingen and private soirées in family homes.
                        The crew intentionally stays compact so that decisions remain quick, produce is bought fresh in the morning
                        and every table feels personally hosted.
                    </p>

                    <h2 class="font-serif text-3xl text-sangiovese mt-10 mb-4">Our philosophy</h2>
                    <p>
                        Antipasti signal the beginning of a convivial evening. Every composition is prepared in our kitchen with
                        slow techniques and a clear belief: fewer ingredients, better quality – from farmers in Baden-Württemberg
                        or directly imported from Apulia.
                    </p>

                    <div class="grid gap-4 md:grid-cols-2 mt-10">
                        <div class="rounded-2xl bg-white/80 p-6 shadow-sm">
                            <p class="text-sm uppercase tracking-[0.3em] text-olive/80 mb-2">Craft</p>
                            <p class="text-base leading-relaxed">Focaccia, pickles and pastes are made in-house – no shortcuts, no convenience products.</p>
                        </div>
                        <div class="rounded-2xl bg-white/80 p-6 shadow-sm">
                            <p class="text-sm uppercase tracking-[0.3em] text-olive/80 mb-2">Service</p>
                            <p class="text-base leading-relaxed">Chef Hasan is present at every event, coordinating timelines and welcoming guests.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="rounded-3xl overflow-hidden shadow-2xl ring-1 ring-verona/40">
                        <img src="../assets/images/hero-bg.jpg" alt="Chef Hasan Geray preparing antipasti"
                             class="w-full h-96 object-cover object-center">
                    </div>
                    <div class="rounded-2xl bg-white/90 p-6 shadow-lg">
                        <p class="text-sm text-seagray uppercase tracking-[0.4em] mb-2">Milestones</p>
                        <p class="text-3xl font-serif text-sangiovese">1,200+</p>
                        <p class="text-seagray">Events hosted since day one – boutique tastings to 1,000-guest productions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <p class="uppercase tracking-[0.4em] text-xs text-sangiovese">Timeline</p>
                <h2 class="font-serif text-4xl text-olive mt-3 mb-4">Moments that shaped our kitchen</h2>
                <p class="text-seagray">Every chapter added new recipes, suppliers and partner agencies – here are three highlights.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <article class="rounded-3xl border text-verona bg-sangiovese/30 p-6 shadow-sm">
                    <p class="text-sm text-seagray uppercase tracking-[0.4em]">1997</p>
                    <h3 class="font-serif text-2xl text-sangiovese mt-2 mb-3">Olio & Pane e Vino</h3>
                    <p class="text-seagray">First pop-up tastings, building a reliable sourcing network between Italy and Germany.</p>
                </article>
                <article class="rounded-3xl border text-verona bg-sangiovese/30 p-6 shadow-sm">
                    <p class="text-sm text-seagray uppercase tracking-[0.4em]">2008</p>
                    <h3 class="font-serif text-2xl text-sangiovese mt-2 mb-3">Weinhalle 1896</h3>
                    <p class="text-seagray">Events for up to 600 guests with a focus on brand launches and curated private dining.</p>
                </article>
                <article class="rounded-3xl border text-verona bg-sangiovese/30 p-6 shadow-sm">
                    <p class="text-sm text-seagray uppercase tracking-[0.4em]">Today</p>
                    <h3 class="font-serif text-2xl text-sangiovese mt-2 mb-3">Catering Antipasti</h3>
                    <p class="text-seagray">A mobile crew covering Stuttgart, Tübingen and the Black Forest – always with a personal host.</p>
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
                             alt="Italian antipasti on a table" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-3xl overflow-hidden h-72 shadow-xl">
                        <img src="../assets/images/team-event.jpg"
                             alt="Team at an event" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="prose prose-lg text-seagray max-w-none">
                    <h2 class="font-serif text-3xl text-olive">People behind the buffet</h2>
                    <p>
                        Our crew combines chefs, event specialists and service staff that have worked together for years.
                        We speak German, English and Turkish – but most importantly, we understand what brands and private hosts expect.
                    </p>
                    <ul class="space-y-3 list-none">
                        <li>Curated team of 6–12 people depending on event size</li>
                        <li>Own buffet furniture, mobile kitchen modules and seasonal styling</li>
                        <li>Sustainable planning with regional supply chains and minimal food waste</li>
                    </ul>

                    <div class="mt-10">
                        <button type="button"
                                class="bg-sangiovese text-cream px-6 py-3 rounded-lg hover:bg-sangiovese/90 transition-all inline-flex items-center gap-2"
                                onclick="whatsappInquiry({ subject: 'About our team' })">
                            <?php echo whatsapp_icon('h-5 w-5'); ?>
                            <span>WhatsApp</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html>
