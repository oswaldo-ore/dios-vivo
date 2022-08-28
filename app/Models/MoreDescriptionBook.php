<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoreDescriptionBook extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id','nombre','precio'
    ];
    protected $table = 'more_description_books';

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
