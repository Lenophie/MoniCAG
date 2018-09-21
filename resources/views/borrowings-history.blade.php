@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | Historique des emprunts
@endsection

@section('stylesheet')
    {{asset('css/borrowings-history.css')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        <i class="fas fa-history menu-icon"></i>
    @endslot
    @slot('rightIcon')
        <i class="fas fa-history menu-icon"></i>
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
    @endslot
    @slot('title')
        Historique des emprunts
    @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-borrowings-history">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="5" class="border-right">Emprunt</th>
                            <th colspan="3">Retour</th>
                        </tr>
                        <tr>
                            <th scope="col">Date d'emprunt</th>
                            <th scope="col">Emprunteur</th>
                            <th scope="col">Jeu</th>
                            <th scope="col">Caution</th>
                            <th scope="col" class="border-right">Prêteur</th>
                            <th scope="col">Date de retour prévu</th>
                            <th scope="col">Date de fin</th>
                            <th scope="col">Validateur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $borrowing)
                            <tr>
                                <td>{{$borrowing->startDate->format('d/m/Y')}}</td>
                                <td>{{$borrowing->borrower->firstName}} {{strtoupper($borrowing->borrower->lastName)}}</td>
                                <td>{{$borrowing->inventoryItem->name}}</td>
                                <td>{{number_format($borrowing->guarantee, 2)}} €</td>
                                <td class="border-right">{{$borrowing->initialLender->firstName}} {{strtoupper($borrowing->initialLender->lastName)}}</td>
                                <td>{{$borrowing->expectedReturnDate->format('d/m/Y')}}</td>
                                <td>@if($borrowing->returnDate){{$borrowing->returnDate->format('d/m/Y')}}@endif</td>
                                <td>@if($borrowing->returnLender){{$borrowing->returnLender->firstName}} {{strtoupper($borrowing->returnLender->lastName)}}@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        const borrowings = {!! json_encode($borrowings)!!};
        console.log(borrowings);
    </script>
@endsection