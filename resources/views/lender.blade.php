@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Prêteurs
@endsection

@section('stylesheet')
    {{asset('css/lender.css')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        @include('icons/lender')
    @endslot
    @slot('rightIcon')
        @include('icons/lender')
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
    @endslot
    @slot('title')
        Prêteurs
    @endslot
    @endheader
@endsection