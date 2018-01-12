@extends('layouts._modal')

@section('body')

    <form id="assign" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "-" }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                {{ Form::select('pricing_id', $submission->pricelist(), !empty($submission->payment_submission) ? [$submission->payment_submission->pricing->id]  : []  ,["id" => "pricing_id","class" => "form-control select2-single"]) }}
            </div>
            <input name="submission_id" type="hidden" value="{{ $submission->id }}">
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

        $('#assign').unbind();

        ajaxSaveUpdate("#assign", function() {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#assign").trigger('submit');
        });

        $(".select2-multiple").select2({
            placeholder: "choose"
        });
    </script>
@endsection