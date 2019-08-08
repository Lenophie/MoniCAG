<template>
    <div class="columns is-multiline" id="inventory-item-buttons-list">
        <inventory-item-button
            v-for="inventoryItem in inventoryItems"
            :inventory-item="inventoryItem"
            :selected-inventory-items="selectedInventoryItems"
            v-bind:key="inventoryItem.id"
            @selected="bubbleUpSelectedItem">
        </inventory-item-button>
    </div>
</template>

<script>
    import inventoryItemButton from './inventoryItemButton.vue';

    export default {
        name: "inventoryItemsList",
        props: {
            inventoryItems: Array,
            selectedInventoryItems: Array
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
