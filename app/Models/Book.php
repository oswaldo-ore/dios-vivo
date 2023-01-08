<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "date", "debe", "haber", "description", "type", "category_id", 'saldo', "user_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function moreDescription()
    {
        return $this->hasMany(MoreDescriptionBook::class);
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
            $book = new Book([
                "date" => $data->date,
                "debe" => $debe,
                "haber" => $haber,
                'saldo' => $debe > 0 ? $debe : $haber,
                "description" => $data->description,
                "type" => $data->type,
                "category_id" => $data->category_id,
                "user_id" => Auth::user()->id,
            ]);
            $book->save();
            $moreDescription = [];
            $dataMore = json_decode(json_encode($data->more_description),true);
            foreach ($dataMore as $dataM) {
                $moreDescription[] = [
                    'nombre' => $dataM['name'],
                    'precio' => $dataM['price'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    'book_id' => $book->id,
                ];
            }
            MoreDescriptionBook::insert($moreDescription);

            /*$books[] = [
                "date" => $data->date,
                "debe" => $debe ,
                "haber" => $haber,
                'saldo' => $debe > 0 ? $debe : $haber,
                "description" => $data->description,
                "type" => $data->type,
                "category_id" => $data->category_id,
                "user_id" => Auth::user()->id,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];*/
            $total_debe += $debe;
            $total_haber += $haber;
        }
        //Book::insert($books);
        return $total_haber - $total_debe;
    }

    public static function getDetailsOfBookInRangeDate($dateStar, $dateEnd, $categoryId)
    {
        if ($categoryId == 0) {
            $books = Book::with(['category' => function($query){
                $query->withTrashed()->select('id','name','deleted_at');
            }])
                ->with('moreDescription')
                ->where("date", ">=", $dateStar)
                ->where('date', '<=', $dateEnd)
                ->orderBy("date", "desc")
                ->get();
        } else {
            $categoryIds = [$categoryId];
            if ($categoryId == 1 || $categoryId == 2) {
                $categoryIds = Category::find($categoryId)->categories->pluck('id')->toArray();
            }
            $books = Book::where("date", ">=", $dateStar)
                ->where('date', '<=', $dateEnd)
                ->with("category:id,name")
                ->with('moreDescription')
                ->orderBy("date", "desc")
                ->whereIn('category_id', $categoryIds)
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
                ->selectRaw("cast(sum(haber)-sum(debe) as decimal(20,2)) as total ")
                ->first()->toArray();
        } else {
            $categoryIds = [$categoryId];
            if ($categoryId == 1 || $categoryId == 2) {
                $categoryIds = Category::find($categoryId)->categories->pluck('id')->toArray();
            }
            $total = Book::where("date", ">=", $dateStart)
                ->where('date', '<=', $dateEnd)
                ->selectRaw("sum(CASE WHEN type = 'ingreso' THEN haber ELSE 0 END ) as total_ingreso")
                ->selectRaw("sum(CASE WHEN type = 'egreso' THEN debe ELSE 0 END ) as total_egreso")
                ->selectRaw("cast(sum(haber)-sum(debe) as decimal(20,2)) as total ")
                ->whereIn('category_id', $categoryIds)
                ->first()
                ->toArray();
        }
        return $total;
    }
    // get first year
    public static function getYearOfFirstRecord(){
        return Book::selectRaw('MIN(date) as min_year')->first()->min_year;
    }

    public static function getYearOfLastRecord(){
        return Book::selectRaw('MAX(date) as max_year')->first()->max_year;
    }

    //get details of books by year
    public static function getDetailsOfBooksByYear($request){
        $year = $request->year;
        $category_id = $request->category_id;
        $show_category = $request->show_category;

        //todas las categorias
        $books = Book::whereYear('date','=',$year);
        if($category_id > 0){
            $categories_id =[$category_id];
            if($category_id == 1 || $category_id == 2){
                $categories_id = Category::withTrashed()->find($category_id)->categories->pluck('id')->toArray();
            }
            $books->whereIn('category_id',$categories_id)->selectRaw('category_id')->groupBy('category_id')->orderBy('category_id')->with('category:id,name');
        }
        if($show_category == 1 && $category_id == 0 ){
            $books->selectRaw('category_id')->groupBy('category_id')->orderBy('category_id')->with('category:id,name');
        }

        $books->selectRaw("
            count('id') as amount,
            DATE_FORMAT(date,'%Y-%m') as new_date,
            cast( sum(haber) as decimal(20,2)) as haber,
            cast( sum(debe) as decimal(20,2)) as debe,
            cast( (sum(haber)- sum(debe))  as decimal(20,2))as balance_sum_debe_haber,
            cast( sum(IF(type = 'ingreso',saldo,0)) as decimal(20,2)) as haber_saldo,
            cast( sum(IF(type = 'egreso',saldo,0)) as decimal(20,2)) as debe_saldo,
            cast( (sum(IF(type = 'ingreso',saldo,0)) - sum(IF(type = 'egreso',saldo,0))) as decimal(20,2)) as total_saldo
        ")->groupBy('new_date')->orderBy('new_date');
        //todas las categorias

        return $books->get();
    }

    public static function getDetailsOfBooksByMonthsAll(){

        $books = Book::selectRaw("
            count('id') as amount,
            DATE_FORMAT(date,'%m-%Y') as new_date,
            cast( sum(haber) as decimal(20,2)) as haber,
            cast( sum(debe) as decimal(20,2)) as debe,
            cast( (sum(haber)- sum(debe))  as decimal(20,2))as balance_sum_debe_haber,
            cast( sum(IF(type = 'ingreso',saldo,0)) as decimal(20,2)) as haber_saldo,
            cast( sum(IF(type = 'egreso',saldo,0)) as decimal(20,2)) as debe_saldo,
            cast( (sum(IF(type = 'ingreso',saldo,0)) - sum(IF(type = 'egreso',saldo,0))) as decimal(20,2)) as total_saldo
        ")
        ->orderBy('new_date')
        ->groupBy('new_date')
        ->get();
        return $books;
    }
    public static function getDetailsOfBooksByYearAll(){

        $books = Book::selectRaw("
            count('id') as amount,
            DATE_FORMAT(date,'%Y') as new_date,
            cast( sum(haber) as decimal(20,2)) as haber,
            cast( sum(debe) as decimal(20,2)) as debe,
            cast( (sum(haber)- sum(debe))  as decimal(20,2))as balance_sum_debe_haber,
            cast( sum(IF(type = 'ingreso',saldo,0)) as decimal(20,2)) as haber_saldo,
            cast( sum(IF(type = 'egreso',saldo,0)) as decimal(20,2)) as debe_saldo,
            cast( (sum(IF(type = 'ingreso',saldo,0)) - sum(IF(type = 'egreso',saldo,0))) as decimal(20,2)) as total_saldo
        ")
        ->orderBy('new_date')
        ->groupBy('new_date')
        ->get();
        return $books;
    }

    public static function getTotalForYear($year){
        $books = Book::whereYear('date', '=', $year)->selectRaw("
            count('id') as amount,
            DATE_FORMAT(date,'%Y') as new_date,
            cast( sum(haber) as decimal(20,2)) as haber,
            cast( sum(debe) as decimal(20,2)) as debe,
            cast( (sum(haber)- sum(debe))  as decimal(20,2))as balance_sum_debe_haber,
            cast( sum(IF(type = 'ingreso',saldo,0)) as decimal(20,2)) as haber_saldo,
            cast( sum(IF(type = 'egreso',saldo,0)) as decimal(20,2)) as debe_saldo,
            cast( (sum(IF(type = 'ingreso',saldo,0)) - sum(IF(type = 'egreso',saldo,0))) as decimal(20,2)) as total_saldo
        ")
        ->orderBy('new_date')
        ->groupBy('new_date')
        ->first();
        return $books;
    }

    public static function totalBalanceUpToThePreviousYear($year){
        $books = Book::whereYear('date', '<=', $year)->selectRaw("
            count('id') as amount,
            DATE_FORMAT(date,'%Y') as new_date,
            cast( sum(haber) as decimal(20,2)) as haber,
            cast( sum(debe) as decimal(20,2)) as debe,
            cast( (sum(haber)- sum(debe))  as decimal(20,2))as balance_sum_debe_haber,
            cast( sum(IF(type = 'ingreso',saldo,0)) as decimal(20,2)) as haber_saldo,
            cast( sum(IF(type = 'egreso',saldo,0)) as decimal(20,2)) as debe_saldo,
            cast( (sum(IF(type = 'ingreso',saldo,0)) - sum(IF(type = 'egreso',saldo,0))) as decimal(20,2)) as total_saldo
        ")
        ->orderBy('new_date')
        ->groupBy('new_date')
        ->get();
        $total = 0;
        foreach ($books as $book) {
            $total+= $book->total_saldo;
        }
        return (object)[
            'last_year' => $year,
            'total' => $total,
        ];
    }

    public static function getAllYearWithoutYearNow(){
        $yearNow = Carbon::now()->format('Y');
        $years = Book::whereYear('date','!=',$yearNow)
        ->selectRaw("DATE_FORMAT(date,'%Y') as new_date")
        ->groupBy('new_date')
        ->get()
        ->pluck('new_date')
        ->toArray();
        return $years;
    }
}
