@extends('layouts._modal')

@section('body')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form id="assign" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "-" }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name" class="control-label">Publication</label>
                    {{ Form::select('pricing_id', $submission->submission_event->publicationlist(), !empty($submission->publication) ? [$submission->payment_submission->pricing->id]  : []  ,["id" => "pricing_id","class" => "form-control select2-single"]) }}
                    <input name="submission_id" type="hidden" value="{{ $submission->id }}">
                </div>

            </form>
        </div>
    </div>
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


    </script>
@endsection