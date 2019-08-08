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
            <a
                class="button is-outlined is-danger height-100"
                type="button"
                id="search-game-button"
                @click="cleanSearchField"
            >
                <i class="fas fa-times"></i>
            </a>
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
            inputValue(newValue) {
                if (newValue === '') this.resetDisplayedInventoryItems();
                else this.$emit('update:displayed-inventory-items', this.getInventoryItemsFilteredByName());
            }
        },
        mounted() {
            this.resetDisplayedInventoryItems();
        },
        methods: {
            cleanSearchField() {
                this.inputValue = '';
            },
            resetDisplayedInventoryItems() {
                this.$emit('update:displayed-inventory-items', this.inventoryItems);
            },
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
            }
        }
    }
</script>
