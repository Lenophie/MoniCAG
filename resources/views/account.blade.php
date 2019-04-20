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
    <!-- suppress JSUnusedLocalSymbols -->
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">
                <h2 class="title is-5">{{__('Welcome')}}, {{Auth::user()->first_name}} {{Auth::user()->last_name}}.</h2>
                <div class="card" id="info-card">
                    <div class="card-content">
                        <h3 class="title is-6">{{__('My info')}}</h3>
                        <div>{{ __('Last name') }} : {{Auth::user()->last_name}}</div>
                        <div>{{ __('First name') }} : {{Auth::user()->first_name}}</div>
                        <div>{{ __('Promotion') }} : {{Auth::user()->promotion}}</div>
                        <div>{{ __('E-mail address') }} : {{Auth::user()->email}}</div>
                        <div>{{ __('Role') }} : {{Auth::user()->role->name}}</div>
                    </div>
                    <footer class="card-footer">
                        <a id="modify-email-link" class="custom-hover-color card-footer-item" href="{{ url('/email/change') }}">{{__('Modify my E-mail address')}}</a>
                        <a id="modify-password-link" class="custom-hover-color card-footer-item" href="{{ url('/password/change') }}">{{__('Modify my password')}}</a>
                        <a id="delete-account-link" class="card-footer-item has-text-danger" data-toggle="modal" data-target="delete-confirm-modal">{{__('Delete my account')}}</a>
                    </footer>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h3 class="title is-6">{{__('My ongoing borrowings')}}</h3>
                        @if (count($userBorrowings) !== 0)
                            <ul>
                            @foreach($userBorrowings as $userBorrowing)
                                <li>{{$userBorrowing->inventoryItem->name}} {{strtolower(__('Until'))}} {{$userBorrowing->expectedReturnDate->format('d/m/Y')}}</li>
                            @endforeach
                            </ul>
                        @else
                            <div id="no-borrowing-div">{{__('messages.end_borrowing.no_current')}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @modal
    @slot('title')
        {{__('messages.account.deletion_title')}}
    @endslot
    @slot('body')
        <div id="delete-modal-body">
            <p>{!!__('messages.account.deletion_warning')!!}</p>
            <hr>
            <form id="delete-form" method="POST" action="{{ route('account.delete') }}" autocomplete="off">
                <div class="field">
                    <label class="label" for="password">{{__('Confirm password')}}</label>
                    <div class="control has-icons-left">
                        <input class="input" type="password" id="password" name="password" required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                </div>
                <div id="errors-field-password"></div>
            </form>
        </div>
    @endslot
    @slot('tags')
        id="delete-confirm-modal"
    @endslot
    @slot('footer')
        <a class="button is-danger" id="delete-confirm-button">
            {{__('Delete my account')}}
        </a>
    @endslot
    @endmodal
@endsection

@push('scripts')
    <script type="text/javascript">
        const deleteRequestURL = @json(route('account.delete'));
    </script>
    <script type="text/javascript" src="{{asset('js/account.js')}}"></script>
@endpush
