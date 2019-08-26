<template>
    <div>
        <form :action="borrowingCreationRequest.route" autocomplete="off" v-on:submit.prevent="submit">
            <!-- Borrowed items -->
            <div id="form-field-borrowedItems">
                <h5 class="title is-5">{{ trans('messages.new_borrowing.selected_list') }}</h5>
                <ul id="toBorrowList">
                    <to-borrow-inventory-item-list-element
                        v-for="inventoryItem in borrowingCreationRequest.params.selectedItems"
                        :inventory-item="inventoryItem"
                        :key="inventoryItem.id"
                        @removed-item="handleRemovalFromBorrowingList">
                    </to-borrow-inventory-item-list-element>
                </ul>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'borrowedItems'">
            </error-field>
            <hr>
            <h5 class="title is-5">{{ trans('Borrower') }}</h5>
            <!-- Borrower email -->
            <div class="field" id="form-field-borrowerEmail">
                <label class="label" for="borrowerEmail">{{ trans('E-mail address') }}</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="text"
                        id="borrowerEmail"
                        name="borrowerEmail"
                        :placeholder="trans('E-mail address')"
                        v-model="borrowingCreationRequest.params.borrowerEmail"
                        :disabled=borrowingCreationRequest.isProcessing
                        required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-at"></i>
                    </span>
                </div>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'borrowerEmail'">
            </error-field>
            <!-- Borrower password -->
            <div class="field" id="form-field-borrowerPassword">
                <label class="label" for="borrowerPassword">{{ trans('Password') }}</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="password"
                        id="borrowerPassword"
                        name="borrowerPassword"
                        :placeholder="trans('Password')"
                        v-model="borrowingCreationRequest.params.borrowerPassword"
                        :disabled=borrowingCreationRequest.isProcessing
                        required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'borrowerPassword'">
            </error-field>
            <hr>
            <h5 class="title is-5">{{ trans('Terms') }}</h5>
            <!-- Expected return date -->
            <div class="field" id="form-field-expectedReturnDate">
                <label class="label" for="expectedReturnDate">{{ trans('Expected return date') }}</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="date"
                        id="expectedReturnDate"
                        name="expectedReturnDate"
                        :placeholder="trans('Expected return date')"
                        v-model="borrowingCreationRequest.params.expectedReturnDate"
                        :disabled=borrowingCreationRequest.isProcessing
                        required>
                    <span class="icon is-small is-left">
                        <span class="fa-layers fa-fw menu-icon">
                            <i
                                class="fas fa-circle"
                                data-fa-transform="shrink-7 down-5 right-8"
                                data-fa-mask="fas fa-calendar-alt">
                            </i>
                            <i
                                class="fas fa-arrow-down"
                                data-fa-transform="shrink-9 down-5 right-8">
                            </i>
                        </span>
                    </span>
                </div>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'expectedReturnDate'">
            </error-field>
            <!-- Guarantee -->
            <div class="field" id="form-field-guarantee">
                <label class="label" for="guarantee">{{ trans('Guarantee') }}</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="text"
                        id="guarantee"
                        name="guarantee"
                        pattern="[0-9]+([.,][0-9][0-9]?)?"
                        v-model="borrowingCreationRequest.params.guarantee"
                        :disabled=borrowingCreationRequest.isProcessing
                        required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-euro-sign"></i>
                    </span>
                </div>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'guarantee'">
            </error-field>
            <!-- Notes -->
            <div class="field" id="form-field-notes">
                <label class="label" for="notes">{{ trans('Notes') }}</label>
                <div class="control">
                    <textarea
                        class="textarea"
                        id="notes" name="notes"
                        :placeholder="trans('messages.new_borrowing.notes_placeholder')"
                        v-model="borrowingCreationRequest.params.notes"
                        :disabled=borrowingCreationRequest.isProcessing
                        rows="3">
                    </textarea>
                </div>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'notes'">
            </error-field>
            <!-- Agreement check 1 -->
            <div class="form-check" id="form-field-agreementCheck1">
                <input
                    type="checkbox"
                    id="agreementCheck1"
                    name="agreementCheck1"
                    v-model="borrowingCreationRequest.params.agreementCheck1"
                    :disabled=borrowingCreationRequest.isProcessing
                    required>
                <label for="agreementCheck1">{{ trans('messages.new_borrowing.agreement_compensation') }}.</label>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'agreementCheck1'">
            </error-field>
            <!-- Agreement check 2 -->
            <div class="form-check" id="form-field-agreementCheck2">
                <input
                    type="checkbox"
                    id="agreementCheck2"
                    name="agreementCheck2"
                    v-model="borrowingCreationRequest.params.agreementCheck2"
                    :disabled=borrowingCreationRequest.isProcessing
                    required>
                <label for="agreementCheck2">{{ trans('messages.new_borrowing.agreement_reimbursement') }}.</label>
            </div>
            <error-field
                :errors-list="borrowingCreationRequest.errors"
                :field-path="'agreementCheck2'">
            </error-field>
        </form>
    </div>
</template>

<script>
    import errorField from '../errorField.vue';
    import toBorrowInventoryItemListElement from '../newBorrowing/toBorrowInventoryItemListElement.vue';

    export default {
        name: "borrowingCreationModalBody",
        props: {
            borrowingCreationRequest: Object,
            submit: Function
        },
        components: {
            errorField, toBorrowInventoryItemListElement
        },
        methods: {
            handleRemovalFromBorrowingList(inventoryItem) {
                this.$emit('removed-item', inventoryItem);
            }
        }
    }
</script>
