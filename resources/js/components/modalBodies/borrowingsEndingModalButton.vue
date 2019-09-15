<template>
    <button
        id="borrowings-ending-confirmation-button"
        class="button is-right"
        :class="{'is-loading': borrowingsEndingRequest.isProcessing,
            'is-link': !isDanger,
            'is-danger': isDanger}"
        :disabled="borrowingsEndingRequest.isProcessing"
        @click="handleClick"
    >
        {{ text }}
    </button>
</template>

<script>
    export default {
        name: "borrowingsEndingModalButton",
        props: {
            borrowingsEndingRequest: {
                type: Object,
                required: true
            },
            newInventoryItemsStatuses: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                messages: {
                    button: {
                        return: Vue.prototype.trans('messages.end_borrowing.modal.title.returned'),
                        lost: Vue.prototype.trans('messages.end_borrowing.modal.title.lost')
                    }
                }
            }
        },
        computed: {
            text: function() {
                if (this.borrowingsEndingRequest.params.newInventoryItemsStatus === null)
                    return 'Confirm';
                if (this.borrowingsEndingRequest.params.newInventoryItemsStatus
                    === this.newInventoryItemsStatuses.return) return this.messages.button.return;
                if (this.borrowingsEndingRequest.params.newInventoryItemsStatus
                    === this.newInventoryItemsStatuses.lost) return this.messages.button.lost;
                return 'Confirm';
            },
            isDanger: function() {
                return this.borrowingsEndingRequest.params.newInventoryItemsStatus === this.newInventoryItemsStatuses.lost;
            }
        },
        methods: {
            handleClick: function() {
                this.$emit('confirm');
            }
        }
    }
</script>

<style scoped>

</style>
