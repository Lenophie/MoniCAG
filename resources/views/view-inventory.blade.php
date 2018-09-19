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
        @include('icons/view-inventory')
    @endslot
    @slot('rightIcon')
        @include('icons/view-inventory')
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
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