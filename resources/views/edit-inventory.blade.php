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
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">
                <h2 class="title is-5 no-mb">{{__('messages.edit_inventory.add_item')}}</h2>
                <table class="table is-bordered is-striped is-narrow is-fullwidth">
                    <thead>
                        <tr class="has-background-grey">
                            <th colspan="1" class="border-right">{{__('Names')}}</th>
                            <th colspan="3" class="border-right">{{__('Properties')}}</th>
                            <th colspan="1">{{__('Add')}}</th>
                        </tr>
                        <tr class="has-background-grey-light">
                            <th scope="col"></th>
                            <th scope="col">{{__('Genres')}}</th>
                            <th scope="col">{{__('Duration')}}</th>
                            <th scope="col" class="border-right">{{__('Players')}}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-right">
                                <div id="nameFr-field-new" class="small-margin-bottom">
                                    <div class="field has-addons has-addons-centered">
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <i class="flag-icon flag-icon-fr flag-icon-squared"></i>
                                            </a>
                                        </div>
                                        <div class="control is-expanded">
                                            <input id="nameFr-new" name="nameFr" type="text" class="input" placeholder="{{__('French name')}}" autocomplete="off" form="add-item-form">
                                        </div>
                                    </div>
                                </div>
                                <div id="nameEn-field-new">
                                    <div class="field has-addons has-addons-centered">
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                                            </a>
                                        </div>
                                        <div class="control is-expanded">
                                            <input id="nameEn-new" name="nameEn" type="text" class="input" placeholder="{{__('English name')}}" autocomplete="off" form="add-item-form">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div id="genres-field-new">
                                    <ul id="genres-ul-new">
                                        <li class="plus-li">
                                            <div class="select">
                                                <select autocomplete="off" id="add-genre-select-new">
                                                    <option value="default" disabled selected>
                                                        {{__('messages.edit_inventory.new_genre')}}
                                                    </option>
                                                    @foreach($genres as $genre)
                                                        <option value="{{$genre->id}}" id="add-genre-{{$genre->id}}-to-new-option">{{$genre->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div id="durationMin-field-new" class="small-margin-bottom">
                                    <div class="field has-addons has-addons-centered">
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <label for="durationMin-new">
                                                    {{__('Min')}}
                                                </label>
                                            </a>
                                        </div>
                                        <div class="control">
                                            <input id="durationMin-new" name="durationMin" type="text" pattern="[0-9]*" class="input number-input" autocomplete="off" form="add-item-form">
                                        </div>
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <label for="durationMin-new">
                                                    {{strtolower(__('Minutes'))}}
                                                </label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="durationMax-field-new">
                                    <div class="field has-addons has-addons-centered">
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <label for="durationMax-new">
                                                    {{__('Max')}}
                                                </label>
                                            </a>
                                        </div>
                                        <div class="control">
                                            <input id="durationMax-new" name="durationMax" type="text" pattern="[0-9]*" class="input number-input" autocomplete="off" form="add-item-form">
                                        </div>
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <label for="durationMax-new">
                                                    {{strtolower(__('Minutes'))}}
                                                </label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border-right">
                                <div id="playersMin-field-new" class="small-margin-bottom">
                                    <div class="field has-addons has-addons-centered">
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <label for="playersMin-new">
                                                    {{__('Min')}}
                                                </label>
                                            </a>
                                        </div>
                                        <div class="control">
                                            <input id="playersMin-new" name="playersMin" type="text" pattern="[0-9]*[1-9][0-9]*" class="input number-input" autocomplete="off" form="add-item-form">
                                        </div>
                                    </div>
                                </div>
                                <div id="playersMax-field-new">
                                    <div class="field has-addons has-addons-centered">
                                        <div class="control">
                                            <a class="button is-static height-100">
                                                <label for="playersMax-new">
                                                    {{__('Max')}}
                                                </label>
                                            </a>
                                        </div>
                                        <div class="control">
                                            <input id="playersMax-new" name="playersMax" type="text" pattern="[0-9]*[1-9][0-9]*" class="input number-input" autocomplete="off" form="add-item-form">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form method="POST" action="{{url('/edit-inventory')}}" id="add-item-form">
                                    @csrf
                                    <a class="button is-link is-fullwidth" id="add-item-submit-button" type="submit">
                                        {{__('Add')}}
                                    </a>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="columns">
            <div class="column is-12">
                <h2 class="title is-5 no-mb">{{__('messages.edit_inventory.edit_items')}}</h2>
                <table class="table is-bordered is-striped is-narrow is-fullwidth">
                    <thead>
                        <tr class="has-background-grey">
                            <th colspan="1" class="border-right">{{__('Names')}}</th>
                            <th colspan="3" class="border-right">{{__('Properties')}}</th>
                            <th colspan="3">{{__('Actions')}}</th>
                        </tr>
                        <tr class="has-background-grey-light">
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
                                <td class="border-right">
                                    <div id="nameFr-field-{{$inventoryItem->id}}" class="small-margin-bottom">
                                        <div class="field has-addons has-addons-centered">
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <i class="flag-icon flag-icon-fr flag-icon-squared"></i>
                                                </a>
                                            </div>
                                            <div class="control is-expanded">
                                                <input id="nameFr-{{$inventoryItem->id}}" name="nameFr" type="text" class="input" placeholder="{{__('French name')}}" autocomplete="off" value="{{$inventoryItem->name_fr}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="nameEn-field-{{$inventoryItem->id}}">
                                        <div class="field has-addons has-addons-centered">
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                                                </a>
                                            </div>
                                            <div class="control is-expanded">
                                                <input id="nameEn-{{$inventoryItem->id}}" name="nameEn" type="text" class="input" placeholder="{{__('English name')}}" autocomplete="off" value="{{$inventoryItem->name_en}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div id="genres-field-{{$inventoryItem->id}}">
                                        <ul id="genres-ul-{{$inventoryItem->id}}">
                                            @foreach($inventoryItem->genres as $genre)
                                                <li class="genre-li" id="genre-{{$genre->id}}-for-{{$inventoryItem->id}}-li">
                                                    <span>{{$genre->name}}</span>
                                                    <a class="button is-small is-danger remove-genre-button" id="button-remove-genre-{{$genre->id}}-for-{{$inventoryItem->id}}" type="button">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="plus-li">
                                                <div class="select">
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
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div id="durationMin-field-{{$inventoryItem->id}}" class="small-margin-bottom">
                                        <div class="field has-addons has-addons-centered">
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <label for="durationMin-{{$inventoryItem->id}}">
                                                        {{__('Min')}}
                                                    </label>
                                                </a>
                                            </div>
                                            <div class="control">
                                                <input id="durationMin-{{$inventoryItem->id}}" name="durationMin" pattern="[0-9]*[1-9][0-9]*" class="input number-input" autocomplete="off" value="{{$inventoryItem->duration->min}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            </div>
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <label for="durationMin-{{$inventoryItem->id}}">
                                                        {{strtolower(__('Minutes'))}}
                                                    </label>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="durationMax-field-{{$inventoryItem->id}}">
                                        <div class="field has-addons has-addons-centered">
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <label for="durationMax-{{$inventoryItem->id}}">
                                                        {{__('Max')}}
                                                    </label>
                                                </a>
                                            </div>
                                            <div class="control">
                                                <input id="durationMax-{{$inventoryItem->id}}" name="durationMax" pattern="[0-9]*[1-9][0-9]*" class="input number-input" autocomplete="off" value="{{$inventoryItem->duration->max}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            </div>
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <label for="durationMax-{{$inventoryItem->id}}">
                                                        {{strtolower(__('Minutes'))}}
                                                    </label>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-right">
                                    <div id="playersMin-field-{{$inventoryItem->id}}" class="small-margin-bottom">
                                        <div class="field has-addons has-addons-centered">
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <label for="playersMin-{{$inventoryItem->id}}">
                                                        {{__('Min')}}
                                                    </label>
                                                </a>
                                            </div>
                                            <div class="control">
                                                <input id="playersMin-{{$inventoryItem->id}}" name="playersMin" pattern="[0-9]*[1-9][0-9]*" class="input number-input" autocomplete="off" value="{{$inventoryItem->players->min}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="playersMax-field-{{$inventoryItem->id}}">
                                        <div class="field has-addons has-addons-centered">
                                            <div class="control">
                                                <a class="button is-static height-100">
                                                    <label for="playersMax-{{$inventoryItem->id}}">
                                                        {{__('Max')}}
                                                    </label>
                                                </a>
                                            </div>
                                            <div class="control">
                                                <input id="playersMax-{{$inventoryItem->id}}" name="playersMax" pattern="[0-9]*[1-9][0-9]*" class="input number-input" autocomplete="off" value="{{$inventoryItem->players->max}}" form="edit-item-{{$inventoryItem->id}}-form">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div id="statusId-field-{{$inventoryItem->id}}">
                                        <label class="is-hidden" for="status-{{$inventoryItem->id}}">
                                            {{__('Status')}}
                                        </label>
                                        <div class="select is-fullwidth">
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
                                    </div>
                                </td>
                                <td>
                                    <a class="button is-danger is-fullwidth" data-toggle="modal" data-target="delete-confirm-modal" id="delete-button-{{$inventoryItem->id}}" {{$inventoryItem->status->id === \App\InventoryItemStatus::BORROWED ? 'disabled=disabled' : ''}}>
                                        {{__('Delete')}}
                                    </a>
                                </td>
                                <td>
                                    <form method="PATCH" action="{{url('/edit-inventory')}}" id="edit-item-{{$inventoryItem->id}}-form">
                                        @csrf
                                        <a class="button is-link is-fullwidth" id="edit-item-{{$inventoryItem->id}}-submit-button" type="submit">
                                            {{__('Confirm')}}
                                        </a>
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
                <button class="button is-danger is-fullwidth delete-confirm-button" type="submit">
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
        const successRedirectionURL = {!! json_encode(url('/edit-inventory')) !!};
    </script>
    <script type="text/javascript" src="{{asset('js/editInventory.js')}}"></script>
@endpush