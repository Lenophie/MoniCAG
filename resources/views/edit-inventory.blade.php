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
                <button
                    class="button is-fullwidth is-medium"
                    :tabindex="isAModalShown ? -1 : 0"
                    @click="flags.showInventoryItemCreationModal = true">
                    <span>
                        <i class="fas fa-plus"></i>
                        {{ __("messages.edit_inventory.add_item") }}
                    </span>
                </button>
            </div>
            <div class="column is-3 has-text-centered">
                <button
                    class="button is-fullwidth is-medium"
                    :tabindex="isAModalShown ? -1 : 0"
                    @click="flags.showGenreCreationModal = true">
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
                        <a
                            href="#inventory-item-collapsible-card"
                            data-action="collapse"
                            class="card-header-icon width-100"
                            :tabindex="isAModalShown ? -1 : 0">
                            <span class="card-header-title collapsible-drawer-title">
                                {{ __("messages.edit_inventory.edit_items") }}
                            </span>
                            <span class="icon collapsible-drawer-icon">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                            </span>
                        </a>
                    </header>
                    <div id="inventory-item-collapsible-card"
                         class="is-collapsible"
                         tabindex="-1">
                        <div :class="{'card-content': flags.isInventoryItemCardsListMounted}">
                            <inventory-item-cards-list
                                :inventory-items="resources.inventoryItems"
                                :tabable="!isInventoryItemCardsListCollapsed && !isAModalShown"
                                @mounted="flags.isInventoryItemCardsListMounted = true"
                                @item-clicked="openInventoryItemUpdateModal"
                                @item-deletion-clicked="openInventoryItemDeletionModal"
                            >
                            </inventory-item-cards-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-12">
                <div class="card">
                    <header class="card-header">
                        <a
                            href="#genre-collapsible-card"
                            data-action="collapse"
                            class="card-header-icon width-100"
                            :tabindex="isAModalShown ? -1 : 0">
                            <span class="card-header-title collapsible-drawer-title">
                                {{ __("messages.edit_inventory.edit_genres") }}
                            </span>
                            <span class="icon collapsible-drawer-icon">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                            </span>
                        </a>
                    </header>
                    <div id="genre-collapsible-card"
                         class="is-collapsible"
                         tabindex="-1">
                        <div :class="{'card-content': flags.isGenreCardsListMounted}">
                            <genre-cards-list
                                :genres="resources.genres"
                                :tabable="!isGenreCardsListCollapsed && !isAModalShown"
                                @mounted="flags.isGenreCardsListMounted = true"
                                @genre-clicked="openGenreUpdateModal"
                                @genre-deletion-clicked="openGenreDeletionModal"
                            >
                            </genre-cards-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!-- Modals -->

        <modal
            :title='"{{__("messages.edit_inventory.add_item")}}"'
            :id="'inventory-item-creation-modal'"
            v-show="flags.showInventoryItemCreationModal"
            @close="closeInventoryItemCreationModal"
        >
            <template v-slot:body>
                <inventory-item-modification-modal-body
                    :inventory-item-modification-request="requests.inventoryItemCreation"
                    :genres="resources.genres"
                    :submit="requestInventoryItemCreation"
                ></inventory-item-modification-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="inventory-item-creation-confirmation-button"
                            class="button is-link"
                            :disabled=requests.inventoryItemCreation.isProcessing
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
            v-show="flags.showGenreCreationModal"
            @close="closeGenreCreationModal"
        >
            <template v-slot:body>
                <genre-modification-modal-body
                    :genre-modification-request="requests.genreCreation"
                    :submit="requestGenreCreation"
                ></genre-modification-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="genre-creation-confirmation-button"
                            class="button is-link"
                            :disabled=requests.genreCreation.isProcessing
                            @click="requestGenreCreation"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>
        <modal
            :title="`${trans('messages.edit_inventory.edit_item')} : ${requests.inventoryItemUpdate.originalName}`"
            :id="'inventory-item-update-modal'"
            v-show="flags.showInventoryItemUpdateModal"
            @close="closeInventoryItemUpdateModal"
        >
            <template v-slot:body>
                <inventory-item-modification-modal-body
                    :inventory-item-modification-request="requests.inventoryItemUpdate"
                    :genres="resources.genres"
                    :inventory-item-statuses="resources.inventoryItemStatuses"
                    :submit="requestInventoryItemUpdate"
                ></inventory-item-modification-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="inventory-item-update-confirmation-button"
                            class="button is-link"
                            :disabled=requests.inventoryItemUpdate.isProcessing
                            @click="requestInventoryItemUpdate"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>
        <modal
            :title="`${trans('messages.edit_inventory.edit_genre')} : ${requests.genreUpdate.originalName}`"
            :id="'genre-update-modal'"
            v-show="flags.showGenreUpdateModal"
            @close="closeGenreUpdateModal"
        >
            <template v-slot:body>
                <genre-modification-modal-body
                    :genre-modification-request="requests.genreUpdate"
                    :submit="requestGenreUpdate"
                ></genre-modification-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="genre-update-confirmation-button"
                            class="button is-link"
                            :disabled=requests.genreUpdate.isProcessing
                            @click="requestGenreUpdate"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>
        <modal
            :title="`${trans('messages.edit_inventory.delete_item')} : ${requests.inventoryItemDeletion.name}`"
            :id="'inventory_item-deletion-modal'"
            v-show="flags.showInventoryItemDeletionModal"
            @close="closeInventoryItemDeletionModal"
        >
            <template v-slot:body>
                <p class="has-text-danger">
                    <span v-html="trans('messages.edit_inventory.item_deletion_warning')"></span>
                </p>
                <error-field
                    :errors-list="requests.inventoryItemDeletion.errors"
                    :field-path="'inventoryItem'">
                </error-field>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="inventory-item-deletion-confirmation-button"
                            class="button is-danger"
                            :disabled=requests.inventoryItemDeletion.isProcessing
                            @click="requestInventoryItemDeletion"
                        >
                            @lang('Delete')
                        </button>
                    </p>
                </div>
            </template>
        </modal>
        <modal
            :title="`${trans('messages.edit_inventory.delete_genre')} : ${requests.genreDeletion.name}`"
            :id="'genre-deletion-modal'"
            v-show="flags.showGenreDeletionModal"
            @close="closeGenreDeletionModal"
        >
            <template v-slot:body>
                <p class="has-text-danger">
                    <span v-html="trans('messages.edit_inventory.genre_deletion_warning')"></span>
                </p>
                <error-field
                    :errors-list="requests.genreDeletion.errors"
                    :field-path="'genre'">
                </error-field>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="genre-deletion-confirmation-button"
                            class="button is-danger"
                            :disabled=requests.genreDeletion.isProcessing
                            @click="requestGenreDeletion"
                        >
                            @lang('Delete')
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
