@extends('template')

@section('stylesheet')
    {{asset('css/index.css')}}
@endsection

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12" id="title-div">
                <h1><i class="fas fa-eye"></i> MoniCAG <i class="fas fa-dice"></i></h1>
                <hr class="h1-hr">
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <h2>Gestion des emprunts</h2>
                </div>
                <hr class="h2-hr">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-3">
                        <button class="btn btn-block btn-outline-new-borrowing menu-button">
                            <span class="menu-text">RÉALISER UN EMPRUNT</span>
                            <br>
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                                <i class="fas fa-arrow-up" data-fa-transform="shrink-10 down-5 right-8"></i>
                            </span>
                        </button>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-3">
                        <button class="btn btn-block btn-outline-end-borrowing menu-button">
                            <span class="menu-text">RÉCUPÉRER UN EMPRUNT</span>
                            <br>
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                                <i class="fas fa-arrow-down" data-fa-transform="shrink-10 down-5 right-8"></i>
                            </span>
                        </button>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-3">
                        <button class="btn btn-block btn-outline-borrowings-history menu-button">
                            <span class="menu-text">VOIR L'HISTORIQUE DES EMPRUNTS</span>
                            <br>
                            <i class="fas fa-history menu-icon"></i>
                        </button>
                    </div>
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
                    <div class="col-md-6 mb-3 mb-md-3">
                        <button class="btn btn-block btn-outline-view-inventory menu-button">
                            <span class="menu-text">VOIR L'INVENTAIRE</span>
                            <br>
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
                                <i class="fas fa-eye" data-fa-transform="shrink-10 down-7 right-9"></i>
                            </span>
                        </button>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-3">
                        <button class="btn btn-block btn-outline-edit-inventory menu-button">
                            <span class="menu-text">GÉRER L'INVENTAIRE</span>
                            <br>
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
                                <i class="fas fa-wrench" data-fa-transform="shrink-10 down-7 right-9"></i>
                            </span>
                        </button>
                    </div>
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
                    <div class="col-md-6 mb-3 mb-md-3">
                        <button class="btn btn-block btn-outline-admin menu-button">
                            <span class="menu-text">GÉRER LES ADMINISTRATEURS</span>
                            <br>
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-6 right-6" data-fa-mask="fas fa-users"></i>
                                <i class="fas fa-crown" data-fa-transform="shrink-10 down-6 right-6"></i>
                            </span>
                        </button>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-3">
                        <button class="btn btn-block btn-outline-lender menu-button">
                            <span class="menu-text">GÉRER LES PRÊTEURS</span>
                            <br>
                            <span class="fa-layers fa-fw menu-icon">
                                <i class="fas fa-circle" data-fa-transform="shrink-7 down-6 right-6" data-fa-mask="fas fa-users"></i>
                                <i class="fas fa-dice" data-fa-transform="shrink-10 down-6 right-6"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection