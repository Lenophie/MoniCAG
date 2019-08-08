<header class="columns">
    <div class="column is-full">
        <div class="columns is-vcentered">
            @if($hasReturnButton == 'true')
                <div class="column is-2">
                    <a id="menu-return" href="{{url('/')}}">
                        <i class="fas fa-arrow-circle-left"></i>
                         {{strtoupper(__('Menu'))}}
                    </a>
                </div>
            @endif
            <div class="column {{$hasReturnButton == 'false' xor $hasCheckoutButton == 'false' ? 'is-offset-2' : ''}} {{$hasReturnButton == 'true' || $hasCheckoutButton == 'true' ? 'is-8' : 'is-full'}}">
                <h1 class="title is-1">{{$leftIcon}} {{$title}} {{$rightIcon}}</h1>
            </div>
            @if($hasCheckoutButton == 'true')
                <div class="column is-2" id="checkout-column">
                    {{$checkoutButton}}
                </div>
            @endif
        </div>
        <div class="columns is-centered">
            <div class="column is-half is-paddingless">
                <hr class="h1-hr">
            </div>
        </div>
        <div class="columns">
            @if($hasAuthBar == 'true')
                @guest
                    <div class="column is-2 is-offset-4 has-text-centered">
                        <a class="button is-small is-link" href="{{ route('login') }}" type="submit">{{ __('Login') }}</a>
                    </div>
                    <div class="column is-2 has-text-centered">
                        <a class="button is-small is-link" href="{{ route('register') }}" type="submit">{{ __('Register') }}</a>
                    </div>
                @else
                    <div class="column is-full has-text-centered" id="connection-row">
                        {{__('Connected as')}}
                        {{Auth::user()->first_name}}
                        {{Auth::user()->last_name}}
                        @usericon
                            @slot('role_id')
                                {{Auth::user()->role_id}}
                            @endslot
                        @endusericon
                         |
                        <a class="button is-small is-link" href="{{ route('account') }}" id="account-link" type="button">
                            <span><i class="fas fa-user"></i> {{ __('messages.titles.account') }}</span>
                        </a>
                         |
                        <a class="button is-small is-danger" type="submit" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                @endguest
            @endif
        </div>
    </div>
</header>
