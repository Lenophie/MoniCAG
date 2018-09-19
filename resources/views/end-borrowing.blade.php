@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Fin d'emprunt
@endsection

@section('stylesheet')
    {{asset('css/end-borrowing.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/end-borrowing')
        @endslot
        @slot('rightIcon')
            @include('icons/end-borrowing')
        @endslot
        @slot('hasReturnButton')
            true
        @endslot
        @slot('hasCheckoutButton')
            false
        @endslot
        @slot('title')
            Fin d'emprunt
        @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                Déclarer les emprunts sélectionnés comme :
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 text-center">
                <button class="btn btn-return-borrowing btn-outline-good" id="return-button" data-toggle="modal" data-target="#end-borrowing-modal">Revenus</button>
            </div>
            <div class="col-md-6 text-center">
                <button class="btn btn-return-borrowing btn-outline-bad" id="lost-button" data-toggle="modal" data-target="#end-borrowing-modal">Perdus</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group" id="borrowings-list"></ul>
            </div>
        </div>
    </div>
    @modal
        @slot('title')
            Confirmation
        @endslot
        @slot('body')
            <div id="modal-body-return">
                <h5 id="modal-list-name">Liste des emprunts sélectionnés</h5>
                <ul id="to-return-list"></ul>
            </div>
            <hr>
            @include('authentications/lender')
        @endslot
        @slot('tags')
            id="end-borrowing-modal"
        @endslot
        @slot('footer')
            <button type="submit" class="btn" id="end-borrowing-submit">Confirmer</button>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const borrowings = {!! json_encode($borrowings)!!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/endBorrowing.js')}}"></script>
@endpush