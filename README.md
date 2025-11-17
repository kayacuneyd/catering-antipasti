# Catering Antipasti Website

Lightweight bilingual (DE/EN) marketing site for Chef Hasan Geray’s catering business. Built with native PHP, Tailwind via CDN, and vanilla JavaScript. Includes contact form backed by PHP `mail()` and optional WhatsApp quick contact flows.

## Requirements

- PHP 7.4+
- Apache (or compatible) web server
- Ability to send email via PHP `mail()` function

## Getting Started

1. Upload or clone the project to your hosting environment.
2. Ensure the document root points to the project folder.
3. Update contact details in `includes/config.php`:
   - `SITE_EMAIL`
   - `ADMIN_EMAIL`
   - `SITE_URL`
   - `WHATSAPP_NUMBER` (digits with optional leading `+`)
4. Create a writable `logs/` directory at the project root and set permissions (`chmod 755 logs`).
5. Add real images to `assets/images/` and update references if required.

## WhatsApp CTA

WhatsApp buttons are powered by the helper in `assets/js/main.js`. Update the phone number once (see `WHATSAPP_NUMBER`) and all CTAs will use it. Messages are prefilled with the relevant menu or form context.

## Contact Form

- Located at `kontakt.php` and `en/contact.php`.
- Submits to `api/send-email.php`, which validates input, enforces CSRF, and logs successful enquiries to `logs/inquiries.log`.
- Responses are localised based on the referer (DE/EN).

## Dynamic Color Palettes

- Brand colors now come from CSS custom properties in `assets/css/custom.css`. Tailwind utility classes such as `bg-sangiovese`, `text-olive`, and `border-terracotta` automatically read from these variables, so updating one variable recolors the entire site.
- Palette presets live inside `COLOR_PALETTES` in `assets/js/main.js`. Call `window.applyColorPalette('tuscan')` (or add a button with `data-palette="tuscan"`) to swap schemes on the fly; the choice is persisted in `localStorage`.
- Add new palettes by extending the `COLOR_PALETTES` object (use hex values) and, if needed, set a default palette via `<html data-palette-default="coastal">`.
- Listen for the `palettechange` event on `document` if components need to react when the theme switches dynamically.

## File Overview

- `index.php`, `menu.php`, `uber-uns.php`, `kontakt.php`, `impressum.php`, `datenschutz.php`
- `en/` directory holds English equivalents.
- `includes/` contains shared config, header, footer, and menu data.
- `assets/css/custom.css` for small overrides.
- `assets/js/main.js` for navigation, WhatsApp helper, and form helpers.
- `assets/js/menu-builder.js` powers the menu builder interactions.
- `.htaccess` disables directory listing and normalises `/en` path.

## Deployment Checklist

- [ ] Replace placeholder text (address, phone, VAT) in `impressum.php`, `en/imprint.php`, and `includes/config.php`.
- [ ] Swap hero and gallery images with optimised assets (< 100 KB each).
- [ ] Test email delivery on production host.
- [ ] Confirm WhatsApp opens with the correct number/message.
- [ ] Review DE/EN links and language switcher.
- [ ] Verify logs directory permissions (`logs/inquiries.log` writable).
- [ ] Test responsive behaviour on common devices.
- [ ] Hetzner ftp connection

## Maintenance

- Monitor `logs/inquiries.log` for incoming leads.
- Rotate the CSRF token by clearing the session when needed.
- Keep PHP up to date and disable error display in production (already enforced in `.htaccess`).
