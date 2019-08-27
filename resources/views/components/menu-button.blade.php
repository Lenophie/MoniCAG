<div class="{{$width}}">
    <button
       class="button is-outlined {{$style}} menu-button is-fullwidth"
       id="{{$id}}"
        @buttonenabler
            @slot('enablerCondition')
                {{$enablerCondition}}
            @endslot
        @endbuttonenabler
    >
        <span>
            <span class="menu-text">{{$title}}</span>
            <br>
            {{$icon}}
        </span>
    </button>
</div>
