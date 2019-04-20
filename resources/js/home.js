import {getById, ready} from './toolbox.js';

const buttonsLinks = {
    'new-borrowing-button': '/new-borrowing',
    'end-borrowing-button': '/end-borrowing',
    'borrowings-history-button': '/borrowings-history',
    'view-inventory-button': '/view-inventory',
    'edit-inventory-button': '/edit-inventory',
    'edit-users-button': '/edit-users',
};

ready(() => addListeners());

const addListeners = () => {
    for (const id in buttonsLinks) {
        getById(id).addEventListener('click', (e) => buttonClickHandler(id));
    }
};

const buttonClickHandler = (id) => {
    if (getById(id).getAttribute('disabled') !== 'disabled') window.location.href = buttonsLinks[id];
};
