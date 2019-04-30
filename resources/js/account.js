import {HTTPVerbs, makeAjaxRequest} from "./ajax.js";

window.Vue = require('vue');
Vue.component('modal', require('./components/modal.vue').default);
Vue.component('account-deletion-modal-body', require('./components/modalBodies/accountDeletionModalBody.vue').default);

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
    methods: {
        /**
         * Handles a click on the account deletion confirmation button
         */
        requestAccountDeletion () {
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
        }
    }
});
