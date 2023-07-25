<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'placa',
        'circulacion',
        'color',
        'marca',
        'modelo',
        'user_id',
    ];


    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function aporte(){
        return $this->hasMany(Aporte::class,'veiculo_id','id');
    }

}
