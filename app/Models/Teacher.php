<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teacher';
    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->age;
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'id_teacher', 'id');
    }
}
