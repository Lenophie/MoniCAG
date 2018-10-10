import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';
import Fuse from 'fuse.js';

const itemsToBorrow = [];

// After page is loaded
$().ready(() => {
    for (const inventoryItem of inventoryItems) inventoryItem.selected = false;
    handleSearchFieldUpdate('');
    addListeners();
});

// Listeners setting
const addListeners = () => {
    // Show modal listener
    $('#new-borrowing-modal').on('shown.bs.modal', () => handleBorrowingModalShow());

    // Search games listeners
    const searchGameField = $('#search-game-field');
    searchGameField.keyup(() => handleSearchFieldUpdate(searchGameField.val()));
    $('#search-game-button').click(() => {
        searchGameField.val('');
        handleSearchFieldUpdate('');
    });

    // Submit button listener
    $('#new-borrowing-submit').click(() => handleFormSubmit());
};

const addInventoryItemButtonsListeners = () => {
    const inventoryItemButtons = $('.inventory-item-button');
    for (const inventoryItemButton of inventoryItemButtons) {
        const id = inventoryItemButton.id.slice('inventory-item-button-'.length);
        const inventoryItem = getInventoryItemById(parseInt(id));
        $(inventoryItemButton).click(() => handleInventoryItemButtonClick(inventoryItem));
    }
};

// Listeners handlers
const handleInventoryItemButtonClick = (inventoryItem) => {
    inventoryItem.selected = !inventoryItem.selected;
    if (inventoryItem.selected) addInventoryItemToBorrowingList(inventoryItem);
    else removeInventoryItemFromBorrowingList(inventoryItem);
    changeinventoryItemButtonState(inventoryItem, inventoryItem.selected);
    updateCheckoutCounter();
};

const handleBorrowingModalShow = () => {
    $('.error-text').remove();
    fillDisplayedToBorrowList();
};

const handleRemoveInventoryItemFromBorrowingButtonClick = (inventoryItem) => {
    inventoryItem.selected = false;
    removeInventoryItemFromBorrowingList(inventoryItem);
    changeinventoryItemButtonState(inventoryItem, false);
    updateCheckoutCounter();
    $(`#to-borrow-list-element-${inventoryItem.id}`).remove();
};

const handleSearchFieldUpdate = (gamesQuery) => {
    let filteredInventoryItems = [];
    if (gamesQuery.length > 0) filteredInventoryItems = getInventoryItemsByName(gamesQuery);
    else filteredInventoryItems = inventoryItems;
    const inventoryItemButtonsList = $('#inventory-item-buttons-list');
    inventoryItemButtonsList.empty();
    for (const filteredInventoryItem of filteredInventoryItems) {
        inventoryItemButtonsList.append(
            `<div class="col-md-2 mb-1">
                <button class="btn ${filteredInventoryItem.selected ? "btn-primary" : "btn-outline-primary"} inventory-item-button" id="inventory-item-button-${filteredInventoryItem.id}" type="button" ${filteredInventoryItem.status.id > 2 ? 'disabled' : ''}>
                    ${filteredInventoryItem.name}
                    <hr class="in-button-hr">
                    <div class="inventory-item-button-footer">${filteredInventoryItem.status.name}</div>
                </button>
            </div>`)
    }
    addInventoryItemButtonsListeners();
};

const handleFormSubmit = () => {
    const newBorrowingForm = $('#new-borrowing-form');
    const itemsToBorrowIDs = {};
    let i = 0;

    for (const itemToBorrow of itemsToBorrow) {
        itemsToBorrowIDs[i] = itemToBorrow.id;
        i++;
    }
    const serializedForm = newBorrowingForm.serializeArray();

    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.borrowedItems = itemsToBorrowIDs;

    if (formattedForm.guarantee != null && /^[0-9]+([.,][0-9][0-9]?)?$/.test(formattedForm.guarantee)) formattedForm.guarantee = parseFloat(formattedForm.guarantee.replace(',', '.'));
    $('.error-text').remove();

    $.ajax({
        url: newBorrowingUrl,
        type: 'POST',
        data: formattedForm,
        success: () => {
            window.location.href = borrowingsHistoryUrl;
        },
        error: (response) => {
            handleFormErrors(response.responseJSON.errors);
        }
    });
};

const handleFormErrors = (errors) => {
    for (const fieldName in errors) {
        for (const error of errors[fieldName]) {
            if (!fieldName.startsWith('borrowedItems.')) {
                $(`#form-field-${fieldName}`).append(`<div class="error-text">${error}</div>`);
            } else {
                $(`#form-field-borrowedItems`).append(`<div class="error-text">${error}</div>`);
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
    const inventoryItemButton = $(`#inventory-item-button-${inventoryItem.id}`);
    if (bool) {
        inventoryItemButton.removeClass('btn-outline-primary');
        inventoryItemButton.addClass('btn-primary');
    } else {
        inventoryItemButton.addClass('btn-outline-primary');
        inventoryItemButton.removeClass('btn-primary');
    }
};

const fillDisplayedToBorrowList = () => {
    const toBorrowListDOMelem = $('#toBorrowList');
    toBorrowListDOMelem.empty();
    for (const itemToBorrow of itemsToBorrow) {
        toBorrowListDOMelem.append(
            `<li id="to-borrow-list-element-${itemToBorrow.id}">
                ${itemToBorrow.name} <button class="btn btn-sm btn-danger remove-item-borrow-list-button" id="remove-item-borrow-list-button-${itemToBorrow.id}">
                    <i class="fas fa-times"></i>
                </button>
            </li>`);
        $(`#remove-item-borrow-list-button-${itemToBorrow.id}`).on('click', () => handleRemoveInventoryItemFromBorrowingButtonClick(itemToBorrow));
    }
};

const updateCheckoutCounter = () => {
    $('#checkout-counter').html(itemsToBorrow.length);
};