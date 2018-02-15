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
                            <table id="datalist" class="table table-responsive">

                            </table>
                        </div>
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
                ajax: '{!! route('admin.master.room.dt') !!}',
                columns: [
                    { title: 'id', data: 'id'},
                    { title: 'Number',data: 'number'},
                    { title: 'Name',data: 'name',},
                    { title: 'Building',data: 'building'},
                    { title: 'Notes',data: 'notes'},
                    { title: 'Created',data: 'created_at'},
                    { title: 'Updated',data: 'updated_at'},
                    { data: 'action', orderable: false, searchable: false}
                ]

            });

            $('#btn_new').on('click', function(e) {
                $.ajax({
                    url: '{{ route('admin.master.room.new') }}',
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

            $('body').on('click','a.btn-edit', function(e) {
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