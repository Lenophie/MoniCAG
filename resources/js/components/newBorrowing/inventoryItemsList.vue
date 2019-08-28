<template>
    <div class="columns is-multiline" id="inventory-item-buttons-list">
        <inventory-item-button
            v-for="inventoryItem in inventoryItems"
            :inventory-item="inventoryItem"
            :selected-inventory-items="selectedInventoryItems"
            :tabable="tabable"
            :key="inventoryItem.id"
            @selected="bubbleUpSelectedItem">
        </inventory-item-button>
    </div>
</template>

<script>
    import inventoryItemButton from './inventoryItemButton.vue';

    export default {
        name: "inventoryItemsList",
        props: {
            inventoryItems: {
                type: Array,
                required: true
            },
            selectedInventoryItems: {
                type: Array,
                required: true,
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        components: {
            inventoryItemButton
        },
        methods: {
            bubbleUpSelectedItem(selectedItem, isSelected) {
                this.$emit('selected', selectedItem, isSelected);
            }
        }
    }
</script>
