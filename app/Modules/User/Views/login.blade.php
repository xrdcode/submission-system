@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row" style="text-align: center">
        <img src="{{ asset('img/cropped-Logo-Icere.png') }}" width="300px">
        </br>
        </br>
        </br>
    </div>
    <form id="user-login" class="form-signin" method="POST" action="{{ route('user.login') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <input class="form-control" name="email" id="email" placeholder="Username" autocomplete="off" type="text">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class=" glyphicon glyphicon-lock "></i>
                </div>
                <input class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" type="password">
            </div>
        </div>

        <label class="checkbox">
            <div class="icheckbox_flat" style="position: relative;"><input name="remember" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" type="checkbox"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div> &nbsp; Remember me
        </label>
        <div class="pull-right">
            <button class="btn btn-xm btn-info" type="submit">Log in</button>
            <a class="btn btn-xm btn-info" href="{{ route('register') }}">Register</a>
        </div>
        <a class="btn btn-link" href="{{ route('user.password.request') }}">
            Forgot Your Password?
        </a>
    </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            ajaxAuth("#user-login");
        });
    </script>

@endsection
