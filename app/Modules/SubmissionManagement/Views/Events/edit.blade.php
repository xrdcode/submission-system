@extends('layouts.admin')

@section('styles')
    <style>
        .clickable:active {
            opacity: 0.1;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {{--{!! Breadcrumbs::render() !!}--}}
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Edit User
                        <a href="{{ route('admin.events.manage') }}" class="btn btn-info btn-sm pull-right">Back</a>
                    </div>

                    <div class="panel-body">
                        <form id="editmodule" class="form-horizontal" method="POST" action="{{ route('admin.events.update', $event->id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $event->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('valid_from') ? ' has-error' : '' }}">
                                <label for="valid_from" class="col-md-4 control-label">Date Range Event</label>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5 col-sm-5">
                                            <input id="valid_from" type="text" class="form-control" name="valid_from" value="{{ $event->valid_from }}" required>
                                        </div>
                                        <div class="col-md-2 col-sm 2">
                                            -
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <input id="valid_thru" type="text" class="form-control" name="valid_thru" value="{{ $event->valid_thru }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ $event->description }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#birthdate").datepicker({
                format: 'yyyy-mm-dd',
                startView: 'year',
                todayHighlight: true,
                setDate: new Date(),
                endDate: '-17y'
            });
            

            ajaxSaveUpdate('#editmodule');

            $(".select2-multiple").select2({
                placeholder: "choose"
            });
        });

    </script>
@endsection