@extends('template')

@section('stylesheet')
    {{asset('css/account.css')}}
@endsection

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.account')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        <i class="fas fa-user menu-icon"></i>
    @endslot
    @slot('rightIcon')
        <i class="fas fa-user menu-icon"></i>
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
    @endslot
    @slot('hasAuthBar')
        false
    @endslot
    @slot('title')
        {{__('messages.titles.account')}}
    @endslot
    @endheader
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">
                <h2 class="title is-5">{{__('Welcome')}}, {{Auth::user()->first_name}} {{Auth::user()->last_name}}.</h2>
                <div class="card" id="info-card">
                    <div class="card-content">
                        <h3 class="title is-6">{{__('My info')}}</h3>
                        <div>{{ __('Last name') }} : {{Auth::user()->last_name}}</div>
                        <div>{{ __('First name') }} : {{Auth::user()->first_name}}</div>
                        <div>{{ __('Promotion') }} : {{Auth::user()->promotion}}</div>
                        <div>{{ __('E-mail address') }} : {{Auth::user()->email}}</div>
                        <div>{{ __('Role') }} : {{Auth::user()->role->name}}</div>
                    </div>
                    <footer class="card-footer">
                        <a class="custom-hover-color card-footer-item">{{__('Modify my E-mail address')}}</a>
                        <a class="custom-hover-color card-footer-item">{{__('Modify my password')}}</a>
                        <a class="card-footer-item has-text-danger">{{__('Delete my account')}}</a>
                    </footer>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h3 class="title is-6">{{__('My ongoing borrowings')}}</h3>
                        @if (count($userBorrowings) !== 0)
                            <ul>
                            @foreach($userBorrowings as $userBorrowing)
                                <li>{{$userBorrowing->inventoryItem->name}} {{strtolower(__('Until'))}} {{$userBorrowing->expectedReturnDate->format('d/m/Y')}}</li>
                            @endforeach
                            </ul>
                        @else
                            <div id="no-borrowing-div">{{__('messages.end_borrowing.no_current')}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection