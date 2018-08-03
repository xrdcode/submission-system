@extends('layouts._modal')

@section('body')
    <form id="editgroup" class="form-horizontal" method="POST" action="{{ route('admin.managegroup.update', $group->id) }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ $group->name }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="address" class="col-md-4 control-label">Description</label>

            <div class="col-md-6">
                <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ $group->description }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label for="rolelist" class="col-md-4 control-label">Roles</label>
            <div class="col-md-6 col-md-4">
                {{ Form::select('rolelist[]', $rolelist, $group->selectedRole() ,["id" => "grouplist","class" => "form-control select2-multiple", "multiple"]) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
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

        $('#editgroup').unbind();

        ajaxSaveUpdate("#editgroup", function() {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#editgroup").trigger('submit');
        });


    </script>
@endsection