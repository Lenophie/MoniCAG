import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

const itemsToBorrow = [];

// Listeners setting
const addListeners = () => {
    for (const inventoryItemButton of $('.inventory-item-button')) {
        const id = parseInt(inventoryItemButton.id.slice('inventory-item-button-'.length));
        const name = $(inventoryItemButton).text();
        $(inventoryItemButton).click(()=>handleAddInventoryItemButtonClick(id, name));
    }
    $('#newBorrowingModal').on('shown.bs.modal', () => handleBorrowingModalShow());
};

$().ready(addListeners);

// Listeners handlers
const handleAddInventoryItemButtonClick = (id, name) => {
    addInventoryItemToBorrowingList(id, name);
    disableInventoryItemButton(id, true);
    updateBorrowingCheckoutCounter();
};

const handleBorrowingModalShow = () => {
    fillDisplayedToBorrowList();
};

const handleRemoveInventoryItemButtonClick = (id) => {
    removeInventoryItemFromBorrowingList(id);
    disableInventoryItemButton(id, false);
    updateBorrowingCheckoutCounter();
    $(`#to-borrow-list-element-${id}`).remove();
};

// Actions

const addInventoryItemToBorrowingList = (id, name) => {
    itemsToBorrow.push({name: name, id: id});
};

const removeInventoryItemFromBorrowingList = (id) => {
    for (const i in itemsToBorrow) {
        if (itemsToBorrow[i].id === id) itemsToBorrow.splice(i, 1);
    }
};

const disableInventoryItemButton = (id, bool) => {
    if (bool) $(`#inventory-item-button-${id}`).attr('disabled', 'disabled');
    else $(`#inventory-item-button-${id}`).removeAttr('disabled');
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
        $(`#remove-item-borrow-list-button-${itemToBorrow.id}`).on('click', () => handleRemoveInventoryItemButtonClick(itemToBorrow.id));
    }
};

const updateBorrowingCheckoutCounter = () => {
    $('#checkout-counter').html(itemsToBorrow.length);
};
