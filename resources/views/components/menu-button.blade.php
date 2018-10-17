<div class="{{$width}}">
    <a class="button is-outlined {{$style}} menu-button is-fullwidth" id="{{$id}}" onclick="{{$action ?? ''}}"
            @buttonenabler
                @slot('enablerCondition')
                    {{$enablerCondition}}
                @endslot
            @endbuttonenabler
    >
        <div>
            <span class="menu-text">{{$title}}</span>
            <br>
            {{$icon}}
        </div>
    </a>
</div>