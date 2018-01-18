@extends('layouts.user')

@section("content")
    <div class="row">
        <div class="col-md-12">
            <table id="datalist" class="table table-responsive tbl-no-wrap">

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
                scrollX: true,
                ajax: '{!! route('user.submission.dt') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Title',data: 'title', name: 'title', class: 'force-wrap'},
                    { title: 'Event',data: 'submission_event.name', orderable: false},
                    { title: 'Type',data: 'submission_type.name', orderable: false},
                    { title: 'Abstract Files', data: 'file_abstract', orderable: false, searchable: false},
                    { title: 'Paper', data: 'action', orderable: false, searchable: false},
                    { title: 'Progress Status',data: 'workstate.name', orderable: true, class: 'force-wrap'},
                    { title: 'Feedback',data: 'feedback', orderable: true, class: 'force-wrap'},
                ]

            });

            $('body').on('click','a.btn-modal', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('href'),
                    method: 'GET',
                    success: function(response) {
                        $("#modal-container").html(response);
                        $(".modal", "#modal-container").modal();
                    },
                    error: function(xHr) {
                        console.log(xHr);
                    }
                });
            });

        });
    </script>

@endsection