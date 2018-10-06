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
    <div class="container-fluid">
        <div class="row">
            <h2 class="ml-3">{{__('messages.edit_inventory.add_item')}}</h2>
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-edit-inventory">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="1" class="border-right">{{__('Names')}}</th>
                            <th colspan="3" class="border-right">{{__('Properties')}}</th>
                            <th colspan="1">{{__('Add')}}</th>
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">{{__('Genres')}}</th>
                            <th scope="col">{{__('Duration')}}</th>
                            <th scope="col" class="border-right">{{__('Players')}}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle border-right">
                                <div id="nameFr-field-new">
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="nameFr-new">
                                                <i class="flag-icon flag-icon-fr flag-icon-squared"></i>
                                            </label>
                                        </div>
                                        <input id="nameFr-new" name="nameFr" type="text" class="form-control" placeholder="{{__('French name')}}" autocomplete="off" form="add-item-form">
                                    </div>
                                </div>
                                <div id="nameEn-field-new">
                                    <div class="input-group mb-0">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="nameEn-new">
                                                <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                                            </label>
                                        </div>
                                        <input id="nameEn-new" name="nameEn" type="text" class="form-control" placeholder="{{__('English name')}}" autocomplete="off" form="add-item-form">
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div id="genres-field-new">
                                    <ul class="mb-0" id="genres-ul-new">
                                        <li class="plus-li">
                                            <select autocomplete="off" id="add-genre-select-new">
                                                <option value="default" disabled selected>
                                                    {{__('messages.edit_inventory.new_genre')}}
                                                </option>
                                                @foreach($genres as $genre)
                                                    <option value="{{$genre->id}}" id="add-genre-{{$genre->id}}-to-new-option">{{$genre->name}}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div id="durationMin-field-new">
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="durationMin-new">
                                                {{__('Min')}}
                                            </label>
                                        </div>
                                        <input id="durationMin-new" name="durationMin" type="text" pattern="[0-9]*" class="form-control number-input" autocomplete="off" form="add-item-form">
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="durationMin-new">
                                                {{strtolower(__('Minutes'))}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="durationMax-field-new">
                                    <div class="input-group mb-0">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="durationMax-new">
                                                {{__('Max')}}
                                            </label>
                                        </div>
                                        <input id="durationMax-new" name="durationMax" type="text" pattern="[0-9]*" class="form-control number-input" autocomplete="off" form="add-item-form">
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="durationMax-new">
                                                {{strtolower(__('Minutes'))}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle border-right">
                                <div id="playersMin-field-new">
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="playersMin-new">
                                                {{__('Min')}}
                                            </label>
                                        </div>
                                        <input id="playersMin-new" name="playersMin" type="text" pattern="[0-9]*[1-9][0-9]*" class="form-control number-input" autocomplete="off" form="add-item-form">
                                    </div>
                                </div>
                                <div id="playersMax-field-new">
                                    <div class="input-group mb-0">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="playersMax-new">
                                                {{__('Max')}}
                                            </label>
                                        </div>
                                        <input id="playersMax-new" name="playersMax" type="text" pattern="[0-9]*[1-9][0-9]*" class="form-control number-input" autocomplete="off" form="add-item-form">
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <form method="POST" action="{{url('/edit-inventory')}}" id="add-item-form">
                                    @csrf
                                    <button class="btn btn-sm btn-primary w-100" id="add-item-submit-button" type="submit">
                                        {{__('Add')}}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h2 class="ml-3">{{__('messages.edit_inventory.edit_items')}}</h2>
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-edit-inventory">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="1" class="border-right">{{__('Names')}}</th>
                            <th colspan="3" class="border-right">{{__('Properties')}}</th>
                            <th colspan="3">{{__('Actions')}}</th>
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">{{__('Genres')}}</th>
                            <th scope="col">{{__('Duration')}}</th>
                            <th scope="col" class="border-right">{{__('Players')}}</th>
                            <th scope="col">{{__('messages.edit_inventory.change_status')}}</th>
                            <th scope="col">{{__('Delete')}}</th>
                            <th scope="col">{{__('Confirm changes')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventoryItems as $inventoryItem)
                            <tr id="modify-item-{{$inventoryItem->id}}">
                                <td class="align-middle border-right">
                                    <div id="nameFr-field-{{$inventoryItem->id}}">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="nameFr-{{$inventoryItem->id}}">
                                                    <i class="flag-icon flag-icon-fr flag-icon-squared"></i>
                                                </label>
                                            </div>
                                            <input id="nameFr-{{$inventoryItem->id}}" name="nameFr" type="text" class="form-control" placeholder="{{__('French name')}}" autocomplete="off" value="{{$inventoryItem->name_fr}}" form="edit-item-{{$inventoryItem->id}}-form">
                                        </div>
                                    </div>
                                    <div id="nameEn-field-{{$inventoryItem->id}}">
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="nameEn-{{$inventoryItem->id}}">
                                                    <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                                                </label>
                                            </div>
                                            <input id="nameEn-{{$inventoryItem->id}}" name="nameEn" type="text" class="form-control" placeholder="{{__('English name')}}" autocomplete="off" value="{{$inventoryItem->name_en}}" form="edit-item-{{$inventoryItem->id}}-form">
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div id="genres-field-{{$inventoryItem->id}}">
                                        <ul class="mb-0" id="genres-ul-{{$inventoryItem->id}}">
                                            @foreach($inventoryItem->genres as $genre)
                                                <li>
                                                    <span id="genre-{{$genre->id}}" class="genre">{{$genre->name}}</span>
                                                    <button class="btn btn-sm btn-danger remove-genre-button">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </li>
                                            @endforeach
                                            <li class="plus-li">
                                                <select autocomplete="off" id="add-genre-select-{{$inventoryItem->id}}">
                                                    <option value="default" disabled selected>{{__('messages.edit_inventory.new_genre')}}</option>
                                                    @foreach($genres as $genre)
                                                        <option value="{{$genre->id}}" id="add-genre-{{$genre->id}}-to-{{$inventoryItem->id}}-option"
                                                        @foreach($inventoryItem->genres as $referenceGenre)
                                                            @if ($genre->id === $referenceGenre->id)
                                                                disabled
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        >{{$genre->name}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div id="durationMin-field-{{$inventoryItem->id}}">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="durationMin-{{$inventoryItem->id}}">
                                                    {{__('Min')}}
                                                </label>
                                            </div>
                                            <input id="durationMin-{{$inventoryItem->id}}" name="durationMin" type="text" pattern="[0-9]*" class="form-control number-input" autocomplete="off" value="{{$inventoryItem->duration->min}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="durationMin-{{$inventoryItem->id}}">
                                                    {{strtolower(__('Minutes'))}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="durationMax-field-{{$inventoryItem->id}}">
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="durationMax-{{$inventoryItem->id}}">
                                                    {{__('Max')}}
                                                </label>
                                            </div>
                                            <input id="durationMax-{{$inventoryItem->id}}" name="durationMax" type="text" pattern="[0-9]*" class="form-control number-input" autocomplete="off" value="{{$inventoryItem->duration->max}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="durationMax-{{$inventoryItem->id}}">
                                                    {{strtolower(__('Minutes'))}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle border-right">
                                    <div id="playersMin-field-{{$inventoryItem->id}}">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="playersMin-{{$inventoryItem->id}}">
                                                    {{__('Min')}}
                                                </label>
                                            </div>
                                            <input id="playersMin-{{$inventoryItem->id}}" name="playersMin" pattern="[0-9]*[1-9][0-9]*" class="form-control number-input" autocomplete="off" value="{{$inventoryItem->players->min}}" form="edit-item-{{$inventoryItem->id}}-form">
                                        </div>
                                    </div>
                                    <div id="playersMax-field-{{$inventoryItem->id}}">
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="playersMax-{{$inventoryItem->id}}">
                                                    {{__('Max')}}
                                                </label>
                                            </div>
                                            <input id="playersMax-{{$inventoryItem->id}}" name="playersMax" pattern="[0-9]*[1-9][0-9]*" class="form-control number-input" autocomplete="off" value="{{$inventoryItem->players->max}}" form="edit-item-{{$inventoryItem->id}}-form">
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div id="statusId-field-{{$inventoryItem->id}}">
                                        <label class="input-group-text d-none" for="status-{{$inventoryItem->id}}">
                                            {{__('Status')}}
                                        </label>
                                        <select id="status-{{$inventoryItem->id}}" name="statusId" class="custom-select form-control" autocomplete="off" form="edit-item-{{$inventoryItem->id}}-form">
                                            @foreach($inventoryStatuses as $inventoryStatus)
                                                <option value="{{$inventoryStatus->id}}"
                                                        @if($inventoryItem->status->id === $inventoryStatus->id)
                                                            selected
                                                        @endif
                                                        @if($inventoryItem->status->id === \App\InventoryItemStatus::BORROWED
                                                        xor $inventoryStatus->id === \App\InventoryItemStatus::BORROWED)
                                                            disabled
                                                        @endif
                                                >
                                                    {{$inventoryStatus->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-danger w-100" id="delete-button-{{$inventoryItem->id}}">
                                        {{__('Delete')}}
                                    </button>
                                </td>
                                <td class="align-middle">
                                    <form method="PATCH" action="{{url('/edit-inventory')}}" id="edit-item-{{$inventoryItem->id}}-form">
                                        @csrf
                                        <button class="btn btn-sm btn-primary w-100" id="edit-item-{{$inventoryItem->id}}-submit-button" type="submit">
                                            {{__('Confirm')}}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @modal
        @slot('title')
            {{__('messages.edit_inventory.deletion_title')}}
        @endslot
        @slot('body')
            <div id="delete-modal-body">
                {!!__('messages.edit_inventory.deletion_warning')!!}
            </div>
        @endslot
        @slot('tags')
            id="delete-confirm-modal"
        @endslot
        @slot('footer')
            <form class="delete-form" method="DELETE" action="{{url('/edit-inventory')}}">
                @csrf
                <button class="btn btn-sm btn-danger w-100 delete-confirm-button" type="submit">
                    {{__('Delete')}}
                </button>
            </form>
        @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const inventoryItems = {!! json_encode($inventoryItems)!!};
        const requestsURL = {!! json_encode(url('/edit-inventory')) !!};
        const viewInventoryURL = {!! json_encode(url('/view-inventory')) !!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/editInventory.js')}}"></script>
@endpush