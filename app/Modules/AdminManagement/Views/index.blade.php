@extends('layouts.admin')

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
               {{-- {!! Breadcrumbs::render() !!}--}}
            </div>
            <div class="col-md-10 col-md-offset-1">
                <form action="{{ route('admin.manageadmin.search') }}" id="search" method="post">

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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Group</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i =  ($admins->currentPage()-1) * $admins->perPage())
                        @foreach($admins as $x)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $x->name  }}</td>
                                <td>{{ $x->username }}</td>
                                <td>{{ $x->email }}</td>
                                <td>
                                    @if($x->active)
                                        <label for="" class="label label-success">Verified</label>
                                    @else
                                        <label for="" class="label label-danger">Not-Verified</label>
                                    @endif
                                </td>
                                <td>
                                    @foreach($x->groups as $group)
                                        <label for="" class="label label-info">{{ $group->name }}</label>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.manageadmin.edit', $x->id) }}" class="btn btn-primary btn-sm">
                                        <span class="glyphicon glyphicon-edit"></span>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $admins->links() }}
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
                var routes = '{{ route('admin.manageadmin') }}';
                var search = $('input#search').val();

                window.location.href = routes + "?search=" + search;
            })
        });
    </script>

@endsection