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
    <div class="container-fluid">
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
            @slot('title')
                MoniCAG
            @endslot
        @endheader
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <h2>{{__('messages.titles.borrowings_management')}}</h2>
                </div>
                <hr class="h2-hr">
                <div class="row">
                    @menubutton
                        @slot('width')
                            col-md-4
                        @endslot
                        @slot('style')
                            btn-outline-new-borrowing
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.perform_borrowing'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('new-borrowing')}}'
                        @endslot
                        @slot('icon')
                            @include('icons/new-borrowing')
                        @endslot
                    @endmenubutton
                    @menubutton
                        @slot('width')
                            col-md-4
                        @endslot
                        @slot('style')
                            btn-outline-end-borrowing
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.retrieve_borrowing'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('end-borrowing')}}'
                        @endslot
                        @slot('icon')
                            @include('icons/end-borrowing')
                        @endslot
                    @endmenubutton
                    @menubutton
                        @slot('width')
                            col-md-4
                        @endslot
                        @slot('style')
                            btn-outline-borrowings-history
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.view_borrowings_history'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('borrowings-history')}}'
                        @endslot
                        @slot('icon')
                            <i class="fas fa-history menu-icon"></i>
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <h2>{{__('messages.titles.inventory_management')}}</h2>
                </div>
                <hr class="h2-hr">
                <div class="row">
                    @menubutton
                        @slot('width')
                            col-md-6
                        @endslot
                        @slot('style')
                            btn-outline-view-inventory
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.view_inventory'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('view-inventory')}}'
                        @endslot
                        @slot('icon')
                            @include('icons/view-inventory')
                        @endslot
                    @endmenubutton
                    @menubutton
                        @slot('width')
                            col-md-6
                        @endslot
                        @slot('style')
                            btn-outline-edit-inventory
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.edit_inventory'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('edit-inventory')}}'
                        @endslot
                        @slot('icon')
                            @include('icons/edit-inventory')
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <h2>{{__('messages.titles.users_management')}}</h2>
                </div>
                <hr class="h2-hr">
                <div class="row">
                    @menubutton
                        @slot('width')
                            col-md-12
                        @endslot
                        @slot('style')
                            btn-outline-user
                        @endslot
                        @slot('title')
                            {{mb_strtoupper(__('messages.titles.edit_users'))}}
                        @endslot
                        @slot('action')
                            location.href='{{url('user')}}'
                        @endslot
                        @slot('icon')
                            @include('icons/user')
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
        <hr id="footer-hr">
        <a id="github-link" href="https://www.github.com/Lenophie/MoniCAG/"> {{__('Checkout MoniCAG on GitHub')}} <i class="fab fa-github"></i></a>
    </div>
@endsection