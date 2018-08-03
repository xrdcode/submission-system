@extends('layouts._modal')

@section('body')
    <form id="newevent" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
        {{ csrf_field() }}

        <div id="eventselect" class="form-group">
            <label for="parent" class="col-md-4 control-label">Event</label>
            <div class="col-md-6 col-md-4">
                {{ Form::select('submission_event_id[]', $eventlist, [] ,["id" => "submission_event_id","class" => "form-control select2-multiple", "required","multiple"]) }}
            </div>
        </div>

        <div id="typeselect" class="form-group">
            <label for="parent" class="col-md-4 control-label">Type</label>
            <div class="col-md-6 col-md-4">
                {{ Form::select('pricing_type_id', $typelist, [] ,["id" => "pricing_type_id","class" => "form-control select2-single", "required"]) }}
            </div>
        </div>

        <div class="form-group">
            <label for="title" class="col-md-4 control-label">Price Name</label>
            <div class="col-md-6">
                <input name="title" type="text" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="price" class="col-md-4 control-label">Price</label>

            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">
                        Rp
                    </div>
                    <input id="price" type="text" class="form-control" name="price" value="" style="text-align: right" required autofocus>
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
                    <input id="early_price" type="text" class="form-control" name="early_price" value="" style="text-align: right" required autofocus>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="early_price" class="col-md-4 control-label">Early Date Expired</label>

            <div class="col-md-6">
                <input id="early_date_until" type="text" class="form-control" name="early_date_until" value="" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {{ Form::select('isparticipant', [0 => 'Non Participant', 1 => 'Participant'], [] ,["id" => "isparticipant","class" => "form-control select2-single", "required"]) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {{ Form::select('occupation', \App\Helper\Constant::OCCUPATION, [] ,["id" => "occupation","class" => "form-control select2-single", "required"]) }}
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
    {{-- <script src="{{ asset('js/ssmath.js') }}"></script> --}}
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