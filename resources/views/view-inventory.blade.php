@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.inventory')}}
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
        @slot('hasAuthBar')
            true
        @endslot
        @slot('title')
            {{__('messages.titles.inventory')}}
        @endslot
    @endheader
    <meta name="players" content="{{__('Players')}}">
    <meta name="min" content="{{__('Min')}}">
    <div class="ml-3 mr-3">
        <div class="container-fluid border rounded">
            <div class="row mt-3">
                <div class="col-md-8 offset-md-2">
                    <div class="input-group mb-0">
                        <input type="text" class="form-control" id="game-search-input" placeholder="{{__("messages.view_inventory.filter_game_placeholder")}}">
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
                            <option value="" selected>{{__("messages.view_inventory.filter_genre_placeholder")}}</option>
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
                        <input id="duration-input" type="number" min="0" class="form-control" placeholder="{{__("messages.view_inventory.filter_duration_placeholder")}}">
                        <div class="input-group-append">
                            <label class="input-group-text" for="duration-input">
                                {{strtolower(__('Minutes'))}}
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
                        <input id="players-input" type="number" min="0" class="form-control" placeholder="{{__("messages.view_inventory.filter_players_placeholder")}}">
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