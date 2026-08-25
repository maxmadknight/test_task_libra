import TomSelect from 'tom-select';

document.querySelectorAll('[data-searchable-select]').forEach((select) => {
    if (select.tomselect) {
        return;
    }

    new TomSelect(select, {
        allowEmptyOption: true,
        create: false,
        plugins: ['dropdown_input'],
        placeholder: select.dataset.placeholder || '',
    });
});
