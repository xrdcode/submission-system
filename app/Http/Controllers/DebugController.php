<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
