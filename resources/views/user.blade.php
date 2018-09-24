@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('Users')}}
@endsection

@section('stylesheet')
    {{asset('user.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/user')
        @endslot
        @slot('rightIcon')
            @include('icons/user')
        @endslot
        @slot('hasReturnButton')
            true
        @endslot
        @slot('hasCheckoutButton')
            false
        @endslot
        @slot('title')
            {{__('Users')}}
        @endslot
    @endheader
@endsection