// Tools
import {HTTPVerbs, makeAjaxRequest} from './ajax.js';
import {requestTranslationFile, trans} from './trans.js';

// Components
import modal from './components/modal.vue';
import borrowingCreationModalBody from './components/modalBodies/borrowingCreationModalBody.vue';
import checkoutButton from './components/newBorrowing/checkoutButton.vue';
import inventoryItemsList from './components/newBorrowing/inventoryItemsList.vue';
import inventoryItemSearchBar from './components/newBorrowing/inventoryItemSearchBar.vue';

window.Vue = require('vue');

const setupVueComponents = () => {
    Vue.prototype.trans = trans;

    new Vue({
        el: '#app',
        data: {
            showModal: false,
            displayedInventoryItems: [],
            borrowingCreationRequest: {
                isProcessing: false,
                params: {
                    selectedItems: [],
                    borrowerEmail: '',
                    borrowerPassword: '',
                    expectedReturnDate: '',
                    guarantee: '10.00',
                    agreementCheck1: false,
                    agreementCheck2: false,
                    notes: ''
                },
                route: '',
                errors: {}
            }
        },
        components: {
            modal, borrowingCreationModalBody, checkoutButton, inventoryItemsList, inventoryItemSearchBar
        },
        methods: {
            /**
             * Handles a click on the borrowing creation confirmation button
             */
            requestBorrowingCreation() {
                this.borrowingCreationRequest.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.borrowingCreationRequest.isProcessing = false;
                    this.borrowingCreationRequest.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.POST,
                    this.borrowingCreationRequest.route,
                    JSON.stringify(this.formatRequestParams()),
                    successCallback,
                    errorCallback);
            },

            /**
             * Handles borrowing creation modal closing
             */
            closeBorrowingCreationModal() {
                this.showModal = false;
                this.borrowingCreationRequest.params.borrowerPassword = '';
                this.borrowingCreationRequest.errors = {};
            },

            /**
             * Sets the borrowing creation request route
             * @param route
             */
            setBorrowingCreationRequestRoute(route) {
                this.borrowingCreationRequest.route = route;
            },

            /**
             * Updates the selected items list
             * @param selectedItem The item to add or remove from the list
             * @param isSelected If true, the item has to be added to the list. If false, it has to be removed.
             */
            updateSelectedItemsList(selectedItem, isSelected) {
                if (isSelected) this.borrowingCreationRequest.params.selectedItems.push(selectedItem);
                else this.removeItemFromSelectedItemsList(selectedItem);
            },

            /**
             * Removes an item from the selected items list
             * @param item The item to remove from the list
             */
            removeItemFromSelectedItemsList(item) {
                for (let i = 0; i < this.borrowingCreationRequest.params.selectedItems.length; i++) {
                    if (this.borrowingCreationRequest.params.selectedItems[i].id === item.id)
                        this.borrowingCreationRequest.params.selectedItems.splice(i, 1);
                }
            },

            /**
             * Returns formatted request parameters
             * @returns {{notes: *, borrowedItems: *, expectedReturnDate: *, guarantee: *, borrowerEmail: *, agreementCheck2: *, agreementCheck1: *, borrowerPassword: *}}
             */
            formatRequestParams() {
                const requestParams = this.borrowingCreationRequest.params;
                return {
                    borrowedItems: requestParams.selectedItems.map(e => e.id),
                    borrowerEmail: requestParams.borrowerEmail,
                    borrowerPassword: requestParams.borrowerPassword,
                    expectedReturnDate: requestParams.expectedReturnDate,
                    guarantee: requestParams.guarantee,
                    agreementCheck1: requestParams.agreementCheck1,
                    agreementCheck2: requestParams.agreementCheck2,
                    notes: requestParams.notes
                }
            }
        }
    });
};

requestTranslationFile().then(setupVueComponents);
