@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Inventaire
@endsection

@section('stylesheet')
    {{asset('css/view-inventory.css')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
            <i class="fas fa-eye" data-fa-transform="shrink-10 down-7 right-9"></i>
        </span>
    @endslot
    @slot('rightIcon')
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-7 right-9" data-fa-mask="fas fa-boxes"></i>
            <i class="fas fa-eye" data-fa-transform="shrink-10 down-7 right-9"></i>
        </span>
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('title')
        Inventaire
    @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Rechercher un jeu...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-view-inventory" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul>
        @foreach($inventoryItems as $inventoryItem)
            <li>{{$inventoryItem->name}}</li>
        @endforeach
    </ul>
@endsection