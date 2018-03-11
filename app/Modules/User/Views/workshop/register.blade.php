@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form id="newsubmission" role="form" method="POST" action="{{ route('user.workshop.submit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="submission_event_id">Topics | Event</label>
                                {{ Form::select('submission_event_id', $eventlist, [] ,["id" => "submission_event_id","class" => "form-control select2-single"]) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pricing_id">Topics</label>
                                <select id="workshoplist" name="pricing_id" data-need="#submission_event_id" data-src="{{ url('api/workshop/list') }}" class="form-control select2-single"></select>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            userSaveUpload("#newsubmission",
                function(d) {
                    if(d.success) {
                        showAlert('Your submission has been registered','success','Success:')
                        setTimeout(function() {
                            location.href = '{{ route('user.submission') }}'
                        }, 1000);
                    }
                },
                function(xHr) {
                    showAlert('Something when wrong.. Please contact the administrator if the problem persists','danger','Error:')
                }
            );

            $('.select2-single').select2({
                placholder: "Choose"
            })

            loadListOption("#workshoplist")
        });
    </script>
@endsection