<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "date", "debe", "haber", "description", "type", "category_id",'saldo',"user_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function addDebeHaberBooks($request)
    {
        $datas = json_decode($request->books);
        $books = [];
        $total_debe = 0;
        $total_haber = 0;
        foreach ($datas as $key => $data) {
            //activo y gasto => debe --> pasivo e ingresos --> haber
            $debe = $data->type == "egreso" ? $data->amount : 0;
            $haber = $data->type  == "ingreso" ? $data->amount : 0;
            $books[] = [
                "date" => $data->date,
                "debe" => $debe * (-1),
                "haber" => $haber,
                'saldo' => $debe > 0 ? (-1 * $debe): $haber,
                "description" => $data->description,
                "type" => $data->type,
                "category_id" => $data->category_id,
                "user_id" => Auth::user()->id,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];
            $total_debe += $debe;
            $total_haber += $haber;
        }
        Book::insert($books);
        return $total_haber - $total_debe;
    }

    public static function getDetailsOfBookInRangeDate($dateStar, $dateEnd, $categoryId)
    {
        if ($categoryId == 0) {
            $books = Book::with('category:id,name')
                ->where("date", ">=", $dateStar)
                ->where('date', '<=', $dateEnd)
                ->orderBy("date", "asc")
                ->get();
        } else {
            $books = Book::where("date", ">=", $dateStar)
                ->where('date', '<=', $dateEnd)
                ->with("category")
                ->orderBy("date", "asc")
                ->where('category_id', $categoryId)
                ->get();
        }
        return $books;
    }

    public static function getTotalIngresoEgresoBooksInRangeDate($dateStart, $dateEnd, $categoryId)
    {
        if ($categoryId == 0) {
            $total = Book::where("date", ">=", $dateStart)
                ->where('date', '<=', $dateEnd)
                ->selectRaw("sum(CASE WHEN type = 'ingreso' THEN haber ELSE 0 END ) as total_ingreso")
                ->selectRaw("sum(CASE WHEN type = 'egreso' THEN debe ELSE 0 END ) as total_egreso")
                ->selectRaw("sum(debe)+sum(haber) as total")
                ->first()->toArray();
        } else {
            $total = Book::where("date", ">=", $dateStart)
                ->where('date', '<=', $dateEnd)
                ->selectRaw("sum(CASE WHEN type = 'ingreso' THEN haber ELSE 0 END ) as total_ingreso")
                ->selectRaw("sum(CASE WHEN type = 'egreso' THEN debe ELSE 0 END ) as total_egreso")
                ->selectRaw("sum(debe)+sum(haber) as total")
                ->where('category_id', $categoryId)
                ->first()
                ->toArray();
        }
        return $total;
    }
}
