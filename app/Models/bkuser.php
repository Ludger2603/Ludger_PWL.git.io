<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bkuser extends Model
{
    use HasFactory;
    protected $table = 'bkusers';
    protected $fillable = ['id_user','name','no_plat','name_motor','lama_sewa','keterangan','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
