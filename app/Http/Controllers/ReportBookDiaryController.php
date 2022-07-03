<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportBookDiaryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull("category_id")->with('categories')->get();
        return view('admin.report_book.index', compact('categories'));
    }

    public function getBookRange(Request $request)
    {
        try {
            $date = explode(" a ", $request->date);
            $dateInicio = $date[0];
            $dateFin = $date[1];
            $category_id = $request->category_id;
            if ($request->category_id == 0) {
                $books = Book::with('category:id,name')->where("date", ">=", $dateInicio)->where('date', '<=', $dateFin)->get();
            } else {
                $books = Book::where("date", ">=", $dateInicio)
                    ->where('date', '<=', $dateFin)
                    ->with("category")
                    ->where('category_id', $category_id)
                    ->get();
            }
            return response()->json(["books" => json_decode($books), "message" => "petición correcta"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }
}
