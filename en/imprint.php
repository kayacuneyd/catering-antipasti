<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprint | Catering Antipasti</title>
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
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="font-serif text-5xl text-center text-olive mb-12">
                Imprint
            </h1>
            <div class="prose prose-lg mx-auto text-seagray">
                <h2>Service provider</h2>
                <p class="text-xl">
                    Catering Antipasti<br>
                    Hasan Geray<br>
                    [Street & number]<br>
                    [Postal code & city]
                </p>

                <h2>Contact</h2>
                <p class="text-xl">
                    Phone: [Phone number]<br>
                    Email: <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
                </p>

                <h2>VAT ID</h2>
                <p class="text-xl">
                    VAT identification number according to §27 a Umsatzsteuergesetz:<br>
                    [VAT ID]
                </p>

                <h2>Supervisory authority</h2>
                <p class="text-xl">
                    [Authority name]<br>
                    [Authority address]
                </p>

                <h2>Liability for content</h2>
                <p class="text-xl">
                    As a service provider we are responsible for our own content on these pages according to § 7 Abs.1 TMG.
                    According to §§ 8 to 10 TMG we are not obliged to monitor transmitted or stored third-party information
                    or to investigate circumstances indicating illegal activity.
                </p>

                <h2>Liability for links</h2>
                <p class="text-xl">
                    Our offer contains links to external websites of third parties on whose contents we have no influence.
                    We therefore cannot assume any liability for these external contents.
                </p>

                <h2>Copyright</h2>
                <p class="text-xl">
                    The content and works created by the site operators on these pages are subject to German copyright law.
                    Contributions by third parties are marked as such.
                </p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html>
