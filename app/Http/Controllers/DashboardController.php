<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $year = Carbon::now()->year;
        //suma total de las categorias con sus respectivas clases
        $year= Category::totalByCategoryByYear($year);

        return view('admin.dashboard.index',compact('year'));
    }

    public function indexByGestion()
    {
        $year = Carbon::now()->year;
        //suma total de las categorias con sus respectivas clases
        $year= Category::totalByCategoryByYear($year);

        return view('admin.dashboard.index',compact('year'));
    }
}
