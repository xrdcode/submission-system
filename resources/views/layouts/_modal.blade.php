<div class="modal fade" id="{{ isset($modalId) ? $modalId : "myModal" }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog {{ isset($class) ? $class : "" }}" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{isset($title) ? $title : ""}}</h4>
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

@yield('scripts')