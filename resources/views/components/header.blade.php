<header class="columns" id="main-header">
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
                <h1 class="title is-1"><span class="is-hidden-mobile">{{$leftIcon}}</span> {{$title}} <span class="is-hidden-mobile">{{$rightIcon}}</span></h1>
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
                        <button class="button is-small is-danger" type="submit" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                @endguest
            @endif
        </div>
    </div>
</header>
@isset($hasLoadingSpinner)
    @if($hasLoadingSpinner == 'true')
        <div class="has-text-centered" id="loading-div" v-if="false">
            <i class="fas fa-spinner fa-pulse" id="loading-icon"></i>
        </div>
    @endif
@endisset
