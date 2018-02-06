@extends('layouts.user')

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="row">
                    <div class="col-md-12">
                        <table id="datalist" class="table table-responsive tbl-no-wrap">

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
                ajax: '{!! route('user.workshop.dt') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Topic',data: 'submission_event.name', orderable: false},
                    { title: 'Title',data: 'pricing.title', orderable: false},
                    { title: 'Billing',data: 'pricing.price', orderable: false},
                    { title: 'Progress',data: 'workstate.name', orderable: false},
                    { title: 'Status',data: 'verified', orderable: false},
                    { title: 'Action',data: 'action', orderable: false, searchable: false},
                ]

            });


            $('table').on('click','a.btn-modal, a.btn-edit', function(e) {
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