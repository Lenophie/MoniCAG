<template>
    <div class="column is-2">
        <a
            :id="id"
            class="button is-link inventory-item-button"
            :class="{'is-outlined': !isSelected}"
            type="button"
            :disabled="isDisabled"
            :tabindex="isDisabled || !tabable ? -1 : 0"
            @click="handleClick"
        >
            <div class="inventory-item-button-content">
                {{inventoryItem.name}}
                <hr class="in-button-hr">
                <div class="inventory-item-button-footer">
                    {{inventoryItem.status.name}}
                </div>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        name: "inventoryItemButton",
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
