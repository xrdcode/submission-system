@extends('layouts.login')

@section('content')
    <div class="container">

        <form class="form-signin" method="POST" action="{{ route('user.password.email') }}">
            {{ csrf_field() }}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <p>
                Reset password
            </p>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-envelope"></i>
                    </div>
                    <input id="email" type="email" class="form-control" name="email" placeholder="E-Mail" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">

                <button type="submit" class="btn btn-primary pull-right">
                    Send Password Reset Link
                </button>

            </div>
        </form>
    </div>
@endsection
