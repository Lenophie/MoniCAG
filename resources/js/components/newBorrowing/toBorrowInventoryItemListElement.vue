<template>
    <li :id="id">
        {{inventoryItem.name}} <a
          class="button is-small is-danger remove-item-borrow-list-button"
          type="button"
          :id="buttonId"
          @click="handleCloseButtonClick">
            <i class="fas fa-times"></i>
        </a>
    </li>
</template>

<script>
    export default {
        name: "toBorrowInventoryItemListElement",
        props: {
            inventoryItem: Object
        },
        computed: {
            id: function () {
                return `to-borrow-list-element-${this.inventoryItem.id}`;
            },
            buttonId: function () {
                return `remove-item-borrow-list-button-${this.inventoryItem.id}`;
            }
        },
        methods: {
            handleCloseButtonClick() {
                this.$emit('removed-item', this.inventoryItem)
            }
        }
    }
</script>
