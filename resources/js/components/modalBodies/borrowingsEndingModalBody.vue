<template>
    <div id="modal-body-return">
        <span id="modal-list-name">{{ trans('messages.end_borrowing.selected_list') }}</span>
        <ul id="to-return-list">
            <li v-for="borrowing in borrowingsEndingRequest.params.selectedBorrowings">
                {{`${borrowing.inventoryItem.name} ${trans('Borrowed by').toLowerCase()} ${borrowing.borrower.name} (Promo ${borrowing.borrower.promotion}) : ${borrowing.startDate}`}}
            </li>
        </ul>
        <error-field
            :errors-list="borrowingsEndingRequest.errors"
            :field-path="'selectedBorrowings'">
        </error-field>
    </div>
</template>

<script>
    import errorField from "../errorField.vue";

    export default {
        name: "borrowingsEndingModalBody",
        props: {
            borrowingsEndingRequest: {
                type: Object,
                required: true
            }
        },
        components: {
            errorField
        }
    }
</script>
