@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('Change password')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            <i class="fas fa-user-check"></i>
        @endslot
        @slot('rightIcon')
            <i class="fas fa-user-check"></i>
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
            {{__('Change password')}}
        @endslot
    @endheader
    <div class="container">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <div class="card">
                    <div class="card-content">
                        <form method="POST" action="{{ route('password.change') }}">
                            @csrf
                            <div class="field">
                                <label for="oldPassword" class="label">{{ __('Current password') }}</label>

                                <div class="control">
                                    <input id="oldPassword" type="password" class="input {{ $errors->has('oldPassword') ? ' is-danger' : '' }}" name="oldPassword" required>
                                </div>
                                @if ($errors->has('oldPassword'))
                                    <p class="help is-danger">{{ $errors->first('oldPassword') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <label for="newPassword" class="label">{{ __('New password') }}</label>

                                <div class="control">
                                    <input id="newPassword" type="password" class="input {{ $errors->has('newPassword') ? ' is-danger' : '' }}" name="newPassword" required>
                                </div>
                                @if ($errors->has('newPassword'))
                                    <p class="help is-danger">{{ $errors->first('newPassword') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <label for="password-confirm" class="label">{{ __('Confirm new password') }}</label>

                                <div class="control">
                                    <input id="password-confirm" type="password" class="input" name="newPassword_confirmation" required>
                                </div>
                            </div>

                            <div class="field">
                                <div class=control">
                                    <button type="submit" class="button is-link">
                                        {{__('Modify my password')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
