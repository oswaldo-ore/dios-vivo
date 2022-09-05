<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id','name'
    ];

    protected $table = "rols";

    public function users(){
        return $this->hasMany(User::class,'rol_id','id');
    }

    public static function getRoles(){
        return Rol::where('id','!=',1)->get();
    }
}
