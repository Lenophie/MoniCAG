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
        @slot('hasLoadingSpinner')
            true
        @endslot
        @slot('title')
            {{__('messages.titles.inventory')}}
        @endslot
    @endheader
    <data-carrier
        :php-data='@json($compactData)'
        @ready="setCarriedData">
    </data-carrier>
    <div class="container is-fluid" v-cloak>
        <search-section
            :inventory-items="inventoryItems"
            :filtered-inventory-items.sync="displayedInventoryItems"
            :genres="genres">
        </search-section>
        <div class="columns is-multiline">
            <div class="column is-2" v-for="inventoryItem in displayedInventoryItems">
                <inventory-item-card
                    :inventory-item="inventoryItem">
                </inventory-item-card>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/viewInventory.js')}}"></script>
@endpush
