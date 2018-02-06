<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class DebugController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web','auth']);
    }

    public function testAbstractNotification($id) {
        $submission = Auth::user()->submissions()->find($id);
        return view('email.abstract', compact(['submission']));
    }

    public function testQrcode() {
//        echo DNS1D::getBarcodeSVG("4445645656", "C39");
        echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
//        echo DNS2D::getBarcodePNGPath("4445645656", "PDF417");
    }
}
