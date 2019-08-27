@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.edit_inventory')}}
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
        @slot('hasAuthBar')
            true
        @endslot
        @slot('title')
            {{__('messages.titles.edit_inventory')}}
        @endslot
    @endheader
    <data-carrier
        :php-data='@json($compactData)'
        @ready="setCarriedData">
    </data-carrier>
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-3 has-text-centered">
                <button class="button is-link is-fullwidth is-medium" @click="showInventoryItemCreationModal = true">
                    <span>
                        <i class="fas fa-plus"></i>
                        {{ __("messages.edit_inventory.add_item") }}
                    </span>
                </button>
            </div>
            <div class="column is-3 has-text-centered">
                <button class="button is-link is-fullwidth is-medium" @click="showGenreCreationModal = true">
                    <span>
                        <i class="fas fa-plus"></i>
                        {{ __("messages.edit_inventory.add_genre") }}
                    </span>
                </button>
            </div>
        </div>

        <div class="columns">
            <div class="column is-12">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            {{ __("messages.edit_inventory.edit_items") }}
                        </p>
                        <a href="#collapsible-card" data-action="collapse" class="card-header-icon is-hidden-fullscreen" aria-label="more options">
                            <span class="icon">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                            </span>
                        </a>
                    </header>
                    <div id="collapsible-card" class="is-collapsible">
                        <div :class="{'card-content': isInventoryItemCardsListMounted}">
                            <inventory-item-cards-list
                                :inventory-items="inventoryItems"
                                @mounted="isInventoryItemCardsListMounted = true">
                            </inventory-item-cards-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal
            :title='"{{__("messages.edit_inventory.add_item")}}"'
            :id="'inventory-item-creation-modal'"
            v-show="showInventoryItemCreationModal || inventoryItemCreationRequest.isProcessing"
            @close="closeInventoryItemCreationModal"
        >
            <template v-slot:body>
                <inventory-item-modification-modal-body
                    :inventory-item-modification-request="inventoryItemCreationRequest"
                    :genres="genres"
                    :submit="requestInventoryItemCreation"
                ></inventory-item-modification-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="inventory-item-creation-confirmation-button"
                            class="button is-link"
                            :disabled=inventoryItemCreationRequest.isProcessing
                            @click="requestInventoryItemCreation"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>
        <modal
            :title='"{{__("messages.edit_inventory.add_genre")}}"'
            :id="'genre-creation-modal'"
            v-show="showGenreCreationModal || genreCreationRequest.isProcessing"
            @close="closeGenreCreationModal"
        >
            <template v-slot:body>
                <genre-modification-modal-body
                    :genre-modification-request="genreCreationRequest"
                    :submit="requestGenreCreation"
                ></genre-modification-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="genre-creation-confirmation-button"
                            class="button is-link"
                            :disabled=genreCreationRequest.isProcessing
                            @click="requestGenreCreation"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/editInventory.js')}}"></script>
@endpush
