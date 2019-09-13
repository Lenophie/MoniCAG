// Tools
import {requestTranslationFile} from './trans.js';
// Icons
import {library} from '@fortawesome/fontawesome-svg-core';
import {faChess} from '@fortawesome/free-solid-svg-icons';
// Components
import modal from './components/modal.vue';
import userDeletionModalBody from './components/modalBodies/userDeletionModalBody.vue';
import userRoleUpdateModalBody from "./components/modalBodies/userRoleUpdateModalBody.vue";
import dataCarrier from './components/dataCarrier.vue';
import userCardButton from './components/editUsers/userCardButton.vue';
import {HTTPVerbs, makeAjaxRequest} from "./ajax.js";

// Load icons present on page
library.add(faChess);

const setupVueComponents = () => {
    new Vue({
        el: '#app',
        data: {
            resources: {
                users: [],
                userRoles: [],
                loggedUserId: null,
            },
            flags: {
                showUserRoleUpdateModal: false,
                showUserDeletionModal: false,
                isMounted: false,
            },
            requests: {
                userRoleUpdate: {
                    isProcessing: false,
                    user: null,
                    params: {
                        role: null,
                        password: ''
                    },
                    route: '',
                    errors: {}
                },
                userDeletion: {
                    isProcessing: false,
                    user: null,
                    params: {
                        password: '',
                    },
                    route: '',
                    errors: {}
                },
            },
            baseUsersUrl: '',
        },
        computed: {
            /**
             * Indicated whether or not a modal is currently shown
             * @returns Boolean
             */
            isAModalShown: function() {
                return this.flags.showUserRoleUpdateModal || this.flags.showUserDeletionModal;
            },
            userDeletionModalTitle: function() {
                let title = this.trans('messages.edit_users.delete_user');
                if (this.requests.userDeletion.user != null)
                    title += ` : ${this.requests.userDeletion.user.firstName} ${this.requests.userDeletion.user.lastName}`;
                return title;
            },
            userRoleUpdateModalTitle: function () {
                let title = this.trans('messages.edit_users.change_role');
                if (this.requests.userRoleUpdate.user != null)
                    title += ` : ${this.requests.userRoleUpdate.user.firstName} ${this.requests.userRoleUpdate.user.lastName}`;
                return title;
            }
        },
        components: {
            modal, dataCarrier, userCardButton, userDeletionModalBody, userRoleUpdateModalBody
        },
        methods: {
            /**
             * Handle the PHP compacted data
             * @param {Object} data
             */
            setCarriedData(data) {
                this.baseUsersUrl = data.routes.users;
                this.resources.users = data.resources.users;
                this.resources.userRoles = data.resources.userRoles;
                this.resources.loggedUserId = data.resources.loggedUserId;
            },
            openUserDeletionModal(user) {
                this.requests.userDeletion.user = user;
                this.requests.userDeletion.route = `${this.baseUsersUrl}/${user.id}`;

                this.flags.showUserDeletionModal = true;
            },
            openUserRoleUpdateModal(user) {
                this.requests.userRoleUpdate.user = user;
                this.requests.userRoleUpdate.route = `${this.baseUsersUrl}/${user.id}/role`;
                this.requests.userRoleUpdate.params.role = user.role;

                this.flags.showUserRoleUpdateModal = true;
            },
            closeUserDeletionModal() {
                if (!this.requests.userDeletion.isProcessing) {
                    this.flags.showUserDeletionModal = false;

                    this.requests.userDeletion.user = null;
                    this.requests.userDeletion.route = '';
                    this.requests.userDeletion.errors = {};
                    this.requests.userDeletion.params.password = '';
                }
            },
            closeUserRoleUpdateModal() {
                if (!this.requests.userRoleUpdate.isProcessing) {
                    this.flags.showUserRoleUpdateModal = false;

                    this.requests.userRoleUpdate.user = null;
                    this.requests.userRoleUpdate.route = '';
                    this.requests.userRoleUpdate.errors = {};
                    this.requests.userRoleUpdate.params.role = null;
                    this.requests.userRoleUpdate.params.password = '';
                }
            },
            requestUserRoleUpdate() {
                this.requests.userRoleUpdate.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.userRoleUpdate.isProcessing = false;
                    this.requests.userRoleUpdate.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.PATCH,
                    this.requests.userRoleUpdate.route,
                    JSON.stringify(this.formatUserRoleUpdateRequestParams()),
                    successCallback,
                    errorCallback);
            },
            requestUserDeletion() {
                this.requests.userDeletion.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.userDeletion.isProcessing = false;
                    this.requests.userDeletion.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.DELETE,
                    this.requests.userDeletion.route,
                    JSON.stringify(this.requests.userDeletion.params),
                    successCallback,
                    errorCallback);
            },
            formatUserRoleUpdateRequestParams() {
                return {
                    role: this.requests.userRoleUpdate.params.role.id,
                    password: this.requests.userRoleUpdate.params.password,
                }
            }
        },
        mounted() {
            this.$nextTick(function () {
                this.flags.isMounted = true;
            });
        }
    });
};

requestTranslationFile().then(setupVueComponents);
