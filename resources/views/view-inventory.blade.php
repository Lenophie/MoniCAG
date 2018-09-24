@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('Inventory')}}
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
        {{__('Inventory')}}
    @endslot
    @endheader
    <div class="ml-3 mr-3">
        <div class="container-fluid border rounded">
            <div class="row mt-3">
                <div class="col-md-8 offset-md-2">
                    <div class="input-group mb-0">
                        <input type="text" class="form-control" id="game-search-input" placeholder="Rechercher un jeu...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-view-inventory" id="cancel-game-search-button" type="submit"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="genre-select">
                                <i class="fas fa-trophy"></i>
                            </label>
                        </div>
                        <select id="genre-select" class="custom-select">
                            <option value="" selected>Filtrer par genre...</option>
                            @foreach ($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->name}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-view-inventory" id="cancel-genre-filtering-button" type="submit"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="duration-input">
                                <i class="far fa-clock"></i>
                            </label>
                        </div>
                        <input id="duration-input" type="number" min="0" class="form-control" placeholder="Filtrer par durée...">
                        <div class="input-group-append">
                            <label class="input-group-text" for="duration-input">
                                minutes
                            </label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-view-inventory" id="cancel-duration-filtering-button" type="submit"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="players-input">
                                <i class="fas fa-users"></i>
                            </label>
                        </div>
                        <input id="players-input" type="number" min="0" class="form-control" placeholder="Filtrer par nombre de joueurs...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-view-inventory" id="cancel-players-filtering-button" type="submit"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="row" id="inventory-items-list"></div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const inventoryItems = {!! json_encode($inventoryItems)!!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/viewInventory.js')}}"></script>
@endpush