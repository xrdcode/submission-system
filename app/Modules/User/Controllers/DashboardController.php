<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 29/12/2017
 * Time: 11:10
 */

namespace App\Modules\User\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['profile_complete']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            $payment_notif = Auth::user()->payment_notification(),
        ];
        return view('User::dashboard', $data);
    }


}