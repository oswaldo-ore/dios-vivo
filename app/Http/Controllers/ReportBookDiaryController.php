<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;

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
            $dateInicio = $request->date_start;
            $dateFin = $request->date_end;
            $category_id = $request->category_id;
            $books = Book::getDetailsOfBookInRangeDate($dateInicio,$dateFin,$category_id);
            return response()->json(["books" => json_decode($books), "message" => "petición correcta"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }

    public function showPdf(Request $request){
            $dateInicio = $request->date_start_report;
            $dateFin = $request->date_end_report;
            $category_id = $request->category_report;
            $books = Book::getDetailsOfBookInRangeDate($dateInicio,$dateFin,$category_id);
            $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio,$dateFin,$category_id);
            $category = Category::find($category_id,['name']);
            return view('pdf.libro',compact('books','dateInicio','dateFin','category_id','category'));

    }

    public function downloadBooksPdf(Request $request){
        $date = explode(" a ", $request->date_reporte);
        $dateInicio = $date[0];
        $dateFin = $date[1];
        $category_id = $request->category_report;
        $books = Book::getDetailsOfBookInRangeDate($dateInicio,$dateFin,$category_id);
        $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio,$dateFin,$category_id);
        $category = Category::find($category_id,['name']);
        $background = "si";
        $pdf = Pdf::loadView('pdf.download-books',compact('books','dateInicio','dateFin','category_id','category','background'));
        return $pdf->stream();

}
}
