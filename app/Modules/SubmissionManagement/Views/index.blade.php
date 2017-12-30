@extends('layouts.admin')

@section("content")
    <div class="container">
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
                {{-- {!! Breadcrumbs::render() !!}--}}
            </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section("scripts")
    <script>
        $(document).ready(function() {
            $('.btn-search').click(function(e) {
                var routes = '{{ route('admin.module') }}';
                var search = $('input#search').val();

                window.location.href = routes + "?search=" + search;
            });

            $('#btn_new').on('click', function(e) {
                $.ajax({
                    url: '{{ route('admin.module.newmodule') }}',
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