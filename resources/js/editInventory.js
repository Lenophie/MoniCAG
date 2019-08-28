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
import inventoryItemCardsList from "./components/inventoryItemCardsList.vue";
import genreCardsList from "./components/genreCardsList.vue";
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
                isInventoryItemCardsListMounted: false,
                isGenreCardsListMounted: false
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
            inventoryItemCardsList, genreCardsList, errorField
        },
        computed: {
            isInventoryItemCardsListCollapsed: function () {
                if (this.collapsibles.inventoryItemsList != null)
                    return this.collapsibles.inventoryItemsList.collapsed();
                return false;
            },
            isGenreCardsListCollapsed: function () {
                if (this.collapsibles.genresList != null)
                    return this.collapsibles.genresList.collapsed();
                return false;
            },
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
            // Modals
            closeInventoryItemCreationModal() {
                this.flags.showInventoryItemCreationModal = false;
            },
            closeGenreCreationModal() {
                this.flags.showGenreCreationModal = false;
            },
            closeInventoryItemUpdateModal() {
                this.flags.showInventoryItemUpdateModal = false;
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
            },
            closeGenreUpdateModal() {
                this.flags.showGenreUpdateModal = false;
                this.requests.genreUpdate.originalName = '';
                this.requests.genreUpdate.params.nameFr = '';
                this.requests.genreUpdate.params.nameEn = '';
                this.requests.genreUpdate.route = '';
                this.requests.genreUpdate.errors = {};
            },
            closeInventoryItemDeletionModal() {
                this.flags.showInventoryItemDeletionModal = false;
                this.requests.inventoryItemDeletion.name = '';
                this.requests.inventoryItemDeletion.route = '';
                this.requests.inventoryItemDeletion.errors = {};
            },
            closeGenreDeletionModal() {
                this.flags.showGenreDeletionModal = false;
                this.requests.genreDeletion.name = '';
                this.requests.genreDeletion.route = '';
                this.requests.genreDeletion.errors = {};
            },
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
                this.requests.inventoryItemUpdate.params.status = inventoryItem.status;
                this.requests.inventoryItemUpdate.route = `${this.requests.inventoryItemCreation.route}/${inventoryItem.id}`;

                // Open modal
                this.flags.showInventoryItemUpdateModal = true;
            },
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
            openInventoryItemDeletionModal(inventoryItem) {
                this.requests.inventoryItemDeletion.name = inventoryItem.name;
                this.requests.inventoryItemDeletion.route =
                    `${this.requests.inventoryItemCreation.route}/${inventoryItem.id}`;

                this.flags.showInventoryItemDeletionModal = true;
            },
            openGenreDeletionModal(genre) {
                this.requests.genreDeletion.name = genre.name;
                this.requests.genreDeletion.route = `${this.requests.genreCreation.route}/${genre.id}`;

                this.flags.showGenreDeletionModal = true;
            },

            // Requests
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
            setCarriedData(data) {
                this.requests.inventoryItemCreation.route = data.routes.inventoryItems;
                this.requests.genreCreation.route = data.routes.genres;
                this.resources.genres = data.resources.genres;
                this.resources.inventoryItems = data.resources.inventoryItems;
                this.resources.inventoryItemStatuses = data.resources.inventoryItemStatuses;
            },
            /**
             * Returns formatted request parameters
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
                    statusId: requestParams.status.id,
                }
            }
        },
        mounted() {
            bulmaCollapsible.attach();
            this.collapsibles.inventoryItemsList =
                document.getElementById('inventory-item-collapsible-card').bulmaCollapsible();
            this.collapsibles.genresList =
                document.getElementById('genre-collapsible-card').bulmaCollapsible();
        }
    });
};

requestTranslationFile().then(setupVueComponents);
