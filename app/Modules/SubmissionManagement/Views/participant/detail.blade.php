@extends('layouts._modal')

@section('body')
    @php($local = !empty($user->personal_data) ? $user->personal_data->islocal ? "(Local)" : "(International)" : "")
    <table class="table table-boredered">
        <tr><td>Name</td><td>:</td><td>{{ $user->name }}</td></tr>
        <tr><td>Email</td><td>:</td><td>{{ $user->email }}</td></tr>
        <tr><td>Phone</td><td>:</td><td>{{ $user->phone }}</td></tr>
        <tr><td>Address</td><td>:</td><td>{{ $user->address }}</td></tr>
        <tr><td>From</td><td>:</td><td>{{ $user->personal_data != null ? $user->personal_data->country->name . " $local" : "Not Filled" }}</td></tr>
        <tr><td>Status</td><td>:</td><td>{{ $user->personal_data != null ? $user->personal_data->student ? "Student" : "Non-Student" : "Not Filled" }}</td></tr>
        <tr><td>Institution</td><td>:</td><td>{{ $user->personal_data != null ? $user->personal_data->institution : "Not Filled " }}</td></tr>
        <tr><td>Department</td><td>:</td><td>{{ $user->personal_data != null ? $user->personal_data->department : "Not Filled " }}</td></tr>
    </table>
@endsection

@section('footer')

@endsection

@section('scripts')

@endsection