<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Italian Catering Stuttgart | Catering Antipasti</title>
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
    <section class="relative flex h-screen items-center justify-center bg-cover bg-center"
             style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('../assets/images/hero-bg.jpg');">
        <div class="max-w-4xl px-4 text-center text-white">
            <h1 class="font-serif text-5xl md:text-7xl mb-6 leading-tight">
                Italian Elegance,<br>Swabian Warmth
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-verona">
                25+ years of catering in the Tübingen & Stuttgart region
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="menu.php"
                   class="bg-sangiovese hover:bg-sangiovese/90 text-cream px-8 py-4 rounded-lg text-lg transition-all">
                    View menus
                </a>
                <a href="contact.php"
                   class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white border-2 border-white px-8 py-4 rounded-lg text-lg transition-all">
                    Request a quote
                </a>
                <button type="button"
                        class="bg-white text-olive px-8 py-4 rounded-lg text-lg transition-all hover:bg-verona inline-flex items-center justify-center gap-2"
                        onclick="whatsappInquiry({ subject: 'General catering enquiry' })">
                    <?php echo whatsapp_icon('h-5 w-5'); ?>
                    <span>WhatsApp</span>
                </button>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-3xl text-center text-olive space-y-6">
            <p class="text-lg">
                Whether you host a leadership offsite, wedding or branded launch, we choreograph culinary flow,
                service moments and logistics so every touchpoint reinforces your story.
            </p>
            <p class="text-lg text-seagray">
                From the first briefing through mood boards, tasting sessions and on-site direction, Hasan Geray guides
                you personally with clear timelines and a hands-on team.
            </p>
        </div>
    </section>

    <section class="py-20 bg-verona">
        <div class="container mx-auto px-4 max-w-5xl">
            <h2 class="font-serif text-4xl text-center text-olive mb-12">
                Services
            </h2>
            <p class="text-center text-seagray max-w-3xl mx-auto mb-12">
                Modular service packages – from concept and logistics to on-site execution.
            </p>
            <?php
            $services_en = [
                [
                    'title' => 'Corporate Catering',
                    'text' => 'Workshops, leadership gatherings and conferences with cohesive storytelling.',
                    'bullets' => ['Brand-aligned buffet styling', 'On-site kitchen & captain'],
                    'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Weddings & celebrations',
                    'text' => 'Multi-course menus, flying buffets and aperitivo bars for signature moments.',
                    'bullets' => ['Signature aperitivo station', 'Dessert islands & live cooking'],
                    'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Wine tastings',
                    'text' => 'Sommelier-led tastings paired with curated antipasti flights.',
                    'bullets' => ['Selected winemakers', 'Sensory moderation'],
                    'image' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Product launches',
                    'text' => 'Branded food storytelling including scripting, signage and logistics.',
                    'bullets' => ['On-brand displays', 'Launch playbooks'],
                    'image' => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Private dining',
                    'text' => 'Chef’s Table experiences and intimate anniversaries.',
                    'bullets' => ['Cooked live on site', 'Menu cards & floral partners'],
                    'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'title' => 'Consulting & logistics',
                    'text' => 'Planning, rentals and timelines with one point of contact.',
                    'bullets' => ['360° project management', 'Trusted partner network'],
                    'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&q=80',
                ],
            ];
            ?>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 max-w-5xl mx-auto">
                <?php foreach ($services_en as $service): ?>
                    <div class="service-card rounded-2xl shadow-lg min-h-[320px]">
                        <div class="service-card__background" style="background-image: url('<?php echo htmlspecialchars($service['image'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
                        <div class="service-card__overlay"></div>
                        <div class="service-card__content p-8 flex flex-col gap-4">
                            <h3 class="font-serif text-2xl text-white mb-1">
                                <?php echo htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                            <p class="text-white/80">
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

    <section class="py-20 bg-verona text-white text-center ready-highlight">
        <div class="container mx-auto px-4 max-w-5xl ready-highlight__content">
            <div class="mb-10 inline-flex items-center gap-3 bg-white/10 px-6 py-2 rounded-full text-sm ready-badge">
                <span class="w-2 h-2 rounded-full bg-terracotta animate-ping"></span>
                <span>48-hour proposals & founder-led guidance</span>
            </div>
            <h2 class="font-serif text-4xl mb-6 text-white">
                Ready for your next event?
            </h2>
            <p class="text-xl mb-8 text-white max-w-2xl mx-auto">
                Tell us about your guests and objectives – we share menu ideas, flow and budget in one concise deck.
            </p>
            <div class="flex flex-wrap gap-6 justify-center mb-10">
                <div class="ready-stat">
                    <span class="text-4xl font-serif">25+</span>
                    <span>years of expertise</span>
                </div>
                <div class="ready-stat">
                    <span class="text-4xl font-serif">120</span>
                    <span>events per year</span>
                </div>
                <div class="ready-stat">
                    <span class="text-4xl font-serif">98%</span>
                    <span>referral rate</span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.php"
                   class="inline-block bg-sangiovese hover:bg-sangiovese/90 px-10 py-4 rounded-lg text-lg transition-all text-cream">
                    Contact us
                </a>
                <button type="button"
                        class="inline-flex items-center justify-center gap-2 border-terracotta border-2 bg-white/20 hover:bg-white/30 px-10 py-4 rounded-lg text-lg text-olive transition-all"
                        onclick="whatsappInquiry({ subject: 'Event enquiry', details: 'I would like to receive a quote.' })">
                    <?php echo whatsapp_icon('h-5 w-5'); ?>
                    <span>WhatsApp</span>
                </button>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html>
