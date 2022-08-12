<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    public function index()
    {
        $categories = Category::whereNull('category_id')->with('categories')->get();
        return view('admin.book.index', compact('categories'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            Book::addDebeHaberBooks($request);
            return back()->with("success", "Libro agregado correctamente");
        } catch (\Throwable $th) {
            return back()->with("error","No se pudo completar la operación".$th->getMessage());
        }
    }

}
