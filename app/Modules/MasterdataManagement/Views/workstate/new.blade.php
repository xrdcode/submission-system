@extends('layouts._modal')

@section('body')
    <form id="newws" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
            </div>
        </div>
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="address" class="col-md-4 control-label">Description</label>

            <div class="col-md-6">
                <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="form-group{{ $errors->has('workstate_type') ? ' has-error' : '' }}">
            <label for="type" class="col-md-4 control-label">Type</label>
            <div class="col-md-6 col-md-4">
                {{ Form::select('workstate_type_id', $typelist, [] ,["id" => "workstate_type_id","class" => "form-control select2-single"]) }}
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

        ajaxSaveUpdate("#newws", function() {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newws").trigger('submit');
        });



    </script>
@endsection