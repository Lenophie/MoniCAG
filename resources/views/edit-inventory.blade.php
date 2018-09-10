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
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
            <i class="fas fa-wrench" data-fa-transform="shrink-10 down-7 right-9"></i>
        </span>
    @endslot
    @slot('rightIcon')
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
            <i class="fas fa-wrench" data-fa-transform="shrink-10 down-7 right-9"></i>
        </span>
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('title')
        Edition de l'inventaire
    @endslot
    @endheader
@endsection