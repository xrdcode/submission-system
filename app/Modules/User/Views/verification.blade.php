@extends('layouts.login')
@section('content')
    <div class="container">
        <div class="row center-block">
            <br>
            <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-default">
                <h4>Heads up!</h4>
                <p style="font-size: 18px">Your account need verification, we've sent verification link to your email, please check your inbox or spam folder.</p>
                <p><a class="btn btn-success pull-right" href="{{ route('user.login') }}">Log in</a></p>
            </div>
        </div>
    </div>
    </div>
@endsection