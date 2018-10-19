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
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12 search-section">
                <div class="columns no-mb">
                    <div class="column is-8 is-offset-2">
                        <div class="field has-addons has-addons-centered">
                            <div class="control is-expanded">
                                <input type="text" id="search-game-field" class="input" placeholder="{{__('messages.view_inventory.filter_game_placeholder')}}">
                            </div>
                            <div class="control">
                                <a class="button is-outlined is-view-inventory height-100" type="button" id="cancel-game-search-button">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr id="search-hr">
                <div class="columns">
                    <div class="column is-4">
                        <div class="field has-addons has-addons-centered">
                            <div class="control">
                                <a class="button is-static height-100">
                                    <i class="fas fa-trophy"></i>
                                </a>
                            </div>
                            <div class="control is-expanded">
                                <div class="select is-fullwidth">
                                    <select id="genre-select">
                                        <option value="" selected>{{__("messages.view_inventory.filter_genre_placeholder")}}</option>
                                        @foreach ($genres as $genre)
                                            <option value="{{$genre->id}}">{{$genre->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control">
                                <a class="button is-outlined is-view-inventory height-100" type="button" id="cancel-genre-filtering-button">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field has-addons has-addons-centered">
                            <div class="control">
                                <a class="button is-static height-100">
                                    <i class="fas fa-clock"></i>
                                </a>
                            </div>
                            <div class="control is-expanded">
                                    <input id="duration-input" type="number" min="0" class="input" placeholder="{{__("messages.view_inventory.filter_duration_placeholder")}}">
                            </div>
                            <div class="control">
                                <a class="button is-outlined is-view-inventory height-100" type="button" id="cancel-duration-filtering-button">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field has-addons has-addons-centered">
                            <div class="control">
                                <a class="button is-static height-100">
                                    <i class="fas fa-users"></i>
                                </a>
                            </div>
                            <div class="control is-expanded">
                                <input id="players-input" type="number" min="1" class="input" placeholder="{{__("messages.view_inventory.filter_players_placeholder")}}">
                            </div>
                            <div class="control">
                                <a class="button is-outlined is-view-inventory height-100" type="button" id="cancel-players-filtering-button">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns is-multiline" id="inventory-items-list"></div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const inventoryItems = {!! json_encode($inventoryItems)!!};
    </script>
    <script type="text/javascript" src="{{asset('js/viewInventory.js')}}"></script>
@endpush