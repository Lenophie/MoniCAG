@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('Register')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            <i class="fas fa-user-plus"></i>
        @endslot
        @slot('rightIcon')
            <i class="fas fa-user-plus"></i>
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
            {{__('Register')}}
        @endslot
    @endheader
    <div class="container">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <div class="card">
                    <div class="card-content">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="field">
                                <label for="firstName" class="label">{{ __('First name') }}</label>

                                <div class="control">
                                    <input
                                        id="firstName"
                                        type="text"
                                        class="input {{ $errors->has('firstName') ? 'is-danger' : '' }}"
                                        name="firstName"
                                        value="{{ old('firstName') }}"
                                        required
                                        autofocus>
                                </div>
                                @if ($errors->has('firstName'))
                                    <p class="help is-danger">{{ $errors->first('firstName') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <label for="lastName" class="label">{{ __('Last name') }}</label>

                                <div class="control">
                                    <input id="lastName"
                                           type="text"
                                           class="input {{ $errors->has('lastName') ? ' is-danger' : '' }}"
                                           name="lastName"
                                           value="{{ old('lastName') }}"
                                           required
                                           autofocus>
                                </div>
                                @if ($errors->has('lastName'))
                                    <p class="help is-danger">{{ $errors->first('lastName') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <label for="promotion" class="label">{{ __('Promotion') }}</label>

                                <div class=control">
                                    <input
                                        id="promotion"
                                        type="text"
                                        class="input {{ $errors->has('promotion') ? ' is-danger' : '' }}"
                                        name="promotion"
                                        value="{{ old('promotion') }}"
                                        required
                                        autofocus>
                                </div>
                                @if ($errors->has('promotion'))
                                    <p class="help is-danger">{{ $errors->first('promotion') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <label for="email" class="label">{{ __('E-mail address') }}</label>

                                <div class=control">
                                    <input
                                        id="email"
                                        type="email"
                                        class="input {{ $errors->has('email') ? ' is-danger' : '' }}"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required>
                                </div>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <label for="password" class="label">{{ __('Password') }}</label>

                                <div class=control">
                                    <input
                                        id="password"
                                        type="password"
                                        class="input {{ $errors->has('password') ? ' is-danger' : '' }}"
                                        name="password"
                                        required>
                                </div>
                                @if ($errors->has('password'))
                                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <label for="password-confirm" class="label">{{ __('Confirm password') }}</label>

                                <div class=control">
                                    <input
                                        id="password-confirm"
                                        type="password"
                                        class="input"
                                        name="password_confirmation"
                                        required>
                                </div>
                            </div>

                            <div class="field">
                                <div class=control">
                                    <button type="submit" class="button is-link">
                                        {{ __('Register') }}
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
