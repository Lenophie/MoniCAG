@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.perform_borrowing')}}
@endsection

@section('stylesheet')
    {{asset('css/new-borrowing.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/new-borrowing')
        @endslot
        @slot('rightIcon')
            @include('icons/new-borrowing')
        @endslot
        @slot('hasReturnButton')
            true
        @endslot
        @slot('hasCheckoutButton')
            true
        @endslot
        @slot('hasAuthBar')
            true
        @endslot
        @slot('hasLoadingSpinner')
            true
        @endslot
        @slot('checkoutButton')
            <checkout-button
                :counter="borrowingCreationRequest.params.selectedItems.length"
                @open="showModal = true"
                :tabable="!showModal"
            ></checkout-button>
        @endslot
        @slot('title')
            {{__('messages.titles.perform_borrowing')}}
        @endslot
    @endheader
    <data-carrier
        :php-data='@json($compactData)'
        @ready="setCarriedData">
    </data-carrier>
    <div class="container is-fluid" v-cloak>
        <div class="columns">
            <div class="column is-full">
                <inventory-item-search-bar
                    :inventory-items="inventoryItems"
                    :displayed-inventory-items.sync="displayedInventoryItems"
                    :tabable="!showModal">
                </inventory-item-search-bar>
            </div>
        </div>
        <div class="columns is-multiline" id="inventory-item-buttons-list">
            <div class="column is-2" v-for="inventoryItem in displayedInventoryItems">
                <inventory-item-button
                    :inventory-item="inventoryItem"
                    :selected-inventory-items="borrowingCreationRequest.params.selectedItems"
                    :tabable="!showModal"
                    :key="inventoryItem.id"
                    @selected="updateSelectedItemsList">
                </inventory-item-button>
            </div>
        </div>
    </div>
    <modal
        :title='"{{__("messages.new_borrowing.confirm_title")}}"'
        :id="'borrowing-creation-modal'"
        v-show="showModal"
        @close="closeBorrowingCreationModal"
    >
        <template v-slot:body>
            <borrowing-creation-modal-body
                :borrowing-creation-request="borrowingCreationRequest"
                :submit="requestBorrowingCreation"
                @removed-item="removeItemFromSelectedItemsList"
            ></borrowing-creation-modal-body>
        </template>
        <template v-slot:footer>
            <div class="field is-grouped is-grouped-right width-100">
                <p class="control">
                    <button
                        id="borrowing-creation-confirmation-button"
                        class="button is-link is-right"
                        :class="{'is-loading': borrowingCreationRequest.isProcessing}"
                        :disabled="borrowingCreationRequest.isProcessing"
                        @click="requestBorrowingCreation"
                    >
                        @lang('Confirm')
                    </button>
                </p>
            </div>
        </template>
    </modal>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/newBorrowing.js')}}"></script>
@endpush
