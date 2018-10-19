import $ from 'jquery';
import './modal.js';

let messages = {};
const selectedBorrowings = [];
const buttonsEnum = {
    END: 0,
    LOST: 1
};

// After page is loaded
$().ready(() => {
    getTranslatedMessages();
    for (const borrowing of borrowings) borrowing.selected = false;
    addListElements(borrowings);
    addListeners();
});

const getTranslatedMessages = () => {
    messages.late = $("meta[name='messages.late']").attr('content');
    messages.selectedTag = $("meta[name='messages.selected_tag']").attr('content');
    messages.borrowedBy = $("meta[name='messages.borrowed_by']").attr('content');
    messages.lentBy = $("meta[name='messages.lent_by']").attr('content');
    messages.modal = {
        title: {},
        button: {}
    };
    messages.modal.title.returned = $("meta[name='messages.modal.title.returned']").attr('content');
    messages.modal.title.lost = $("meta[name='messages.modal.title.lost']").attr('content');
    messages.modal.button.returned = $("meta[name='messages.modal.button.returned']").attr('content');
    messages.modal.button.lost = $("meta[name='messages.modal.button.lost']").attr('content');
};

const addListElements = (borrowings) => {
    for (const borrowing of borrowings) {
        $('#borrowings-list').append(
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
            </a>`
        );
    }
};

const addListeners = () => {
    for (const borrowing of borrowings) {
        $(`#borrowings-list-element-${borrowing.id}`).click(() => handleBorrowingsListElementClick(borrowing));
    }
    $('#return-button').click(() => handleReturnButtonClick(buttonsEnum.END));
    $('#lost-button').click(() => handleReturnButtonClick(buttonsEnum.LOST));
};


const handleBorrowingsListElementClick = (borrowing) => {
    const borrowingListElement = $(`#borrowings-list-element-${borrowing.id}`);
    if (borrowing.selected === false) {
        borrowingListElement.addClass('is-active');
        borrowingListElement.addClass(borrowing.isLate ? 'has-background-darker-bad' : 'has-background-darker-good');
        borrowingListElement.removeClass(borrowing.isLate ? 'has-background-bad' : 'has-background-good');
        $(`#borrowings-list-element-${borrowing.id} .selection-span`).removeClass('no-display');
        addBorrowingToSelectedBorrowingsList(borrowing);
    } else {
        borrowingListElement.removeClass('is-active');
        borrowingListElement.removeClass(borrowing.isLate ? 'has-background-darker-bad' : 'has-background-darker-good');
        borrowingListElement.addClass(borrowing.isLate ? 'has-background-bad' : 'has-background-good');
        $(`#borrowings-list-element-${borrowing.id} .selection-span`).addClass('no-display');
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
    if (bool) $('.end-button').removeAttr('disabled');
    else $('.end-button').attr('disabled', 'disabled');

};

const handleReturnButtonClick = (buttonEnum) => {
    let modalTitle;
    let modalSubmitText;
    const modalSubmitButton = $(`#end-borrowing-submit`);
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
          classToAddToSubmitButton = 'is-success';
          classToRemoveFromSubmitButton = 'is-danger';
      break;
    }
    $(`#end-borrowing-modal .modal-title`).html(modalTitle);
    modalSubmitButton.html(modalSubmitText);
    modalSubmitButton.addClass(classToAddToSubmitButton);
    modalSubmitButton.removeClass(classToRemoveFromSubmitButton);

    const toReturnListElement = $(`#end-borrowing-modal #to-return-list`);
    toReturnListElement.empty();
    for (const borrowing of selectedBorrowings) {
        toReturnListElement.append(
            `<li>${borrowing.inventoryItem.name} ${messages.borrowedBy.toLowerCase()} ${borrowing.borrower.firstName} ${borrowing.borrower.lastName.toUpperCase()} (Promo ${borrowing.borrower.promotion}) le ${borrowing.startDate}</li>`
        );
    }

    $('.error-text').remove();
    modalSubmitButton.off();
    modalSubmitButton.click(() => handleConfirmButtonClick(buttonEnum));
};

const handleConfirmButtonClick = (buttonEnum) => {
    const selectedBorrowingsIDs = {};
    let i = 0;

    for (const selectedBorrowing of selectedBorrowings) {
        selectedBorrowingsIDs[i] = selectedBorrowing.id;
        i++;
    }
    const newInventoryItemsStatus = buttonEnum === buttonsEnum.END ? inventoryItemStatuses.RETURNED : inventoryItemStatuses.LOST;
    const csrfTokenForm = $('#csrf-token').serializeArray();

    $('.error-text').remove();
    $.ajax({
        url: endBorrowingUrl,
        type: 'PATCH',
        data: {
            _token: csrfTokenForm[0].value,
            selectedBorrowings: selectedBorrowingsIDs,
            newInventoryItemsStatus: newInventoryItemsStatus
        },
        success: () => {
            window.location.href = borrowingsHistoryUrl
        },
        error: (response) => {
            handleFormErrors(response.responseJSON.errors);
        }
    });
};

const handleFormErrors = (errors) => {
    for (const fieldName in errors) {
        for (const error of errors[fieldName]) {
            if (!fieldName.startsWith('selectedBorrowings.')) {
                $(`#form-field-${fieldName}`).append(`<div class="error-text">${error}</div>`);
            } else {
                $(`#form-field-selectedBorrowings`).append(`<div class="error-text">${error}</div>`);
            }
        }
    }
};