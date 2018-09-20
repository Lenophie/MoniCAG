import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

const selectedBorrowings = [];
const buttonsEnum = {
    END: 0,
    LOST: 1
};

// After page is loaded
$().ready(() => {
    for (const borrowing of borrowings) borrowing.selected = false;
    addListElements(borrowings);
    addListeners();
});

const addListElements = (borrowings) => {
    for (const borrowing of borrowings) {
        $('#borrowings-list').append(
            `<a id="borrowings-list-element-${borrowing.id}" class="list-group-item list-group-item-action flex-column align-items-start list-group-item-${borrowing.isLate ? 'bad' : 'good'}">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="borrowed-item-name mb-1">${borrowing.inventoryItem.name}</h5>
                    ${borrowing.isLate ? '<small class="late-message">En retard !</small>' : ''}
                    <small>
                        <span class="borrow-date">${borrowing.startDate}</span>
                         <i class="fas fa-arrow-right"></i> <span class="expected-return-date">${borrowing.expectedReturnDate}
                        </span>
                    </small>
                </div>
                <div class="d-flex w-100 justify-content-between">
                    <p class="mb-0">Emprunté par ${borrowing.borrower.firstName} ${borrowing.borrower.lastName.toUpperCase()} (Promo ${borrowing.borrower.promotion}) | Prêté par ${borrowing.initialLender.firstName} ${borrowing.initialLender.lastName.toUpperCase()} (Promo ${borrowing.initialLender.promotion})</p>
                    <small class="selection-span no-display">Sélectionné</small>
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
    if (borrowing.selected === false) {
        $(`#borrowings-list-element-${borrowing.id}`).addClass('active');
        $(`#borrowings-list-element-${borrowing.id} .selection-span`).removeClass('no-display');
        addBorrowingToSelectedBorrowingsList(borrowing);
    } else {
        $(`#borrowings-list-element-${borrowing.id}`).removeClass('active');
        $(`#borrowings-list-element-${borrowing.id} .selection-span`).addClass('no-display');
        removeBorrowingFromSelectedBorrowingsList(borrowing);
    }
    borrowing.selected = !borrowing.selected;
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

const handleReturnButtonClick = (buttonEnum) => {
    let modalTitle;
    let modalSubmitText;
    const modalSubmitButton = $(`#end-borrowing-submit`);
    let classToAddToSubmitButton;
    let classToRemoveFromSubmitButton;
    switch (buttonEnum) {
      case buttonsEnum.END:
          modalTitle = 'Confirmation de <b>retour</b> d\'emprunts';
          modalSubmitText = 'Confirmer le retour';
          classToAddToSubmitButton = 'btn-good';
          classToRemoveFromSubmitButton = 'btn-bad';
      break;
      case buttonsEnum.LOST:
          modalTitle = 'Confirmation de <b>perte</b> d\'emprunts';
          modalSubmitText = 'Confirmer la perte';
          classToAddToSubmitButton = 'btn-bad';
          classToRemoveFromSubmitButton = 'btn-good';
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
            `<li>${borrowing.inventoryItem.name} emprunté par ${borrowing.borrower.firstName} ${borrowing.borrower.lastName.toUpperCase()} (Promo ${borrowing.borrower.promotion}) le ${borrowing.startDate}</li>`
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
    const newInventoryItemsStatus = buttonEnum === buttonsEnum.END ? 0 : 3;
    const csrfTokenForm = $('#csrf-token').serializeArray();

    $('.error-text').remove();
    const postURL = buttonEnum === buttonsEnum.END ? "/end-borrowing/returned" : "/end-borrowing/lost";
    $.ajax({
        url: postURL,
        type: 'POST',
        data: {
            _token: csrfTokenForm[0].value,
            selectedBorrowings: selectedBorrowingsIDs,
            newInventoryItemsStatus: newInventoryItemsStatus
        },
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
        for (const error of errors[fieldName]) {
            $(`#form-field-${fieldName}`).append(`<div class="error-text">${error}</div>`);
        }
    }
};