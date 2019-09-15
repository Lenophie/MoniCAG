<template>
    <a
        :id="`borrowings-list-element-${borrowing.id}`"
        class="list-item"
        :class="{'has-background-bad': borrowing.isLate && !isSelected,
            'has-background-darker-bad': borrowing.isLate && isSelected,
            'has-background-good': !borrowing.isLate && !isSelected,
            'has-background-darker-good': !borrowing.isLate && isSelected,
            'is-active': isSelected}"
        :tabindex="tabable ? 0 : -1"
        @keyup.enter="handleClick"
        @click="handleClick">
        <div class="level">
            <div class="level-left">
                <h5 class="borrowed-item-name level-item">{{ borrowing.inventoryItem.name }}</h5>
            </div>
            <small class="late-message level-item" v-if="borrowing.isLate">
                {{ trans('messages.end_borrowing.late') }}
            </small>
            <div class="level-right">
                <small class="level-item">
                    <span>
                        <span class="borrow-date">{{ borrowing.startDate }}</span>
                         <i class="fas fa-arrow-right"></i>
                         <span class="expected-return-date">{{ borrowing.expectedReturnDate }}</span>
                    </span>
                </small>
            </div>
        </div>
        <div class="level">
            <div class="level-left">
                <p class="level-item">
                    {{ `${trans('Borrowed by')} ${borrowing.borrower.name} (Promo ${borrowing.borrower.promotion}) | ${trans('Lent by')} ${borrowing.initialLender.name} (Promo ${borrowing.initialLender.promotion})` }}
                </p>
            </div>
            <div class="level-right">
                <small
                    class="level-item selection-span"
                    v-show="isSelected">
                        {{ trans('messages.end_borrowing.selected_tag') }}
                </small>
            </div>
        </div>
    </a>
</template>

<script>
    export default {
        name: "borrowingsListElement",
        props: {
            borrowing: {
                type: Object,
                required: true
            },
            selectedBorrowings: {
                type: Array,
                required: true
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true
            }
        },
        computed: {
            isSelected: function() {
                for (const borrowing of this.selectedBorrowings) {
                    if (this.borrowing.id === borrowing.id) return true;
                }
                return false;
            }
        },
        methods: {
            handleClick() {
                this.$emit('selected', this.borrowing, !this.isSelected);
            }
        }
    }
</script>
