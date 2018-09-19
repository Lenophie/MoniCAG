@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Nouvel emprunt
@endsection

@section('stylesheet')
    {{asset('css/new-borrowing.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/new-borrowing')
        @endslot
        @slot('rightIcon')
            @include('icons/new-borrowing')
        @endslot
        @slot('hasReturnButton')
            true
        @endslot
        @slot('hasCheckoutButton')
            true
        @endslot
        @slot('checkoutCounter')
            0
        @endslot
        @slot('checkoutTags')
            data-toggle="modal" data-target="#new-borrowing-modal"
        @endslot
        @slot('title')
            Nouvel emprunt
        @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="input-group mb-3">
                    <input type="text" id="search-game-field" class="form-control" placeholder="Chercher un jeu à emprunter...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-new-borrowing" id="search-game-button" type="submit"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="inventory-item-buttons-list"></div>
    </div>
    @modal
        @slot('title')
            Confirmation de l'emprunt
        @endslot
        @slot('body')
            <div id="form-field-borrowedItems">
                Liste des jeux choisis :
                <ul id="toBorrowList"></ul>
            </div>
            <hr>
            @include('forms/new-borrowing')
        @endslot
        @slot('tags')
            id="new-borrowing-modal"
        @endslot
        @slot('footer')
            <button type="submit" class="btn btn-new-borrowing" id="new-borrowing-submit">Confirmer</button>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const inventoryItems = {!! json_encode($inventoryItems)!!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/newBorrowing.js')}}"></script>
@endpush