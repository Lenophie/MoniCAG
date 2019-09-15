// Tools
import {HTTPVerbs, makeAjaxRequest} from './ajax.js';
import {requestTranslationFile} from './trans.js';
// Icons
import {library} from '@fortawesome/fontawesome-svg-core';
import {faArrowRight, faDice} from '@fortawesome/free-solid-svg-icons';
// Components
import modal from './components/modal.vue';
import dataCarrier from './components/dataCarrier.vue';
import borrowingsEndingModalBody from './components/modalBodies/borrowingsEndingModalBody.vue';
import borrowingsEndingModalButton from "./components/modalBodies/borrowingsEndingModalButton.vue";
import borrowingsListElement from "./components/endBorrowing/borrowingsListElement.vue";

library.add(faDice, faArrowRight);

const setupVueComponents = () => {
    new Vue({
        el: '#app',
        data: {
            showModal: false,
            borrowings: [],
            newInventoryItemsStatuses: {},
            borrowingsEndingRequest: {
                isProcessing: false,
                params: {
                    selectedBorrowings: [],
                    newInventoryItemsStatus: null,
                },
                route: '',
                errors: {}
            },
            messages: {
                modalTitle: {
                    return: Vue.prototype.trans('messages.end_borrowing.modal.title.returned'),
                    lost: Vue.prototype.trans('messages.end_borrowing.modal.title.lost')
                }
            },
            isMounted: false,
        },
        components: {
            modal, dataCarrier, borrowingsEndingModalBody, borrowingsEndingModalButton, borrowingsListElement
        },
        computed: {
            modalTitle: function() {
                if (this.borrowingsEndingRequest.params.newInventoryItemsStatus === null)
                    return 'Confirmation';
                if (this.borrowingsEndingRequest.params.newInventoryItemsStatus
                    === this.newInventoryItemsStatuses.return) return this.messages.modalTitle.return;
                if (this.borrowingsEndingRequest.params.newInventoryItemsStatus
                    === this.newInventoryItemsStatuses.lost) return this.messages.modalTitle.lost;
                return 'Confirmation';
            },
        },
        methods: {
            /**
             * Handles a click on the borrowings ending confirmation button
             */
            requestBorrowingsEnding() {
                this.borrowingsEndingRequest.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/borrowings-history';
                const errorCallback = (response) => {
                    this.borrowingsEndingRequest.isProcessing = false;
                    this.borrowingsEndingRequest.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.PATCH,
                    this.borrowingsEndingRequest.route,
                    JSON.stringify(this.formatRequestParams()),
                    successCallback,
                    errorCallback);
            },

            /**
             * Handles borrowings ending modal closing
             */
            closeBorrowingsEndingModal() {
                if (!this.borrowingsEndingRequest.isProcessing) {
                    this.showModal = false;
                    this.borrowingsEndingRequest.params.newInventoryItemsStatus = null;
                    this.borrowingsEndingRequest.errors = {};
                }
            },

            /**
             * Handles borrowings opening modal in return mode
             */
            openBorrowingsEndingModalAsReturned() {
                this.showModal = true;
                this.borrowingsEndingRequest.params.newInventoryItemsStatus = this.newInventoryItemsStatuses.return;
            },

            /**
             * Handles borrowings opening modal in lost mode
             */
            openBorrowingsEndingModalAsLost() {
                this.showModal = true;
                this.borrowingsEndingRequest.params.newInventoryItemsStatus = this.newInventoryItemsStatuses.lost;
            },

            /**
             * Updates the selected borrowings list
             * @param {Object} selectedBorrowing The borrowing to add or remove from the list
             * @param {boolean} isSelected If true, the item has to be added to the list. If false, it has to be removed.
             */
            updateSelectedBorrowingsList(selectedBorrowing, isSelected) {
                if (isSelected) this.borrowingsEndingRequest.params.selectedBorrowings.push(selectedBorrowing);
                else this.removeBorrowingFromSelectedBorrowingsList(selectedBorrowing);
            },

            /**
             * Removes a borrowing from the selected borrowings list
             * @param {Object} borrowing The borrowing to remove from the list
             */
            removeBorrowingFromSelectedBorrowingsList(borrowing) {
                for (let i = 0; i < this.borrowingsEndingRequest.params.selectedBorrowings.length; i++) {
                    if (this.borrowingsEndingRequest.params.selectedBorrowings[i].id === borrowing.id)
                        this.borrowingsEndingRequest.params.selectedBorrowings.splice(i, 1);
                }
            },

            /**
             * Returns formatted request parameters
             */
            formatRequestParams() {
                const requestParams = this.borrowingsEndingRequest.params;
                return {
                    newInventoryItemsStatus: requestParams.newInventoryItemsStatus,
                    selectedBorrowings: requestParams.selectedBorrowings.map(borrowing => borrowing.id),
                }
            },

            /**
             * Handle the PHP compacted data
             * @param {Object} data
             */
            setCarriedData(data) {
                this.borrowingsEndingRequest.route = data.routes.borrowings;
                this.borrowings = data.resources.borrowings;
                this.newInventoryItemsStatuses = data.resources.newInventoryItemsStatuses;
            }
        },
        mounted() {
            this.$nextTick(function () {
                this.isMounted = true;
            });
        }
    });
};

requestTranslationFile().then(setupVueComponents);
