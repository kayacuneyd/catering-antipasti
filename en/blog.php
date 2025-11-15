<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/blog.php';

$posts = blog_posts('en');
?>
<!DOCTYPE html>
<html lang="en" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog & Insights | Catering Antipasti</title>
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
    <section class="py-20">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="max-w-3xl mb-12">
                <p class="uppercase tracking-[0.3em] text-xs text-sangiovese mb-4">Insights</p>
                <h1 class="font-serif text-5xl mb-6">Catering stories & strategy</h1>
                <p class="text-lg text-seagray">
                    Project recaps, playbooks from 25+ years in catering and inspiration for your next event.
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2">
                <?php foreach ($posts as $post): ?>
                    <article class="bg-white rounded-2xl shadow-lg p-0 flex flex-col overflow-hidden">
                        <?php if (!empty($post['image'])): ?>
                            <div class="relative aspect-[4/3] w-full overflow-hidden">
                                <img src="<?php echo htmlspecialchars($post['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="<?php echo htmlspecialchars($post['image_alt'] ?? $post['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                     loading="lazy"
                                     class="h-full w-full object-cover">
                            </div>
                        <?php endif; ?>
                        <div class="p-8 flex flex-col flex-1">
                        <div class="flex items-center justify-between text-sm text-seagray mb-4">
                            <span class="uppercase tracking-wide text-xs text-sangiovese">
                                <?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                            <span><?php echo htmlspecialchars(blog_date($post['date'], 'en'), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <h2 class="font-serif text-3xl mb-4">
                            <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </h2>
                        <p class="text-seagray flex-1">
                            <?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <?php if (!empty($post['tags'])): ?>
                            <div class="flex flex-wrap gap-2 mt-6">
                                <?php foreach ($post['tags'] as $tag): ?>
                                    <span class="bg-verona text-olive text-xs uppercase tracking-wide px-3 py-1 rounded-full">
                                        <?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <a href="blog-article.php?slug=<?php echo urlencode($post['slug']); ?>"
                           class="mt-8 inline-flex items-center gap-2 text-sangiovese font-semibold hover:translate-x-1 transition-transform">
                            Read article
                            <span aria-hidden="true">→</span>
                        </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html>
