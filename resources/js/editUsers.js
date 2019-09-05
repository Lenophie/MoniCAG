// Tools
import {requestTranslationFile} from './trans.js';
// Icons
import {library} from '@fortawesome/fontawesome-svg-core';
import {faChess} from '@fortawesome/free-solid-svg-icons';
// Components
import modal from './components/modal.vue';
import dataCarrier from './components/dataCarrier.vue';
import userCardButton from './components/editUsers/userCardButton.vue';

// Load icons present on page
library.add(faChess);

const setupVueComponents = () => {
    new Vue({
        el: '#app',
        data: {
            resources: {
                users: [],
                userRoles: []
            },
            flags: {
                showUserRoleUpdateModal: false,
                showUserDeletionModal: false,
            },
            userRoleUpdateRequest: {
                isProcessing: false,
                id: null,
                params: {
                    role: null,
                    password: ''
                },
                route: '',
                errors: {}
            },
            userDeletionRequest: {
                isProcessing: false,
                id: null,
                params: {
                    password: '',
                },
                route: '',
                errors: {}
            },
            baseUsersUrl: '',
            isMounted: false,
        },
        computed: {
            /**
             * Indicated whether or not a modal is currently shown
             * @returns Boolean
             */
            isAModalShown: function() {
                return this.showUserRoleUpdateModal || this.showUserDeletionModal;
            }
        },
        components: {
            modal, dataCarrier, userCardButton
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
            },
            openUserDeletionModal(user) {
                console.log(user);
                console.log('del')
            },
            openUserUpdateModal(user) {
                console.log(user);
                console.log('up')
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
