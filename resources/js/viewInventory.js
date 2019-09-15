// Tools
import {requestTranslationFile} from './trans.js';
// Icons
import {library} from '@fortawesome/fontawesome-svg-core';
import {faClock, faEye, faTrophy, faUsers, faWarehouse} from '@fortawesome/free-solid-svg-icons';
// Components
import dataCarrier from './components/dataCarrier.vue';
import searchSection from "./components/viewInventory/searchSection.vue";
import inventoryItemCard from "./components/inventoryItemCard.vue";

// Load icons present on page
library.add(faWarehouse, faEye, faTrophy, faClock, faUsers);

const setupVueComponents = () => {
    new Vue({
        el: '#app',
        data: {
            inventoryItems: [],
            displayedInventoryItems: [],
            genres: [],
            isMounted: false,
        },
        components: {
            dataCarrier, searchSection, inventoryItemCard
        },
        methods: {
            /**
             * Handle the PHP compacted data
             * @param {Object} data
             */
            setCarriedData(data) {
                this.inventoryItems = data.resources.inventoryItems;
                this.genres = data.resources.genres;
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
