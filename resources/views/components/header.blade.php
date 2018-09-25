<header class="container-fluid">
    <div class="row">
        @if($hasReturnButton == 'true')
            <div class="col-md-2">
                <a id="menu-return" href="{{url('/')}}"><i class="fas fa-arrow-circle-left"></i> {{strtoupper(__('Menu'))}}</a>
            </div>
        @endif
        <div class="{{$hasReturnButton == 'false' xor $hasCheckoutButton == 'false' ? 'offset-md-2' : ''}} {{$hasReturnButton == 'true' || $hasCheckoutButton == 'true' ? 'col-md-8' : 'col-md-12'}}">
            <h1>{{$leftIcon}} {{$title}} {{$rightIcon}}</h1>
        </div>
        @if($hasCheckoutButton == 'true')
            <div class="col-md-2" id="checkout-column">
                <span class="fa-layers fa-fw" id="checkout-link" {{$checkoutTags ?? ''}}>
                    <i class="fas fa-gift"></i>
                    <span class="fa-layers-counter" id="checkout-counter">{{$checkoutCounter}}</span>
                </span>
            </div>
        @endif
    </div>
    <hr class="h1-hr">
    <div class="row">
        @if($hasAuthBar == 'true')
            @guest
                <div class="col-2 offset-4" align="center">
                    <form action="{{ route('login') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary" type="submit">{{ __('Login') }}</button>
                    </form>
                </div>
                <div class="col-2" align="center">
                    <form action="{{ route('register') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary" type="submit">{{ __('Register') }}</button>
                    </form>
                </div>
            @else
                <div class="col-12" align="center">
                    {{__('Connected as')}}
                    {{Auth::user()->first_name}}
                    {{Auth::user()->last_name}}
                    @usericon
                        @slot('role_id')
                            {{Auth::user()->role_id}}
                        @endslot
                    @endusericon
                    <button class="btn btn-sm btn-outline-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            @endguest
        @endif
    </div>
</header>