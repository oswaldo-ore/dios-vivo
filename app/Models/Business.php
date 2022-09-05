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

    public function getNameAttribute($name){
        return ucwords($name);
    }
    public function getCurrencyAttribute($currency){
        return ucwords($currency);
    }
}
