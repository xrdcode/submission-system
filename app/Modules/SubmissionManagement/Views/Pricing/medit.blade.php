@extends('layouts._modal')

@section('body')
    <form id="newevent" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
        {{ csrf_field() }}

        <div id="eventselect" class="form-group">
            <label for="event" class="col-md-4 control-label">Event</label>
            <div class="col-md-6 col-md-4">
                <input type="text" class="form-control" name="event" value="{{ $pricing->submission_event->name }}" disabled>
                <input type="hidden"  name="submission_event_id" value="{{ $pricing->submission_event_id }}">
            </div>
        </div>

        <div id="typeselect" class="form-group">
            <label for="type" class="col-md-4 control-label">Type</label>
            <div class="col-md-6 col-md-4">
                <input type="text" class="form-control" name="type" value="{{ $pricing->pricing_type->name }}" disabled>
                <input type="hidden"  name="pricing_type_id" value="{{ $pricing->pricing_type_id }}">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Price</label>

            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">
                        Rp
                    </div>
                    <input id="price" type="text" class="form-control" name="price" value="{{ $pricing->price }}" style="text-align: right" required autofocus>
                </div>
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

        ajaxSaveUpdate("#newevent", function(d) {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newevent").trigger('submit');
        });

        $(".select2-multiple").select2({
            placeholder: "choose"
        });
    </script>
@endsection