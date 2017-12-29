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
            <div class="col-md-10 col-md-offset-1">
                <form action="{{ route('module.manage.search') }}" id="search" method="post">

                </form>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        All User Data
                    </div>
                    <div class="panel-body">
                        <div class="col-md-4 col-md-offset-8">
                            <div class = "input-group">
                                <input id="search" type="text" class="form-control pull-right" name="search" placeholder="search..">
                                <span class = "input-group-btn">
                                    <button class = "btn btn-default btn-search" type = "button">
                                        Search
                                    </button>
                                </span>

                            </div>
                        </div>

                    </div>
                    <div>&nbsp;</div>
                    <table class="table table-responsive" id="userlist">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Path</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i =  ($modules->currentPage()-1) * $modules->perPage())
                        @foreach($modules as $x)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $x->name  }}</td>
                                <td>Modules\{{ $x->pathname }}</td>
                                <td>{{ $x->description }}</td>
                                <td>
                                    @if($x->active)
                                        <label for="" class="label label-success">Active</label>
                                    @else
                                        <label for="" class="label label-danger">Disabled</label>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('module.manage.edit', $x->id) }}" class="btn btn-primary btn-sm">
                                        <span class="glyphicon glyphicon-edit"></span>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $modules->links() }}
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
            $('.btn-search').click(function(e) {
                var routes = '{{ route('module.manage') }}';
                var search = $('input#search').val();

                window.location.href = routes + "?search=" + search;
            });

            $('#btn_new').on('click', function(e) {
                $.ajax({
                    url: '{{ route('module.manage.newmodule') }}',
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