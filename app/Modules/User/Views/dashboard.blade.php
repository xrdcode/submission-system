@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Account Information</h3>
                </div>
                <div class="panel-body">
                    <table>
                        <tbody>
                            <tr>
                                <td width="20%">Name</td>
                                <td width="5%"> : </td>
                                <td width="75%">{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td width="20%">E-Mail</td>
                                <td width="5%"> : </td>
                                <td width="75%">{{ Auth::user()->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Progress Log</h3>
                </div>
                <div class="panel-body" style="max-height: 600px; overflow-x: scroll">
                    @if(Auth::user()->user_notifications->count() == 0)
                        <p>Empty</p>
                    @endif
                    <ul class="media-list">
                        @foreach(Auth::user()->user_notifications()->latest("created_at")->get() as $un)
                            <li class="media">
                                <a class="pull-right" href="#"></a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $un->title }}</h4>
                                    <p>{{ $un->created_at }}</p>
                                    <p style="color: #2B303A">{!! $un->body !!}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
