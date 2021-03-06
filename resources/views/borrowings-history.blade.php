@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.borrowings_history')}}
@endsection

@section('stylesheet')
    {{asset('css/borrowings-history.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/borrowings-history')
        @endslot
        @slot('rightIcon')
            @include('icons/borrowings-history')
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
            {{__('messages.titles.borrowings_history')}}
        @endslot
    @endheader
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">
                <table class="table is-bordered is-striped is-narrow is-fullwidth">
                    <thead>
                        <tr class="has-background-grey">
                            <th colspan="5" class="border-right">{{__('Borrowing')}}</th>
                            <th colspan="3">{{__('Return')}}</th>
                        </tr>
                        <tr class="has-background-grey-light">
                            <th scope="col">{{__('Borrowing date')}}</th>
                            <th scope="col">{{__('Borrower')}}</th>
                            <th scope="col">{{__('Game')}}</th>
                            <th scope="col">{{__('Guarantee')}}</th>
                            <th scope="col" class="border-right">{{__('Lender')}}</th>
                            <th scope="col">{{__('Expected return date')}}</th>
                            <th scope="col">{{__('Return date')}}</th>
                            <th scope="col">{{__('Validator')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $borrowing)
                            <tr id="borrowings-row-{{$borrowing["id"]}}">
                                <td class="borrowing-start-date-cell">
                                    {{$borrowing["startDate"]}}
                                </td>
                                <td class="borrowing-borrower-cell">
                                    @if($borrowing["borrower"])
                                        {{$borrowing["borrower"]["name"]}}
                                    @else
                                        <span class="deleted-user-span">{{__('messages.borrowings_history.deleted_user')}}</span>
                                    @endif
                                </td>
                                <td class="borrowing-inventory-item-cell">
                                    {{$borrowing["inventoryItem"]["name"]}}
                                </td>
                                <td class="borrowing-guarantee-cell">
                                    {{number_format($borrowing["guarantee"], 2)}} €
                                </td>
                                <td class="border-right borrowing-initial-lender-cell">
                                    @if($borrowing["initialLender"])
                                        {{$borrowing["initialLender"]["name"]}}
                                    @else
                                        <span class="deleted-user-span">{{__('messages.borrowings_history.deleted_user')}}</span>
                                    @endif
                                </td>
                                <td class="borrowing-expected-return-date-cell">
                                    {{$borrowing["expectedReturnDate"]}}
                                </td>
                                <td class="borrowing-return-date-cell">
                                    @if($borrowing["returnDate"])
                                        {{$borrowing["returnDate"]}}
                                    @endif
                                </td>
                                <td class="borrowing-return-lender-cell">
                                    @if($borrowing["returnLender"])
                                        {{$borrowing["returnLender"]["name"]}}
                                    @elseif($borrowing["returnDate"] !== null)
                                        <span class="deleted-user-span">{{__('messages.borrowings_history.deleted_user')}}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/borrowingsHistory.js')}}"></script>
@endpush
