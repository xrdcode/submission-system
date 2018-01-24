@extends('layouts._modal')

@section('body')
    <form id="newevent" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
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

        <div class="form-group{{ $errors->has('valid_from') ? ' has-error' : '' }}">
            <label for="valid_from" class="col-md-4 control-label">Date Range</label>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <input id="valid_from" type="text" class="form-control" name="valid_from" value="{{ old('valid_from') }}" readonly required>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input id="valid_thru" type="text" class="form-control" name="valid_thru" value="{{ old('valid_thru') }}" readonly required>
                    </div>
                </div>
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

        <div class="form-group{{ $errors->has('hasparent') ? ' has-error' : '' }}">
            <label for="address" class="col-md-4 control-label">Has Parent?</label>

            <div class="col-md-6">
                <input id="hasparent" name="hasparent"  type="checkbox" class="form-inline">
            </div>
        </div>

        <div id="selectparent" class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}" style="display: none">
            <label for="parent_id" class="col-md-4 control-label">Parent</label>
            <div class="col-md-6">
                {{ Form::select('parent_id', $parentlist, [] ,["id" => "parent","class" => "form-control select2-single", "disabled"]) }}
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
    <script src="{{ asset('js/ssmath.js') }}"></script>
    <script type="text/javascript">

        ajaxSaveUpdate("#newevent", function(d) {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newevent").trigger('submit');
        });




        $('#hasparent').change(function() {
            if($(this).is(':checked')) {
                $("select#parent").prop('disabled', false);
                $('#selectparent').fadeIn();
            } else {
                $("select#parent").prop('disabled', true);
                $('#selectparent').fadeOut();
            }
        });

        setupDateRange("#valid_from", "#valid_thru");
    </script>
@endsection