<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Business;
use App\Models\Category;
use App\Models\CloseBox;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SnappyPDF;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            if($request->has('date_start') && $request->has('date_end')){
                $dateInicio = $request->date_start;
                $dateFin = $request->date_end;
            }else{
                $dateInicio = Carbon::now()->subMonth(12)->startOfMonth()->format('Y-m-d');
                $dateFin = Carbon::now()->addDay()->format('Y-m-d');
            }
            $category_id = $request->category_id;
            $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, $category_id);
            return response()->json(["books" => json_decode($books), "message" => "petición correcta"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }

    public function getBookRangeV2(Request $request)
    {
        try {
            if($request->has('date_start') && $request->has('date_end')){
                $dateInicio = $request->date_start;
                $dateFin = $request->date_end;
            }else{
                $dateInicio = Carbon::now()->subMonth(12)->startOfMonth()->format('Y-m-d');
                $dateFin = Carbon::now()->addDay()->format('Y-m-d');
            }
            $category_id = $request->category_id;
            $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, $category_id);
            return response()->json(["books" => json_decode($books), "message" => "petición correcta"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }

    public function deleteBook(Book $book){
        DB::beginTransaction();
        try {
            $book->delete();
            if ($book->type == Book::EGRESO) {
                $saldo = $book->saldo;
            }else{
                $saldo = $book->saldo * (-1);
            }
            Business::updateSaldoTotal($saldo);
            DB::commit();
            return response()->json(['codigo'=> 0,"message"=>"Registro eliminado con éxito"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['codigo'=> 1,"message"=>"No se pudo elimianr el libro ".$th->getTraceAsString(),"data" => ""]);
        }
    }

    public function showPdf(Request $request)
    {
        $dateInicio = $request->date_start_report;
        $dateFin = $request->date_end_report;
        $category_id = $request->category_report;
        $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, $category_id);
        $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio, $dateFin, $category_id);
        $category = Category::find($category_id, ['name']);
        return view('pdf.libro', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category'));
    }

    public function downloadBooksPdf(Request $request)
    {
        $date = explode(" a ", $request->date_reporte);
        $dateInicio = $date[0];
        $dateFin = $date[1];
        $category_id = $request->category_report;
        $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, $category_id);
        $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio, $dateFin, $category_id);
        $category = Category::find($category_id, ['name']);
        $background = "si";
        $business = Business::getBusiness();

        //$pdf = SnappyPDF::loadView('pdf.download-books', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background'));
        $pdf = DomPDF::loadView('pdf.download-books', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background'));
        $pdf->setOptions([
            'page-size' => 'letter',
        ]);
        //$pdf = SnappyPdf::loadView('pdf.download-books', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background'));
        return $pdf->stream("Reporte-" . $dateInicio . "_" . $dateFin . "_" . $business->name . ".pdf");
    }

    public function indexReportYearly()
    {

        $minYear = Carbon::parse(Book::getYearOfFirstRecord())->firstOfYear()->format('Y');
        $maxYear = Carbon::parse(Book::getYearOfLastRecord())->format('Y');
        $categories = Category::whereNull("category_id")->with('categories')->get();
        return view('admin.report_yearly.index', compact('minYear', 'maxYear', 'categories'));
    }

    public function getReportByYear(Request $request)
    {
        try {
            if ($request->has('imprimir')) {
                return $this->downloadBooksYearlyPdf($request);
            }
            $books = Book::getDetailsOfBooksByYear($request);
            $close = null;
            $previousManagement = $request->previous_management;
            if ($request->previous_management == 1) {
                $previousYear = Carbon::parse($request->year . '-01-01')->subYear()->format('Y');
                $close = CloseBox::getCloseBoxByYear($previousYear);
            }
            $view = view('admin.report_yearly.search', compact('books', 'close', 'previousManagement'))->render();
            return response()->json(["codigo" => 1, 'mensaje' => "Consulta realizada correctamente", 'view' => $view, 'books' => $books]);
        } catch (\Throwable $th) {
            return response()->json(["codigo" => 0, 'mensaje' => "La consulta no se  realizo " . $th->getTraceAsString() . " " . $th->getMessage()]);
        }
    }

    private function downloadBooksYearlyPdf(Request $request)
    {
        $business = Business::getBusiness();
        $books = Book::getDetailsOfBooksByYear($request);
        $close = null;
        $previousManagement = $request->previous_management;
        if ($request->previous_management == 1) {
            $previousYear = Carbon::parse($request->year . '-01-01')->subYear()->format('Y');
            $close = CloseBox::getCloseBoxByYear($previousYear);
        }
        $year = $request->year;
        $saldo = (object)[
            "saldo_haber"  => array_sum(collect($books)->pluck('haber_saldo')->toArray()),
            "saldo_debe"  => array_sum(collect($books)->pluck('debe_saldo')->toArray()),
            "saldo_anual" => array_sum(collect($books)->pluck('total_saldo')->toArray()),
        ];
        $category_id = $request->category_id;
        $category = Category::find($category_id, ['name']);

        // $pdf = SnappyPDF::loadView(
        //     'pdf.download-books-yearly',
        //     compact('books', 'year', 'business', 'saldo', 'category', 'category_id', 'close', 'previousManagement')
        // );
        $pdf = DomPDF::loadView(
            'pdf.download-books-yearly',
            compact('books', 'year', 'business', 'saldo', 'category', 'category_id', 'close', 'previousManagement')
        );
        $pdf->setOptions([
            'page-size' => 'letter',
        ]);
        //$pdf = SnappyPdf::loadView('pdf.download-books', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background'));
        return $pdf->stream("Reporte-GESTION -" . $year . "_" . $business->name . ".pdf");
    }
}
