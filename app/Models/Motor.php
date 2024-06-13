<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    protected $table = 'motors';
    protected $fillable = ['gambar','name','type','year','price_per_day','availability','denda'];
}
