<?php

namespace App\Http\Controllers;

use App\Atleta;
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
            for($i = 0; $i < count($request->atletas); $i++){
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
                        'pago' => 1,
                        'invitado' =>  $request->tipo_pago
                    ]
                );
            }
        });
    }
}
