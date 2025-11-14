// Mobile navigation handling
function toggleMobileMenu() {
    var menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (event) {
        var targetSelector = this.getAttribute('href');
        if (!targetSelector || targetSelector === '#') {
            return;
        }

        var target = document.querySelector(targetSelector);
        if (target) {
            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

function getWhatsappNumber() {
    var root = document.documentElement;
    return (root && root.dataset.whatsapp) || '';
}

function buildWhatsappLink(message) {
    var number = getWhatsappNumber();
    if (!number) {
        return null;
    }

    var text = encodeURIComponent(message);
    return "https://wa.me/" + number + "?text=" + text;
}

/**
 * Trigger WhatsApp chat with a prefilled message.
 * @param {Object} options
 * @param {string} options.subject - Short description of the request.
 * @param {string[]} [options.items] - List of menu items or highlights.
 * @param {string} [options.details] - Additional detail lines.
 */
function whatsappInquiry(options) {
    var subject = options.subject || 'Catering Anfrage';
    var parts = ['Hallo Hasan,'];
    parts.push('ich interessiere mich für: ' + subject + '.');

    if (Array.isArray(options.items) && options.items.length > 0) {
        parts.push('');
        parts.push('Auswahl:');
        options.items.forEach(function (item) {
            parts.push('- ' + item);
        });
    }

    if (options.details) {
        parts.push('');
        parts.push(options.details);
    }

    parts.push('');
    parts.push('Liebe Grüße');

    var link = buildWhatsappLink(parts.join('\n'));
    if (link) {
        window.open(link, '_blank', 'noopener');
    }
}

function hideCookieBanner() {
    var banner = document.getElementById('cookie-banner');
    if (banner) {
        banner.classList.add('hidden');
    }
}

function setCookieConsent(value) {
    try {
        localStorage.setItem('cookieConsent', value);
    } catch (error) {
        console.warn('Consent could not be stored', error);
    }
    hideCookieBanner();
}

function initCookieConsent() {
    var banner = document.getElementById('cookie-banner');
    if (!banner) {
        return;
    }

    var stored = null;
    try {
        stored = localStorage.getItem('cookieConsent');
    } catch (error) {
        stored = null;
    }

    if (!stored) {
        setTimeout(function () {
            banner.classList.remove('hidden');
        }, 400);
    }

    var acceptAll = document.getElementById('cookie-accept-all');
    var acceptEssential = document.getElementById('cookie-accept-essential');

    if (acceptAll) {
        acceptAll.addEventListener('click', function () {
            setCookieConsent('all');
        });
    }

    if (acceptEssential) {
        acceptEssential.addEventListener('click', function () {
            setCookieConsent('essential');
        });
    }

    document.querySelectorAll('[data-cookie-manage]').forEach(function (button) {
        button.addEventListener('click', function () {
            banner.classList.remove('hidden');
        });
    });
}

window.addEventListener('DOMContentLoaded', function () {
    var customMenuInput = document.getElementById('custom-menu-items');
    if (customMenuInput) {
        try {
            var storedMenu = JSON.parse(sessionStorage.getItem('customMenu') || '[]');
            if (storedMenu.length > 0) {
                customMenuInput.value = storedMenu.join('\n');
            }
        } catch (error) {
            console.error('Could not parse stored menu', error);
        }
    }

    initCookieConsent();
});
