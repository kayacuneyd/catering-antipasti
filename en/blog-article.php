<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/blog.php';

$slug = $_GET['slug'] ?? '';
$post = blog_post($slug, 'en');

if (!$post) {
    http_response_code(404);
}

$related = array_values(array_filter(blog_posts('en'), function ($item) use ($post) {
    if (!$post) {
        return true;
    }
    return $item['slug'] !== $post['slug'];
}));
?>
<!DOCTYPE html>
<html lang="en" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post ? htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') . ' | Blog' : 'Article not found'; ?> | Catering Antipasti</title>
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
<body class="font-sans text-olive bg-verona min-h-screen">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <section class="py-20 bg-verona/60 text-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <?php if ($post): ?>
                <p class="uppercase tracking-[0.4em] text-xs text-white/70 mb-4">Insights</p>
                <h1 class="font-serif text-5xl mb-4 text-white">
                    <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                </h1>
                <div class="text-white/80 text-sm flex flex-wrap gap-4">
                    <span><?php echo htmlspecialchars(blog_date($post['date'], 'en'), ENT_QUOTES, 'UTF-8'); ?></span>
                    <span>·</span>
                    <span><?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            <?php else: ?>
                <h1 class="font-serif text-4xl mb-4 text-white">Article not found</h1>
                <p class="text-white/80">This post no longer exists. Return to the <a class="text-white underline" href="blog.php">blog overview</a>.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($post): ?>
        <?php if (!empty($post['image'])): ?>
            <section class="bg-white">
                <div class="container mx-auto px-4 max-w-4xl">
                    <div class="overflow-hidden rounded-3xl shadow-lg">
                        <img src="<?php echo htmlspecialchars($post['image'], ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars($post['image_alt'] ?? $post['title'], ENT_QUOTES, 'UTF-8'); ?>"
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="py-16">
            <div class="container mx-auto px-4 max-w-4xl">
                <article class="prose max-w-none text-lg leading-relaxed">
                    <?php foreach ($post['content'] as $paragraph): ?>
                        <p class="mb-6 text-olive/90">
                            <?php echo htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    <?php endforeach; ?>
                </article>

                <?php if (!empty($post['tags'])): ?>
                    <div class="mt-10 flex flex-wrap gap-3">
                        <?php foreach ($post['tags'] as $tag): ?>
                            <span class="bg-verona px-4 py-2 rounded-full text-xs uppercase tracking-wide text-olive/80">
                                <?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-12 rounded-2xl bg-vineyard text-cream p-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="font-serif text-2xl mb-2">Plan an event?</p>
                        <p class="text-sm text-cream/90">We translate ideas into cohesive catering concepts – tell us about yours.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="contact.php" class="bg-white text-olive px-6 py-3 rounded-lg font-semibold">Contact</a>
                        <button type="button" class="bg-transparent border border-white px-6 py-3 rounded-lg inline-flex items-center gap-2" onclick="whatsappInquiry({ subject: '<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>' })">
                            <?php echo whatsapp_icon('h-5 w-5'); ?>
                            <span>WhatsApp</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <?php if (!empty($related)): ?>
            <section class="py-12 bg-verona/40">
                <div class="container mx-auto px-4 max-w-5xl">
                    <h2 class="font-serif text-3xl mb-8">More reads</h2>
                    <div class="grid gap-6 md:grid-cols-2">
                        <?php foreach (array_slice($related, 0, 2) as $item): ?>
                            <article class="bg-white rounded-xl p-6 shadow">
                                <p class="text-xs uppercase tracking-[0.3em] text-sangiovese mb-2">
                                    <?php echo htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                                <h3 class="font-serif text-2xl mb-3">
                                    <?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>
                                </h3>
                                <p class="text-seagray mb-4">
                                    <?php echo htmlspecialchars($item['excerpt'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                                <a href="blog-article.php?slug=<?php echo urlencode($item['slug']); ?>"
                                   class="text-sangiovese font-semibold">Read</a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html>
