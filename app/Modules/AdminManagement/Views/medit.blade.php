@extends('layouts._modal')

@section('body')

    <form id="editadmin" class="form-horizontal" method="POST" action="{{ route('admin.manageadmin.update', $admin->id) }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ $admin->name }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ $admin->email }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div>
        </div>


        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label for="username" class="col-md-4 control-label">Phone</label>

            <div class="col-md-6">
                <input id="phone" type="text" class="form-control" name="phone" value="{{ $admin->phone }}" required autofocus>

                @if ($errors->has('phone'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label for="address" class="col-md-4 control-label">Address</label>

            <div class="col-md-6">
                <textarea id="address" type="text" class="form-control" name="address" required autofocus>{{ $admin->address }}</textarea>

                @if ($errors->has('address'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('grouplist') ? ' has-error' : '' }}">
            <label for="address" class="col-md-4 control-label">Groups</label>
            <div class="col-md-6 col-md-4">
                {{ Form::select('grouplist[]', $grouplist, $admin->selectedGroup() ,["id" => "grouplist","class" => "form-control select2-multiple", "multiple"]) }}
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

        $('#editadmin').unbind();

        ajaxSaveUpdate("#editadmin", function() {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#editadmin").trigger('submit');
        });


    </script>
@endsection