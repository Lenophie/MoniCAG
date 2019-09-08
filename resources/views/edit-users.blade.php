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
        @slot('hasLoadingSpinner')
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
    <div class="container is-fluid" v-cloak>
        <div class="columns">
            <div class="column is-12">
                <div class="columns is-multiline">
                    <div class="column is-2" v-for="user in resources.users">
                        <user-card-button
                            :user="user"
                            :logged-user-id="resources.loggedUserId"
                            :has-delete-button="true"
                            :tabable="!isAModalShown"
                            @user-clicked="openUserRoleUpdateModal"
                            @user-deletion-clicked="openUserDeletionModal">
                        </user-card-button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User update role modal -->
        <modal
            :title="userRoleUpdateModalTitle"
            :id="'user-role-update-modal'"
            v-show="flags.showUserRoleUpdateModal"
            @close="closeUserRoleUpdateModal"
        >
            <template v-slot:body>
                <user-role-update-modal-body
                    :user-role-update-request="requests.userRoleUpdate"
                    :user-roles="resources.userRoles"
                    :submit="requestUserRoleUpdate">
                </user-role-update-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="user-role-update-confirmation-button"
                            class="button is-link"
                            :class="{'is-loading': requests.userRoleUpdate.isProcessing}"
                            :disabled="requests.userRoleUpdate.isProcessing"
                            @click="requestUserRoleUpdate"
                        >
                            @lang('Confirm')
                        </button>
                    </p>
                </div>
            </template>
        </modal>

        <!-- User deletion modal -->
        <modal
            :title="userDeletionModalTitle"
            :id="'user-deletion-modal'"
            v-show="flags.showUserDeletionModal"
            @close="closeUserDeletionModal"
        >
            <template v-slot:body>
                <user-deletion-modal-body
                    :user-deletion-request="requests.userDeletion"
                    :submit="requestUserDeletion">
                </user-deletion-modal-body>
            </template>
            <template v-slot:footer>
                <div class="field is-grouped is-grouped-right width-100">
                    <p class="control">
                        <button
                            id="user-deletion-confirmation-button"
                            class="button is-danger"
                            :class="{'is-loading': requests.userDeletion.isProcessing}"
                            :disabled="requests.userDeletion.isProcessing"
                            @click="requestUserDeletion"
                        >
                            @lang('Delete')
                        </button>
                    </p>
                </div>
            </template>
        </modal>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/editUsers.js')}}"></script>
@endpush
