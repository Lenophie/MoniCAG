@extends('template')

@section('stylesheet')
    {{asset('css/index.css')}}
@endsection

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.home')}}
@endsection

@section('content')
    <div class="container is-fluid">
        @header
            @slot('leftIcon')
                <i class="fas fa-eye"></i>
            @endslot
            @slot('rightIcon')
                <i class="fas fa-dice"></i>
            @endslot
            @slot('hasReturnButton')
                false
            @endslot
            @slot('hasCheckoutButton')
                false
            @endslot
            @slot('hasAuthBar')
                true
            @endslot
            @slot('title')
                MoniCAG
            @endslot
        @endheader
        <div class="columns">
            <div class="column is-full">
                <div class="columns">
                    <h2 class="title is-3">{{__('messages.titles.borrowings_management')}}</h2>
                </div>
                <div class="columns">
                    <hr class="h2-hr">
                </div>
                <div class="columns">
                    @menubutton
                        @slot('width')
                            column is-4
                        @endslot
                        @slot('id')
                            new-borrowing-button
                        @endslot
                        @slot('style')
                            is-new-borrowing
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.perform_borrowing'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('new-borrowing')}}'
                        @endslot
                        @slot('enablerCondition')
                            {{\App\UserRole::LENDER}}
                        @endslot
                        @slot('icon')
                            @include('icons/new-borrowing')
                        @endslot
                    @endmenubutton
                    @menubutton
                        @slot('width')
                            column is-4
                        @endslot
                        @slot('id')
                            end-borrowing-button
                        @endslot
                        @slot('style')
                            is-end-borrowing
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.retrieve_borrowing'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('end-borrowing')}}'
                        @endslot
                        @slot('enablerCondition')
                            {{\App\UserRole::LENDER}}
                        @endslot
                        @slot('icon')
                            @include('icons/end-borrowing')
                        @endslot
                    @endmenubutton
                    @menubutton
                        @slot('width')
                            column is-4
                        @endslot
                        @slot('id')
                            borrowings-history-button
                        @endslot
                        @slot('style')
                            is-borrowings-history
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.view_borrowings_history'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('borrowings-history')}}'
                        @endslot
                        @slot('enablerCondition')
                            {{\App\UserRole::LENDER}}
                        @endslot
                        @slot('icon')
                            <i class="fas fa-history menu-icon"></i>
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column is-full">
                <div class="columns">
                    <h2 class="title is-3">{{__('messages.titles.inventory_management')}}</h2>
                </div>
                <div class="columns">
                    <hr class="h2-hr">
                </div>
                <div class="columns">
                    @menubutton
                        @slot('width')
                            column is-half
                        @endslot
                        @slot('id')
                            view-inventory-button
                        @endslot
                        @slot('style')
                            is-view-inventory
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.view_inventory'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('view-inventory')}}'
                        @endslot
                        @slot('enablerCondition')
                            {{\App\UserRole::NONE}}
                        @endslot
                        @slot('icon')
                            @include('icons/view-inventory')
                        @endslot
                    @endmenubutton
                    @menubutton
                        @slot('width')
                            column is-half
                        @endslot
                        @slot('id')
                            edit-inventory-button
                        @endslot
                        @slot('style')
                            is-edit-inventory
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.edit_inventory'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('edit-inventory')}}'
                        @endslot
                        @slot('enablerCondition')
                            {{\App\UserRole::ADMINISTRATOR}}
                        @endslot
                        @slot('icon')
                            @include('icons/edit-inventory')
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column is-full">
                <div class="columns">
                    <h2 class="title is-3">{{__('messages.titles.users_management')}}</h2>
                </div>
                <div class="columns">
                    <hr class="h2-hr">
                </div>
                <div class="columns">
                    @menubutton
                        @slot('width')
                            column is-full
                        @endslot
                        @slot('id')
                            edit-users-button
                        @endslot
                        @slot('style')
                            is-edit-users
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.edit_users'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('edit-users')}}'
                        @endslot
                        @slot('enablerCondition')
                            {{\App\UserRole::ADMINISTRATOR}}
                        @endslot
                        @slot('icon')
                            @include('icons/user')
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
        <hr id="footer-hr">
        <a id="french-link" href="{{ url('/lang/fr') }}"><i class="flag-icon flag-icon-fr flag-icon-squared"></i></a>
        <a id="english-link" href="{{ url('/lang/en') }}"><i class="flag-icon flag-icon-gb flag-icon-squared"></i></a>
        <a id="github-link" href="https://www.github.com/Lenophie/MoniCAG/"> {{__('messages.titles.github')}} <i class="fab fa-github"></i></a>
    </div>
@endsection