<?php

namespace App\Http\Controllers;

use App\Models\Business;
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
        $countryCurrencyJson = file_get_contents('json/currency.json');
        $countryCurrency = json_decode($countryCurrencyJson);
        $countryCodeNumberJson = file_get_contents('json/country_codes.json');
        $countryCodeNumber = json_decode($countryCodeNumberJson);
        return view('admin.business.index',compact('business','countryCurrency','countryCodeNumber' ));
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
            $business->update();
            return redirect('/');
        } catch (\Throwable $th) {
            return back()->with('error','No se pudo completar la acción '. $th->getMessage() );
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
