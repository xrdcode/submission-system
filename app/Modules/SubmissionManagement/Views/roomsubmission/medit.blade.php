@extends('layouts._modal')

@section('body')

    <form id="assign_room" class="form-horizontal" method="POST" action="{{ isset($action) ? $action : "-" }}">
        {{ csrf_field() }}
        <input type="hidden" id="submission_list" name="submission_id" value="{{ $rs->submission_id }}">

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Room</label>

            <div class="col-md-6">
                <select id="room_list" name="room_id" data-src="{{ url('admin/submission/room/room_slist') }}"></select>
            </div>
        </div>

        <div class="form-group{{ $errors->has('valid_from') ? ' has-error' : '' }}">
            <label for="valid_from" class="col-md-4 control-label">Presentation Date</label>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <input id="datetimes" type="text" class="form-control" name="datetimes" value="{{ $rs->datetimes->format("Y-m-d") }}" readonly required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('valid_from') ? ' has-error' : '' }}">
            <label for="valid_from" class="col-md-4 control-label">Presentation Time (H:M)</label>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <select id="hours" class="form-control select2-single" name="hours" value="{{ old('hours') }}">
                            @for($i=0; $i < 24;$i++)
                                @if($i >= 10)
                                    <option {{ $rs->datetimes->format("H") == "$i" ? "selected" : ""  }} value="{{ $i }}">{{ $i }}</option>
                                @else
                                    <option {{ $rs->datetimes->format("H") == "0$i" ? "selected" : ""  }} value="0{{ $i }}">0{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <select id="minutes" class="form-control select2-single" name="minutes" value="{{ old('minutes') }}">
                            @for($i=0; $i < 60;$i+=5)
                                @if($i >= 10)
                                    <option {{ $rs->datetimes->format("i") == "$i" ? "selected" : ""  }} value="{{ $i }}">{{ $i }}</option>
                                @else
                                    <option {{ $rs->datetimes->format("i") == "0$i" ? "selected" : ""  }} value="0{{ $i }}">0{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
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

        $("#datetimes").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        $('#assign').unbind();

        ajaxSaveUpdate("#assign_room", function() {
            var table = $("#datalist").DataTable();
            table.draw();
        });

        $('#save').on('click', function(e) {
            e.preventDefault();

            $("#assign_room").trigger('submit');
        });

        $(".select2-single").select2({});

        loadListOption("#room_list");

    </script>
@endsection