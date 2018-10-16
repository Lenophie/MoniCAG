<header class="columns">
    <div class="column is-full">
        <div class="columns">
            @if($hasReturnButton == 'true')
                <div class="column is-2">
                    <a id="menu-return" href="{{url('/')}}"><i class="fas fa-arrow-circle-left"></i> {{strtoupper(__('Menu'))}}</a>
                </div>
            @endif
            <div class="column {{$hasReturnButton == 'false' xor $hasCheckoutButton == 'false' ? 'is-offset-2' : ''}} {{$hasReturnButton == 'true' || $hasCheckoutButton == 'true' ? 'is-8' : 'is-full'}}">
                <h1 class="title is-1">{{$leftIcon}} {{$title}} {{$rightIcon}}</h1>
            </div>
            @if($hasCheckoutButton == 'true')
                <div class="column is-2" id="checkout-column">
                    <span class="fa-layers fa-fw" id="checkout-link" {{$checkoutTags ?? ''}}>
                        <i class="fas fa-gift"></i>
                        <span class="fa-layers-counter" id="checkout-counter">{{$checkoutCounter}}</span>
                    </span>
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
                    <div class="column is-2 is-offset-4" align="center">
                        <form action="{{ route('login') }}">
                            @csrf
                            <button class="button is-small is-link" type="submit">{{ __('Login') }}</button>
                        </form>
                    </div>
                    <div class="column is-2" align="center">
                        <form action="{{ route('register') }}">
                            @csrf
                            <button class="button is-small is-link" type="submit">{{ __('Register') }}</button>
                        </form>
                    </div>
                @else
                    <div class="column is-full" align="center">
                        {{__('Connected as')}}
                        {{Auth::user()->first_name}}
                        {{Auth::user()->last_name}}
                        @usericon
                            @slot('role_id')
                                {{Auth::user()->role_id}}
                            @endslot
                        @endusericon
                         |
                        <button class="button is-small is-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                @endguest
            @endif
        </div>
    </div>
</header>