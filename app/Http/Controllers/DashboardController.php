<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Business;
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
        $business = Business::getBusiness();
        $statistics = Book::getDetailsOfBooksByMonthsAll();
        $statisticsYear = Book::getDetailsOfBooksByYearAll();
        return view('admin.dashboard.index-management',compact('business','statistics','statisticsYear'));
    }
}
