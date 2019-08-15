<script>
    export default {
        name: "dataCarrier",
        props: {
            phpData: Object
        },
        mounted() {
            this.$emit('ready', this.phpData)
        },
    }
</script>
