@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.retrieve_borrowing')}}
@endsection

@section('stylesheet')
    {{asset('css/end-borrowing.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/end-borrowing')
        @endslot
        @slot('rightIcon')
            @include('icons/end-borrowing')
        @endslot
        @slot('hasReturnButton')
            true
        @endslot
        @slot('hasCheckoutButton')
            false
        @endslot
        @slot('hasAuthBar')
            true
        @endslot
        @slot('hasLoadingSpinner')
            true
        @endslot
        @slot('title')
            {{__('messages.titles.retrieve_borrowing')}}
        @endslot
    @endheader
    <data-carrier
        :php-data='@json($compactData)'
        @ready="setCarriedData">
    </data-carrier>
    <div class="container is-fluid" v-cloak>
        <div class="columns">
            <div class="column is-full">
                {{__('messages.end_borrowing.declaration.content')}} :
            </div>
        </div>
        <div class="columns">
            <div class="column is-half">
                <button
                    class="button is-success end-button"
                    id="return-button"
                    :disabled="borrowingsEndingRequest.params.selectedBorrowings.length === 0"
                    @click="openBorrowingsEndingModalAsReturned">
                        {{__('messages.end_borrowing.declaration.returned')}}
                </button>
            </div>
            <div class="column is-half">
                <button
                    class="button is-danger end-button"
                    id="lost-button"
                    :disabled="borrowingsEndingRequest.params.selectedBorrowings.length === 0"
                    @click="openBorrowingsEndingModalAsLost">
                        {{__('messages.end_borrowing.declaration.lost')}}
                </button>
            </div>
        </div>
        <div class="columns">
            <div class="column is-full">
                <ul id="borrowings-list" class="list is-hoverable">
                    <borrowings-list-element
                        v-for="borrowing in borrowings"
                        :key="borrowing.id"
                        :borrowing="borrowing"
                        :selected-borrowings="borrowingsEndingRequest.params.selectedBorrowings"
                        :tabable="!showModal"
                        @selected="updateSelectedBorrowingsList"
                    >
                    </borrowings-list-element>
                </ul>
                <div id="no-borrowing-div" v-if="borrowings.length === 0">
                    {{__('messages.end_borrowing.no_current')}}
                </div>
            </div>
        </div>
    </div>
    <modal
        :title="modalTitle"
        :id="'borrowings-ending-modal'"
        v-show="showModal"
        @close="closeBorrowingsEndingModal"
    >
        <template v-slot:body>
            <borrowings-ending-modal-body
                :borrowings-ending-request="borrowingsEndingRequest"
            ></borrowings-ending-modal-body>
        </template>
        <template v-slot:footer>
            <div class="field is-grouped is-grouped-right width-100">
                <p class="control">
                    <borrowings-ending-modal-button
                        :borrowings-ending-request="borrowingsEndingRequest"
                        :new-inventory-items-statuses="newInventoryItemsStatuses"
                        @confirm="requestBorrowingsEnding">
                    </borrowings-ending-modal-button>
                </p>
            </div>
        </template>
    </modal>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/endBorrowing.js')}}"></script>
@endpush
