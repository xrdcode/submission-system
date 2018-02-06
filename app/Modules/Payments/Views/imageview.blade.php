@extends('layouts._modal')

@section('body')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="{{ URL::to($file) }}" class="img img-responsive">
        </div>
    </div>
@endsection