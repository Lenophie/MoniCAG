import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';
import Fuse from 'fuse.js';

const itemsToBorrow = [];
console.log(inventoryItems);

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
    updateBorrowingCheckoutCounter();
};

const handleBorrowingModalShow = () => {
    fillDisplayedToBorrowList();
};

const handleRemoveInventoryItemButtonClick = (inventoryItem) => {
    inventoryItem.selected = false;
    removeInventoryItemFromBorrowingList(inventoryItem);
    disableInventoryItemButton(inventoryItem, false);
    updateBorrowingCheckoutCounter();
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
            `<div class="col-md-2">
                <button class="btn btn-outline-primary inventory-item-button" id="inventory-item-button-${filteredInventoryItem.id}" type="button" ${filteredInventoryItem.selected || filteredInventoryItem.status_id > 1 ? 'disabled' : ''}>${filteredInventoryItem.name}</button>
            </div>`)
    }
    addInventoryItemButtonsListeners();
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
    if (bool) $(`#inventory-item-button-${inventoryItem.id}`).attr('disabled', 'disabled');
    else $(`#inventory-item-button-${inventoryItem.id}`).removeAttr('disabled');
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

const updateBorrowingCheckoutCounter = () => {
    $('#checkout-counter').html(itemsToBorrow.length);
};