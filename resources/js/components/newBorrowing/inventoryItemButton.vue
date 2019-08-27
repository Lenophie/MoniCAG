<template>
    <div class="column is-2">
        <a
            :id="id"
            class="button inventory-item-card-button height-100 width-100"
            :class="{'is-outlined': !isSelected, 'is-link': !isSelected, 'is-danger': isSelected}"
            type="button"
            :disabled="isDisabled"
            :tabindex="isDisabled || !tabable ? -1 : 0"
            @click="handleClick"
        >
            <inventory-item-card
                :inventory-item="inventoryItem"
                :show-duration="false"
                :show-players="false"
                :show-genres="false">
            </inventory-item-card>
        </a>
    </div>
</template>

<script>
    import InventoryItemCard from "../inventoryItemCard.vue";

    export default {
        name: "inventoryItemButton",
        components: { InventoryItemCard },
        props: {
            inventoryItem: Object,
            selectedInventoryItems: Array,
            tabable: {
                type: Boolean,
                default: true
            }
        },
        data: function () {
            return {
                isDisabled: this.inventoryItem.status.id > 2
            }
        },
        computed: {
            id: function () {
                return `inventory-item-button-${this.inventoryItem.id}`;
            },
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
