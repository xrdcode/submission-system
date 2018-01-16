@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form id="editsubmission" role="form" method="POST" action="{{ route('user.submission.edit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <fieldset>
                    <legend>Submission Detail</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="submission_event_id">Submission Event</label>
                                <input type="hidden" name="submission_event_id" value="{{ $submission->submission_event_id }}">
                                <input type="text" class="form-control" name="submission.name" value="{{ $submission->submission_event->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="submission_event_id">Type of Submission (Presentation)</label>
                                {{ Form::select('submission_type_id', \App\Models\BaseModel\SubmissionType::getlist(), [] ,["id" => "submission_type_id","class" => "form-control select2-single"]) }}

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control" id="title" name="title" placeholder="Paper Title" type="text" value="{{ $submission->title }}">
                    </div>
                    <div class="form-group">
                        <label for="abstract">Abstract</label>
                        <textarea class="form-control" placeholder="Abstract" rows="10" cols="30" id="abstract" name="abstract"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Abstract File (.PDF)</label>
                        <input type="file" required="" class="" placeholder=""  id="description" name="file">
                    </div>
                </fieldset>

                 <input type="hidden" name="id" id="id" value="{{ $submission->id }}">
               <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#abstract").val('{{ $submission->abstract }}');

            userSaveUpload("#editsubmission",
                function(d) {
                    if(d.success) {
                        showAlert('Your submission has been updated','success','Success:')
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
            });
        });
    </script>
@endsection