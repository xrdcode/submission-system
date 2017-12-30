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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="{{ asset("css/select2.css") }}">
    <link rel="stylesheet" href="{{ asset("css/select2-bootstrap.css") }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>


    <style>
        .dropdown-large {
            position: static !important;
        }
        .dropdown-menu-large {
            margin-left: 16px;
            margin-right: 16px;
            padding: 20px 0px;
            min-width: 50%;
        }
        .dropdown-menu-large > li > ul {
            padding: 0;
            margin: 0;
        }
        .dropdown-menu-large > li > ul > li {
            list-style: none;
        }
        .dropdown-menu-large > li > ul > li > a {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.428571429;
            color: #EEEEEE;
            white-space: normal;
        }
        .dropdown-menu-large > li ul > li > a:hover,
        .dropdown-menu-large > li ul > li > a:focus {
            text-decoration: none;
            color: #CCCCCC;
            /*background-color: #f5f5f5;*/
        }
        .dropdown-menu-large .disabled > a,
        .dropdown-menu-large .disabled > a:hover,
        .dropdown-menu-large .disabled > a:focus {
            color: #999999;
        }
        .dropdown-menu-large .disabled > a:hover,
        .dropdown-menu-large .disabled > a:focus {
            text-decoration: none;
            background-color: transparent;
            background-image: none;
            filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
            cursor: not-allowed;
        }
        .dropdown-menu-large .dropdown-header {
            color: #FFFFFF;
            font-size: 18px;
        }
        @media (max-width: 768px) {
            .dropdown-menu-large {
                margin-left: 0 ;
                margin-right: 0 ;
            }
            .dropdown-menu-large > li {
                margin-bottom: 30px;
            }
            .dropdown-menu-large > li:last-child {
                margin-bottom: 0;
            }
            .dropdown-menu-large .dropdown-header {
                padding: 3px 15px !important;
            }
        }

        .datepicker-dropdown th, .datepicker-dropdown td {
            color: #EFEFEF;
        }

        .datepicker-dropdown .old {
            color: #BBBBBB;
        }

        .datepicker-dropdown .month:hover {
            color: #333333;
        }

        .datepicker-dropdown .focused {
            color: #333333;
        }
        .datepicker-dropdown .datepicker-switch:hover {
            color: #333333;
        }

        [data-notify="progressbar"] {
            margin-bottom: 0px;
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 100%;
            height: 5px;
        }

    </style>
    @yield("styles")
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;<li class="dropdown dropdown-large">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-large row">
                            <li class="col-md-4">
                                <ul>
                                    <li class="dropdown-header">Admin</li>
                                    <li><a href="{{ route('admin.manageadmin') }}">Manage Admin</a></li>
                                    <li><a href="{{ route('admin.managegroup') }}">Manage Group</a></li>
                                    <li><a href="{{ route('admin.managerole') }}">Manage Role</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Module</li>
                                    <li><a href="{{ route('admin.module') }}">Manage</a></li>
                                </ul>
                            </li>
                            <li class="col-md-4">
                                <ul>
                                    <li class="dropdown-header">System</li>
                                    <li><a href="#">Setting</a></li>
                                    <li><a href="#">Flash Message</a></li>
                                    <li class="divider"></li>
                                </ul>
                            </li>
                            <li class="col-md-4">
                                <ul>
                                    <li class="dropdown-header">Master</li>
                                    <li><a href="#">Identity Type</a></li>
                                    <li><a href="#">Submission Status</a></li>
                                    <li><a href="#">Workstate</a></li>
                                    <li class="divider"></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-large">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submission<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-large row">
                            <li class="col-md-4">
                                <ul>
                                    <li class="dropdown-header">Events</li>
                                    <li><a href="#">Event List</a></li>
                                    <li><a href="#">Schedule</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Submission</li>
                                    <li><a href="#">Submission List</a></li>
                                </ul>
                            </li>
                            <li class="col-md-4">
                                <ul>
                                    <li class="dropdown-header">Room</li>
                                    <li><a href="#">Room List</a></li>
                                    <li><a href="#">Submission Room</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Participant</li>
                                    <li><a href="#">User List</a></li>
                                </ul>
                            </li>
                            <li class="col-md-4">
                                <ul>
                                    <li class="dropdown-header">Pricing</li>
                                    <li><a href="#">Manage Pricing</a></li>
                                    <li><a href="#">Pricing Type</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Payments</li>
                                    <li><a href="#">General Payment</a></li>
                                    <li><a href="#">Submission Payment</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-large">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-large row">
                            <li class="col-md-4">
                                <ul>
                                    <li><a href="#">Payment Mutation</a></li>
                                    <li><a href="#">Participant Data</a></li>
                                </ul>
                            </li>
                            <li class="col-md-4">
                                <ul>
                                    <li><a href="#">A</a></li>
                                    <li><a href="#">B</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest('admin'))
                        <li><a href="{{ route('admin.login') }}">Login</a></li>
                    @else

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<div id="modal-container">

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('js/ssmath.js') }}"></script>
<script src="{{ asset("js/select2.min.js") }}"></script>
<script src="{{ asset("js/bootstrap-notify.min.js") }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>
@yield('scripts')
</body>
</html>
