<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyClosure extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "monthly_closure";
    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'total_haber',
        'total_debe',
        'total_debe_haber',
        'total_anterior',
        'total_cierre',
        'description',
        "start_date",
        "end_date",
    ];

    public static function createClouseMonthly(
        $totalHaber,
        $totalDebe,
        $totalAnterior,
        $startDate,
        $endDate){
        $clousure = new self();
        $clousure->total_haber= $totalHaber;
        $clousure->total_debe= $totalDebe;
        $clousure->total_debe_haber= $totalHaber - $totalDebe;
        $clousure->total_anterior= $totalAnterior;
        $clousure->total_cierre= $totalAnterior +($totalHaber - $totalDebe);
        $clousure->start_date= $startDate;
        $clousure->end_date= $endDate;
        $clousure->description = "Cierre cerrando caja";
        $clousure->save();
        return $clousure;
    }

    public static function listMonthlyClosure(){
        return self::orderBy('start_date',"DESC")->orderBy('end_date',"DESC")->paginate(10);
    }

    public static function lastRecordedDate(){
        $min = self::max('start_date');
        $max = self::max('end_date');
        if(is_null($min) || is_null($max)){
            return null;
        }
        return (object)[
            "min" => $min,
            "max" => $max,
        ];
    }

    public static function validRangeDate($startDate,$endDate){
        $startDate =Carbon::parse($startDate);
        $endDate =Carbon::parse($endDate);
        /* Fecha fin es menor o igual q la fecha inicio */
        if($endDate->lessThanOrEqualTo($startDate)){
            return false;
        }
        $clouse = MonthlyClosure::where('end_date',">",$startDate)->first();
        if(is_null($clouse)){
            return true;
        }
        return false;
    }

    public static function saveCloseBoxByRangeDate($startDate,$endDate){
        $books = Book::where("date",">=",$startDate)->where('date',"<=",$endDate)->selectRaw("
            cast( sum(haber) as decimal(20,2)) as haber,
            cast( sum(debe) as decimal(20,2)) as debe,
            cast( (sum(haber)- sum(debe))  as decimal(20,2))as balance_sum_debe_haber,
            cast( sum(IF(type = 'ingreso',saldo,0)) as decimal(20,2)) as haber_saldo,
            cast( sum(IF(type = 'egreso',saldo,0)) as decimal(20,2)) as debe_saldo,
            cast( (sum(IF(type = 'ingreso',saldo,0)) - sum(IF(type = 'egreso',saldo,0))) as decimal(20,2)) as total_saldo
        ")->first();
        $ultimo = self::orderBy('end_date',"DESC")->first();
        $anterior = 0;
        if(!is_null($ultimo)){
            $anterior = $ultimo->total_cierre;
        }
        $close = self::createClouseMonthly($books->haber_saldo,$books->debe_saldo, $anterior,$startDate,$endDate);
        return $close;
    }

    public static function before($startDate){
        return self::where('end_date',"<=",$startDate)->orderBy('end_date',"DESC")->first();
    }
}
