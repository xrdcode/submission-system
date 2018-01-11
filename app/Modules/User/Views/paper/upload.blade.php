@extends('layouts._modal')

@section('body')

    <form id="uploads" class="form-vertical" method="POST" action="{{ isset($action) ? $action : "-" }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="file">Paper Upload</label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input name="file" type="file" style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" required readonly>
            </div>
            <input type="hidden" name="submission_id" value="{{ $s->id }}" readonly>
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

        $('#uploads').unbind();

        userSaveUpload("#uploads",
            function(d) {
                if(d.success) {
                    showAlert('The file has been uploaded','success','Success:')
                    var table = $("#datalist").DataTable();
                    table.draw();
                }
            },
            function(xHr) {
                showAlert('Something when wrong.. Please contact the administrator if the problem persists','danger','Error:')
            }
        );


        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#uploads").trigger('submit');
        });



    </script>
@endsection