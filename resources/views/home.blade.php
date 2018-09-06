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
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                                <i class="fas fa-arrow-up" data-fa-transform="shrink-10 down-5 right-8"></i>
                            </span>
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
                        @slot('icon')
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                                <i class="fas fa-arrow-down" data-fa-transform="shrink-10 down-5 right-8"></i>
                            </span>
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
                        @slot('icon')
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
                                <i class="fas fa-eye" data-fa-transform="shrink-10 down-7 right-9"></i>
                            </span>
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
                        @slot('icon')
                             <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
                                <i class="fas fa-wrench" data-fa-transform="shrink-10 down-7 right-9"></i>
                            </span>
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
                        @slot('icon')
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-6 right-6" data-fa-mask="fas fa-users"></i>
                                <i class="fas fa-crown" data-fa-transform="shrink-10 down-6 right-6"></i>
                            </span>
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
                        @slot('icon')
                             <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-6 right-6" data-fa-mask="fas fa-users"></i>
                                <i class="fas fa-dice" data-fa-transform="shrink-10 down-6 right-6"></i>
                             </span>
                        @endslot
                    @endmenubutton
                </div>
            </div>
        </div>
    </div>
@endsection