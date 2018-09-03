@extends('layouts.admin')

@section("content")
    <div class="container-fluid">
        {{--<div class="row">--}}
            {{--<div class="col-md-10 col-md-offset-1">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="form-inline pull-right">--}}
                            {{--<button id="btn_new" class="btn btn-primary">New</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
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
                iDisplayLength: 15,
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('admin.participant.workshop.dt') !!}',
                order: [[1,"asc"]] ,
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Name',data: 'name', name:"users.name"},
                    { title: 'Email',data: 'email', name:"users.email"},
                    { title: 'Phone',data: 'phone', name:"users.phone"},
                    { title: 'Institution',data: 'institution', name:"personal_datas.institution"},
                    { title: 'Workshop',data: 'title', name:"pricings.title"},
                    { title: 'Payment Status',data: 'verified', searchable: false, class:'force-wrap', orderable: false},
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

            toggleDelete("a.btn-delete", function(d) {
                if(d.success) {
                    showAlert(d.message, "success", "Success");
                    var table = $("#datalist").DataTable();
                    table.draw();
                } else {
                    showAlert(d.message, "warning","Failed: ")
                }
            });

            toggleRecover("a.btn-recover", function(d) {
                if(d.success) {
                    showAlert(d.message, "success", "Success");
                    var table = $("#datalist").DataTable();
                    table.draw();
                } else {
                    showAlert(d.message, "warning","Failed: ")
                }
            });

        });
    </script>

@endsection