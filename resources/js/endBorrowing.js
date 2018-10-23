import './modal.js';
import {cloneAndReplace, getByClass, getById, getBySelector, ready, remove} from './toolbox.js';
import {HTTPVerbs, makeAjaxRequest} from './ajax.js';

let messages = {};
const selectedBorrowings = [];
const buttonsEnum = {
    END: 0,
    LOST: 1
};

// After page is loaded
ready(() => {
    getTranslatedMessages();
    for (const borrowing of borrowings) borrowing.selected = false;
    addListElements(borrowings);
    addListeners();
});

const getTranslatedMessages = () => {
    messages.late = getBySelector("meta[name='messages.late']").getAttribute('content');
    messages.selectedTag = getBySelector("meta[name='messages.selected_tag']").getAttribute('content');
    messages.borrowedBy = getBySelector("meta[name='messages.borrowed_by']").getAttribute('content');
    messages.lentBy = getBySelector("meta[name='messages.lent_by']").getAttribute('content');
    messages.modal = {
        title: {},
        button: {}
    };
    messages.modal.title.returned = getBySelector("meta[name='messages.modal.title.returned']").getAttribute('content');
    messages.modal.title.lost = getBySelector("meta[name='messages.modal.title.lost']").getAttribute('content');
    messages.modal.button.returned = getBySelector("meta[name='messages.modal.button.returned']").getAttribute('content');
    messages.modal.button.lost = getBySelector("meta[name='messages.modal.button.lost']").getAttribute('content');
};

const addListElements = (borrowings) => {
    for (const borrowing of borrowings) {
        getById('borrowings-list').innerHTML +=
            `<a id="borrowings-list-element-${borrowing.id}" class="list-item has-background-${borrowing.isLate ? 'bad' : 'good'}">
                <div class="level">
                    <div class="level-left">
                        <h5 class="borrowed-item-name level-item">${borrowing.inventoryItem.name}</h5>
                    </div>
                    ${borrowing.isLate ? `<small class="late-message level-item">${messages.late}</small>` : ''}
                    <div class="level-right">
                        <small class="level-item">
                            <span>
                                <span class="borrow-date">${borrowing.startDate}</span>
                                 <i class="fas fa-arrow-right"></i>
                                 <span class="expected-return-date">${borrowing.expectedReturnDate}</span>
                            </span>
                        </small>
                    </div>
                </div>
                <div class="level">
                    <div class="level-left">
                        <p class="level-item">${messages.borrowedBy} ${borrowing.borrower.firstName} ${borrowing.borrower.lastName.toUpperCase()} (Promo ${borrowing.borrower.promotion}) | ${messages.lentBy} ${borrowing.initialLender.firstName} ${borrowing.initialLender.lastName.toUpperCase()} (Promo ${borrowing.initialLender.promotion})</p>
                    </div>
                    <div class="level-right">
                        <small class="level-item selection-span no-display">${messages.selectedTag}</small>
                    </div>
                </div>
            </a>`;
    }
};

const addListeners = () => {
    for (const borrowing of borrowings) {
        getById(`borrowings-list-element-${borrowing.id}`).addEventListener('click', () => handleBorrowingsListElementClick(borrowing));
    }
    getById('return-button').addEventListener('click', () => handleReturnButtonClick(buttonsEnum.END));
    getById('lost-button').addEventListener('click', () => handleReturnButtonClick(buttonsEnum.LOST));
};


const handleBorrowingsListElementClick = (borrowing) => {
    const borrowingListElement = getById(`borrowings-list-element-${borrowing.id}`);
    if (borrowing.selected === false) {
        borrowingListElement.classList.add('is-active');
        borrowingListElement.classList.add(borrowing.isLate ? 'has-background-darker-bad' : 'has-background-darker-good');
        borrowingListElement.classList.remove(borrowing.isLate ? 'has-background-bad' : 'has-background-good');
        getBySelector(`#borrowings-list-element-${borrowing.id} .selection-span`).classList.remove('no-display');
        addBorrowingToSelectedBorrowingsList(borrowing);
    } else {
        borrowingListElement.classList.remove('is-active');
        borrowingListElement.classList.remove(borrowing.isLate ? 'has-background-darker-bad' : 'has-background-darker-good');
        borrowingListElement.classList.add(borrowing.isLate ? 'has-background-bad' : 'has-background-good');
        getBySelector(`#borrowings-list-element-${borrowing.id} .selection-span`).classList.add('no-display');
        removeBorrowingFromSelectedBorrowingsList(borrowing);
    }
    borrowing.selected = !borrowing.selected;
    enableEndButtons(selectedBorrowings.length > 0);
};

