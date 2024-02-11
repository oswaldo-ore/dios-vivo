<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Business;
use App\Models\Category;
use App\Utils\WhatsappBussines;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business = Business::getBusiness();
        $whatsapp = new WhatsappBussines($business);
        $whatsapp->verifySessionV2();
        $countryCurrencyJson = file_get_contents('json/currency.json');
        $countryCurrency = json_decode($countryCurrencyJson);
        $countryCodeNumberJson = file_get_contents('json/country_codes.json');
        $countryCodeNumber = json_decode($countryCodeNumberJson);
        return view('admin.business.index', compact('business', 'countryCurrency', 'countryCodeNumber'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        try {
            $business->name = strtolower($request->name);
            $business->location = strtolower($request->location);
            $business->email = strtolower($request->email);
            $business->code_number = $request->code_number;
            $business->phone_number = $request->phone_number;
            $business->currency = strtolower($request->currency);
            if ($request->has('show_report_public')) {
                $business->show_report_public = $request->has('show_report_public');
                $business->start_date_report_public = $request->date_inicio;
                $business->end_date_report_public = $request->date_fin;
                $business->date_close_show = $request->date_close_show;
            }
            if ($request->has('show_report_yearly')) {
                $business->show_report_yearly = $request->has('show_report_yearly');
                $business->start_report_year = $request->year;
                $business->date_close_show = $request->date_close_show;
            }
            $business->update();
            return back()->with('success', "Datos actualizados");
        } catch (\Throwable $th) {
            return back()->with('error', 'No se pudo completar la acción ' . $th->getMessage());
        }
    }


    public function clearReportPublic(Request $request)
    {
        try {
            $business = Business::getBusiness();
            $business->show_report_public = false;
            $business->start_date_report_public = null;
            $business->end_date_report_public = null;

            $business->show_report_yearly = false;
            $business->start_report_year = null;
            $business->date_close_show = null;
            $business->update();
            return response()->json(["codigo"=>0,"message"=>"actualizado correctamente"]);
        } catch (\Throwable $th) {
            return response()->json(["codigo"=>1,"message"=>"Ocurrio un error"]);

        }
    }

    public function showReportPublic(){
        $business = Business::getBusiness();
        if(!$business->show_report_public &&  !$business->show_report_public ){
            return redirect('admin');
        }
        if($business->show_report_public){
            $dateInicio = $business->start_date_report_public;
            $dateFin = $business->end_date_report_public;
            $category_id = 0;
            $books = Book::getDetailsOfBookInRangeDate($dateInicio, $dateFin, $category_id);
            $books->totales = Book::getTotalIngresoEgresoBooksInRangeDate($dateInicio, $dateFin, $category_id);
            $category = Category::find($category_id, ['name']);
            return view('pdf.libro', compact('books', 'dateInicio', 'dateFin', 'category_id', 'category'));
        }
        if($business->show_report_yearly){
            return redirect('admin');
        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
    }
}
