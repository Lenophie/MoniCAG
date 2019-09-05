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
    <data-carrier
        :php-data='@json($compactData)'
        @ready="setCarriedData">
    </data-carrier>
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">
                <div class="columns is-multiline">
                    <div class="column is-2" v-for="user in resources.users">
                        <user-card-button
                            :user="user"
                            :has-delete-button="true"
                            :tabable="!isAModalShown"
                            @user-clicked="openUserUpdateModal"
                            @user-deletion-clicked="openUserDeletionModal">
                        </user-card-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/editUsers.js')}}"></script>
@endpush