const addBorrowingToSelectedBorrowingsList = (borrowing) => {
    selectedBorrowings.push(borrowing);
};

const removeBorrowingFromSelectedBorrowingsList = (borrowing) => {
    for (const i in selectedBorrowings) {
        if (selectedBorrowings[i].id === borrowing.id) {
            selectedBorrowings.splice(i, 1);
            break;
        }
    }
};

const enableEndButtons = (bool) => {
    if (bool) {
        for (const elem of getByClass('end-button')) elem.removeAttribute('disabled');
    } else {
        for (const elem of getByClass('end-button')) elem.setAttribute('disabled', 'disabled');
    }
};

const handleReturnButtonClick = (buttonEnum) => {
    let modalTitle;
    let modalSubmitText;
    const modalSubmitButton = getById(`end-borrowing-submit`);
    let classToAddToSubmitButton;
    let classToRemoveFromSubmitButton;
    switch (buttonEnum) {
      case buttonsEnum.END:
          modalTitle = messages.modal.title.returned;
          modalSubmitText = messages.modal.button.returned;
          classToAddToSubmitButton = 'is-success';
          classToRemoveFromSubmitButton = 'is-danger';
      break;
      case buttonsEnum.LOST:
          modalTitle = messages.modal.title.lost;
          modalSubmitText = messages.modal.button.lost;
          classToAddToSubmitButton = 'is-danger';
          classToRemoveFromSubmitButton = 'is-success';
      break;
    }
    getBySelector(`#end-borrowing-modal .modal-card-title`).innerHTML = modalTitle;
    modalSubmitButton.innerHTML = modalSubmitText;
    modalSubmitButton.classList.add(classToAddToSubmitButton);
    modalSubmitButton.classList.remove(classToRemoveFromSubmitButton);

    const toReturnListElement = getBySelector('#end-borrowing-modal #to-return-list');
    toReturnListElement.innerHTML = '';
    for (const borrowing of selectedBorrowings) {
        toReturnListElement.innerHTML +=
            `<li>${borrowing.inventoryItem.name} ${messages.borrowedBy.toLowerCase()} ${borrowing.borrower.firstName} ${borrowing.borrower.lastName.toUpperCase()} (Promo ${borrowing.borrower.promotion}) le ${borrowing.startDate}</li>`;
    }

    remove(getByClass('error-text'));
    const newModalSubmitButton = cloneAndReplace(modalSubmitButton);
    newModalSubmitButton.addEventListener('click', () => handleConfirmButtonClick(buttonEnum));
};

const handleConfirmButtonClick = (buttonEnum) => {
    const selectedBorrowingsIDs = {};
    let i = 0;

    for (const selectedBorrowing of selectedBorrowings) {
        selectedBorrowingsIDs[i] = selectedBorrowing.id;
        i++;
    }
    const newInventoryItemsStatus = buttonEnum === buttonsEnum.END ? inventoryItemStatuses.RETURNED : inventoryItemStatuses.LOST;
    const csrfToken = Array.from(new FormData(getById('csrf-token')));
    const data = {
        _token: csrfToken[0][1],
        selectedBorrowings: selectedBorrowingsIDs,
        newInventoryItemsStatus: newInventoryItemsStatus
    };
    const successCallback = () => window.location.href = borrowingsHistoryUrl;
    const errorCallback = (response) => handleFormErrors(JSON.parse(response).errors);

    remove(getByClass('error-text'));
    makeAjaxRequest(HTTPVerbs.PATCH, endBorrowingUrl, JSON.stringify(data), successCallback, errorCallback);
};

const handleFormErrors = (errors) => {
    for (const fieldName in errors) {
        for (const error of errors[fieldName]) {
            if (!fieldName.startsWith('selectedBorrowings.')) {
                getById(`form-field-${fieldName}`).innerHTML += `<div class="error-text">${error}</div>`;
            } else {
                getById(`form-field-selectedBorrowings`).innerHTML += `<div class="error-text">${error}</div>`;
            }
        }
    }
};