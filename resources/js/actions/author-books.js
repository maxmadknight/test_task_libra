document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-author-books-toggle]');

    if (!toggle) {
        return;
    }

    const target = document.querySelector(toggle.dataset.authorBooksToggle);

    if (!target) {
        return;
    }

    const isHidden = target.hasAttribute('hidden');

    target.toggleAttribute('hidden', !isHidden);
    toggle.setAttribute('aria-expanded', String(isHidden));
    toggle.textContent = isHidden ? 'Hide books' : 'Show books';
});
