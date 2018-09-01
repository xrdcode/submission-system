@extends('layouts.admin')

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel">
                    <ul id="myTab1" class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#conference" data-toggle="tab" onclick="refreshTable('#datalist')">Conference & Publication</a></li>
                        <li class=""><a href="#workshop" data-toggle="tab" onclick="refreshTable('#datalist2')">Workshop</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="conference">
                            <table id="datalist" class="table table-responsive tbl-no-wrap">

                            </table>
                        </div>
                        <div class="tab-pane fade" id="workshop">
                            <table id="datalist2" class="table table-responsive tbl-no-wrap">

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
                ajax: '{!! route('admin.payment.dt') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: 'Event',data: 'event', name:"se.name", orderable: false, searchable: false},
                    { title: 'Title',data: 'title', class: 'force-wrap'},
                    { title: 'User',data: 'name', name:"users.name"},
                    { title: 'Submission Type',data: 'type', orderable: false, name: "st.name"},
                    { title: 'Receipt',data: 'receipt', orderable: false, searchable: "false"},
                    { title: 'Verified',data: 'verified', orderable: false, searchable: "false"},
                ]

            });

            $('#datalist2').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('admin.payment.dt_ws') !!}',
                columns: [
                    {
                        title: 'No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                },
                    { title: 'Workshop',data: 'title', orderable: false, name: "p.title"},
                    { title: 'Name',data: 'name', orderable: false, name: "users.name"},
                    { title: 'Receipt',data: 'receipt', orderable: false, searchable: false},
                    { title: 'Progress',data: 'state', orderable: false, searchable: false},
                    { title: 'Status',data: 'verified', searchable: false},
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

            initHideNseek();

        });
    </script>

@endsection