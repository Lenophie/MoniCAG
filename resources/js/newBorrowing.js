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
        $(inventoryItemButton).click(() => handleAddInventoryItemButtonClick(inventoryItem));
    }
};

// Listeners handlers
const handleAddInventoryItemButtonClick = (inventoryItem) => {
    inventoryItem.selected = true;
    addInventoryItemToBorrowingList(inventoryItem);
    disableInventoryItemButton(inventoryItem, true);
    updateCheckoutCounter();
};

const handleBorrowingModalShow = () => {
    fillDisplayedToBorrowList();
};

const handleRemoveInventoryItemButtonClick = (inventoryItem) => {
    inventoryItem.selected = false;
    removeInventoryItemFromBorrowingList(inventoryItem);
    disableInventoryItemButton(inventoryItem, false);
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
                <button class="btn ${filteredInventoryItem.selected ? "btn-outline-new-borrowing" : "btn-outline-primary"} inventory-item-button" id="inventory-item-button-${filteredInventoryItem.id}" type="button" ${filteredInventoryItem.selected || filteredInventoryItem.status_id > 2 ? 'disabled' : ''}>
                    ${filteredInventoryItem.name}
                    <hr class="in-button-hr">
                    <div class="inventory-item-button-footer">${filteredInventoryItem.status}</div>
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
        url: "/new-borrowing/",
        type: 'POST',
        data: formattedForm,
        success: () => {
            window.location.href = "/borrowings-history"
        },
        error: (response) => {
            handleFormErrors(response.responseJSON.errors);
        }
    });
};

const handleFormErrors = (errors) => {
    for (const fieldName in errors) {
        $(`#form-field-${fieldName}`).append(`<div class="error-text">${errors[fieldName]}</div>`);
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
    const result = fuse.search(searchQuery);
    return result;
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

const disableInventoryItemButton = (inventoryItem, bool) => {
    const inventoryItemButton = $(`#inventory-item-button-${inventoryItem.id}`);
    if (bool) {
        inventoryItemButton.attr('disabled', 'disabled');
        inventoryItemButton.removeClass('btn-outline-primary');
        inventoryItemButton.addClass('btn-outline-new-borrowing');
    } else {
        inventoryItemButton.removeAttr('disabled');
        inventoryItemButton.addClass('btn-outline-primary');
        inventoryItemButton.removeClass('btn-outline-new-borrowing');
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
        $(`#remove-item-borrow-list-button-${itemToBorrow.id}`).on('click', () => handleRemoveInventoryItemButtonClick(itemToBorrow));
    }
};

const updateCheckoutCounter = () => {
    $('#checkout-counter').html(itemsToBorrow.length);
};