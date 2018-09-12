@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Historique des emprunts
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
    @slot('title')
        Historique des emprunts
    @endslot
    @endheader
@endsection