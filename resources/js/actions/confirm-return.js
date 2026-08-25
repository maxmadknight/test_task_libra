document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-confirm-return]');

    if (form && ! window.confirm('Return this book and remove the loan record?')) {
        event.preventDefault();

        return;
    }

    const deleteForm = event.target.closest('[data-confirm-delete]');

    if (! deleteForm) {
        return;
    }

    if (! window.confirm(deleteForm.dataset.confirmDelete)) {
        event.preventDefault();
    }
});
