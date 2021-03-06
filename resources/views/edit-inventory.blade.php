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
        @slot('hasLoadingSpinner')
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
    <div class="container is-fluid" v-cloak>
        <div class="columns">
            <!-- Add item button -->
            <div class="column is-3 has-text-centered">
                <button
                    class="button is-fullwidth is-medium"
                    id="inventory-item-creation-modal-open-button"
                    :tabindex="isAModalShown ? -1 : 0"
                    @click="flags.showInventoryItemCreationModal = true">
                    <span>
                        <i class="fas fa-plus"></i>
                        {{ __("messages.edit_inventory.add_item") }}
                    </span>
                </button>
            </div>
            <!-- Add genre button -->
            <div class="column is-3 has-text-centered">
                <button
                    class="button is-fullwidth is-medium"
                    id="genre-creation-modal-open-button"
                    :tabindex="isAModalShown ? -1 : 0"
                    @click="flags.showGenreCreationModal = true">
                    <span>
                        <i class="fas fa-plus"></i>
                        {{ __("messages.edit_inventory.add_genre") }}
                    </span>
                </button>
            </div>
        </div>

        <!-- Inventory items collapsible list -->
        <div class="columns">
            <div class="column is-12">
                <div class="card">
                    <header class="card-header">
                        <a
                            href="#inventory-item-collapsible-card"
                            data-action="collapse"
                            class="card-header-icon width-100"
                            :tabindex="isAModalShown ? -1 : 0"
                            id="inventory-item-collapse-link">
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
                        <div class="card-content">
                            <div class="columns is-multiline" id="inventory-item-collapsible-list">
                                <div class="column is-2" v-for="inventoryItem in resources.inventoryItems">
                                    <inventory-item-button
                                        :inventory-item="inventoryItem"
                                        :tabable="!isInventoryItemsListCollapsed && !isAModalShown"
                                        @item-clicked="openInventoryItemUpdateModal"
                                        @item-deletion-clicked="openInventoryItemDeletionModal"></inventory-item-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Genres collapsible list -->
        <div class="columns">
            <div class="column is-12">
                <div class="card">
                    <header class="card-header">
                        <a
                            href="#genre-collapsible-card"
                            data-action="collapse"
                            class="card-header-icon width-100"
                            :tabindex="isAModalShown ? -1 : 0"
                            id="genre-collapse-link">
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
                        <div class="card-content">
                            <div class="columns is-multiline" id="genre-collapsible-list">
                                <div class="column is-2" v-for="genre in resources.genres">
                                    <genre-button
                                        :genre="genre"
                                        :tabable="!isGenresListCollapsed && !isAModalShown"
                                        @genre-clicked="openGenreUpdateModal"
                                        @genre-deletion-clicked="openGenreDeletionModal"
                                    >
                                    </genre-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->

        <!-- Add item modal -->
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
                            :class="{'is-loading': requests.inventoryItemCreation.isProcessing}"
                            :disabled="requests.inventoryItemCreation.isProcessing"
                            @click="requestInventoryItemCreation"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>

        <!-- Add genre modal -->
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
                            :class="{'is-loading': requests.genreCreation.isProcessing}"
                            :disabled="requests.genreCreation.isProcessing"
                            @click="requestGenreCreation"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>

        <!-- Edit item modal -->
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
                            :class="{'is-loading': requests.inventoryItemUpdate.isProcessing}"
                            :disabled="requests.inventoryItemUpdate.isProcessing"
                            @click="requestInventoryItemUpdate"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>

        <!-- Edit genre modal -->
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
                            :class="{'is-loading': requests.genreUpdate.isProcessing}"
                            :disabled="requests.genreUpdate.isProcessing"
                            @click="requestGenreUpdate"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>

        <!-- Delete item modal -->
        <modal
            :title="`${trans('messages.edit_inventory.delete_item')} : ${requests.inventoryItemDeletion.name}`"
            :id="'inventory-item-deletion-modal'"
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
                            :class="{'is-loading': requests.inventoryItemDeletion.isProcessing}"
                            :disabled="requests.inventoryItemDeletion.isProcessing"
                            @click="requestInventoryItemDeletion"
                        >
                            @lang('Delete')
                        </button>
                    </p>
                </div>
            </template>
        </modal>

        <!-- Delete genre modal -->
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
                            :class="{'is-loading': requests.genreDeletion.isProcessing}"
                            :disabled="requests.genreDeletion.isProcessing"
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
