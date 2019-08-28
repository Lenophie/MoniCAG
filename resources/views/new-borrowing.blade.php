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
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-full">
                <inventory-item-search-bar
                    :inventory-items="inventoryItems"
                    :displayed-inventory-items.sync="displayedInventoryItems"
                    :tabable="!showModal">
                </inventory-item-search-bar>
            </div>
        </div>
        <inventory-items-list
            :inventory-items="displayedInventoryItems"
            :selected-inventory-items="borrowingCreationRequest.params.selectedItems"
            :tabable="!showModal"
            @selected="updateSelectedItemsList"
        ></inventory-items-list>
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
            <button
                id="borrowing-creation-confirmation-button"
                class="button is-link is-right"
                :disabled=borrowingCreationRequest.isProcessing
                @click="requestBorrowingCreation"
            >
                @lang('Confirm')
            </button>
        </template>
    </modal>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/newBorrowing.js')}}"></script>
@endpush
