@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('Reset password')}}
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
            {{__('Reset password')}}
        @endslot
    @endheader
    <div class="container">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <div class="card">
                    <div class="card-content">
                        @if (session('status'))
                            <div class="notification is-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            <div class="field">
                                <label for="email" class="label">{{ __('E-mail address') }}</label>

                                <div class="control">
                                    <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>

                            <div class="field">
                                <div class=control">
                                    <button type="submit" class="button is-link">
                                        {{ __('Send password reset link') }}
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
