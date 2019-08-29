// Tools
import {requestTranslationFile} from './trans.js';
import bulmaCollapsible from '@creativebulma/bulma-collapsible/dist/js/bulma-collapsible.min.js';
import {HTTPVerbs, makeAjaxRequest} from './ajax.js';

// Icons
import { library } from '@fortawesome/fontawesome-svg-core';
import { faWarehouse, faWrench, faPlus, faArrowRight, faAngleDown } from '@fortawesome/free-solid-svg-icons';

// Components
import modal from './components/modal.vue';
import dataCarrier from './components/dataCarrier.vue';
import genresList from './components/editInventoryItems/genresSelectionList.vue';
import inventoryItemModificationModalBody from './components/modalBodies/inventoryItemModificationModalBody.vue';
import genreModificationModalBody from "./components/modalBodies/genreModificationModalBody.vue";
import inventoryItemButton from "./components/editInventoryItems/inventoryItemButton.vue";
import genreButton from "./components/editInventoryItems/genreButton.vue";
import errorField from "./components/errorField.vue";

library.add(faWarehouse, faWrench, faPlus, faArrowRight, faAngleDown);

const setupVueComponents = () => {
    new Vue({
        el: '#app',
        data: {
            resources: {
                inventoryItems: [],
                inventoryItemStatuses: [],
                genres: [],
            },
            flags: {
                showInventoryItemCreationModal: false,
                showInventoryItemUpdateModal: false,
                showGenreCreationModal: false,
                showGenreUpdateModal: false,
                showInventoryItemDeletionModal: false,
                showGenreDeletionModal: false,
                isMounted: false, // Used by Dusk
            },
            collapsibles: {
                inventoryItemsList: null,
                genresList: null,
            },
            requests: {
                inventoryItemCreation: {
                    isProcessing: false,
                    params: {
                        name: '',
                        duration: {
                            min: null,
                            max: null
                        },
                        players: {
                            min: null,
                            max: null
                        },
                        genres: [],
                        altNames: []
                    },
                    route: '',
                    errors: {}
                },
                genreCreation: {
                    isProcessing: false,
                    params: {
                        nameFr: '',
                        nameEn: ''
                    },
                    route: '',
                    errors: {}
                },
                inventoryItemUpdate: {
                    isProcessing: false,
                    originalName: '',
                    id: null,
                    params: {
                        name: '',
                        duration: {
                            min: null,
                            max: null
                        },
                        players: {
                            min: null,
                            max: null
                        },
                        genres: [],
                        altNames: [],
                        status: null,
                    },
                    route: '',
                    errors: {}
                },
                genreUpdate: {
                    isProcessing: false,
                    originalName: '',
                    id: null,
                    params: {
                        nameFr: '',
                        nameEn: ''
                    },
                    route: '',
                    errors: {}
                },
                inventoryItemDeletion: {
                    isProcessing: false,
                    name: '',
                    route: '',
                    errors: {}
                },
                genreDeletion: {
                    isProcessing: false,
                    name:'',
                    route: '',
                    errors: {}
                }
            }
        },
        components: {
            modal, inventoryItemModificationModalBody,genreModificationModalBody, dataCarrier, genresList,
            inventoryItemButton, genreButton, errorField
        },
        computed: {
            /**
             * Indicated whether or not the inventory items list is collapsed
             * @returns Boolean
             */
            isInventoryItemsListCollapsed: function () {
                if (this.collapsibles.inventoryItemsList != null)
                    return this.collapsibles.inventoryItemsList.collapsed();
                return false;
            },
            /**
             * Indicated whether or not the genres list is collapsed
             * @returns Boolean
             */
            isGenresListCollapsed: function () {
                if (this.collapsibles.genresList != null)
                    return this.collapsibles.genresList.collapsed();
                return false;
            },
            /**
             * Indicated whether or not a modal is currently shown
             * @returns Boolean
             */
            isAModalShown: function () {
                return this.flags.showInventoryItemCreationModal
                    || this.flags.showInventoryItemUpdateModal
                    || this.flags.showInventoryItemDeletionModal
                    || this.flags.showGenreCreationModal
                    || this.flags.showGenreUpdateModal
                    || this.flags.showGenreDeletionModal;
            }
        },
        methods: {
            // Modals closing
            /**
             * Closes the inventory item creation modal
             */
            closeInventoryItemCreationModal() {
                if (!this.requests.inventoryItemCreation.isProcessing) this.flags.showInventoryItemCreationModal = false;
            },

            /**
             * Closes the genre creation modal
             */
            closeGenreCreationModal() {
                if (!this.requests.genreCreation.isProcessing) this.flags.showGenreCreationModal = false;
            },

            /**
             * Closes the inventory item update modal and resets the corresponding request parameters
             */
            closeInventoryItemUpdateModal() {
                if (!this.requests.inventoryItemUpdate.isProcessing) {
                    // Close modal
                    this.flags.showInventoryItemUpdateModal = false;

                    // Reset request parameters
                    this.requests.inventoryItemUpdate.originalName = '';
                    this.requests.inventoryItemUpdate.id = null;
                    this.requests.inventoryItemUpdate.params.name = '';
                    this.requests.inventoryItemUpdate.params.altNames = [];
                    this.requests.inventoryItemUpdate.params.duration.min = null;
                    this.requests.inventoryItemUpdate.params.duration.max = null;
                    this.requests.inventoryItemUpdate.params.players.min = null;
                    this.requests.inventoryItemUpdate.params.players.max = null;
                    this.requests.inventoryItemUpdate.params.genres = [];
                    this.requests.inventoryItemUpdate.params.status = null;
                    this.requests.inventoryItemUpdate.route = '';
                    this.requests.inventoryItemUpdate.errors = {};
                }
            },

            /**
             * Closes the genre update modal and resets the corresponding request parameters
             */
            closeGenreUpdateModal() {
                if (!this.requests.genreUpdate.isProcessing) {
                    // Close modal
                    this.flags.showGenreUpdateModal = false;

                    // Reset request parameters
                    this.requests.genreUpdate.originalName = '';
                    this.requests.genreUpdate.params.nameFr = '';
                    this.requests.genreUpdate.params.nameEn = '';
                    this.requests.genreUpdate.route = '';
                    this.requests.genreUpdate.errors = {};
                }
            },

            /**
             * Closes the inventory item deletion modal and resets the corresponding request parameters
             */
            closeInventoryItemDeletionModal() {
                if (!this.requests.inventoryItemDeletion.isProcessing) {
                    // Close modal
                    this.flags.showInventoryItemDeletionModal = false;

                    // Reset request parameters
                    this.requests.inventoryItemDeletion.name = '';
                    this.requests.inventoryItemDeletion.route = '';
                    this.requests.inventoryItemDeletion.errors = {};
                }
            },

            /**
             * Closes the genre deletion modal and resets the corresponding request parameters
             */
            closeGenreDeletionModal() {
                if (!this.requests.genreDeletion.isProcessing) {
                    // Close modal
                    this.flags.showGenreDeletionModal = false;

                    // Reset request parameters
                    this.requests.genreDeletion.name = '';
                    this.requests.genreDeletion.route = '';
                    this.requests.genreDeletion.errors = {};
                }
            },

            // Modals opening
            /**
             * Opens the inventory item update modal and sets the request initial parameters
             * @param {Object} inventoryItem
             */
            openInventoryItemUpdateModal(inventoryItem) {
                // Set request initial parameters
                this.requests.inventoryItemUpdate.originalName = inventoryItem.name;
                this.requests.inventoryItemUpdate.id = inventoryItem.id;
                this.requests.inventoryItemUpdate.params.name = inventoryItem.name;
                this.requests.inventoryItemUpdate.params.altNames = inventoryItem.altNames.map(altName => altName.name);
                this.requests.inventoryItemUpdate.params.duration.min = inventoryItem.duration.min;
                this.requests.inventoryItemUpdate.params.duration.max = inventoryItem.duration.max;
                this.requests.inventoryItemUpdate.params.players.min = inventoryItem.players.min;
                this.requests.inventoryItemUpdate.params.players.max = inventoryItem.players.max;
                this.requests.inventoryItemUpdate.params.genres = inventoryItem.genres.map(genre => genre.id);
                this.requests.inventoryItemUpdate.params.status = inventoryItem.status.id;
                this.requests.inventoryItemUpdate.route = `${this.requests.inventoryItemCreation.route}/${inventoryItem.id}`;

                // Open modal
                this.flags.showInventoryItemUpdateModal = true;
            },

            /**
             * Opens the genre update modal and sets the request initial parameters
             * @param {Object} genre
             */
            openGenreUpdateModal(genre) {
                // Set request initial parameters
                this.requests.genreUpdate.originalName = genre.name;
                this.requests.genreUpdate.id = genre.id;
                this.requests.genreUpdate.params.nameFr = genre.nameFr;
                this.requests.genreUpdate.params.nameEn = genre.nameEn;
                this.requests.genreUpdate.route = `${this.requests.genreCreation.route}/${genre.id}`;

                // Open modal
                this.flags.showGenreUpdateModal = true;
            },

            /**
             * Opens the inventory item deletion modal and sets the request initial parameters
             * @param {Object} inventoryItem
             */
            openInventoryItemDeletionModal(inventoryItem) {
                this.requests.inventoryItemDeletion.name = inventoryItem.name;
                this.requests.inventoryItemDeletion.route =
                    `${this.requests.inventoryItemCreation.route}/${inventoryItem.id}`;

                this.flags.showInventoryItemDeletionModal = true;
            },

            /**
             * Opens the genre deletion modal and sets the request initial parameters
             * @param {Object} genre
             */
            openGenreDeletionModal(genre) {
                this.requests.genreDeletion.name = genre.name;
                this.requests.genreDeletion.route = `${this.requests.genreCreation.route}/${genre.id}`;

                this.flags.showGenreDeletionModal = true;
            },

            // Requests
            /**
             * Requests the creation of an inventory item
             */
            requestInventoryItemCreation() {
                this.requests.inventoryItemCreation.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.inventoryItemCreation.isProcessing = false;
                    this.requests.inventoryItemCreation.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.POST,
                    this.requests.inventoryItemCreation.route,
                    JSON.stringify(this.formatInventoryItemCreationRequestParams()),
                    successCallback,
                    errorCallback);
            },

            /**
             * Requests the creation of a genre
             */
            requestGenreCreation() {
                this.requests.genreCreation.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.genreCreation.isProcessing = false;
                    this.requests.genreCreation.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.POST,
                    this.requests.genreCreation.route,
                    JSON.stringify(this.requests.genreCreation.params),
                    successCallback,
                    errorCallback);
            },

            /**
             * Requests the update of an inventory item
             */
            requestInventoryItemUpdate() {
                this.requests.inventoryItemUpdate.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.inventoryItemUpdate.isProcessing = false;
                    this.requests.inventoryItemUpdate.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.PATCH,
                    this.requests.inventoryItemUpdate.route,
                    JSON.stringify(this.formatInventoryItemUpdateRequestParams()),
                    successCallback,
                    errorCallback);
            },

            /**
             * Requests the update of a genre
             */
            requestGenreUpdate() {
                this.requests.genreUpdate.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.genreUpdate.isProcessing = false;
                    this.requests.genreUpdate.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.PATCH,
                    this.requests.genreUpdate.route,
                    JSON.stringify(this.requests.genreUpdate.params),
                    successCallback,
                    errorCallback);
            },

            /**
             * Requests the deletion of an inventory item
             */
            requestInventoryItemDeletion() {
                this.requests.inventoryItemDeletion.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.inventoryItemDeletion.isProcessing = false;
                    this.requests.inventoryItemDeletion.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.DELETE,
                    this.requests.inventoryItemDeletion.route,
                    JSON.stringify({}),
                    successCallback,
                    errorCallback);
            },

            /**
             * Requests the deletion of a genre
             */
            requestGenreDeletion() {
                this.requests.genreDeletion.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.requests.genreDeletion.isProcessing = false;
                    this.requests.genreDeletion.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.DELETE,
                    this.requests.genreDeletion.route,
                    JSON.stringify({}),
                    successCallback,
                    errorCallback);
            },

            // Data management
            /**
             * Handles the PHP compacted data
             * @param {Object} data
             */
            setCarriedData(data) {
                this.requests.inventoryItemCreation.route = data.routes.inventoryItems;
                this.requests.genreCreation.route = data.routes.genres;
                this.resources.genres = data.resources.genres;
                this.resources.inventoryItems = data.resources.inventoryItems;
                this.resources.inventoryItemStatuses = data.resources.inventoryItemStatuses;
            },

            /**
             * Returns formatted request parameters
             * @returns {{durationMax: *, altNames: *, genres: *, name: *, playersMin: *, playersMax: *, durationMin: *}}
             */
            formatInventoryItemCreationRequestParams() {
                const requestParams = this.requests.inventoryItemCreation.params;
                return {
                    name: requestParams.name,
                    durationMin: requestParams.duration.min,
                    durationMax: requestParams.duration.max,
                    playersMin: requestParams.players.min,
                    playersMax: requestParams.players.max,
                    genres: requestParams.genres,
                    altNames: requestParams.altNames
                }
            },
            /**
             * Returns formatted request parameters
             * @returns {{durationMax: *, altNames: *, statusId: *, genres: *, name: *, playersMin: *, id: *, playersMax: *, durationMin: *}}
             */
            formatInventoryItemUpdateRequestParams() {
                const requestParams = this.requests.inventoryItemUpdate.params;
                return {
                    id: requestParams.id,
                    name: requestParams.name,
                    durationMin: requestParams.duration.min,
                    durationMax: requestParams.duration.max,
                    playersMin: requestParams.players.min,
                    playersMax: requestParams.players.max,
                    genres: requestParams.genres,
                    altNames: requestParams.altNames,
                    statusId: requestParams.status,
                }
            }
        },
        mounted() {
            // Attach collapsible logic to collapsible elements
            bulmaCollapsible.attach();

            // Reference collapsible elements
            this.collapsibles.inventoryItemsList =
                document.getElementById('inventory-item-collapsible-card').bulmaCollapsible();
            this.collapsibles.genresList =
                document.getElementById('genre-collapsible-card').bulmaCollapsible();

            this.$nextTick(function () {
                this.flags.isMounted = true;
            });
        }
    });
};

requestTranslationFile().then(setupVueComponents);
