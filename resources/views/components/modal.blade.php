<div class="modal" {{$tags ?? ''}}>
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">{{$title}}</p>
            <a class="delete" aria-label="close"></a>
        </header>
        <section class="modal-card-body">
            {{$body}}
        </section>
        <footer class="modal-card-foot">
            {{$footer}}
        </footer>
    </div>
</div>
