import Fuse from 'fuse.js';
import './modal.js';
import {makeAjaxRequest, HTTPVerbs} from './ajax.js';
import {ready, remove} from './toolbox.js';

const itemsToBorrow = [];

// After page is loaded
ready(() => {
    for (const inventoryItem of inventoryItems) inventoryItem.selected = false;
    handleSearchFieldUpdate('');
    addListeners();
});

// Listeners setting
const addListeners = () => {
    observeModal();

    // Search games listeners
    const searchGameField = document.getElementById('search-game-field');
    searchGameField.addEventListener('keyup', () => handleSearchFieldUpdate(searchGameField.value));
    document.getElementById('search-game-button').addEventListener('click', () => {
        searchGameField.value = '';
        handleSearchFieldUpdate('');
    });

    // Submit button listener
    document.getElementById('new-borrowing-submit').addEventListener('click', () => handleFormSubmit());
};

// Modal observation setup
const observeModal = () => {
    const newBorrowingModal = document.getElementById('new-borrowing-modal');
    const observerConfig = {attributes: true};
    const observeCallback = (mutationsList, observer) => {
        for (const mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.target.classList.contains('is-active')) {
                handleBorrowingModalShow();
            }
        }
    };
    const observer = new MutationObserver(observeCallback);
    observer.observe(newBorrowingModal, observerConfig);
};

const addInventoryItemButtonsListeners = () => {
    const inventoryItemButtons = document.getElementsByClassName('inventory-item-button');
    for (const inventoryItemButton of inventoryItemButtons) {
        const id = inventoryItemButton.id.slice('inventory-item-button-'.length);
        const inventoryItem = getInventoryItemById(parseInt(id));
        inventoryItemButton.addEventListener('click', () => handleInventoryItemButtonClick(inventoryItem));
    }
};

// Listeners handlers
const handleInventoryItemButtonClick = (inventoryItem) => {
    if (inventoryItem.status.id < 3) {
        inventoryItem.selected = !inventoryItem.selected;
        if (inventoryItem.selected) addInventoryItemToBorrowingList(inventoryItem);
        else removeInventoryItemFromBorrowingList(inventoryItem);
        changeinventoryItemButtonState(inventoryItem, inventoryItem.selected);
        updateCheckoutCounter();
    }
};

const handleBorrowingModalShow = () => {
    document.getElementsByClassName('.error-text').innerHTML = '';
    fillDisplayedToBorrowList();
};

const handleRemoveInventoryItemFromBorrowingButtonClick = (inventoryItem) => {
    inventoryItem.selected = false;
    removeInventoryItemFromBorrowingList(inventoryItem);
    changeinventoryItemButtonState(inventoryItem, false);
    updateCheckoutCounter();
    const listElementToRemove = document.getElementById(`to-borrow-list-element-${inventoryItem.id}`);
    remove(listElementToRemove);
};

const handleSearchFieldUpdate = (gamesQuery) => {
    let filteredInventoryItems = [];
    if (gamesQuery.length > 0) filteredInventoryItems = getInventoryItemsByName(gamesQuery);
    else filteredInventoryItems = inventoryItems;
    const inventoryItemButtonsList = document.getElementById('inventory-item-buttons-list');
    inventoryItemButtonsList.innerHTML = '';
    for (const filteredInventoryItem of filteredInventoryItems) {
        inventoryItemButtonsList.innerHTML +=
            `<div class="column is-2">
                <a class="button is-link ${filteredInventoryItem.selected ? '' : 'is-outlined'} inventory-item-button" id="inventory-item-button-${filteredInventoryItem.id}" type="button" ${filteredInventoryItem.status.id > 2 ? 'disabled' : ''}>
                    <div class="inventory-item-button-content">
                        ${filteredInventoryItem.name}
                        <hr class="in-button-hr">
                        <div class="inventory-item-button-footer">
                            ${filteredInventoryItem.status.name}
                        </div>
                    </div>
                </a>
            </div>`;
    }
    addInventoryItemButtonsListeners();
};

const handleFormSubmit = () => {
    const newBorrowingForm = document.getElementById('new-borrowing-form');
    const itemsToBorrowIDs = {};
    let i = 0;

    for (const itemToBorrow of itemsToBorrow) {
        itemsToBorrowIDs[i] = itemToBorrow.id;
        i++;
    }
    const serializedForm = Array.from(new FormData(newBorrowingForm));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    formattedForm.borrowedItems = itemsToBorrowIDs;

    if (formattedForm.guarantee != null && /^[0-9]+([.,][0-9][0-9]?)?$/.test(formattedForm.guarantee)) formattedForm.guarantee = parseFloat(formattedForm.guarantee.replace(',', '.'));
    document.getElementsByClassName('error-text').innerHTML = '';

    const successCallback = () => window.location.href = borrowingsHistoryUrl;
    const errorCallback = (response) => handleFormErrors(JSON.parse(response).errors);
    makeAjaxRequest(HTTPVerbs.POST, newBorrowingUrl, JSON.stringify(formattedForm), successCallback, errorCallback);
};

const handleFormErrors = (errors) => {
    console.log(errors);
    for (const fieldName in errors) {
        for (const error of errors[fieldName]) {
            if (!fieldName.startsWith('borrowedItems.')) {
                document.getElementById(`form-field-${fieldName}`).innerHTML += `<div class="error-text">${error}</div>`;
            } else {
                document.getElementById(`form-field-borrowedItems`).innerHTML += `<div class="error-text">${error}</div>`;
            }
        }
    }
};

// Actions

const getInventoryItemById = (id) => {
    for (const inventoryItem of inventoryItems) {
        if (inventoryItem.id === id) return inventoryItem;
    }
};

const getInventoryItemsByName = (searchQuery) => {
    const options = {
        shouldSort: true,
        tokenize: true,
        threshold: 0.6,
        location: 0,
        distance: 0,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
            "name"
        ]
    };
    const fuse = new Fuse(inventoryItems, options);
    return fuse.search(searchQuery);
};

const addInventoryItemToBorrowingList = (inventoryItem) => {
    itemsToBorrow.push(inventoryItem);
};

const removeInventoryItemFromBorrowingList = (inventoryItem) => {
    for (const i in itemsToBorrow) {
        if (itemsToBorrow[i].id === inventoryItem.id) {
            itemsToBorrow.splice(i, 1);
            break;
        }
    }
};

const changeinventoryItemButtonState = (inventoryItem, bool) => {
    const inventoryItemButton = document.getElementById(`inventory-item-button-${inventoryItem.id}`);
    if (bool) inventoryItemButton.classList.remove('is-outlined');
    else inventoryItemButton.classList.add('is-outlined');
};

const fillDisplayedToBorrowList = () => {
    const toBorrowListDOMelem = document.getElementById('toBorrowList');
    toBorrowListDOMelem.innerHTML = '';
    for (const itemToBorrow of itemsToBorrow) {
        toBorrowListDOMelem.innerHTML +=
            `<li id="to-borrow-list-element-${itemToBorrow.id}">
                ${itemToBorrow.name} <button class="button is-small is-danger remove-item-borrow-list-button" id="remove-item-borrow-list-button-${itemToBorrow.id}">
                    <i class="fas fa-times"></i>
                </button>
            </li>`;
        document.getElementById(`remove-item-borrow-list-button-${itemToBorrow.id}`).addEventListener('click', () => handleRemoveInventoryItemFromBorrowingButtonClick(itemToBorrow));
    }
};

const updateCheckoutCounter = () => {
    document.getElementById('checkout-counter').innerHTML = itemsToBorrow.length;
};