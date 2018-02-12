@extends('layouts._modal')

@section('body')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form id="assign" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "-" }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name" class="control-label">Select Publication:</label>
            {{ Form::select('pricing_id', $publication->submission_event->publicationlist() , !empty($publication->submission_event->pricing) ? [$publication->submission_event->pricing->id] : [] ,["id" => "pricing_id","class" => "form-control select2-single"]) }}
            <input name="submission_id" type="hidden" value="{{ $publication->id }}">
        </div>
        </form>
    </div>
</div>
@endsection

@section('footer')
<button id="save" class="btn btn-primary">
    Approve
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