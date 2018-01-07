@extends('layouts.user')

@section("content")
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table id="datalist" class="table table-responsive" width="100%">

            </table>
        </div>
    </div>

@endsection

@section("scripts")
    <script>
        $(document).ready(function() {
            $('#datalist').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('user.submission.dt') !!}',
                columns: [
                    { title: 'No.', data: 'row', searchable : false, orderable: false},
                    { title: 'Title',data: 'title', name: 'title'},
                    { title: 'Event',data: 'submission_event.name', orderable: false},
                    { title: 'Abstract Files', data: 'file_abstract', orderable: false, searchable: false},
                    { title: 'Progress Status',data: 'workstate.name', orderable: true},
                    { title: '', data: 'action', orderable: false, searchable: false},
                ]

            });

        });
    </script>

@endsection