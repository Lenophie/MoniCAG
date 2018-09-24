@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('Edit inventory')}}
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
        {{__('Edit inventory')}}
    @endslot
    @endheader
@endsection