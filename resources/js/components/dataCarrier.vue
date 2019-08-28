<template>

</template>

<script>
    export default {
        name: "dataCarrier",
        props: {
            phpData: {
                type: Object,
                required: true
            }
        },
        mounted() {
            this.$emit('ready', this.phpData)
        },
    }
</script>
