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
                        <a href="{{ route('admin.manageadmin') }}" class="btn btn-info btn-sm pull-right">Back</a>
                    </div>

                    <div class="panel-body">
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

                            {{-- <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                 <label for="password" class="col-md-4 control-label">Password</label>

                                 <div class="col-md-6">
                                     <input id="password" type="password" class="form-control" name="password" required>

                                     @if ($errors->has('password'))
                                         <span class="help-block">
                                         <strong>{{ $errors->first('password') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group">
                                 <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                 <div class="col-md-6">
                                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                 </div>
                             </div>--}}
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-4 control-label">Groups</label>
                                <div class="col-md-6 col-md-4">
                                    {{ Form::select('grouplist[]', $grouplist, $admin->selectedGroup() ,["id" => "grouplist","class" => "form-control select2-multiple", "multiple"]) }}
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
            

            ajaxSaveUpdate('#editadmin');

            $(".select2-multiple").select2({
                placeholder: "choose"
            });
        });

    </script>
@endsection