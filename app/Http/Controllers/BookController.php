<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('category_id')->with('categories')->get();
        return view('admin.book.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
