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
    <!-- suppress JSUnusedLocalSymbols -->
    <meta name="messages.late" content="{{__('messages.end_borrowing.late')}}">
    <meta name="messages.borrowed_by" content="{{__('Borrowed by')}}">
    <meta name="messages.lent_by" content="{{__('Lent by')}}">
    <meta name="messages.selected_tag" content="{{__('messages.end_borrowing.selected_tag')}}">
    <meta name="messages.modal.title.returned" content="{{__('messages.end_borrowing.modal.title.returned')}}">
    <meta name="messages.modal.title.lost" content="{{__('messages.end_borrowing.modal.title.lost')}}">
    <meta name="messages.modal.button.returned" content="{{__('messages.end_borrowing.modal.button.returned')}}">
    <meta name="messages.modal.button.lost" content="{{__('messages.end_borrowing.modal.button.lost')}}">
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-full">
                {{__('messages.end_borrowing.declaration.content')}} :
            </div>
        </div>
        <div class="columns">
            <div class="column is-half">
                <button class="button is-success end-button" id="return-button" data-toggle="modal" data-target="end-borrowing-modal" disabled="disabled">{{__('messages.end_borrowing.declaration.returned')}}</button>
            </div>
            <div class="column is-half">
                <button class="button is-danger end-button" id="lost-button" data-toggle="modal" data-target="end-borrowing-modal" disabled="disabled">{{__('messages.end_borrowing.declaration.lost')}}</button>
            </div>
        </div>
        <div class="columns">
            <div class="column is-full">
                <ul id="borrowings-list" class="list is-hoverable"></ul>
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
        @endslot
        @slot('tags')
            id="end-borrowing-modal"
        @endslot
        @slot('footer')
            <div class="field is-grouped is-grouped-right width-100">
                <p class="control">
                    <a type="submit" class="button" id="end-borrowing-submit">{{__('Confirm')}}</a>
                </p>
            </div>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const borrowings = @json($borrowings);
        const inventoryItemStatuses = @json($inventoryItemStatuses);
        const borrowingsApiUrl = @json(route('borrowings.index'));
        const borrowingsHistoryUrl = @json(url('/borrowings-history'));
    </script>
    <script type="text/javascript" src="{{mix('js/endBorrowing.js')}}"></script>
@endpush
