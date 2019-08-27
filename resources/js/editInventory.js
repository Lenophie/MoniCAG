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
            inventoryItems: [],
            genres: [],
            showInventoryItemCreationModal: false,
            showGenreCreationModal: false,
            isInventoryItemCardsListMounted: false,
            inventoryItemCreationRequest: {
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
            genreCreationRequest: {
                isProcessing: false,
                params: {
                    nameFr: '',
                    nameEn: ''
                },
                route: '',
                errors: {}
            }
        },
        components: {
            modal, inventoryItemModificationModalBody,genreModificationModalBody, dataCarrier, genresList, inventoryItemCardsList
        },
        methods: {
            // Modals
            closeInventoryItemCreationModal() {
                this.showInventoryItemCreationModal = false;
            },
            closeGenreCreationModal() {
                this.showGenreCreationModal = false;
            },

            // Requests
            requestInventoryItemCreation() {
                this.inventoryItemCreationRequest.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.inventoryItemCreationRequest.isProcessing = false;
                    this.inventoryItemCreationRequest.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.POST,
                    this.inventoryItemCreationRequest.route,
                    JSON.stringify(this.formatInventoryItemCreationRequestParams()),
                    successCallback,
                    errorCallback);
            },
            requestGenreCreation() {
                this.genreCreationRequest.isProcessing = true;

                // Prepare request callbacks
                const successCallback = () => window.location.href = '/';
                const errorCallback = (response) => {
                    this.genreCreationRequest.isProcessing = false;
                    this.genreCreationRequest.errors = JSON.parse(response).errors;
                };

                // Make deletion request
                makeAjaxRequest(
                    HTTPVerbs.POST,
                    this.genreCreationRequest.route,
                    JSON.stringify(this.genreCreationRequest.params),
                    successCallback,
                    errorCallback);
            },

            // Data management
            setCarriedData(data) {
                this.inventoryItemCreationRequest.route = data.routes.inventoryItems;
                this.genreCreationRequest.route = data.routes.genres;
                this.genres = data.resources.genres;
                this.inventoryItems = data.resources.inventoryItems;
            },
            /**
             * Returns formatted request parameters
             */
            formatInventoryItemCreationRequestParams() {
                const requestParams = this.inventoryItemCreationRequest.params;
                return {
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
            bulmaCollapsible.attach();
        }
    });
};

requestTranslationFile().then(setupVueComponents);
