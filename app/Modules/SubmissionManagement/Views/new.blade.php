@extends('layouts._modal')

@section('body')
    <form id="newmodule" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('pathname') ? ' has-error' : '' }}">
            <label for="pathname" class="col-md-4 control-label">Path Name</label>

            <div class="col-md-6">
                <input id="pathname" type="text" class="form-control" name="pathname" value="{{ old('pathname') }}" placeholder="PathName" required autofocus>

                @if ($errors->has('pathname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pathname') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="address" class="col-md-4 control-label">Description</label>

            <div class="col-md-6">
                <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ old('description') }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
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

        ajaxSaveUpdate("#newmodule");

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newmodule").trigger('submit');
        });


    </script>
@endsection