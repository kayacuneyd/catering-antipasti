<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/references.php';

$references = references_content();
$highlights = $references['highlights'] ?? [];
$gallery = $references['gallery'] ?? [];
$testimonials = $references['testimonials'] ?? [];
?>
<!DOCTYPE html>
<html lang="de" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referenzen & Projekte | Catering Antipasti</title>
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
        'eyebrow' => 'Referenzen',
        'title' => 'Ausgewählte Projekte & Feedback',
        'description' => 'Vom exklusiven Aperitivo bis zum Großevent: Wir konzipieren Caterings, die Marke und Anlass präzise widerspiegeln.',
    ]);
    ?>

    <section class="py-16 bg-verona/40">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="grid gap-6 md:grid-cols-3">
                <?php foreach ($highlights as $item): ?>
                    <div class="bg-white rounded-2xl p-6 text-center shadow">
                        <p class="text-4xl font-serif text-sangiovese mb-2">
                            <?php echo htmlspecialchars($item['value'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p class="text-seagray uppercase tracking-wide text-xs">
                            <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (!empty($gallery)): ?>
    <section class="py-16 bg-verona/40">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-sangiovese mb-2">Bildstrecke</p>
                    <h2 class="font-serif text-3xl text-olive">Aus Einsätzen & Lieblingsprojekten</h2>
                </div>
                <a href="kontakt.php" class="hidden md:inline-flex items-center gap-2 text-sangiovese font-semibold">
                    Projekt anfragen
                    <span aria-hidden="true">→</span>
                </a>
            </div>
            <div class="grid gap-8 md:grid-cols-2">
                <?php foreach ($gallery as $project): ?>
                    <article class="reference-gallery-card">
                        <div class="reference-gallery-card__media">
                            <img src="<?php echo htmlspecialchars($project['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                 alt="<?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                 loading="lazy">
                        </div>
                        <div class="p-6 space-y-3">
                            <p class="text-xs uppercase tracking-[0.3em] text-sangiovese">
                                <?php echo htmlspecialchars($project['location'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            <h3 class="font-serif text-2xl">
                                <?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                            <p class="text-xl text-seagray">
                                <?php echo htmlspecialchars($project['description'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            <?php if (!empty($project['tags'])): ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($project['tags'] as $tag): ?>
                                        <span class="reference-gallery-card__tag">
                                            <?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="py-16">
        <div class="container mx-auto px-4 max-w-5xl space-y-10">
            <?php foreach ($testimonials as $reference): ?>
                <article class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                    <div class="flex flex-col gap-1 mb-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-sangiovese">Case Study</p>
                        <h2 class="font-serif text-3xl">
                            <?php echo htmlspecialchars($reference['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </h2>
                        <p class="text-xl text-seagray">mit <?php echo htmlspecialchars($reference['client'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <p class="text-xl text-olive/90 italic mb-6">
                        „<?php echo htmlspecialchars($reference['quote'], ENT_QUOTES, 'UTF-8'); ?>“
                    </p>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <p class="text-sm text-seagray uppercase tracking-wide mb-2">Setup</p>
                            <ul class="space-y-2">
                                <?php foreach ($reference['details'] as $detail): ?>
                                    <li class="flex items-start gap-2 text-olive">
                                        <span aria-hidden="true">•</span>
                                        <span><?php echo htmlspecialchars($detail, ENT_QUOTES, 'UTF-8'); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div>
                            <p class="text-sm text-seagray uppercase tracking-wide mb-2">Leistungspakete</p>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($reference['services'] as $service): ?>
                                    <span class="bg-verona px-4 py-2 rounded-full text-xs uppercase tracking-wide text-olive/80">
                                        <?php echo htmlspecialchars($service, ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="py-16 ">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="rounded-3xl text-cream p-10 text-center shadow-xl bg-vineyard">
                <h3 class="font-serif text-3xl mb-4 text-cream">Interesse an einer ähnlichen Umsetzung?</h3>
                <p class="text-xl mb-8">Wir entwickeln Konzepte für Business-Events, Hochzeiten und Launches – on-brand und skalierbar.</p>
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="kontakt.php" class="bg-white text-olive px-8 py-4 rounded-lg font-semibold">Kontakt aufnehmen</a>
                    <button type="button" class="bg-transparent border border-white px-8 py-4 rounded-lg inline-flex items-center gap-2" onclick="whatsappInquiry({ subject: 'Referenzen', details: 'Ich interessiere mich für eine ähnliche Umsetzung.' })">
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
