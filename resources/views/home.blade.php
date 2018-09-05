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
                    @include('menu-buttons.new-borrowing')
                    @include('menu-buttons.end-borrowing')
                    @include('menu-buttons.borrowings-history')
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
                    @include('menu-buttons.view-inventory')
                    @include('menu-buttons.edit-inventory')
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
                    @include('menu-buttons.admin')
                    @include('menu-buttons.lender')
                </div>
            </div>
        </div>
    </div>
@endsection