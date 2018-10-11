@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.edit_users')}}
@endsection

@section('stylesheet')
    {{asset('css/edit-users.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/user')
        @endslot
        @slot('rightIcon')
            @include('icons/user')
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
            {{__('messages.titles.edit_users')}}
        @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-edit-users">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="3" class="border-right">{{__('User')}}</th>
                            <th colspan="2" class="border-right">{{__('messages.edit_users.change_role')}}</th>
                            <th colspan="1">{{__('Delete')}}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Promotion')}}</th>
                            <th scope="col" class="border-right">{{__('E-mail address')}}</th>
                            <th scope="col">{{__('Role')}}</th>
                            <th scope="col" class="border-right">{{__('Confirm')}}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                       <tr>
                           <td class="align-middle">{{$user->firstName}} {{$user->lastName}}</td>
                           <td class="align-middle">{{$user->promotion}}</td>
                           <td class="align-middle">{{$user->email}}</td>
                           <td class="align-middle">
                               <div id="role-field-{{$user->id}}">
                                   <label class="input-group-text d-none" for="role-{{$user->id}}">
                                       {{__('Role')}}
                                   </label>
                                   <select id="role-{{$user->id}}" name="role" class="custom-select form-control" autocomplete="off" form="edit-user-{{$user->id}}-form">
                                       @foreach($userRoles as $userRole)
                                           <option value="{{$userRole->id}}"
                                                   @if($user->role->id === $userRole->id)
                                                       selected
                                                   @endif
                                                   @if($user->role->id === \App\UserRole::ADMINISTRATOR
                                                       && $userRole->id !== \App\UserRole::ADMINISTRATOR
                                                       && $user->id !== Auth::user()->id)
                                                        disabled
                                                   @endif
                                           >
                                               {{$userRole->name}}
                                           </option>
                                       @endforeach
                                   </select>
                               </div>
                               <div id="errors-field-{{$user->id}}"></div>
                           </td>
                           <td class="align-middle border-right">
                               <form method="PATCH" action="{{url('/edit-users')}}" id="edit-user-{{$user->id}}-form">
                                   @csrf
                                   <button class="btn btn-sm btn-primary table-button" id="edit-user-{{$user->id}}-button">
                                       {{__('Confirm')}}
                                   </button>
                               </form>
                           </td>
                           <td class="align-middle">
                               <form method="DELETE" action="{{url('/edit-users')}}" id="delete-user-{{$user->id}}-form">
                                   @csrf
                                   <button class="btn btn-sm btn-danger table-button" id="delete-user-{{$user->id}}-button">
                                       {{__('Delete')}}
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
@endsection

@push('scripts')
    <script type="text/javascript">
        const users = {!! json_encode($users)!!};
        const requestsURL = {!! json_encode(url('/edit-users')) !!};
    </script>
    <script type="text/javascript" src="{{asset('js/editUsers.js')}}"></script>
@endpush