<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CloseBox extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "close_boxes";

    protected $fillable=[
        'id','year','total_haber','total_debe','total_saldo','description'
    ];

    public static function getCloseBoxByYears($years){
        return CloseBox::whereIn('year',$years)->get();
    }
    public static function getCloseBoxByYearByRequest($request){
        $year = $request->year;
        return CloseBox::getCloseBoxByYears([$year]);
    }

    public static function getCloseBoxByYear($year){
        return CloseBox::getCloseBoxByYears([$year])->first();
    }

    public static function existsYear($year){
        return CloseBox::where('year',$year)->count() > 0;
    }
    public static function saveCloseBoxByYear($year){
        $books = Book::whereYear('date','=',$year);
        $books->selectRaw("
            count('id') as amount,
            DATE_FORMAT(date,'%Y') as new_date,
            cast( sum(haber) as decimal(20,2)) as haber,
            cast( sum(debe) as decimal(20,2)) as debe,
            cast( (sum(haber)- sum(debe))  as decimal(20,2))as balance_sum_debe_haber,
            cast( sum(IF(type = 'ingreso',saldo,0)) as decimal(20,2)) as haber_saldo,
            cast( sum(IF(type = 'egreso',saldo,0)) as decimal(20,2)) as debe_saldo,
            cast( (sum(IF(type = 'ingreso',saldo,0)) - sum(IF(type = 'egreso',saldo,0))) as decimal(20,2)) as total_saldo
        ")->groupBy('new_date');
        $book= $books->first();
        $close = new CloseBox();
        $close->year = $year;
        $close->total_haber = $book->haber_saldo;
        $close->total_debe = $book->debe_saldo;
        $close->total_saldo = $book->total_saldo;
        $close->description = "";
        $close->save();
        return $close;
    }
}
