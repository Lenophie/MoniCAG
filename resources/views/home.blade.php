@extends('template')

@section('stylesheet')
    {{asset('css/index.css')}}
@endsection

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Home
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
                    <h2>Gestion des emprunts</h2>
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
                            RÉALISER UN EMPRUNT
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
                            RÉCUPÉRER UN EMPRUNT
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
                            VOIR L'HISTORIQUE DES EMPRUNTS
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
                    <h2>Gestion de l'inventaire</h2>
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
                            VOIR L'INVENTAIRE
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
                            GÉRER L'INVENTAIRE
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
                    <h2>Gestion des utilisateurs</h2>
                </div>
                <hr class="h2-hr">
                <div class="row">
                    @menubutton
                        @slot('width')
                            col-md-6
                        @endslot
                        @slot('style')
                            btn-outline-admin
                        @endslot
                        @slot('title')
                            GÉRER LES ADMINISTRATEURS
                        @endslot
                        @slot('action')
                            location.href='{{url('admin')}}'
                        @endslot
                        @slot('icon')
                            @include('icons/admin')
                        @endslot
                    @endmenubutton
                    @menubutton
                        @slot('width')
                            col-md-6
                        @endslot
                        @slot('style')
                            btn-outline-lender
                        @endslot
                        @slot('title')
                            GÉRER LES PRÊTEURS
                        @endslot
                        @slot('action')
                            location.href='{{url('lender')}}'
                        @endslot
                        @slot('icon')
                             @include('icons/lender')
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
    </div>
@endsection