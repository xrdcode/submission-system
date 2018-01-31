@extends('layouts.admin')

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-inline pull-right">
                            <button id="btn_new" class="btn btn-primary">New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        All User Data
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
            });

            $('#datalist').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('admin.pricing.dt') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Event',data: 'submission_event.name', orderable: false, class:"force-wrap"},
                    { title: 'Category',data: 'pricing_type.name', orderable: false},
                    { title: 'Detail',data: 'title', class: 'force-wrap'},
                    { title: 'Participant',data: 'isparticipant', searchable: false},
                    { title: 'Price For',data: 'occupation', searchable: false},
                    { title: 'Price',data: 'price', class: "force-wrap"},
                    { title: 'Created By',data: 'createdby.name'},
                    { title: 'Updated By',data: 'updatedby.name'},
                    { data: 'action', orderable: false, searchable: false, class: "force-wrap-1"}
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

            toggleDelete("a.btn-delete", function(d) {
                if(d.success) {
                    showAlert(d.message, "success", "Success");
                    var table = $("#datalist").DataTable();
                    table.draw();
                } else {
                    showAlert(d.message, "warning","Failed: ")
                }
            });

            $('body').on('click','a.btn-edit', function(e) {
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
        });
    </script>

@endsection