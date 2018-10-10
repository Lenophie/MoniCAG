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
            data-toggle="modal" data-target="#new-borrowing-modal"
        @endslot
        @slot('title')
            {{__('messages.titles.perform_borrowing')}}
        @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="input-group mb-3">
                    <input type="text" id="search-game-field" class="form-control" placeholder="{{__('messages.new_borrowing.search_placeholder')}}...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-new-borrowing" id="search-game-button" type="submit"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="inventory-item-buttons-list"></div>
    </div>
    @modal
        @slot('title')
            {{__('messages.new_borrowing.confirm_title')}}
        @endslot
        @slot('body')
            <div id="form-field-borrowedItems">
                {{__('messages.new_borrowing.selected_list')}} :
                <ul id="toBorrowList"></ul>
            </div>
            <hr>
            @include('forms/new-borrowing')
        @endslot
        @slot('tags')
            id="new-borrowing-modal"
        @endslot
        @slot('footer')
            <button type="submit" class="btn btn-new-borrowing" id="new-borrowing-submit">{{__('Confirm')}}</button>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const inventoryItems = {!! json_encode($inventoryItems)!!};
        const newBorrowingUrl = {!! json_encode(url('/new-borrowing')) !!};
        const borrowingsHistoryUrl = {!! json_encode(url('/borrowings-history')) !!};
    </script>
    <script type="text/javascript" src="{{asset('js/newBorrowing.js')}}"></script>
@endpush