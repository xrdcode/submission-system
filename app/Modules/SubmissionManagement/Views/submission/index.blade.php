@extends('layouts.admin')

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Submission List
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <table id="datalist" class="table table-responsive tbl-no-wrap">

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <div id="modal-container">

    </div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $('#datalist').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('admin.submission.dt') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Event',data: 'submission_event.name', orderable: false, searchable: false},
                    { title: 'Title',data: 'title', class: 'force-wrap'},
                    { title: 'User',data: 'user.name'},
                    { title: 'Submission Type',data: 'submission_type.name', orderable: false},
                    { title: 'Abstract', data: 'file_abstract'},
                    { title: 'Full Paper', data: 'file_paper'},
                    { title: 'Feedback', data: 'feedback', orderable: false},
                    { title: 'Progress',data: 'progress', orderable: false, searchable: false},
                    { title: 'Approved',data: 'approved', orderable: false, searchable: false},
                    //{ title: 'Add Payment',data: 'payment', orderable: false, searchable: false},
                    // { data: 'action', orderable: false, searchable: false}
                ]

            });


            $('#btn_new').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('admin.pricing.new') }}',
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

            $('body').on('click','a.btn-edit, a.btn-modal', function(e) {
                e.preventDefault()

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

            initHideNseek();

        });
    </script>

@endsection