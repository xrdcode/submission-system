@extends('layouts._modal')

@section('body')
    <div class="row">
        <div class="col-md-4 col-md-offset-1" style="alignment: center">
            <img src="data:image/png;base64,{{ \Milon\Barcode\DNS2D::getBarcodePNG($ticket->code, "QRCODE", 5,5) }}" alt="barcode"   />
        </div>
        <div class="col-md-6">
            <h5 style="margin: 5px 0px 5px 0px">{{ $gp->user->name }}</h5>
            <label for="">Code: </label> {{ $ticket->code }}
            <br>
            <label for="">Title:</label> {{ $gp->pricing->title }}
            {{--<h4>{{ $gp->user->personal_data->islocal ? "IDR {$gp->pricing->price}" : "USD {$gp->pricing->usd_price}" }}</h4>--}}
            <br>
            <label for="">Location:</label>

        </div>
    </div>
@endsection

@section('footer')
    <div>
        <button class="btn btn-default">Print</button>
    </div>
@endsection

@section('scripts')

@endsection