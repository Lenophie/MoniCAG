<template>

</template>

<script>
    export default {
        name: "dataCarrier",
        props: {
            phpData: {
                type: Object,
                required: true,
                default: {}
            }
        },
        mounted() {
            this.$emit('ready', this.phpData)
        },
    }
</script>
