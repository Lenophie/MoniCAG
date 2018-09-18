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
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
            <i class="fas fa-arrow-down" data-fa-transform="shrink-10 down-5 right-8"></i>
        </span>
    @endslot
    @slot('rightIcon')
        <span class="fa-layers fa-fw menu-icon">
            <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-dice"></i>
            <i class="fas fa-arrow-down" data-fa-transform="shrink-10 down-5 right-8"></i>
        </span>
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
                <button class="btn btn-return-borrowing btn-outline-good">Revenus</button>
            </div>
            <div class="col-md-6 text-center">
                <button class="btn btn-return-borrowing btn-outline-bad">Perdus</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group" id="borrowings-list"></ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const borrowings = {!! json_encode($borrowings)!!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/endBorrowing.js')}}"></script>
@endpush