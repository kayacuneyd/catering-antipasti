// Palette definitions for dynamic theme switching
var COLOR_PALETTES = window.COLOR_PALETTES || {
    classic: {
        olive: '#6C1F2B',
        sangiovese: '#6C1F2B',
        verona: '#F5E6D3',
        terracotta: '#E8B944',
        seagray: '#7A8C8E',
        vineyard: '#6C1F2B',
        cream: '#FFFFFF'
    },
    toscana: {
        olive: '#5C4A3C',
        sangiovese: '#D4704A',
        verona: '#F5E6D3',
        terracotta: '#E8B944',
        seagray: '#7A8C8E',
        vineyard: '#3A5A40',
        cream: '#FFFFFF'
    },
    amalfi: {
        olive: '#023E8A',
        sangiovese: '#0077B6',
        verona: '#FFFFFF',
        terracotta: '#FFD60A',
        seagray: '#4D7D8C',
        vineyard: '#023E8A',
        cream: '#F5FBFF'
    },
    sicilia: {
        olive: '#1E3A8A',
        sangiovese: '#FB923C',
        verona: '#FEFCE8',
        terracotta: '#DC2626',
        seagray: '#4B5563',
        vineyard: '#6B21A8',
        cream: '#FFFFFF'
    },
    venezia: {
        olive: '#1F2937',
        sangiovese: '#F59E0B',
        verona: '#FEF3C7',
        terracotta: '#991B1B',
        seagray: '#4B5563',
        vineyard: '#1F2937',
        cream: '#FFF8E1'
    }
};

if (!window.COLOR_PALETTES) {
    window.COLOR_PALETTES = COLOR_PALETTES;
}

function hexToRgbTriplet(hex) {
    var normalized = hex.replace('#', '');
    if (normalized.length === 3) {
        normalized = normalized.split('').map(function (char) {
            return char + char;
        }).join('');
    }

    var bigint = parseInt(normalized, 16);
    var r = (bigint >> 16) & 255;
    var g = (bigint >> 8) & 255;
    var b = bigint & 255;

    return r + ' ' + g + ' ' + b;
}

function applyColorPalette(name, persist) {
    if (!COLOR_PALETTES[name]) {
        console.warn('Palette not found:', name);
        return;
    }

    var root = document.documentElement;
    var palette = COLOR_PALETTES[name];

    Object.keys(palette).forEach(function (token) {
        root.style.setProperty('--color-' + token, hexToRgbTriplet(palette[token]));
    });

    root.dataset.paletteActive = name;

    if (persist !== false) {
        try {
            localStorage.setItem('colorPalette', name);
        } catch (error) {
            console.warn('Palette preference could not be stored', error);
        }
    }

    document.dispatchEvent(new CustomEvent('palettechange', { detail: { name: name } }));
}

function initColorPalette() {
    var preferred = document.documentElement.dataset.paletteDefault || window.ACTIVE_PALETTE || null;
    var stored = null;

    try {
        stored = localStorage.getItem('colorPalette');
    } catch (error) {
        stored = null;
    }

    var target = stored || preferred || 'classic';
    if (!COLOR_PALETTES[target]) {
        target = 'classic';
    }

    applyColorPalette(target, false);
}

function initPaletteToggles() {
    document.querySelectorAll('[data-palette]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var palette = trigger.getAttribute('data-palette');
            applyColorPalette(palette);
        });
    });
}

window.applyColorPalette = function (name) {
    applyColorPalette(name);
};

window.getAvailablePalettes = function () {
    return Object.keys(COLOR_PALETTES);
};

// Mobile navigation handling
function toggleMobileMenu() {
    var menu = document.getElementById('mobile-menu');
    var trigger = document.querySelector('[aria-controls="mobile-menu"]');

    if (!menu) {
        return;
    }

    menu.classList.toggle('hidden');
    var isOpen = !menu.classList.contains('hidden');

    if (trigger) {
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }
}

function closeMobileMenu() {
    var menu = document.getElementById('mobile-menu');
    var trigger = document.querySelector('[aria-controls="mobile-menu"]');

    if (menu && !menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
    }

    if (trigger) {
        trigger.setAttribute('aria-expanded', 'false');
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
    initColorPalette();
    initPaletteToggles();

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

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
            closeMobileMenu();
        }
    });
});
