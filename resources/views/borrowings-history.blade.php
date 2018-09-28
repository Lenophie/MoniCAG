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
            <i class="fas fa-history menu-icon"></i>
        @endslot
        @slot('rightIcon')
            <i class="fas fa-history menu-icon"></i>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-borrowings-history">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="5" class="border-right">{{__('Borrowing')}}</th>
                            <th colspan="3">{{__('Return')}}</th>
                        </tr>
                        <tr>
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
                            <tr>
                                <td>{{$borrowing->startDate->format('d/m/Y')}}</td>
                                <td>
                                    @if($borrowing->borrower)
                                        {{$borrowing->borrower->firstName}} {{strtoupper($borrowing->borrower->lastName)}}
                                    @else
                                        <span class="deleted-user-span">Utilisateur supprimé</span>
                                    @endif
                                </td>
                                <td>{{$borrowing->inventoryItem->name}}</td>
                                <td>{{number_format($borrowing->guarantee, 2)}} €</td>
                                <td class="border-right">
                                    @if($borrowing->initialLender)
                                        {{$borrowing->initialLender->firstName}} {{strtoupper($borrowing->initialLender->lastName)}}
                                    @else
                                        <span class="deleted-user-span">Utilisateur supprimé</span>
                                    @endif
                                </td>
                                <td>{{$borrowing->expectedReturnDate->format('d/m/Y')}}</td>
                                <td>
                                    @if($borrowing->returnDate)
                                        {{$borrowing->returnDate->format('d/m/Y')}}
                                    @endif
                                </td>
                                <td>
                                    @if($borrowing->returnLender)
                                        {{$borrowing->returnLender->firstName}} {{strtoupper($borrowing->returnLender->lastName)}}
                                    @elseif($borrowing->returnDate !== null)
                                        <span class="deleted-user-span">Utilisateur supprimé</span>
                                    @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection