document.querySelectorAll('[data-autoclose]').forEach((el) => {
    const timeout = parseInt(el.dataset.autoclose, 10) || 4000;
    setTimeout(() => {
        el.classList.add('opacity-0');
        setTimeout(() => el.remove(), 300);
    }, timeout);
});
