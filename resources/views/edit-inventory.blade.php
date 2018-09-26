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
                            <tr>
                                <form autocomplete="off">
                                    <td class="align-middle border-right">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="language-fr-{{$inventoryItem->id}}">
                                                    <i class="flag-icon flag-icon-fr flag-icon-squared"></i>
                                                </label>
                                            </div>
                                            <input id="language-fr-{{$inventoryItem->id}}" name="language-fr-{{$inventoryItem->id}}" type="text" class="form-control" value="{{$inventoryItem->name_fr}}">
                                        </div>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="language-gb-{{$inventoryItem->id}}">
                                                    <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                                                </label>
                                            </div>
                                            <input id="language-gb-{{$inventoryItem->id}}" name="language-gb-{{$inventoryItem->id}}" type="text" class="form-control" value="{{$inventoryItem->name_en}}">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <ul class="mb-0">
                                            @foreach($inventoryItem->genres as $genre)
                                                <li>
                                                    {{$genre->name}}
                                                    <button class="btn btn-sm btn-danger remove-genre-button">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </li>
                                            @endforeach
                                            <li class="plus-li">
                                                <a href="">{{__('messages.edit_inventory.add_new_genre')}}</a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="duration-min-{{$inventoryItem->id}}">
                                                    {{__('Min')}}
                                                </label>
                                            </div>
                                            <input id="duration-min-{{$inventoryItem->id}}" name="duration-min-{{$inventoryItem->id}}" type="number" min="0" class="form-control number-input" value="{{$inventoryItem->duration->min}}">
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="duration-min-{{$inventoryItem->id}}">
                                                    {{strtolower(__('Minutes'))}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="duration-max-{{$inventoryItem->id}}">
                                                    {{__('Max')}}
                                                </label>
                                            </div>
                                            <input id="duration-max-{{$inventoryItem->id}}" name="duration-max-{{$inventoryItem->id}}" type="number" min="0" class="form-control number-input" value="{{$inventoryItem->duration->max}}">
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="duration-max-{{$inventoryItem->id}}">
                                                    {{strtolower(__('Minutes'))}}
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle border-right">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="players-min-{{$inventoryItem->id}}">
                                                    {{__('Min')}}
                                                </label>
                                            </div>
                                            <input id="players-min-{{$inventoryItem->id}}" name="players-min-{{$inventoryItem->id}}" type="number" min="0" class="form-control number-input" value="{{$inventoryItem->players->min}}">
                                        </div>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="players-max-{{$inventoryItem->id}}">
                                                    {{__('Max')}}
                                                </label>
                                            </div>
                                            <input id="players-max-{{$inventoryItem->id}}" name="players-max-{{$inventoryItem->id}}" type="number" min="0" class="form-control number-input" value="{{$inventoryItem->players->max}}">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <select id="status-{{$inventoryItem->id}}" name="status-{{$inventoryItem->id}}" class="custom-select form-control">
                                            @foreach($inventoryStatuses as $inventoryStatus)
                                                <option value="{{$inventoryStatus->id}}" @if($inventoryItem->status->id === $inventoryStatus->id) selected @endif @if($inventoryItem->status->id === \App\InventoryItemStatus::BORROWED || $inventoryStatus->id === \App\InventoryItemStatus::BORROWED) disabled @endif>{{$inventoryStatus->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="align-middle"><button class="btn btn-sm btn-danger w-100">{{__('Delete')}}</button></td>
                                    <td class="align-middle"><button class="btn btn-sm btn-primary w-100">{{__('Confirm')}}</button></td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="javascript">
        $(document).ready(function() {
            localStorage.clear();
        });
    </script>
@endsection