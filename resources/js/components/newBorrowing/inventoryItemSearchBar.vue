<template>
    <div class="field has-addons has-addons-centered">
        <div class="control">
            <input
                type="text"
                id="search-game-field"
                class="input"
                :placeholder="trans('messages.new_borrowing.search_placeholder')"
                v-model:value="inputValue"
            >
        </div>
        <div class="control">
            <button
                class="button is-outlined is-danger height-100"
                type="button"
                id="search-game-button"
                @click="cleanSearchField"
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
            inventoryItems: Array,
            displayedInventoryItems: Array
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
                if (this.inputValue === '') this.emitDisplayedInventoryItems(this.inventoryItems);
                else this.emitDisplayedInventoryItems(this.getInventoryItemsFilteredByName());
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
                        "name"
                    ]
                };
                const fuse = new Fuse(this.inventoryItems, options);
                return fuse.search(this.inputValue);
            },
            /**
             * Emits an update of the inventory items to display
             * @param displayedInventoryItems
             */
            emitDisplayedInventoryItems(displayedInventoryItems) {
                this.$emit('update:displayed-inventory-items', displayedInventoryItems);
            }
        }
    }
</script>
