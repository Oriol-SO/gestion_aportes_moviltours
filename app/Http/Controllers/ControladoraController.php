<?php

namespace App\Http\Controllers;

use App\Models\Aporte;
use App\Models\Veiculo;
use Exception;
use Illuminate\Http\Request;

class ControladoraController extends Controller
{
    //
    private $user;
    
    public function __construct(Request $request)
    {   
        $this->user=$request->user();
        if($this->user->rol_id==1){
            abort(405,response()->json(['message'=>'No estas autorizado']));
        }
    }

    public function registrar_aporte(Request $request){
        try{
            $request->validate([
                'monto'=>'required|numeric',
                'fecha'=>'required|date',
                'veiculo'=>'required|numeric',
            ]);
            //verificar que ya exista un aporte en esta fecha
            $a=Aporte::where('veiculo_id',$request->veiculo)->whereDate('fecha',$request->fecha)->first();
            if($a){
                abort(405,'ya existe un registro en esta fecha');
            }
            $aporte= new Aporte();
            $aporte->monto=$request->monto;
            $aporte->fecha=$request->fecha;
            $aporte->veiculo_id=$request->veiculo;
            $aporte->rol=$this->user->rol_id==2?1:2;
            $aporte->user_id=$this->user->id;
            $aporte->save();

            return 'agregado';
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],405);
        }
    }


    public function get_veiculos(){
        try{
            $veiculos=Veiculo::where('circulacion',1)->get()->map(function($v){
                return[
                    'id'=>$v->id,
                      'socio_id'=>$v->user_id,
                      'socio_nombre'=>$v->user->name,
                      'socio_dni'=>$v->user->dni,
                      'socio_email'=>$v->user->email,
                      'socio_telefono'=>$v->user->telefono,
                    'placa'=>$v->placa,
                    'color'=>$v->color,
                    'marca'=>$v->marca,
                    'modelo'=>$v->modelo,
                    'aportaciones'=>$v->aporte,
                ];
            });

            return $veiculos;
            
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],405);
        }
    }

    public function del_aporte_veiculo(Request $request){
        try{
            $request->validate([
                'aporte_id'=>'required|numeric',
                'veiculo'=>'required|numeric'
            ]);
            $aporte=Aporte::where('id',$request->aporte_id)->where('veiculo_id',$request->veiculo)->first();
            $rol=$this->user->rol_id==2?1:2;
            if($aporte->rol!=$rol){
                abort(405,'No registraste este aporte asi que no puedes eliminar');
            }
            $aporte->delete();
            return 'eliminado';
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],405);
        }
    }
}
