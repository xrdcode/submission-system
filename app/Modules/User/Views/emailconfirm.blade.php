@extends('layouts.login')
@section('content')
    <div class="container">
        <div class="center-block">
            Your Email is successfully verified. You'll be redirected to login page or click here to <a href="{{url('/user/login')}}">login</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                location.href = '{{ route('user.login') }}';
            }, 3000);
        })
    </script>
@endsection