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
            <div class="column is-2 has-text-centered">
                <a class="button is-link is-fullwidth is-medium" @click="showInventoryItemCreationModal = true">
                    <p>
                        <i class="fas fa-plus"></i>
                        {{ __("messages.edit_inventory.add_item") }}
                    </p>
                </a>
            </div>
            <div class="column is-2 has-text-centered">
                <a class="button is-link is-fullwidth is-medium" @click="showGenreCreationModal = true">
                    <p>
                        <i class="fas fa-plus"></i>
                        {{ __("messages.edit_inventory.add_genre") }}
                    </p>
                </a>
            </div>
        </div>
        <modal
            :title='"{{__("messages.edit_inventory.add_item")}}"'
            :id="'inventory-item-creation-modal'"
            v-show="showInventoryItemCreationModal || inventoryItemCreationRequest.isProcessing"
            @close="closeInventoryItemCreationModal"
        >
            <template v-slot:body>
                <inventory-item-creation-modal-body
                    :inventory-item-creation-request="inventoryItemCreationRequest"
                    :genres="genres"
                    :submit="requestInventoryItemCreation"
                ></inventory-item-creation-modal-body>
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
                <genre-creation-modal-body
                    :genre-creation-request="genreCreationRequest"
                    :submit="requestGenreCreation"
                ></genre-creation-modal-body>
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
