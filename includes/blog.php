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
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1600&q=80',
                'image_alt' => 'Winterliche Antipasti Auswahl auf rustikalem Holztisch',
                'content' => [
                    'Winter bedeutet Komfortküche und aromatische Zutaten. Wir kombinieren geschmorte Artischocken, geröstete Paprika und eingelegte Pilze mit cremigen Dips, um Buffets zu schaffen, die optisch und geschmacklich Wärme spenden.',
                    'Ein wichtiger Faktor sind Texturen: knusprige Crostini, seidige Ricotta-Cremes und knackige Pickles sorgen für Spannung. Für Business-Events empfehlen wir Stationen, an denen sich Gäste ihr Lieblingssetup zusammenstellen können.',
                    'Begleitet wird das Ganze von würzigen Kräuterölen und hausgemachten Agrumi-Sirups, die wir auch als Basis für alkoholfreie Aperitifs servieren.',
                ],
                'tags' => ['Saisonale Küche', 'Business Events', 'Antipasti'],
                'status' => 'published',
            ],
            [
                'slug' => 'nachhaltige-eventplanung',
                'title' => 'Nachhaltige Eventplanung – unsere Checkliste',
                'date' => '2023-11-28',
                'category' => 'Planung',
                'excerpt' => 'Von Lieferketten bis zur Resteküche: So planen wir ressourcenschonende Caterings.',
                'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=1600&q=80',
                'image_alt' => 'Team plant nachhaltiges Event mit Moodboard',
                'content' => [
                    'Wir beginnen jedes Projekt mit einer Transparenzrunde: Welche Produkte kommen regional, wo setzen wir auf Bioqualität und wie reduzieren wir Transportwege?',
                    'Dank enger Produzentenpartnerschaften können wir Menüs auf verfügbare Ernten abstimmen. Übrig gebliebene Komponenten werden weiterverarbeitet – etwa zu Fonds oder Antipasti im Glas.',
                    'Auch beim Equipment achten wir auf Nachhaltigkeit: wiederverwendbare Servicematerialien, Mehrwegverpackungen und klimaneutrale Logistikpartner gehören zu unserem Standard.',
                ],
                'tags' => ['Nachhaltigkeit', 'Logistik', 'Catering'],
                'status' => 'published',
            ],
            [
                'slug' => 'hochzeit-kornwestheim-best-practices',
                'title' => 'Best Practices aus einer Hochzeit in Kornwestheim',
                'date' => '2023-09-05',
                'category' => 'Case Study',
                'excerpt' => 'Ein Blick hinter die Kulissen: 140 Gäste, mediterranes Flying Buffet und Live-Cooking.',
                'image' => 'https://images.unsplash.com/photo-1478145046317-39f10e56b5e9?auto=format&fit=crop&w=1600&q=80',
                'image_alt' => 'Hochzeitstafel mit mediterranen Speisen',
                'content' => [
                    'Das Brautpaar wünschte sich ein lockeres Setup ohne starres Sitzmenü. Wir entwickelten ein Flying Buffet mit saisonalen Antipasti, kleinen Pastagängen und Dessertinseln.',
                    'Highlight war die offene Pasta-Manufaktur mit einer Station für glutenfreie Varianten. Ein dediziertes Service-Team kümmerte sich um Foodstorytelling und Weinempfehlungen.',
                    'Fazit: Durch eine klare Dramaturgie der Gänge und abgestimmte Serviceabläufe blieb der Abend leicht, aber äußerst hochwertig.',
                ],
                'tags' => ['Hochzeit', 'Flying Buffet', 'Live Cooking'],
                'status' => 'published',
            ],
        ],
        'en' => [
            [
                'slug' => 'seasonal-antipasti-trends',
                'title' => 'Seasonal antipasti trends for winter receptions',
                'date' => '2024-01-12',
                'category' => 'Concepts',
                'excerpt' => 'How we build warming antipasti bars with regional produce and Italian flair.',
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1600&q=80',
                'image_alt' => 'Winter antipasti spread on rustic table',
                'content' => [
                    'Winter calls for comforting flavors. We combine braised artichokes, roasted peppers and pickled mushrooms with creamy dips to create spreads that feel indulgent yet light.',
                    'Texture drives the experience: crisp crostini, silky ricotta creams and quick-pickled vegetables keep every bite exciting. For corporate events we like modular stations so guests build their own plates.',
                    'Infused herb oils and homemade citrus syrups tie everything together and double as the base for zero-proof aperitifs.',
                ],
                'tags' => ['Seasonal cooking', 'Corporate', 'Antipasti'],
                'status' => 'published',
            ],
            [
                'slug' => 'sustainable-event-playbook',
                'title' => 'Our sustainable catering playbook',
                'date' => '2023-11-28',
                'category' => 'Planning',
                'excerpt' => 'From sourcing to logistics – the checklist we use to keep events resource-friendly.',
                'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=1600&q=80',
                'image_alt' => 'Sustainable event planning workshop',
                'content' => [
                    'Every project starts with transparency: which ingredients are sourced locally, where do we rely on organic suppliers and how do we minimize transport miles?',
                    'Because we work closely with producers we can align menus with actual harvests. Any leftovers are preserved or reworked into stocks and antipasti jars.',
                    'Equipment matters as well. Reusable service ware, multi-use packaging and climate-neutral logistics partners are part of our standard toolkit.',
                ],
                'tags' => ['Sustainability', 'Operations', 'Catering'],
                'status' => 'published',
            ],
            [
                'slug' => 'wedding-best-practices-kornwestheim',
                'title' => 'Wedding best practices from Kornwestheim',
                'date' => '2023-09-05',
                'category' => 'Case study',
                'excerpt' => '140 guests, a Mediterranean flying buffet and plenty of live cooking.',
                'image' => 'https://images.unsplash.com/photo-1478145046317-39f10e56b5e9?auto=format&fit=crop&w=1600&q=80',
                'image_alt' => 'Wedding reception buffet with antipasti',
                'content' => [
                    'The couple wanted a relaxed format without a seated dinner. We curated a flying buffet with seasonal antipasti, mini pasta courses and dessert stations.',
                    'A live pasta atelier produced gluten-free options on demand. A dedicated storytelling team guided guests through wine pairings and dish origins.',
                    'By staging the evening in thematic waves we kept the experience light, conversational and unmistakably premium.',
                ],
                'tags' => ['Weddings', 'Flying buffet', 'Live cooking'],
                'status' => 'published',
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

    $posts = array_filter($posts, function ($post) {
        return ($post['status'] ?? 'published') === 'published';
    });

    usort($posts, function (array $a, array $b) {
        return strcmp($b['date'], $a['date']);
    });

    return array_values($posts);
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
