<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'veiculo_id',
        'user_id',   //quien hizo el registro
        'monto',
        'rol',
        'fecha',
    ];


    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function veiculo(){
        return $this->belongsTo(Veiculo::class,'veiculo_id','id');
    }
}
