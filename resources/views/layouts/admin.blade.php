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
    <link href="{{ asset('css/bootstrap-dialog.css') }}" rel="stylesheet">
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

        .datepicker-dropdown .datepicker-switch {
            color: #FFFFFF;
        }

        [data-notify="progressbar"] {
            margin-bottom: 0px;
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 100%;
            height: 5px;


        }

        .modal-body {
            padding: 15px 15px;
        }

        .red {
            color: #ff0703;
        }



    </style>

    <style media="screen" type="text/css">

        table.tbl-no-wrap > thead > tr > th {
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        table.tbl-no-wrap > tbody > tr > td {
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        table.tbl-no-wrap > tbody > tr > td.force-wrap {
            min-width: 200px;
            white-space: normal;
        }

        table.tbl-no-wrap > tbody > tr > td.force-wrap-1 {
            min-width: 150px;
            white-space: normal;
        }

        table.dataTable tbody td {
            vertical-align: middle;
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
                @if(Auth::guard('admin')->check())
                    <ul class="nav navbar-nav">
                        &nbsp;

                        @if(Auth::user()->hasRole('MasterdataManagement-View, ModuleManagement-View'))
                            <li class="dropdown dropdown-large">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master<span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-large row">
                                    <li class="col-md-4">
                                        <ul>
                                            <li class="dropdown-header">Admin</li>
                                            <li><a href="{{ route('admin.manageadmin') }}">Manage Admin</a></li>
                                            <li><a href="{{ route('admin.managegroup') }}">Manage Group</a></li>
                                            <li><a href="{{ route('admin.managerole') }}">Manage Role</a></li>
                                        </ul>
                                    </li>
                                    <li class="col-md-4">
                                        <ul>
                                            <li class="dropdown-header">Module</li>
                                            <li><a href="{{ route('admin.module') }}">Manage</a></li>
                                        </ul>
                                    </li>
                                    <li class="col-md-4">
                                        <ul>
                                            <li class="dropdown-header">System</li>
                                            <li><a href="#">Setting</a></li>
                                            <li><a href="#">Flash Message</a></li>
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
                        @endif

                        <li class="dropdown dropdown-large">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submission<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-large row">
                                <li class="col-md-4">
                                    <ul>
                                        @if(Auth::user()->hasRole('EventManagement-View, ScheduleManagement-View'))
                                        <li class="dropdown-header">Events</li>
                                        @if(Auth::user()->hasRole('EventManagement-View'))
                                        <li><a href="{{ route('admin.event') }}">Manage Event</a></li>
                                        @endif
                                        <li><a href="#">Schedule <i class="glyphicon glyphicon-ban-circle red"></i></a>/li>
                                        <li class="divider"></li>
                                        @endif
                                        @if(Auth::user()->hasRole('SubmissionManagement-View'))
                                            <li class="dropdown-header">Submission</li>
                                            <li><a href="{{ route('admin.submission') }}">Submission List</a></li>
                                        @endif
                                    </ul>
                                </li>
                                @if(Auth::user()->hasRole('RoomManagement-View, UserManagement-View'))
                                <li class="col-md-4">
                                    <ul>
                                        @if(Auth::user()->hasRole('RoomManagement-View'))
                                        <li class="dropdown-header">Room</li>
                                        <li><a href="#">Room List <i class="glyphicon glyphicon-ban-circle red"></i></a></li>
                                        <li><a href="#">Submission Room <i class="glyphicon glyphicon-ban-circle red"></i></a></li>
                                        @endif
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Participant</li>
                                        <li><a href="#">User List <i class="glyphicon glyphicon-ban-circle red"></i></a></li>
                                    </ul>
                                </li>
                                @endif
                                <li class="col-md-4">
                                    <ul>
                                        @if(Auth::user()->hasRole('PricingManagement-View'))
                                        <li class="dropdown-header">Pricing</li>
                                        <li><a href="{{ route('admin.pricing') }}">Pricing</a></li>
                                        <li><a href="{{ route('admin.pricing.type') }}">Pricing Type</a></li>
                                        <li class="divider"></li>
                                        @endif
                                        @if(Auth::user()->hasRole('PaymentManagement-View'))
                                        <li class="dropdown-header">Payments</li>
                                        <li><a href="{{ route('admin.payment.submission') }}">Assign Payment</a></li>
                                                <li><a href="{{ route('admin.payment') }}">Verify Payment</a></li>
                                                <li><a href="#">Workshop Payment <i class="glyphicon glyphicon-ban-circle red"></i></a></li>
                                            @endif
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-large">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-large row">
                                <li class="col-md-4">
                                    <ul>
                                        <li><a href="#">Payment Mutation <i class="glyphicon glyphicon-ban-circle red"></i></a></li>
                                        <li><a href="#">Participant Data <i class="glyphicon glyphicon-ban-circle red"></i></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endif

            <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (!Auth::guard('admin')->check())
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
<script src="{{ asset('js/bootstrap-dialog.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('js/ssmath.js') }}"></script>
<script src="{{ asset("js/select2.min.js") }}"></script>
<script src="{{ asset("js/bootstrap-notify.min.js") }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>
@yield('scripts')
</body>
</html>
