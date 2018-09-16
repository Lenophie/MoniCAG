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
            <span class="fa-layers fa-fw menu-icon">
                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                <i class="fas fa-arrow-up" data-fa-transform="shrink-10 down-5 right-8"></i>
            </span>
        @endslot
        @slot('rightIcon')
            <span class="fa-layers fa-fw menu-icon">
                <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
                <i class="fas fa-arrow-up" data-fa-transform="shrink-10 down-5 right-8"></i>
            </span>
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
        <div class="row" id="inventory-item-buttons-list">

        </div>
    </div>
    @modal
        @slot('title')
            Confirmation de l'emprunt
        @endslot
        @slot('body')
            <div id="form-field-borrowedItems">
            Liste des jeux choisis :
            <ul id="toBorrowList">

            </ul>
            </div>
            <hr>
            @include('forms/new-borrowing')
        @endslot
        @slot('tags')
            id="new-borrowing-modal"
        @endslot
        @slot('footer')
            <button type="submit" class="btn btn-new-borrowing" id="new-borrowing-submit">Submit</button>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const inventoryItems = {!! json_encode($inventoryItems)!!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/newBorrowing.js')}}"></script>
@endpush