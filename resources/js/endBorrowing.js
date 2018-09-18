import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

const selectedBorrowings = [];

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
    console.log(selectedBorrowings);
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