<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $date = Carbon::now();
        return view('admin.dashboard.index');
    }
}
