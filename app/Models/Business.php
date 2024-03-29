<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name', 'location', 'code_number', 'phone_number', 'currency', 'saldo_total',
        'show_report_public', 'start_date_report_public', 'end_date_report_public', 'show_report_yearly', 'start_report_year', 'date_close_show',
        'whatsapp_instance', 'state_connection', 'phone_number_connected'
    ];

    public static function getBusiness()
    {
        $business = Business::first();
        if (is_null($business)) {
            $business = new Business();
            $business->save();
        }
        return $business;
    }

    public static function updateSaldoTotal($monto)
    {
        $business = Business::first();
        if (!is_null($business)) {
            $business->saldo_total = $business->saldo_total + ($monto);
            $business->update();
        }
    }

    public function disabledReportPublic()
    {
        $this->show_report_public = false;
        $this->start_date_report_public = null;
        $this->end_date_report_public = null;

        $this->show_report_yearly = false;
        $this->start_report_year = null;
        $this->date_close_show = null;
        $this->update();
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }
    public function getCurrencyAttribute($currency)
    {
        return ucwords($currency);
    }

    public function logoBase64()
    {
        $image = base64_encode(file_get_contents(public_path('assets/media/dios_vivo_fondo_blanco.jpg')));
        return $image;
    }

    public function generateInstanceId(){
        if($this->whatsapp_instance == '' || is_null($this->whatsapp_instance)){
            $this->whatsapp_instance = Str::upper(Str::random(11));
            $this->update();
        }
    }
}
