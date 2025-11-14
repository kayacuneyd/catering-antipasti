<?php
require_once __DIR__ . '/config.php';

function get_default_blog_data(): array
{
    return [
        'de' => [
            [
                'slug' => 'saisonale-antipasti-trends',
                'title' => 'Saisonale Antipasti-Trends für Winterevents',
                'date' => '2024-01-12',
                'category' => 'Eventkonzepte',
                'excerpt' => 'So komponieren wir wärmende Antipasti-Buffets mit regionalen Zutaten und italienischer Eleganz.',
                'content' => [
                    'Winter bedeutet Komfortküche und aromatische Zutaten. Wir kombinieren geschmorte Artischocken, geröstete Paprika und eingelegte Pilze mit cremigen Dips, um Buffets zu schaffen, die optisch und geschmacklich Wärme spenden.',
                    'Ein wichtiger Faktor sind Texturen: knusprige Crostini, seidige Ricotta-Cremes und knackige Pickles sorgen für Spannung. Für Business-Events empfehlen wir Stationen, an denen sich Gäste ihr Lieblingssetup zusammenstellen können.',
                    'Begleitet wird das Ganze von würzigen Kräuterölen und hausgemachten Agrumi-Sirups, die wir auch als Basis für alkoholfreie Aperitifs servieren.',
                ],
                'tags' => ['Saisonale Küche', 'Business Events', 'Antipasti'],
            ],
            [
                'slug' => 'nachhaltige-eventplanung',
                'title' => 'Nachhaltige Eventplanung – unsere Checkliste',
                'date' => '2023-11-28',
                'category' => 'Planung',
                'excerpt' => 'Von Lieferketten bis zur Resteküche: So planen wir ressourcenschonende Caterings.',
                'content' => [
                    'Wir beginnen jedes Projekt mit einer Transparenzrunde: Welche Produkte kommen regional, wo setzen wir auf Bioqualität und wie reduzieren wir Transportwege?',
                    'Dank enger Produzentenpartnerschaften können wir Menüs auf verfügbare Ernten abstimmen. Übrig gebliebene Komponenten werden weiterverarbeitet – etwa zu Fonds oder Antipasti im Glas.',
                    'Auch beim Equipment achten wir auf Nachhaltigkeit: wiederverwendbare Servicematerialien, Mehrwegverpackungen und klimaneutrale Logistikpartner gehören zu unserem Standard.',
                ],
                'tags' => ['Nachhaltigkeit', 'Logistik', 'Catering'],
            ],
            [
                'slug' => 'hochzeit-kornwestheim-best-practices',
                'title' => 'Best Practices aus einer Hochzeit in Kornwestheim',
                'date' => '2023-09-05',
                'category' => 'Case Study',
                'excerpt' => 'Ein Blick hinter die Kulissen: 140 Gäste, mediterranes Flying Buffet und Live-Cooking.',
                'content' => [
                    'Das Brautpaar wünschte sich ein lockeres Setup ohne starres Sitzmenü. Wir entwickelten ein Flying Buffet mit saisonalen Antipasti, kleinen Pastagängen und Dessertinseln.',
                    'Highlight war die offene Pasta-Manufaktur mit einer Station für glutenfreie Varianten. Ein dediziertes Service-Team kümmerte sich um Foodstorytelling und Weinempfehlungen.',
                    'Fazit: Durch eine klare Dramaturgie der Gänge und abgestimmte Serviceabläufe blieb der Abend leicht, aber äußerst hochwertig.',
                ],
                'tags' => ['Hochzeit', 'Flying Buffet', 'Live Cooking'],
            ],
        ],
        'en' => [
            [
                'slug' => 'seasonal-antipasti-trends',
                'title' => 'Seasonal antipasti trends for winter receptions',
                'date' => '2024-01-12',
                'category' => 'Concepts',
                'excerpt' => 'How we build warming antipasti bars with regional produce and Italian flair.',
                'content' => [
                    'Winter calls for comforting flavors. We combine braised artichokes, roasted peppers and pickled mushrooms with creamy dips to create spreads that feel indulgent yet light.',
                    'Texture drives the experience: crisp crostini, silky ricotta creams and quick-pickled vegetables keep every bite exciting. For corporate events we like modular stations so guests build their own plates.',
                    'Infused herb oils and homemade citrus syrups tie everything together and double as the base for zero-proof aperitifs.',
                ],
                'tags' => ['Seasonal cooking', 'Corporate', 'Antipasti'],
            ],
            [
                'slug' => 'sustainable-event-playbook',
                'title' => 'Our sustainable catering playbook',
                'date' => '2023-11-28',
                'category' => 'Planning',
                'excerpt' => 'From sourcing to logistics – the checklist we use to keep events resource-friendly.',
                'content' => [
                    'Every project starts with transparency: which ingredients are sourced locally, where do we rely on organic suppliers and how do we minimize transport miles?',
                    'Because we work closely with producers we can align menus with actual harvests. Any leftovers are preserved or reworked into stocks and antipasti jars.',
                    'Equipment matters as well. Reusable service ware, multi-use packaging and climate-neutral logistics partners are part of our standard toolkit.',
                ],
                'tags' => ['Sustainability', 'Operations', 'Catering'],
            ],
            [
                'slug' => 'wedding-best-practices-kornwestheim',
                'title' => 'Wedding best practices from Kornwestheim',
                'date' => '2023-09-05',
                'category' => 'Case study',
                'excerpt' => '140 guests, a Mediterranean flying buffet and plenty of live cooking.',
                'content' => [
                    'The couple wanted a relaxed format without a seated dinner. We curated a flying buffet with seasonal antipasti, mini pasta courses and dessert stations.',
                    'A live pasta atelier produced gluten-free options on demand. A dedicated storytelling team guided guests through wine pairings and dish origins.',
                    'By staging the evening in thematic waves we kept the experience light, conversational and unmistakably premium.',
                ],
                'tags' => ['Weddings', 'Flying buffet', 'Live cooking'],
            ],
        ],
    ];
}

function load_blog_data(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $path = dirname(__DIR__) . '/data/blog-posts.json';
    $cache = [];

    if (is_readable($path)) {
        $json = file_get_contents($path);
        $decoded = json_decode($json, true);
        if (is_array($decoded)) {
            $cache = $decoded;
        }
    }

    if (!$cache) {
        $cache = get_default_blog_data();
    }

    return $cache;
}

function blog_posts(?string $locale = null): array
{
    if ($locale === null) {
        global $lang;
        $locale = $lang ?? 'de';
    }

    $data = load_blog_data();
    $posts = $data[$locale] ?? [];

    usort($posts, function (array $a, array $b) {
        return strcmp($b['date'], $a['date']);
    });

    return $posts;
}

function blog_post(string $slug, ?string $locale = null): ?array
{
    if ($locale === null) {
        global $lang;
        $locale = $lang ?? 'de';
    }

    $slug = strtolower(preg_replace('/[^a-z0-9\-]/', '', $slug));
    if ($slug === '') {
        return null;
    }

    foreach (blog_posts($locale) as $post) {
        if ($post['slug'] === $slug) {
            return $post;
        }
    }

    return null;
}

function blog_date(string $date, ?string $locale = null): string
{
    if ($locale === null) {
        global $lang;
        $locale = $lang ?? 'de';
    }

    try {
        $dt = new DateTimeImmutable($date);
    } catch (Exception $e) {
        return $date;
    }

    return $locale === 'de'
        ? $dt->format('d.m.Y')
        : $dt->format('M j, Y');
}
