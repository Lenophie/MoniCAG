<template>
    <a
        class="button inventory-item-card-button is-outlined height-100 width-100"
        type="button"
        :id="`inventory-item-card-button-${inventoryItem.id}`"
        :tabindex="tabable ? 0 : -1"
        @keyup.enter="handleClick"
        @click="handleClick"
    >
        <inventory-item-card
            :inventory-item="inventoryItem"
            :has-delete-button="true"
            @item-deletion-clicked="handleDeleteClick"
        ></inventory-item-card>
    </a>
</template>

<script>
    import inventoryItemCard from "../inventoryItemCard.vue";

    export default {
        name: "inventoryItemButton",
        props: {
            inventoryItem: {
                type: Object,
                required: true
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        components: { inventoryItemCard },
        methods: {
            /**
             * Handles a click on the button
             */
            handleClick: function() {
                this.$emit('item-clicked', this.inventoryItem);
            },

            /**
             * Handles a click on the inner delete button
             * @param inventoryItem
             */
            handleDeleteClick: function(inventoryItem) {
                this.$emit('item-deletion-clicked', inventoryItem);
            }
        }
    }
</script>
