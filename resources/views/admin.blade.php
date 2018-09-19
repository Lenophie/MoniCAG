@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Administrateurs
@endsection

@section('stylesheet')
    {{asset('css/admin.css')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        @include('icons/admin')
    @endslot
    @slot('rightIcon')
        @include('icons/admin')
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
    @endslot
    @slot('title')
        Administrateurs
    @endslot
    @endheader
@endsection