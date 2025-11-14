<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-whatsapp="<?php echo preg_replace('/[^0-9]/', '', WHATSAPP_NUMBER); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | Catering Antipasti</title>
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
                Privacy policy
            </h1>
            <div class="prose prose-lg mx-auto text-seagray">
                <h2>1. Overview</h2>
                <p>
                    The following sections provide a simple overview of what happens to your personal data when you visit this website.
                </p>

                <h2>2. Data collection</h2>
                <p>
                    Data processing on this website is carried out by the website operator.
                    Their contact details can be found in the imprint.
                </p>

                <h3>Contact form</h3>
                <p>
                    When you submit our contact form, the details you provide including contact information are stored to process your request
                    and in case of follow-up questions. We do not share this data without your consent.
                </p>

                <h2>3. Hosting</h2>
                <p>
                    This website is hosted by an external provider. Personal data collected on this site
                    is stored on the host's servers.
                </p>

                <h2>4. Your rights</h2>
                <p>
                    You have the right to receive information about the origin, recipient and purpose of your stored personal data at any time free of charge.
                    You also have the right to request correction or deletion of this data.
                </p>

                <h2>5. WhatsApp</h2>
                <p>
                    We offer WhatsApp for direct enquiries. Using WhatsApp is voluntary. Please avoid sending sensitive data via WhatsApp.
                    Find more on WhatsApp privacy at
                    <a href="https://www.whatsapp.com/legal/privacy-policy" target="_blank" rel="noopener">https://www.whatsapp.com/legal/privacy-policy</a>.
                </p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html>
