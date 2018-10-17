@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('Verify')}}
@endsection

@section('content')
<div class="container">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div class="card">
                <div class="card-content">
                    @if (session('resent'))
                        <div class="notification is-success" role="alert">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    Before proceeding, please check your email for a verification link.
                    If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to request another</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
