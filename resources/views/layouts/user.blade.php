<!DOCTYPE html>
<html class="gr__" lang="{{ app()->getLocale() }}"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset("css/animate.css") }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sites.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="{{ asset("css/select2.css") }}">
    <link rel="stylesheet" href="{{ asset("css/select2-bootstrap.css") }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>

</head>
<body data-gr-c-s-loaded="true">
<div id="app">

    <!--nav-->
    <nav role="navigation" class="navbar navbar-custom">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button data-target="#bs-content-row-navbar-collapse-5" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">{{ env('APP_NAME', '') }}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div id="bs-content-row-navbar-collapse-5" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('user.login') }}">{{ __('apps.menu.login') }}</a></li>
                        <li><a href="{{ route('register') }}">{{ __('apps.menu.register') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#">{{ __('apps.menu.profile') }}</a>
                                </li>
                                <li>
                                    <a href="#"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('apps.menu.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!--header-->
    <div class="container-fluid">
        <!--documents-->
        <div class="row row-offcanvas row-offcanvas-left">
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
                <ul class="list-group panel">
                    <li class="list-group-item"><i class="glyphicon glyphicon-align-justify"></i> <b></b></li>
                    {{--<li class="list-group-item"><input class="form-control search-query" placeholder="Search Something" type="text"></li>--}}
                    <li class="list-group-item"><a href="{{ route('user') }}"><i class="glyphicon glyphicon-home"></i>Dashboard </a></li>
                    <li>
                        <a href="#submissions" class="list-group-item " data-toggle="collapse"><i class="glyphicon glyphicon-list"></i>Submission  <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <div class="collapse" id="submissions">
                            <a href="{{ route('user.submission.register') }}" class="list-group-item">Register</a>
                            <a href="{{ route('user.submission') }}" class="list-group-item">List</a>
                        </div>
                    </li>
                    <li>
                        <a href="#payment" class="list-group-item " data-toggle="collapse"><i class="glyphicon glyphicon-list"></i>Payment  <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <div class="collapse" id="payment">
                            <a href="{{ route('user.payment') }}" class="list-group-item">Speakers</a>
                            <a href="" class="list-group-item">Non-Speaker</a>
                            <a href="" class="list-group-item">History</a>
                        </div>
                    </li>
                    <li>
                        <a href="#faq" class="list-group-item " data-toggle="collapse">Profile<span class="glyphicon glyphicon-chevron-right"></span></a>
                    </li>
                    <li class="collapse" id="faq">
                        <a href="" class="list-group-item">Subitem 1</a>
                        <a href="" class="list-group-item">Subitem 2</a>
                        <a href="" class="list-group-item">Subitem 3</a>
                    </li>

                </ul>
            </div>
            <div class="col-xs-12 col-sm-9 content">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a> Panel Title</h3>
                    </div>
                    <div class="panel-body">
                        @yield('content')
                    </div><!-- panel body -->
                </div>
            </div><!-- content -->
        </div>
    </div>

</div>

<div id="modal-container">

</div>

<script type="text/javascript" src="/js/bf-admin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('js/ssmath.js') }}"></script>
<script src="{{ asset("js/select2.min.js") }}"></script>
<script src="{{ asset("js/bootstrap-notify.min.js") }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>

@yield('scripts',"")

</body></html>