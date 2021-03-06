<template>
    <div class="field has-addons has-addons-centered">
        <div class="control is-expanded">
            <input
                type="text"
                id="search-game-field"
                class="input"
                :placeholder="trans('messages.new_borrowing.search_placeholder')"
                :tabindex="tabable ? 0 : -1"
                v-model:value="inputValue"
            >
        </div>
        <div class="control">
            <button
                class="button is-outlined is-danger height-100"
                type="button"
                id="search-game-button"
                @click="cleanSearchField"
                :tabindex="tabable ? 0 : -1"
            >
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</template>

<script>
    import Fuse from 'fuse.js';

    export default {
        name: "inventoryItemSearchBar",
        props: {
            inventoryItems: {
                type: Array,
                required: true
            },
            filteredInventoryItems: {
                type: Array,
                required: true,
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        data: function() {
            return {
                inputValue: ''
            }
        },
        watch: {
            inputValue() {
                this.applyFilter();
            },
            inventoryItems() {
                this.applyFilter();
            }
        },
        methods: {
            /**
             * Emits the filtered inventoryItems
             * If the input is empty, it emits the base inventory items
             * If the input is not empty, it calls the filtering function and emits its result
             */
            applyFilter() {
                if (this.inputValue === '') this.emitFilteredInventoryItems(this.inventoryItems);
                else this.emitFilteredInventoryItems(this.getInventoryItemsFilteredByName());
            },
            /**
             * Cleans the input of the search field
             */
            cleanSearchField() {
                this.inputValue = '';
            },
            /**
             * Filters inventory items with Fuse
             * @returns Array
             */
            getInventoryItemsFilteredByName() {
                const options = {
                    shouldSort: true,
                    tokenize: true,
                    threshold: 0.6,
                    location: 0,
                    distance: 0,
                    maxPatternLength: 32,
                    minMatchCharLength: 1,
                    keys: [
                        "name", "altNames.name"
                    ]
                };
                const fuse = new Fuse(this.inventoryItems, options);
                return fuse.search(this.inputValue);
            },
            /**
             * Emits an update of the filtered inventory items
             * @param filteredInventoryItems
             */
            emitFilteredInventoryItems(filteredInventoryItems) {
                this.$emit('update:filtered-inventory-items', filteredInventoryItems);
            }
        }
    }
</script>
