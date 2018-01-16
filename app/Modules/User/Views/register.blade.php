@extends('layouts.login')

@section('content')
<div class="container">
    <form id="signup" class="form-signin" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <input class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" type="text">
            </div>
        </div>


        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-envelope"></i>
                </div>
                <input class="form-control" name="email" id="email" placeholder="E-mail" autocomplete="off" type="text">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input id="birthdate" type="text" class="form-control" placeholder="Birthdate" name="birthdate" value="" required readonly>
            </div>
        </div>


        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-phone"></i>
                </div>
                <input class="form-control" name="phone" id="phone" placeholder="Phone" autocomplete="off" type="text">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-home"></i>
                </div>
                <textarea id="address" type="text" class="form-control" name="address" placeholder="Address" required autofocus></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-lock"></i>
                </div>
                <input class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" type="password">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-lock"></i>
                </div>
                <input class="form-control" name="password_confirmation" id="password-confirm" placeholder="Password Confirmation" autocomplete="off" type="password">
            </div>
        </div>



        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
        <a class="btn btn-link" href="{{ route('user.login') }}">
            Already have an account? Click here..
        </a>
    </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#birthdate").datepicker({
                format: 'yyyy-mm-dd',
                startView: 'year',
                todayHighlight: true,
                endDate: '-17y'
            });

            ajaxSignUp("#signup");

        });





    </script>
@endsection
