<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "id", "name", "category_id",
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
}
