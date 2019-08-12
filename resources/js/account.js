// Tools
import {HTTPVerbs, makeAjaxRequest} from "./ajax.js";
import {requestTranslationFile, trans} from './trans.js';

// Vue components
import modal from './components/modal.vue';
import accountDeletionModalBody from './components/modalBodies/accountDeletionModalBody.vue';

const setupVueComponents = () => {
    Vue.prototype.trans = trans;

    new Vue({
        el: '#app',
        data: {
            showModal: false,
            accountDeletionRequest: {
                isProcessing: false,
                params: {
                    password: ''
                },
                route: '',
                errors: {}
            }
        },
        components: {
            modal, accountDeletionModalBody
        },
        methods: {
            /**
             * Handles a click on the account deletion confirmation button
             */
            requestAccountDeletion() {
                this.accountDeletionRequest.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.accountDeletionRequest.isProcessing = false;
                    this.accountDeletionRequest.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.DELETE,
                    this.accountDeletionRequest.route,
                    JSON.stringify(this.accountDeletionRequest.params),
                    successCallback,
                    errorCallback);
            },

            /**
             * Handles account deletion modal closing
             */
            closeAccountDeletionModal() {
                this.showModal = false;
                this.accountDeletionRequest.params.password = '';
                this.accountDeletionRequest.errors = {};
            },

            /**
             * Sets the account deletion request route
             * @param route
             */
            setAccountDeletionRequestRoute(route) {
                this.accountDeletionRequest.route = route;
            }
        }
    });
};

requestTranslationFile().then(setupVueComponents);
