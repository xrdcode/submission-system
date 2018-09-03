@extends('layouts._modal')

@section('body')

@endsection

@section('footer')
    <button id="close" class="btn btn-primary">
        Close
    </button>
@endsection

@section('scripts')
    <script type="text/javascript">

        $('#close').on('click', function(e) {
            var me = $(this);
            if($(me).closest('.modal').length > 0) {
                $(me).closest('.modal').modal('hide');
            }
        });
    </script>
@endsection