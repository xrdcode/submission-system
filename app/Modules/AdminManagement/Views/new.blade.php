@extends('layouts._modal')

@section('body')

    <form id="newadmin" class="form-horizontal" method="POST" action="{{ route('admin.manageadmin.save') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="" required>
            </div>
        </div>


        <div class="form-group">
            <label for="username" class="col-md-4 control-label">Phone</label>

            <div class="col-md-6">
                <input id="phone" type="text" class="form-control" name="phone" value="" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="col-md-4 control-label">Address</label>

            <div class="col-md-6">
                <textarea id="address" type="text" class="form-control" name="address" required autofocus></textarea>
                
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="col-md-4 control-label">Groups</label>
            <div class="col-md-6 col-md-4">
                {{ Form::select('grouplist[]', $grouplist, [] ,["id" => "grouplist","class" => "form-control select2-multiple", "multiple"]) }}
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

        $('#newadmin').unbind();

        ajaxSaveUpdate("#newadmin", function() {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newadmin").trigger('submit');
        });



    </script>
@endsection