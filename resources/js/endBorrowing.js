import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

const selectedBorrowings = [];

// After page is loaded
$().ready(() => {
    console.log(borrowings);
    for (const borrowing of borrowings) borrowing.selected = false;
    addListElements(borrowings);
});

const addListElements = (borrowings) => {
    for (const borrowing of borrowings) {
        $('#borrowings-list').append(
            `<button type="button" id="#borrowings-list-element-${borrowing.id}" class="list-group-item list-group-item-action flex-column align-items-start list-group-item-${borrowing.isLate ? 'late-borrowing' : 'not-late-borrowing'}">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="borrowed-item-name mb-1">${borrowing.inventoryItem.name}</h5>
                    ${borrowing.isLate ? '<small class="late-message">En retard !</small>' : ''}
                    <small><span class="borrow-date">${borrowing.startDate}</span> <i class="fas fa-arrow-right"></i> <span class="expected-return-date">${borrowing.expectedReturnDate}</span></small>
                </div>
                <p class="mb-0">Emprunté par ${borrowing.borrower.firstName} ${borrowing.borrower.lastName.toUpperCase()} (Promo ${borrowing.borrower.promotion}) | Prêté par ${borrowing.initialLender.firstName} ${borrowing.initialLender.lastName.toUpperCase()} (Promo ${borrowing.initialLender.promotion})</p>
            </button>`
        );
    }
};
