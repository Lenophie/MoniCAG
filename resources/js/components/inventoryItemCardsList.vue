<template>
    <div class="columns is-multiline">
        <div class="column is-2" v-for="inventoryItem in inventoryItems">
            <a
                class="button inventory-item-card-button is-outlined height-100 width-100"
                type="button"
                :tabindex="tabable ? 0 : -1"
                @keyup.enter="handleClick(inventoryItem)"
                @click="handleClick(inventoryItem)"
            >
                <inventory-item-card
                    :inventory-item="inventoryItem"
                    :has-delete-button="true"
                    @item-deletion-clicked="handleDeleteClick"
                ></inventory-item-card>
            </a>
        </div>
    </div>
</template>

<script>
    import inventoryItemCard from "./inventoryItemCard.vue";

    export default {
        name: "inventoryItemCardsList",
        props: {
            inventoryItems: {
                type: Array,
                required: true
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        components: { inventoryItemCard },
        mounted() {
            this.$nextTick(function () {
                this.$emit('mounted');
            });
        },
        methods: {
            /**
             * Handles a click on an inventory item button
             * @param inventoryItem
             */
            handleClick: function(inventoryItem) {
                this.$emit('item-clicked', inventoryItem);
            },

            /**
             * Handles a click on an inventory item button's delete button
             * @param inventoryItem
             */
            handleDeleteClick: function(inventoryItem) {
                this.$emit('item-deletion-clicked', inventoryItem);
            }
        }
    }
</script>
