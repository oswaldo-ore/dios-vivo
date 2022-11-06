<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'name','location','code_number','phone_number','currency','saldo_total',
        'show_report_public','start_date_report_public','end_date_report_public','show_report_yearly','start_report_year','date_close_show'
    ];

    public static function getBusiness(){
        $business = Business::first();
        if(is_null($business)){
            $business = new Business();
            $business->save();
        }
        return $business;
    }

    public static function updateSaldoTotal($monto){
        $business = Business::first();
        if(!is_null($business)){
            $business->saldo_total = $business->saldo_total + $monto;
            $business->update();
        }
    }

    public function disabledReportPublic(){
        $this->show_report_public = false;
        $this->start_date_report_public = null;
        $this->end_date_report_public = null;

        $this->show_report_yearly = false;
        $this->start_report_year = null;
        $this->date_close_show = null;
        $this->update();
    }

    public function getNameAttribute($name){
        return ucwords($name);
    }
    public function getCurrencyAttribute($currency){
        return ucwords($currency);
    }
}
