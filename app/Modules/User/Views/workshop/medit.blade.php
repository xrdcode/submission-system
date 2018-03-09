@extends('layouts._modal')

@section('body')
    <form id="editws" role="form" method="POST" action="{{ route('user.workshop.update', $gp->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="submission_event_id">Topics | Event</label>
                    <input type="text" class="form-control" value="{{ $gp->submission_event->name }}" disabled readonly>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="pricing_id">Topics</label>
                    {{ Form::select('pricing_id', $gp->submission_event->workshoplist(), [$gp->pricing_id] ,["id" => "pricing_id","class" => "form-control select2-single"]) }}
                    <input name="submission_event_id" type="hidden" value="{{ $gp->submission_event_id }}">
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
    <script type="text/javascript">
        $(document).ready(function() {

            ajaxSaveUpdate("#editws", function(d) {
                var table = $("#datalist").DataTable();
                table.draw();
            });

            $('.select2-single').select2({
                placholder: "Choose",
                width: "100%"
            });

            $('#save').on('click', function(e) {
                e.preventDefault();

                $("#editws").trigger('submit');
            });

        });
    </script>
@endsection