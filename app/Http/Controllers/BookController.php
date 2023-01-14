<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Business;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            dd($th->getMessage().$th->getTraceAsString());
            return back()->with("error","No se pudo completar la operación".$th->getMessage());
        }
    }

    public function transferIndex(){
        try {
            $category = Category::getIncomeCategory();
            $transactions = Transaction::all();
            return view('admin.transfermoney.index',compact('category','transactions'));
        } catch (\Throwable $th) {
        }
    }

    public function transferSave(Request $request){
        try {
            DB::beginTransaction();
            $transaction = Book::transfer($request->category_id,$request->amount);
            DB::commit();
            return response()->json(['message'=> "Transferencia a sido completada correctamente.",'data'=>$transaction]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=> $th->getMessage()],403);
        }
    }

}
