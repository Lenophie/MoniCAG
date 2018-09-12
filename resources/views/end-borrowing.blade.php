@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Fin d'emprunt
@endsection

@section('stylesheet')
    {{asset('css/end-borrowing.css')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
            <i class="fas fa-arrow-down" data-fa-transform="shrink-10 down-5 right-8"></i>
        </span>
    @endslot
    @slot('rightIcon')
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
            <i class="fas fa-arrow-down" data-fa-transform="shrink-10 down-5 right-8"></i>
        </span>
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
    @endslot
    @slot('title')
        Fin d'emprunt
    @endslot
    @endheader
@endsection