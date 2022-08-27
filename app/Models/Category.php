<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "id", "name", "category_id",'is_enabled'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function books()
    {
        return  $this->hasMany(Book::class);
    }

    public static function totalByCategoryByYear($year){
        $books = Category::whereNull("category_id")
            ->with('categories', function ($query) use ($year) {
                $query->withSum(["books" => function ($books) use ($year) {
                    $books->whereYear("date", $year);
                }], 'debe')
                    ->withSum(["books" =>  function ($books) use ($year) {
                        $books->whereYear("date", $year);
                    }], 'haber')->get();
            })
            ->get();
            $total = 0;
            foreach ($books as $key => $book) {
                $total_ingreso_haber =  $book->categories->sum('books_sum_haber');
                $total_ingreso_debe =  $book->categories->sum('books_sum_debe');
                $book->total_ingreso = $total_ingreso_haber - $total_ingreso_debe;
                $book->total_ingreso_haber = $total_ingreso_haber;
                $book->total_ingreso_debe = $total_ingreso_debe;
                $total += $book->total_ingreso;
            }
            $data = [
                "year" => $year,
                "total_year" => $total,
                "categories" => $books,
            ];
        return $data;
    }
}
