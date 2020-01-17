<?php

namespace App\Http\Controllers;

use App\Atleta;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtletaController extends Controller
{
    //
    public function index_categoria($id){
        return ['atletas' => Atleta::where('categoria_id', $id)->orderBy('nombre', 'asc')->get()];
    }

    public function agregar_admin(Request $request){
        DB::transaction(function () use ($request) {
            $categoria = Categoria::find($request->categoria_id);

            for($i = 0; $i < count($request->atletas); $i++){
                if($categoria->categoria < 2){
                    Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $request->email,
                            'encargado' => 1,
                            'fecha_nacimiento' => $request->atletas[$i]['fecha_nacimiento'] != null ? $request->atletas[$i]['fecha_nacimiento'] : 'SIN FECHA',
                            'box' => $request->box,
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                            'invitado' =>  $request->tipo_pago
                        ]
                    );
                } else {
                    Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $i == 0 ? $request->email : 'SIN CORREO',
                            'encargado' => $i == 0 ? 1 : 0,
                            'nombre_equipo' => $request->nombre_equipo != null ? $request->nombre_equipo : 'SIN EQUIPO',
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                            'invitado' =>  $request->tipo_pago
                        ]
                    );
                }
            }
        });
    }
}
