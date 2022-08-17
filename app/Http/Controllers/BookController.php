<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Business;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    public function index()
    {
        $categories = Category::whereNull('category_id')->with(['categories'=> function($query){
            return $query->where('is_enabled',true);
        }])->get();
        return view('admin.book.index', compact('categories'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $saldo = Book::addDebeHaberBooks($request);
            Business::updateSaldoTotal($saldo);
            return back()->with("success", "Registros agregados correctamente");
        } catch (\Throwable $th) {
            return back()->with("error","No se pudo completar la operación".$th->getMessage());
        }
    }

}
