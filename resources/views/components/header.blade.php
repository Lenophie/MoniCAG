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
            <div class="col-md-2" style="text-align:right">
                <span class="fa-layers fa-fw" id="checkout-link" {{$checkoutTags ?? ''}}>
                    <i class="fas fa-gift"></i>
                    <span class="fa-layers-counter" id="checkout-counter">{{$checkoutCounter}}</span>
                </span>
            </div>
        @endif
    </div>
    <hr class="h1-hr">
</header>