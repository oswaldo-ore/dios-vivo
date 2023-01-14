<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "transactions";

    protected $fillable = [
        'id','description','user_id','amount','date','book_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public static function createTransaction($description, $amount,$book_id){
        $transaction = new Transaction();
        $transaction->description = $description;
        $transaction->amount = $amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->book_id = $book_id;
        $transaction->date = Carbon::now()->format('Y-m-d');
        $transaction->save();
        return $transaction;
    }
}
