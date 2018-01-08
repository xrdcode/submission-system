@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form id="newsubmission" role="form" method="POST" action="{{ route('user.submission.submit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="submission_event_id">Submission Event</label>
                    {{ Form::select('submission_event_id', $eventlist, [] ,["id" => "submission_event_id","class" => "form-control select2-single"]) }}

                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" name="title" placeholder="Paper Title" type="text">
                </div>
                <div class="form-group">
                    <label for="abstract">Abstract</label>
                    <textarea required="" class="form-control" placeholder="Abstract" rows="10" cols="30" id="description" name="abstract"></textarea>
                </div>
                <div class="form-group">
                    <label for="file">Abstract File (.PDF)</label>
                    <input type="file" required="" class="" placeholder=""  id="description" name="file">
                </div>
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
        });
    </script>
@endsection