<header class="container-fluid">
    <div class="row">
        @if($hasReturnButton ?? false === true)
        <div class="col-md-2">
            <a id="menu-return" href="{{url('/')}}"><i class="fas fa-arrow-circle-left"></i> MENU</a>
        </div>
        <div class="col-md-8">
            <h1>{{$leftIcon}} {{$title}} {{$rightIcon}}</h1>
        </div>
        @else
        <div class="col-md-12">
            <h1>{{$leftIcon}} {{$title}} {{$rightIcon}}</h1>
        </div>
        @endif
    </div>
    <hr class="h1-hr">
</header>