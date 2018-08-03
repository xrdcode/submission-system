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
            <label for="title" class="col-md-4 control-label">Price Name</label>
            <div class="col-md-6">
                <input name="title" type="text" value="{{ $pricing->title }}" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="price" class="col-md-4 control-label">Price</label>

            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">
                        IDR
                    </div>
                    <input id="price" type="text" class="form-control" name="price" value="{{ $pricing->price }}" style="text-align: right" required autofocus>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="early_price" class="col-md-4 control-label">Early Price</label>

            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">
                        IDR
                    </div>
                    <input id="early_price" type="text" class="form-control" name="early_price" value="{{ $pricing->early_price }}" style="text-align: right" required autofocus>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="early_price" class="col-md-4 control-label">Early Date Expired</label>

            <div class="col-md-6">
                <input id="early_date_until" type="text" class="form-control" name="early_date_until" value="{{ $pricing->early_date_until->format("Y-m-d") }}" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {{ Form::select('isparticipant', [0 => 'Non Participant', 1 => 'Participant'], $pricing->isparticipant ,["id" => "isparticipant","class" => "form-control select2-single", "required"]) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {{ Form::select('occupation', \App\Helper\Constant::OCCUPATION, \App\Helper\Constant::OCCUPATION_R[$pricing->occupation] ,["id" => "occupation","class" => "form-control select2-single", "required"]) }}
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
    <script type="text/javascript">

        ajaxSaveUpdate("#newevent", function(d) {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newevent").trigger('submit');
        });

        $("#early_date_until").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        $(".select2-single").select2({
            placholder: "Choose",
            width: "100%"
        });

        $(".select2-multiple").select2({
            placeholder: "choose",
            width: "100%"
        });


    </script>
@endsection