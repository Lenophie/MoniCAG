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
    <!-- suppress JSUnusedLocalSymbols -->
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">
                <table class="table is-bordered is-striped is-narrow is-fullwidth">
                    <thead>
                        <tr class="has-background-edit-users">
                            <th colspan="3" class="border-right">{{__('User')}}</th>
                            <th colspan="2" class="border-right">{{__('messages.edit_users.change_role')}}</th>
                            <th colspan="1">{{__('Delete')}}</th>
                        </tr>
                        <tr class="has-background-edit-users-light">
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
                       <tr id="user-row-{{$user->id}}">
                           <td class="name-field">{{$user->firstName}} {{$user->lastName}}</td>
                           <td class="promotion-field">{{$user->promotion}}</td>
                           <td class="email-field">{{$user->email}}</td>
                           <td>
                               <div id="control is-expanded role-field-{{$user->id}}">
                                   <label class="is-hidden" for="role-{{$user->id}}">
                                       {{__('Role')}}
                                   </label>
                                   <div class="select is-fullwidth is-small">
                                       <select id="role-{{$user->id}}" name="role" autocomplete="off" form="edit-user-{{$user->id}}-form">
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
                               </div>
                               <div id="errors-field-{{$user->id}}"></div>
                           </td>
                           <td class="border-right">
                               <form method="POST" action="{{url('/edit-users')}}" id="edit-user-{{$user->id}}-form">
                                   <button class="button is-link is-small is-fullwidth" id="edit-user-{{$user->id}}-button">
                                       {{__('Confirm')}}
                                   </button>
                               </form>
                           </td>
                           <td>
                               <form method="POST" action="{{url('/edit-users')}}" id="delete-user-{{$user->id}}-form">
                                   <button class="button is-danger is-small is-fullwidth" id="delete-user-{{$user->id}}-button">
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
        const users = @json($users);
        const currentUserID = @json(Auth::user()->id);
        const usersApiUrl = @json(url('/api/users'));
    </script>
    <script type="text/javascript" src="{{mix('js/editUsers.js')}}"></script>
@endpush
