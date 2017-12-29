<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        return view('Admin::dashboard');
    }

}
