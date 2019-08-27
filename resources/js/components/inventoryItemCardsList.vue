<template>
    <div class="columns is-multiline">
        <div class="column is-2" v-for="inventoryItem in inventoryItems">
            <a
                class="button inventory-item-card-button is-outlined height-100 width-100"
                type="button"
                :tabindex="tabable ? 0 : -1"
                @click="handleClick(inventoryItem)"
            >
                <inventory-item-card :inventory-item="inventoryItem"></inventory-item-card>
            </a>
        </div>
    </div>
</template>

<script>
    import inventoryItemCard from "./inventoryItemCard.vue";

    export default {
        name: "inventoryItemCardsList",
        props: {
            inventoryItems: Array,
            tabable: {
                type: Boolean,
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
            handleClick: function(inventoryItem) {
                this.$emit('item-clicked', inventoryItem);
            }
        }
    }
</script>
