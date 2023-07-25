<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Exception;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    private $user;
    public function __construct(Request $request){
        $this->user=$request->user();
        if($this->user->rol_id!=1){
            abort(405,response()->json(['message'=>'No estas autorizado']));
        }
    }

    public function register_veiculo(Request $request){
        
        $request->validate([
            'nombre'=>'required',
            'placa'=>'required',
            //'color'=>'required',
            //'marca'=>'required',
            //'modelo'=>'required',
        ]);        
        try{
            $veiculo= new Veiculo();
            $veiculo->nombre=$request->nombre;
            $veiculo->placa=$request->placa;
            $veiculo->color=$request->color;
            $veiculo->marca=$request->marca;
            $veiculo->modelo=$request->modelo;
            $veiculo->user_id=$this->user->id;
            $veiculo->save();

            return 'veiculo añadido';
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],405);
        }
    }

    public function get_veiculos(){
        try{
            //obtener los veiculos deel usuario socio

            $veiculos=$this->user->veiculo->map(function($v){
                return[
                    'id'=>$v->id,
                    'user_id'=>$v->user_id,
                    'nombre'=>$v->nombre,
                    'placa'=>$v->placa,
                    'marca'=>$v->marca,
                    'modelo'=>$v->modelo,
                    'color'=>$v->color,
                    'registro'=>$v->created_at,
                    'circulacion'=>$v->circulacion,
                ];
            });

            return $veiculos;
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],405);
        }
    }
    
    public function get_info_veiculo($id){
        try{
            $v=Veiculo::findOrFail($id);
            //verificar si el veiculo me pertenece
            if($v->user_id!=$this->user->id){
                abort(405,'Usuario no autorizado');
            }
            return[
                'id'=>$v->id,
                'aportaciones'=>$v->aporte
            ];
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],405);
        }
    }
}