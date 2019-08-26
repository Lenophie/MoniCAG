// Tools
import {requestTranslationFile} from './trans.js';
import bulmaCollapsible from "@creativebulma/bulma-collapsible/dist/js/bulma-collapsible.min.js";

// Icons
import { library } from '@fortawesome/fontawesome-svg-core';
import { faWarehouse, faWrench, faPlus, faArrowRight } from '@fortawesome/free-solid-svg-icons';

// Components
import modal from './components/modal.vue';
import dataCarrier from './components/dataCarrier.vue';
import genresList from './components/editInventoryItems/genresSelectionList.vue';
import inventoryItemCreationModalBody from './components/modalBodies/inventoryItemCreationModalBody.vue';
import {HTTPVerbs, makeAjaxRequest} from "./ajax.js";

library.add(faWarehouse, faWrench, faPlus, faArrowRight);

const setupVueComponents = () => {
    new Vue({
        el: '#app',
        data: {
            genres: [],
            showInventoryItemCreationModal: false,
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
            }
        },
        components: {
            modal, inventoryItemCreationModalBody, dataCarrier, genresList
        },
        methods: {
            closeInventoryItemCreationModal() {
                this.showInventoryItemCreationModal = false;
            },
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
            setCarriedData(data) {
                this.inventoryItemCreationRequest.route = data.routes.inventoryItems;
                this.genres = data.resources.genres;
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
