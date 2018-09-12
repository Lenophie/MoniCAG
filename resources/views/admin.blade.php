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
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-6 right-6" data-fa-mask="fas fa-users"></i>
            <i class="fas fa-crown" data-fa-transform="shrink-10 down-6 right-6"></i>
        </span>
    @endslot
    @slot('rightIcon')
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-6 right-6" data-fa-mask="fas fa-users"></i>
            <i class="fas fa-crown" data-fa-transform="shrink-10 down-6 right-6"></i>
        </span>
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