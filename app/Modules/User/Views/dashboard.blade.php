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

        </div>
    </div>

@endsection
