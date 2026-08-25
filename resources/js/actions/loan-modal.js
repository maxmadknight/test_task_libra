document.addEventListener('DOMContentLoaded', () => {
    const modalElement = document.querySelector('#issueBookModal');

    if (!modalElement || !window.bootstrap) {
        return;
    }

    if (modalElement.dataset.openOnLoad !== 'true') {
        return;
    }

    window.bootstrap.Modal.getOrCreateInstance(modalElement).show();
});
