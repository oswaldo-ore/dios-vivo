<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $datas = json_decode($request->books);
        $books = [];
        $total_debe = 0;
        $total_haber = 0;
        foreach ($datas as $key => $data) {

            //activo y gasto => debe --> pasivo e ingresos --> haber
            $debe = $data->type == "egreso" ? $data->amount : 0;
            $haber = $data->type  == "ingreso" ? $data->amount : 0;
            $books[] = [
                "date" => $data->date,
                "debe" => $debe*(-1),
                "haber" => $haber,
                "description" => $data->description,
                "type" => $data->type,
                "category_id" => $data->category_id,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];
            $total_debe += $debe;
            $total_haber += $haber;
        }

        Book::insert($books);
        return back()->with("success", "Libro agregado correctamente");
    }

}
