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
            height: 100%;
        }


        body {
            height: 100%;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #303641;
            color: #C1C3C6
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

        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
            cursor: not-allowed;
            background-color: #373e4a;
            opacity: 1;
        }
    </style>
</head>
<body data-gr-c-s-loaded="true" style="height:100%">
    @yield("content")
<div class="clearfix"></div>
<br><br>
<script type="text/javascript" src="{{ asset("/js/bf-admin.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('js/ssmath.js') }}"></script>
<script src="{{ asset("js/select2.min.js") }}"></script>
<script src="{{ asset("js/bootstrap-notify.min.js") }}"></script>

@yield("scripts")



</body></html>