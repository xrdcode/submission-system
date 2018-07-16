<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset("css/animate.css") }}" />
    <link rel="stylesheet" href="{{ asset("css/bootstrap.css") }}" />
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/sites.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
    <style>
        html {
            height: 100vh;
        }


        body {
            height: 95vh;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        textarea {
            resize: none !important;
        }

        .center-block {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .content {
            min-height: 90%;
        }

        .footer {
            min-height: 10%;
        }
    </style>
</head>
<body data-gr-c-s-loaded="true" style="background-image: url('{{ asset("img/Background-Web-ICERE-1.jpg") }}');background-repeat: no-repeat;background-position: top center">
<div class="content">
    @yield("content")
</div>
<div class="clearfix"></div>
<footer class="footer site-footer login-footer" style="background-color: rgba(255,255,255, 0.5);padding: 40px 0 70px">
    <div class="container">
        <div class="copyright clearfix text-center">
            <p>
                <a href="{{ route('user.login') }}">Log In</a> &blacktriangleright;
                <a href="{{ route('user.resendverification') }}">Resend Verification</a> &blacktriangleright;
                <a href="#">FAQ</a> &blacktriangleright;
                <a href="#">{{ config('app.name') }}</a>
            </p>
            <p> Lab Matematika UNJ &copy; 2018</p>
        </div>
    </div>
</footer>
<script type="text/javascript" src="{{ asset("/js/bf-admin.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('js/ssmath.js') }}"></script>
<script src="{{ asset("js/select2.min.js") }}"></script>
<script src="{{ asset("js/bootstrap-notify.min.js") }}"></script>

@yield("scripts")



</body></html>