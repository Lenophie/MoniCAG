import {library} from '@fortawesome/fontawesome-svg-core';
import {faCalendarAlt, faChess, faDice, faEye, faWarehouse, faWrench} from '@fortawesome/free-solid-svg-icons';

// Load icons present on page
library.add(faEye, faDice, faWarehouse, faWrench, faChess, faCalendarAlt);

const buttonsLinks = {
    'new-borrowing-button': '/new-borrowing',
    'end-borrowing-button': '/end-borrowing',
    'borrowings-history-button': '/borrowings-history',
    'view-inventory-button': '/view-inventory',
    'edit-inventory-button': '/edit-inventory',
    'edit-users-button': '/edit-users',
};

const addListeners = () => {
    for (const id in buttonsLinks) {
        const element = document.getElementById(id);
        element.addEventListener('click', () => buttonClickHandler(element, buttonsLinks[id]));
    }
};

const buttonClickHandler = (element, url) => {
    if (element.getAttribute('disabled') !== 'disabled') window.location.href = url;
};

addListeners();
