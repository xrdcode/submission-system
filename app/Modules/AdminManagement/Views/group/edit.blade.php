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
                        <a href="{{ route('admin.managegroup') }}" class="btn btn-info btn-sm pull-right">Back</a>
                    </div>

                    <div class="panel-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            ajaxSaveUpdate('#editgroup');

            $(".select2-multiple").select2({
                placeholder: "choose"
            });
        });

    </script>
@endsection