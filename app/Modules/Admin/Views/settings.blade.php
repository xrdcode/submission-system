@extends('layouts.admin')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Site Setting</div>

                    <div class="panel-body">
                        <form id="setting" method="POST" action="{{ route('admin.settings.update') }}" class="form-horizontal">
                            {{ csrf_field() }}
                            @php($i = 0)
                            @foreach($settings as $setting)
                                <div class="form-group">
                                    <label for="" class="col-md-4 control-label">{{ ucwords(str_replace('_',' ', $setting->name)) }}</label>
                                    <div class="col-md-8">
                                        <input name="setting[{{ $i }}][name]" type="hidden" class="form-control" value="{{ $setting->name }}">
                                        <input name="setting[{{ $i++ }}][value]" type="text" class="form-control" value="{{ $setting->value }}">
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary pull-right">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            ajaxSaveUpdate("#setting");
        });
    </script>
@endsection