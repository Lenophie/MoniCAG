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

library.add(faWarehouse, faWrench, faPlus, faArrowRight, faAngleDown);

const setupVueComponents = () => {
    new Vue({
        el: '#app',
        data: {
            resources: {
                inventoryItems: [],
                genres: [],
            },
            flags: {
                showInventoryItemCreationModal: false,
                showInventoryItemUpdateModal: false,
                showGenreCreationModal: false,
                showGenreUpdateModal: false,
                isInventoryItemCardsListMounted: false,
                isGenresListMounted: false
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
                    params: {
                        id: null,
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
                }
            }
        },
        components: {
            modal, inventoryItemModificationModalBody,genreModificationModalBody, dataCarrier, genresList, inventoryItemCardsList
        },
        computed: {
            isInventoryItemsCardsListCollapsed: function () {
                if (this.collapsibles.inventoryItemsList != null)
                    return this.collapsibles.inventoryItemsList.collapsed();
                return false
            },
            isAModalShown: function () {
                return this.flags.showInventoryItemCreationModal
                    || this.flags.showInventoryItemUpdateModal
                    || this.flags.showGenreCreationModal
                    || this.flags.showGenreUpdateModal;
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
            },
            openInventoryItemUpdateModal(inventoryItem) {
                // Set request initial parameters
                this.requests.inventoryItemUpdate.params.id = inventoryItem.id;
                this.requests.inventoryItemUpdate.params.name = inventoryItem.name;
                this.requests.inventoryItemUpdate.params.altNames = inventoryItem.altNames.map(altName => altName.name);
                this.requests.inventoryItemUpdate.params.duration.min = inventoryItem.duration.min;
                this.requests.inventoryItemUpdate.params.duration.max = inventoryItem.duration.max;
                this.requests.inventoryItemUpdate.params.players.min = inventoryItem.players.min;
                this.requests.inventoryItemUpdate.params.players.max = inventoryItem.players.max;
                this.requests.inventoryItemUpdate.params.genres = inventoryItem.genres.map(genre => genre.id);
                this.requests.inventoryItemUpdate.route = `${this.requests.inventoryItemCreation.route}/${inventoryItem.id}`;

                // Open modal
                this.flags.showInventoryItemUpdateModal = true;
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

            // Data management
            setCarriedData(data) {
                this.requests.inventoryItemCreation.route = data.routes.inventoryItems;
                this.requests.genreCreation.route = data.routes.genres;
                this.resources.genres = data.resources.genres;
                this.resources.inventoryItems = data.resources.inventoryItems;
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
                    altNames: requestParams.altNames
                }
            }
        },
        mounted() {
            this.collapsibles.inventoryItemsList = bulmaCollapsible.attach()[0];
        }
    });
};

requestTranslationFile().then(setupVueComponents);
