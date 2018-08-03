@extends('layouts._modal')

@section('body')
    <form id="newbank" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "" }}">
        {{ csrf_field() }}

        <div id="banklist" class="form-group">
            <label for="parent_id" class="col-md-4 control-label">Parent</label>
            <div class="col-md-6">
                {{ Form::select('bank', \App\Helper\Constant::BANK_LIST, [] ,["id" => "bank","class" => "form-control select2-single"]) }}
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Account Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="number" class="col-md-4 control-label">Account Number</label>

            <div class="col-md-6">
                <input id="number" type="text" class="form-control" name="number" value="" required autofocus>
            </div>
        </div>


        <div class="form-group">
            <label for="notes" class="col-md-4 control-label">Notes</label>

            <div class="col-md-6">
                <textarea id="notes" type="text" class="form-control" name="description"></textarea>

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

        ajaxSaveUpdate("#newbank", function(d) {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#newbank").trigger('submit');
        });

    </script>
@endsection