<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemTransaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'booking';
    protected $fillable = ['id','denda3', 'denda2', 'denda1', 'denda', 'id_transaction', 'id_motor', 'price', 'qty', 'total'];

    public function Transaction(){
        return $this->belongsTo(Transaction::class,'id_transaction','id');
    }

    public function Motor(){
        return $this->belongsTo(Motor::class,'id_motor');
    }
}
