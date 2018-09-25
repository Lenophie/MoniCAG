<div class="{{$width}} mb-3">
    <button class="btn btn-block {{$style}} menu-button" onclick="{{$action ?? ''}}" @buttonenabler @slot('enablerCondition') {{$enablerCondition}} @endslot @endbuttonenabler>
        <span class="menu-text">{{$title}}</span>
        <br>
        {{$icon}}
    </button>
</div>