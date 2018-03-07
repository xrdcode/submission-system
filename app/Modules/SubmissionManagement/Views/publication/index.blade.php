@extends('layouts.admin')

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Publication List
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
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('admin.publication.dt') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Event | Topic',data: 'submission_event.name', orderable: false, searchable: false},
                    { title: 'Title',data: 'title', class: 'force-wrap'},
                    @if(!Auth::user()->hasGroup('Reviewer'))
                    { title: 'User',data: 'user.name', orderable: false},
                    @endif
                    { title: 'Full Paper', data: 'file_paper', orderable: false, searchable: false},
                    { title: 'Feedback', data: 'feedback'},
                    { title: 'Progress',data: 'progress', orderable: false, searchable: false},
                    @if(Auth::user()->hasGroup('Editor, SuperAdmin'))
                    { title: 'Reviewer',data: 'reviewer', orderable: false, searchable: false},
                    @endif
                    { title: 'Action',data: 'approved', orderable: false, searchable: false},

                    //{ title: 'Add Payment',data: 'payment', orderable: false, searchable: false},
                    // { data: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Waiting',
                        action: function ( e, dt, node, config ) {
                            if(config.text == "Waiting") {
                                this.text("Approved");
                                dt.ajax.url('{!! route('admin.publication.dt') !!}?a=1');
                                dt.draw();
                            } else {
                                this.text("Waiting");
                                dt.ajax.url('{!! route('admin.publication.dt') !!}');
                                dt.draw();
                            }

                        }
                    },
                    {
                        text: 'Refresh',
                        action: function ( e, dt, node, config ) {
                            dt.draw();
                        }
                    }
                ]


            });


            $('#btn_new').on('click', function(e) {
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