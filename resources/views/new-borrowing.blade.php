@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Nouvel emprunt
@endsection

@section('stylesheet')
    {{asset('css/new-borrowing.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            <span class="fa-layers fa-fw menu-icon">
                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                <i class="fas fa-arrow-up" data-fa-transform="shrink-10 down-5 right-8"></i>
            </span>
        @endslot
        @slot('rightIcon')
            <span class="fa-layers fa-fw menu-icon">
                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                <i class="fas fa-arrow-up" data-fa-transform="shrink-10 down-5 right-8"></i>
            </span>
        @endslot
        @slot('hasReturnButton')
            true
        @endslot
        @slot('title')
            Nouvel emprunt
        @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Jeu à emprunter...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-new-borrowing" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection