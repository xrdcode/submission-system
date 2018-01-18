@extends('layouts.user')

@section('content')
    <div class="row">
        <form id="saveprofile" class="form-vertical" method="POST" action="{{ route('user.profile.security') }}">
            {{ csrf_field() }}
            <div class="col-md-6 col-md-offset-3">
                <label for="name">Old Password:</label>
                <div class="form-group">
                    <input class="form-control" name="old_password" id="old_password" placeholder="Old Password" autocomplete="off" type="password">
                </div>
                <div class="form-group">
                    <label for="email">New Password:</label>
                    <input class="form-control" name="password" id="password" placeholder="New Password" autocomplete="off" type="password">
                </div>
                <div class="form-group">
                    <label for="birthdate">Password Confirmation:</label>
                    <input id="password_confirmation" type="password" class="form-control" placeholder="Password Confirmation" name="password_confirmation"  required>
                </div>
            </div>
            <div class="col-md-12">
                <button id="save" type="submit" class="btn btn-default pull-right">Save</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#birthdate").datepicker({
                format: 'yyyy-mm-dd',
                startView: 'year',
                todayHighlight: true,
                endDate: '-17y'
            });

        });

        ajaxSaveUpdate("#saveprofile", function(data) {
            setTimeout(function() {
                location.reload();
            }, 1000)
        });

        $(".select2-single").select2({});


    </script>
@endsection
