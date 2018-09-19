@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Edition de l'inventaire
@endsection

@section('stylesheet')
    {{asset('css/edit-inventory.css')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        @include('icons/edit-inventory')
    @endslot
    @slot('rightIcon')
        @include('icons/edit-inventory')
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
    @endslot
    @slot('title')
        Edition de l'inventaire
    @endslot
    @endheader
@endsection