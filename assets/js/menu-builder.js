function showMenuType(type) {
    var presetDiv = document.getElementById('preset-menus');
    var customDiv = document.getElementById('custom-menu');
    var btnPreset = document.getElementById('btn-preset');
    var btnCustom = document.getElementById('btn-custom');

    if (!presetDiv || !customDiv || !btnPreset || !btnCustom) {
        return;
    }

    if (type === 'preset') {
        presetDiv.classList.remove('hidden');
        customDiv.classList.add('hidden');
        btnPreset.classList.add('active', 'bg-sangiovese', 'text-cream');
        btnPreset.classList.remove('bg-verona', 'text-olive');
        btnCustom.classList.remove('active', 'bg-sangiovese', 'text-cream');
        btnCustom.classList.add('bg-verona', 'text-olive');
    } else {
        customDiv.classList.remove('hidden');
        presetDiv.classList.add('hidden');
        btnCustom.classList.add('active', 'bg-sangiovese', 'text-cream');
        btnCustom.classList.remove('bg-verona', 'text-olive');
        btnPreset.classList.remove('active', 'bg-sangiovese', 'text-cream');
        btnPreset.classList.add('bg-verona', 'text-olive');
    }
}

function escapeHtml(text) {
    var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' };
    return String(text || '').replace(/[&<>"']/g, function (m) {
        return map[m];
    });
}

function updateMenuSelection() {
    var checkboxes = document.querySelectorAll('input[name="menu[]"]:checked');
    var summary = document.getElementById('menu-summary');
    var list = document.getElementById('selected-items-list');

    if (!summary || !list) {
        return;
    }

    if (!checkboxes.length) {
        summary.classList.add('hidden');
        list.innerHTML = '';
        sessionStorage.removeItem('customMenu');
        return;
    }

    summary.classList.remove('hidden');

    var items = [];
    var displayItems = [];

    checkboxes.forEach(function (checkbox) {
        var name = checkbox.value;
        var category = checkbox.dataset.category || '';
        items.push(name);

        var label = '<span class="font-semibold">' + escapeHtml(name) + '</span>';
        if (category) {
            label += ' <span class="block text-xs text-seagray">' + escapeHtml(category) + '</span>';
        }

        displayItems.push('<li class="text-olive">✓ ' + label + '</li>');
    });

    list.innerHTML = displayItems.join('');
    sessionStorage.setItem('customMenu', JSON.stringify(items));
}

function proceedToInquiry() {
    var items = [];
    try {
        items = JSON.parse(sessionStorage.getItem('customMenu') || '[]');
    } catch (error) {
        items = [];
    }

    var hiddenInput = document.getElementById('custom-menu-items');
    if (hiddenInput) {
        hiddenInput.value = items.join('\n');
    }

    window.location.href = 'kontakt.php';
}

function whatsappCustomMenu() {
    var items = [];
    try {
        items = JSON.parse(sessionStorage.getItem('customMenu') || '[]');
    } catch (error) {
        items = [];
    }

    if (typeof whatsappInquiry === 'function') {
        whatsappInquiry({
            subject: 'Individuelles Menü',
            items: items,
        });
    }
}

function whatsappPresetMenu(name, items) {
    if (typeof whatsappInquiry === 'function') {
        whatsappInquiry({
            subject: name,
            items: items || [],
        });
    }
}
