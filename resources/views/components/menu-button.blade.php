<div class="{{$width}}">
    <button
        class="button is-outlined {{$style}} menu-button is-fullwidth"
        id="{{$id}}"
        @if($enablerCondition != '1')
            disabled=disabled
        @endif
    >
        <span>
            <span class="menu-text">{{$title}}</span>
            <br>
            {{$icon}}
        </span>
    </button>
</div>
