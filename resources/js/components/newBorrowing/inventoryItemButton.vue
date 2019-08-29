<template>
    <a
        class="button inventory-item-card-button height-100 width-100"
        :class="{'is-outlined': !isSelected, 'is-link': !isSelected, 'is-danger': isSelected}"
        type="button"
        :id="`inventory-item-card-button-${inventoryItem.id}`"
        :disabled="isDisabled"
        :tabindex="isDisabled || !tabable ? -1 : 0"
        @keyup.enter="handleClick"
        @click="handleClick"
    >
        <inventory-item-card
            :inventory-item="inventoryItem"
            :show-duration="false"
            :show-players="false"
            :show-genres="false">
        </inventory-item-card>
    </a>
</template>

<script>
    import InventoryItemCard from "../inventoryItemCard.vue";

    export default {
        name: "inventoryItemButton",
        components: { InventoryItemCard },
        props: {
            inventoryItem: {
                type: Object,
                required: true,
            },
            selectedInventoryItems: {
                type: Array,
                required: true
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        data: function () {
            return {
                isDisabled: this.inventoryItem.status.id > 2
            }
        },
        computed: {
            isSelected: function () {
                for (const inventoryItem of this.selectedInventoryItems) {
                    if (this.inventoryItem.id === inventoryItem.id) return true;
                }
                return false;
            }
        },
        methods: {
            handleClick() {
                if (!this.isDisabled) this.$emit('selected', this.inventoryItem, !this.isSelected);
            }
        }
    }
</script>
