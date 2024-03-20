<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function teacher()
{
    return $this->belongsTo(Teacher::class,'id_teacher','id');  //Relacion de
}

}
