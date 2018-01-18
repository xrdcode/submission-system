@extends('layouts._modal')

@section('body')
    <form id="newtype" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
        {{ csrf_field() }}

        <div id="eventselect" class="form-group">
            <label for="event" class="col-md-4 control-label">Name:</label>
            <div class="col-md-6 col-md-4">
                <input type="text" class="form-control" name="name" autocomplete="off">
            </div>
        </div>

        <div id="typeselect" class="form-group">
            <label for="type" class="col-md-4 control-label">Description:</label>
            <div class="col-md-6 col-md-4">
                <input type="text" class="form-control" name="description" autocomplete="off">
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <button id="save" class="btn btn-primary">
        Save
    </button>
@endsection

@section('scripts')
    <script src="{{ asset('js/ssmath.js') }}"></script>
    <script type="text/javascript">

        ajaxSaveUpdate("#newtype", function(d) {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newtype").trigger('submit');
        });

        $(".select2-multiple").select2({
            placeholder: "choose"
        });
    </script>
@endsection