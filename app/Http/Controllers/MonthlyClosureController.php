<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Business;
use App\Models\Category;
use App\Models\CloseBox;
use App\Models\MonthlyClosure;
use App\Utils\WhatsappBussines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;

class MonthlyClosureController extends Controller
{
    public function index()
    {
        $closures = MonthlyClosure::listMonthlyClosure();
        $lastMonthlyClosure = MonthlyClosure::lastRecordedDate();

        $lastRecordedDate = Book::lastRecordedDate();
        if (!is_null($lastMonthlyClosure)) {
            $lastRecordedDate->min = Carbon::parse($lastMonthlyClosure->max)->addDay()->format('Y-m-d');
        }
        return view('admin.monthly_closure.index', compact('closures', 'lastMonthlyClosure', 'lastRecordedDate'));
    }

    public function closeManagement(Request $request)
    {
        try {
            $dateInicio = $request->date_start;
            $dateFin = $request->date_end;
            if (MonthlyClosure::validRangeDate($dateInicio, $dateFin)) {
                $dateInicio = $dateInicio;
                $dateFin = $dateFin;
                $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, 0);
                $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio, $dateFin, 0);
                $category_id = 0;
                return view('pdf.close-box-monthly', compact('books', 'dateInicio', 'dateFin', 'category_id'));
            } else {
                return back()->with('error', "Este año ya tiene registrado el cierre de caja anual");
            }
        } catch (\Throwable $th) {
            return back()->with('error', "No se pudo completar la opcion");
        }
    }
    public function closeManagementConfirm(Request $request)
    {
        try {
            DB::beginTransaction();
            $dateInicio = $request->date_start;
            $dateFin = $request->date_end;
            if (MonthlyClosure::validRangeDate($dateInicio, $dateFin)) {
                $closeBox = MonthlyClosure::saveCloseBoxByRangeDate($dateInicio, $dateFin);
                DB::commit();
                return response()->json(['codigo' => 1, 'message' => 'Cerrado correctamente ' . $dateInicio . " a " . $dateFin, "close_box" => $closeBox]);
            } else {
                return response()->json(['codigo' => 0, 'message' => 'Rango de fecha incorrectos.']);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['codigo' => 0, 'message' => 'No se pudo completar la acción ' . $th->getMessage()]);
        }
    }

    public function downloadBooksByRangePdf(Request $request)
    {
        $business = Business::getBusiness();
        $closure = MonthlyClosure::findOrFail($request->monthly_id);
        $category_id = $request->has('category_id') ? $request->category_id : 0;

        $dateInicio = $closure->start_date;
        $dateFin = $closure->end_date;
        $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, $category_id);
        $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio, $dateFin, $category_id);
        $category = Category::find($category_id, ['name']);
        $background = "si";
        $business = Business::getBusiness();
        $lastClosure = MonthlyClosure::before($closure->start_date);
        //$pdf = SnappyPDF::loadView('pdf.download-books', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background'));
        $pdf = DomPDF::loadView('pdf.download-books-monthly', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background', 'lastClosure'));
        $pdf->setOptions([
            'page-size' => 'letter',
        ]);
        //$pdf = SnappyPdf::loadView('pdf.download-books', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background'));
        return $pdf->stream("Reporte-" . $dateInicio . "_" . $dateFin . "_" . $business->name . ".pdf");
    }

    public function sendBooksByRangePdf(Request $request)
    {
        try {
            $business = Business::getBusiness();
            $whatsapp = new WhatsappBussines($business);
            $closure = MonthlyClosure::findOrFail($request->monthly_id);
            $category_id = $request->has('category_id') ? $request->category_id : 0;

            $dateInicio = $closure->start_date;
            $dateFin = $closure->end_date;
            $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, $category_id);
            $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio, $dateFin, $category_id);
            $category = Category::find($category_id, ['name']);
            $background = "si";
            $business = Business::getBusiness();
            $lastClosure = MonthlyClosure::before($closure->start_date);
            $pdf = DomPDF::loadView('pdf.download-books-monthly', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category', 'background', 'lastClosure'));
            $pdf->setOptions([
                'page-size' => 'letter',
            ]);
            $pdfContent = base64_encode($pdf->output());
            $name = "Reporte " . $dateInicio . " " . $dateFin  . ".pdf";
            // $whatsapp->sendMediaMessage();
            foreach ($request->contacts as $value) {
                // $response = $whatsapp->sendTextMessage($value,"Reporte Iglesia del Dios Vivo.",$pdfContent,$name,"application/pdf");
                $response = $whatsapp->sendMediaMessage($value,$name,"application/pdf",$pdfContent);
            }
            return response()->json(["success" => true, "message" => "Reporte enviado correctamente"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Reporte no se pudo enviar correctamente"]);
        }
    }
}
