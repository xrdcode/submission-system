@extends('layouts.user')

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <ul id="myTab1" class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#conference" data-toggle="tab" onclick="refreshTable('#datalist')"><strong><h5>Conference</h5></strong></a></li>
                    <li class=""><a href="#publication" data-toggle="tab" onclick="refreshTable('#datalist2')"><strong><h5>Publication</h5></strong></a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="conference">
                        <table id="datalist" class="table table-responsive tbl-no-wrap">

                        </table>
                    </div>
                    <div class="tab-pane fade" id="publication">
                        <table id="datalist2" class="table table-responsive tbl-no-wrap">

                        </table>
                    </div>
                </div>
            </div>


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

            $('#datalist2').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('user.submission.dtpub') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Title',data: 'title', name: 'title', class: 'force-wrap'},
                    { title: 'Event',data: 'submission_event.name', orderable: false},
                    { title: 'Paper', data: 'action', orderable: false, searchable: false},
                    { title: 'Progress Status',data: 'workstate.name', orderable: false},
                    { title: 'Publication Status',data: 'status', orderable: false, class: 'force-wrap'},
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