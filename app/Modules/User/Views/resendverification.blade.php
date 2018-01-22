@extends('layouts.login')
@section('content')
    <div class="container">

        <form class="form-signin" method="POST" action="{{ route('user.sendverification') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-envelope"></i>
                    </div>
                    <input id="email" type="text" class="form-control" name="email" placeholder="E-Mail" value="{{ old('email') }}" required autofocus>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <button id="simpan" type="submit" class="btn btn-primary pull-right">
                    Resend Verification
                </button>
            </div>
        </form>
    </div>
@endsection