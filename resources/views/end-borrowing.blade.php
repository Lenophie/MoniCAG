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
        @slot('title')
            {{__('messages.titles.retrieve_borrowing')}}
        @endslot
    @endheader
    <meta name="messages.late" content="{{__('messages.end_borrowing.late')}}">
    <meta name="messages.borrowed_by" content="{{__('Borrowed by')}}">
    <meta name="messages.lent_by" content="{{__('Lent by')}}">
    <meta name="messages.selected_tag" content="{{__('messages.end_borrowing.selected_tag')}}">
    <meta name="messages.modal.title.returned" content="{{__('messages.end_borrowing.modal.title.returned')}}">
    <meta name="messages.modal.title.lost" content="{{__('messages.end_borrowing.modal.title.lost')}}">
    <meta name="messages.modal.button.returned" content="{{__('messages.end_borrowing.modal.button.returned')}}">
    <meta name="messages.modal.button.lost" content="{{__('messages.end_borrowing.modal.button.lost')}}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                {{__('messages.end_borrowing.declaration.content')}} :
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 text-center">
                <button class="btn btn-return-borrowing btn-outline-good" id="return-button" data-toggle="modal" data-target="#end-borrowing-modal">{{__('messages.end_borrowing.declaration.returned')}}</button>
            </div>
            <div class="col-md-6 text-center">
                <button class="btn btn-return-borrowing btn-outline-bad" id="lost-button" data-toggle="modal" data-target="#end-borrowing-modal">{{__('messages.end_borrowing.declaration.lost')}}</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group" id="borrowings-list"></ul>
                @if (count($borrowings) === 0) <div id="no-borrowing-div">{{__('messages.end_borrowing.no_current')}}</div> @endif
            </div>
        </div>
    </div>
    @modal
        @slot('title')
            Confirmation
        @endslot
        @slot('body')
            <div id="modal-body-return">
                <span id="modal-list-name">{{__('messages.end_borrowing.selected_list')}}</span>
                <ul id="to-return-list"></ul>
                <div id="form-field-selectedBorrowings"></div>
            </div>
            <form id="csrf-token">
                @csrf
                <!-- TODO : Add after notes field -->
            </form>
        @endslot
        @slot('tags')
            id="end-borrowing-modal"
        @endslot
        @slot('footer')
            <button type="submit" class="btn" id="end-borrowing-submit">Confirmer</button>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const borrowings = {!! json_encode($borrowings)!!};
        const inventoryItemStatuses = {!! json_encode($inventoryItemStatuses) !!};
        const endBorrowingUrl = {!! json_encode(url('/end-borrowing')) !!};
        const borrowingsHistoryUrl = {!! json_encode(url('/borrowings-history')) !!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/endBorrowing.js')}}"></script>
@endpush