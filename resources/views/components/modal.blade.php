<div class="modal fade" tabindex="-1" role="dialog" {{$tags ?? ''}} aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{$body}}
            </div>
            <div class="modal-footer">
                {{$footer}}
            </div>
        </div>
    </div>
</div>