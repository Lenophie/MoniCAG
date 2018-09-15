import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';
import Fuse from 'fuse.js';

const itemsToBorrow = [];

// Listeners setting
const addListeners = () => {
    for (const inventoryItemButton of $('.inventory-item-button')) {
        const id = inventoryItemButton.id.slice('inventory-item-button-'.length);
        const inventoryItem = getInventoryItemById(id);
        $(inventoryItemButton).click(()=>handleAddInventoryItemButtonClick(inventoryItem));
    }
    $('#newBorrowingModal').on('shown.bs.modal', () => handleBorrowingModalShow());
};

$().ready(addListeners);

// Listeners handlers
const handleAddInventoryItemButtonClick = (inventoryItem) => {
    addInventoryItemToBorrowingList(inventoryItem);
    disableInventoryItemButton(inventoryItem, true);
    updateBorrowingCheckoutCounter();
};

const handleBorrowingModalShow = () => {
    fillDisplayedToBorrowList();
};

const handleRemoveInventoryItemButtonClick = (inventoryItem) => {
    removeInventoryItemFromBorrowingList(inventoryItem);
    disableInventoryItemButton(inventoryItem, false);
    updateBorrowingCheckoutCounter();
    $(`#to-borrow-list-element-${inventoryItem.id}`).remove();
};

// Actions

const getInventoryItemById = (id) => {
    const options = {
        threshold: 0,
        location: 32,
        distance: 0,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
            "id"
        ]
    };
    const fuse = new Fuse(inventoryItems, options);
    const result = fuse.search(id);
    return result[0];
}

const addInventoryItemToBorrowingList = (inventoryItem) => {
    itemsToBorrow.push(inventoryItem);
};

const removeInventoryItemFromBorrowingList = (inventoryItem) => {
    for (const i in itemsToBorrow) {
        if (itemsToBorrow[i] === inventoryItem) itemsToBorrow.splice(i, 1);
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