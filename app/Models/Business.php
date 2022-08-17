<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','location','code_number','phone_number','currency','saldo_total'
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
}
