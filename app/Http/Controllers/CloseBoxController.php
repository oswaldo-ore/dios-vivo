<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CloseBox;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CloseBoxController extends Controller
{
    public function index()
    {
        $years = Book::getAllYearWithoutYearNow();
        $closeBoxes = CloseBox::getCloseBoxByYears($years);
        $yearsWithManagement = $closeBoxes->pluck('year');
        return view('admin.close_box.index', compact('closeBoxes', 'years', 'yearsWithManagement'));
    }

    public function closeManagement(Request $request, $year)
    {
        try {
            if (!CloseBox::existsYear($year)) {
                $dateInicio = Carbon::parse($year . "-01-01")->format('Y-m-d');
                $dateFin = Carbon::parse($year . "-12-31")->format('Y-m-d');
                $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, 0);
                $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio, $dateFin, 0);
                $category_id = 0;
                return view('pdf.close-box', compact('books', 'dateInicio', 'dateFin', 'category_id','year'));
                dd($books);
            } else {
                return back()->with('error', "Este año ya tiene registrado el cierre de caja anual");
            }
        } catch (\Throwable $th) {
            return back()->with('error', "No se pudo completar la opcion");
        }
    }
    public function closeManagementConfirm(Request $request){
        try {
            if (!CloseBox::existsYear($request->year)) {
                $closeBox = CloseBox::saveCloseBoxByYear($request->year);
                return response()->json(['codigo'=>1,'message'=>'Gestión anual cerrado correctamente '.$request->year,"close_box"=> $closeBox]);
            } else {
                return response()->json(['codigo'=>0,'message'=>'Este año ya tiene registrado el cierre de caja anual '.$request->year]);
            }
        } catch (\Throwable $th) {
            return response()->json(['codigo'=>0,'message'=>'No se pudo completar la acción '.$th->getMessage()]);

        }
    }
}
