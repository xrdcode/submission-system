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
                        <a href="{{ route('admin.module') }}" class="btn btn-info btn-sm pull-right">Back</a>
                    </div>

                    <div class="panel-body">
                        <form id="editmodule" class="form-horizontal" method="POST" action="{{ route('admin.module.update', $module->id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $module->name }}" required autofocus>

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
                                    <input id="pathname" type="text" class="form-control" name="pathname" value="{{ $module->pathname }}" required>

                                    @if ($errors->has('pathname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('pathname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ $module->description }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ $module->description }}</textarea>

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
                placeholder: "choose",
                width: "100%"
            });
        });

    </script>
@endsection