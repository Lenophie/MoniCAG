@extends('template')

@section('stylesheet')
    {{asset('css/account.css')}}
@endsection

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.account')}}
@endsection

@section('content')
    @header
    @slot('leftIcon')
        <i class="fas fa-user menu-icon"></i>
    @endslot
    @slot('rightIcon')
        <i class="fas fa-user menu-icon"></i>
    @endslot
    @slot('hasReturnButton')
        true
    @endslot
    @slot('hasCheckoutButton')
        false
    @endslot
    @slot('hasAuthBar')
        false
    @endslot
    @slot('title')
        {{__('messages.titles.account')}}
    @endslot
    @endheader
    <data-carrier
        :php-data='@json($compactData)'
        @ready="setCarriedData">
    </data-carrier>
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">
                <h2 class="title is-5">{{__('Welcome')}}, {{$user->first_name}} {{$user->last_name}}.</h2>
                <div class="card" id="info-card">
                    <div class="card-content">
                        <h3 class="title is-6">{{__('My info')}}</h3>
                        <div>{{ __('Last name') }} : {{$user->last_name}}</div>
                        <div>{{ __('First name') }} : {{$user->first_name}}</div>
                        <div>{{ __('Promotion') }} : {{$user->promotion}}</div>
                        <div>{{ __('E-mail address') }} : {{$user->email}}</div>
                        <div>{{ __('Role') }} : {{$user->role->name}}</div>
                    </div>
                    <footer class="card-footer">
                        <a id="modify-email-link" class="custom-hover-color card-footer-item" href="{{ url('/email/change') }}">{{__('Modify my E-mail address')}}</a>
                        <a id="modify-password-link" class="custom-hover-color card-footer-item" href="{{ url('/password/change') }}">{{__('Modify my password')}}</a>
                        <button id="delete-account-link" class="card-footer-item has-text-danger" @click="showModal = true">{{__('Delete my account')}}</button>
                    </footer>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h3 class="title is-6">{{__('My ongoing borrowings')}}</h3>
                        @if (count($userBorrowings) !== 0)
                            <ul>
                            @foreach($userBorrowings as $userBorrowing)
                                <li>{{$userBorrowing["inventoryItem"]["name"]}} {{strtolower(__('Until'))}} {{$userBorrowing["expectedReturnDate"]}}</li>
                            @endforeach
                            </ul>
                        @else
                            <div id="no-borrowing-div">{{__('messages.account.no_current')}}</div>
                        @endif
                        <h3 class="title is-6">{{__('My past borrowings')}}</h3>
                        @if (count($userPastBorrowings) !== 0)
                            <ul>
                                @foreach($userPastBorrowings as $userBorrowing)
                                    <li>{{$userBorrowing["inventoryItem"]["name"]}} ({{$userBorrowing["startDate"]}} - {{$userBorrowing["returnDate"]}})</li>
                                @endforeach
                            </ul>
                        @else
                            <div id="no-borrowing-div">{{__('messages.account.no_past')}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <modal
        :id="'account-deletion-confirmation-modal'"
        :title="trans('messages.account.deletion_title')"
        v-show="showModal"
        @close="closeAccountDeletionModal"
    >
        <template v-slot:body>
            <account-deletion-modal-body
                 :account-deletion-request="accountDeletionRequest"
                 :submit="requestAccountDeletion"
            ></account-deletion-modal-body>
        </template>
        <template v-slot:footer>
            <a
                class="button is-danger"
                id="account-deletion-confirmation-button"
                :class="{'is-loading':accountDeletionRequest.isProcessing}"
                :disabled="accountDeletionRequest.isProcessing"
                @click="requestAccountDeletion"
            >
                @lang('Delete my account')
            </a>
        </template>
    </modal>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{mix('js/account.js')}}"></script>
@endpush
