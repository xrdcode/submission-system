@extends('layouts._modal')

@section('body')
    <form id="room" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ $room->name }}" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="number" class="col-md-4 control-label">Number</label>

            <div class="col-md-6">
                <input id="number" type="text" class="form-control" name="number" value="{{ $room->number }}" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="building" class="col-md-4 control-label">Building</label>

            <div class="col-md-6">
                <input id="building" type="text" class="form-control" name="building" value="{{ $room->building }}" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="col-md-4 control-label">Description</label>

            <div class="col-md-6">
                <textarea id="description" type="text" class="form-control" name="address" required autofocus>{{ $room->address }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="notes" class="col-md-4 control-label">Notes</label>

            <div class="col-md-6">
                <textarea id="notes" type="text" class="form-control" name="notes" required autofocus>{{ $room->notes }}</textarea>
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

        ajaxSaveUpdate("#room", function() {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#room").trigger('submit');
        });

    </script>
@endsection