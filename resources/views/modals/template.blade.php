<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="@yield('label')" aria-describedby="@yield('modal-description')" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@yield('title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @yield('body')
            </div>
            <div class="modal-footer">
                @yield('footer')
            </div>
        </div>
    </div>
</div>