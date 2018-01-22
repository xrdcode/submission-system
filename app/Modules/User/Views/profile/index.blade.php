@extends('layouts.user')

@section('content')
    <div class="row">
        <form id="saveprofile" class="form-vertical" method="POST" action="{{ route('user.profile.update') }}">
            {{ csrf_field() }}
            <div class="col-md-6">
                <label for="name">Name:</label>
                <div class="form-group">
                    <input class="form-control" name="name" id="name" placeholder="Name" value="{{ $user->name }}" autocomplete="off" type="text">
                </div>
                <div class="form-group">
                    <label for="email">Mail:</label>
                    <input class="form-control" name="email" id="email" placeholder="E-mail" value="{{ $user->email }}" autocomplete="off" type="text" readonly>
                </div>
                <div class="form-group">
                    <label for="birthdate">Birth Date:</label>
                    <input id="birthdate" type="text" class="form-control" placeholder="Birthdate" name="birthdate" value="{{ $user->birthdate }}" required readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ $user->phone }}" autocomplete="off" type="text">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" type="text" class="form-control" name="address" placeholder="Address" required>{{ $user->address }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Institution:</label>
                    <input class="form-control" name="institution" id="institution" placeholder="Institution" value="{{ isset($user->personal_data->institution) ? $user->personal_data->institution : "" }}" autocomplete="off" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">Department:</label>
                    <input class="form-control" name="department" id="department" placeholder="Department"  value="{{ isset($user->personal_data->department) ? $user->personal_data->department : "" }}" autocomplete="off" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">I am:</label>
                    {{ Form::select('student', [0 => 'Non-Student', 1 => 'Student'], $user->student,['class' => 'form-control select2-single']) }}
                </div>
                <div class="form-group">
                    <label class="control-label">ID Card Number:</label>
                    <input class="form-control" name="nik" id="nik" placeholder="National Identification Number (NIK)"  value="{{ isset($user->personal_data->nik) ? $user->personal_data->nik : "" }}" autocomplete="off" type="text">
                </div>
                <div class="form-group">
                    <label for="identity_type_id">Another ID Card Information</label>
                    {{ Form::select('identity_type_id', \App\Models\BaseModel\IdentityType::getList(), isset($user->personal_data) ? $user->personal_data->identity_type_id : null, ["class" => "form-control select2-single"]) }}

                </div>
                <div class="form-group">
                    <input class="form-control" name="identity_number" id="identity_number" placeholder="Another Identity Number"  value="{{ isset($user->personal_data->identity_number) ? $user->personal_data->identity_number : "" }}" autocomplete="off" type="text">
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

        ajaxSaveUpdate("#saveprofile");

        $(".select2-single").select2({});


    </script>
@endsection
