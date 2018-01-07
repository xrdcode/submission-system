@extends('layouts.login')
@section('content')
    <div class="container">
        <div class="center-block">
            <p>An email has been sent to {{ isset($email) ? $email : "-"  }}. Please confirm your email to finishing sign up process.</p>
        </div>
    </div>
@endsection