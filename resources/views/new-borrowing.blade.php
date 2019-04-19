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
        @slot('checkoutCounter')
            0
        @endslot
        @slot('checkoutTags')
            data-toggle="modal" data-target="new-borrowing-modal"
        @endslot
        @slot('title')
            {{__('messages.titles.perform_borrowing')}}
        @endslot
    @endheader
    <!--suppress JSUnusedLocalSymbols -->
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-full">
                <div class="field has-addons has-addons-centered">
                    <div class="control">
                        <input type="text" id="search-game-field" class="input" placeholder="{{__('messages.new_borrowing.search_placeholder')}}...">
                    </div>
                    <div class="control">
                        <a class="button is-outlined is-danger height-100" type="button" id="search-game-button">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns is-multiline" id="inventory-item-buttons-list"></div>
    </div>
    @modal
        @slot('title')
            {{__('messages.new_borrowing.confirm_title')}}
        @endslot
        @slot('body')
            <div id="form-field-borrowedItems">
                <h5 class="title is-5">{{__('messages.new_borrowing.selected_list')}} :</h5>
                <ul id="toBorrowList"></ul>
            </div>
            <hr>
            @include('forms/new-borrowing')
        @endslot
        @slot('tags')
            id="new-borrowing-modal"
        @endslot
        @slot('footer')
            <div class="field is-grouped is-grouped-right" id="new-borrowing-modal-confirm-field">
                <p class="control">
                    <a type="submit" class="button is-link" id="new-borrowing-submit">{{__('Confirm')}}</a>
                </p>
            </div>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const inventoryItems = @json($inventoryItems);
        const newBorrowingUrl = @json(url('/new-borrowing'));
        const borrowingsHistoryUrl = @json(url('/borrowings-history'));
    </script>
    <script type="text/javascript" src="{{asset('js/newBorrowing.js')}}"></script>
@endpush
