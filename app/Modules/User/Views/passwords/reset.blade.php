@extends('layouts.login')

@section('content')
    <div class="container">
        <form class="form-signin" method="POST" action="{{ route('user.password.request') }}">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-envelope"></i>
                    </div>
                    <input id="email" type="email" class="form-control" placeholder="E-Mail" name="email" value="{{ $email or old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                    </div>
                    <input id="password" type="password" class="form-control" placeholder="Passowrd" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                    </div>
                    <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                    @endif

                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
