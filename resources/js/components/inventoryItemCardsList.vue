<template>
    <div class="columns is-multiline">
        <div class="column is-2" v-for="inventoryItem in inventoryItems">
            <inventory-item-card :inventory-item="inventoryItem"></inventory-item-card>
        </div>
    </div>
</template>

<script>
    import inventoryItemCard from "./inventoryItemCard.vue";

    export default {
        name: "inventoryItemCardsList",
        props: {
            inventoryItems: Array
        },
        components: { inventoryItemCard },
        mounted() {
            this.$nextTick(function () {
                this.$emit('mounted');
            });
        }
    }
</script>
