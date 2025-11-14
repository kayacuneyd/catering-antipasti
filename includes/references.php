<?php
require_once __DIR__ . '/config.php';

function get_default_references_data(): array
{
    return [
        'de' => [
            'highlights' => [
                ['label' => 'Events pro Jahr', 'value' => '120+'],
                ['label' => 'Durchschnittliche Gäste', 'value' => '80-400'],
                ['label' => 'Weiterempfehlung', 'value' => '98%'],
            ],
            'testimonials' => [
                [
                    'title' => 'Firmenjubiläum in Stuttgart',
                    'client' => 'Bosch Engineering',
                    'quote' => 'Das Team hat unser 25-jähriges Jubiläum kulinarisch kuratiert – von Walk-&-Talk Fingerfood bis zur Weinbar.',
                    'details' => [
                        '320 Gäste, hybrides Event',
                        'Fünf Live-Cooking-Stationen',
                        'Zero-Waste-Konzept mit Foodsharing',
                    ],
                    'services' => ['Business Catering', 'Eventdramaturgie', 'Weinbegleitung'],
                ],
                [
                    'title' => 'Sommerhochzeit in Kornwestheim',
                    'client' => 'Laura & Milan',
                    'quote' => 'Die italienisch-schwäbische Mischung hat perfekt zu uns gepasst. Besonders die offene Aperitivo-Bar war ein Highlight.',
                    'details' => [
                        '140 Gäste, Outdoor Setup',
                        'Flying Buffet & Dessertinseln',
                        'Personalisiertes Menübooklet',
                    ],
                    'services' => ['Hochzeiten', 'Aperitivo', 'Live Cooking'],
                ],
                [
                    'title' => 'Produktlaunch in Tübingen',
                    'client' => 'Design Tech GmbH',
                    'quote' => 'Innerhalb von vier Wochen stand ein komplett gebrandetes Catering inklusive veganer Auswahl.',
                    'details' => [
                        '180 Fachgäste',
                        'Branding auf Porzellan & Buffet',
                        'Veganes Signature-Menü',
                    ],
                    'services' => ['Produktlaunch', 'Branding', 'Vegan'],
                ],
            ],
        ],
        'en' => [
            'highlights' => [
                ['label' => 'Events / year', 'value' => '120+'],
                ['label' => 'Guest range', 'value' => '80-400'],
                ['label' => 'Referral rate', 'value' => '98%'],
            ],
            'testimonials' => [
                [
                    'title' => 'Corporate anniversary in Stuttgart',
                    'client' => 'Bosch Engineering',
                    'quote' => 'The team curated our 25th anniversary from walk-and-talk finger food to a sommelier-led wine bar.',
                    'details' => [
                        '320 guests, hybrid format',
                        'Five live cooking stations',
                        'Zero-waste inspired food sharing',
                    ],
                    'services' => ['Corporate catering', 'Event dramaturgy', 'Wine pairing'],
                ],
                [
                    'title' => 'Summer wedding in Kornwestheim',
                    'client' => 'Laura & Milan',
                    'quote' => 'The Italian-Swabian mix fit us perfectly. The open aperitivo bar was the talk of the night.',
                    'details' => [
                        '140 guests, outdoor setup',
                        'Flying buffet & dessert islands',
                        'Personalised menu booklet',
                    ],
                    'services' => ['Weddings', 'Aperitivo', 'Live cooking'],
                ],
                [
                    'title' => 'Product launch in Tübingen',
                    'client' => 'Design Tech GmbH',
                    'quote' => 'Within four weeks we had a fully branded catering concept with elevated vegan options.',
                    'details' => [
                        '180 invited professionals',
                        'Custom branding across porcelain & buffets',
                        'Vegan signature tasting',
                    ],
                    'services' => ['Product launch', 'Branding', 'Vegan'],
                ],
            ],
        ],
    ];
}

function load_references_data(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $path = dirname(__DIR__) . '/data/references.json';
    $cache = [];

    if (is_readable($path)) {
        $json = file_get_contents($path);
        $decoded = json_decode($json, true);
        if (is_array($decoded)) {
            $cache = $decoded;
        }
    }

    if (!$cache) {
        $cache = get_default_references_data();
    }

    return $cache;
}

function references_content(?string $locale = null): array
{
    if ($locale === null) {
        global $lang;
        $locale = $lang ?? 'de';
    }

    $data = load_references_data();
    return $data[$locale] ?? ['highlights' => [], 'testimonials' => []];
}
