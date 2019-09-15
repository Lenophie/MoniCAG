<template>
    <div class="columns">
        <div class="column is-12 search-section">
            <div class="columns no-mb">
                <div class="column is-8 is-offset-2">
                    <inventory-item-search-bar
                        :inventory-items="inventoryItems"
                        :filtered-inventory-items.sync="filteredByNameInventoryItems"
                        :tabable="true"
                    >
                    </inventory-item-search-bar>
                </div>
            </div>
            <hr id="search-hr">
            <div class="columns">
                <div class="column is-4">
                    <div class="field has-addons has-addons-centered">
                        <div class="control">
                            <button class="button is-static height-100">
                                <i class="fas fa-trophy"></i>
                            </button>
                        </div>
                        <div class="control is-expanded">
                            <div class="select is-fullwidth">
                                <select id="genre-select" v-model="selectedGenre">
                                    <option :value="null" selected>{{ trans("messages.view_inventory.filter_genre_placeholder") }}</option>
                                    <option v-for="genre in genres" :value="genre">{{ genre.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="control">
                            <button class="button is-outlined is-view-inventory height-100" type="button" id="cancel-genre-filtering-button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field has-addons has-addons-centered">
                        <div class="control">
                            <button class="button is-static height-100">
                                <i class="fas fa-clock"></i>
                            </button>
                        </div>
                        <div class="control is-expanded">
                            <input
                                id="duration-input"
                                type="number"
                                min="0"
                                class="input"
                                v-model.number="selectedDuration"
                                :placeholder="trans('messages.view_inventory.filter_duration_placeholder')"
                            >
                        </div>
                        <div class="control">
                            <button class="button is-outlined is-view-inventory height-100" type="button" id="cancel-duration-filtering-button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field has-addons has-addons-centered">
                        <div class="control">
                            <button class="button is-static height-100">
                                <i class="fas fa-users"></i>
                            </button>
                        </div>
                        <div class="control is-expanded">
                            <input
                                id="players-input"
                                type="number"
                                min="1"
                                class="input"
                                v-model.number="selectedNumberOfPlayers"
                                :placeholder="trans('messages.view_inventory.filter_players_placeholder')">
                        </div>
                        <div class="control">
                            <button class="button is-outlined is-view-inventory height-100" type="button" id="cancel-players-filtering-button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import inventoryItemSearchBar from "../newBorrowing/inventoryItemSearchBar.vue";

    export default {
        name: "searchSection",
        props: {
            inventoryItems: {
                type: Array,
                required: true
            },
            genres: {
                type: Array,
                required: true
            },
            filteredInventoryItems: {
                type: Array,
                required: true,
            }
        },
        data: function() {
            return {
                filteredByNameInventoryItems: [],
                selectedGenre: null,
                selectedNumberOfPlayers: null,
                selectedDuration: null
            }
        },
        watch: {
            filteredByNameInventoryItems() {
               this.applySearchFilters();
            },
            selectedGenre() {
                this.applySearchFilters();
            },
            selectedNumberOfPlayers(newValue) {
                if (newValue === '') this.selectedNumberOfPlayers = null;
                else this.applySearchFilters();
            },
            selectedDuration(newValue) {
                if (newValue === '') this.selectedDuration = null;
                else this.applySearchFilters();
            }
        },
        methods: {
            applySearchFilters() {
                let filteredItems = Vue.util.extend([], this.filteredByNameInventoryItems);
                if (this.selectedGenre != null) {
                    filteredItems = filteredItems.filter(
                        item => item.genres.findIndex(
                            genre => genre.id === this.selectedGenre.id
                        ) > -1);
                }
                if (this.selectedNumberOfPlayers != null) {
                    filteredItems = filteredItems.filter(
                        item => (item.players.min === null || item.players.min <= this.selectedNumberOfPlayers)
                            && (item.players.max === null || item.players.max >= this.selectedNumberOfPlayers)
                    );
                }
                if (this.selectedDuration != null) {
                    filteredItems = filteredItems.filter(
                        item => (item.duration.min === null || item.duration.min <= this.selectedDuration)
                            && (item.duration.max === null || item.duration.max >= this.selectedDuration)
                    );
                }
                this.emitFilteredInventoryItems(filteredItems);
            },
            /**
             * Emits an update of the filtered inventory items
             * @param filteredInventoryItems
             */
            emitFilteredInventoryItems(filteredInventoryItems) {
                this.$emit('update:filtered-inventory-items', filteredInventoryItems);
            }
        },
        components: {
            inventoryItemSearchBar
        }
    }
</script>
