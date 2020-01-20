<?php

namespace App\Http\Controllers;

use App\Atleta;
use App\Mail\Anular;
use App\Mail\Confirmacion;
use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class VentaController extends Controller
{
    //
    public function index(){
        return ['ventas' => Venta::orderBy('estado', 'asc')->get()];
    }

    public function confirmar_pendiente(Request $request){
        DB::transaction(function () use ($request) {
            $venta = Venta::find($request->id);
            $venta->estado = $request->accion;
            $venta->save();

            $atleta = Atleta::find($venta->atleta_id);

            if($atleta->nombre_equipo != 'SIN EQUIPO'){
                Atleta::where('nombre_equipo', $atleta->nombre_equipo)->where('created_at', $atleta->created_at)->update(['pago' => $request->accion]);
            } else {
                $atleta->pago = $request->accion;
                $atleta->save();
            }

            if($request->accion == 1){
                Mail::to($atleta->correo)->send(new Confirmacion($atleta));
            }

        });
    }

    public function eliminar_inscripcion(Request $request){
        DB::transaction(function () use ($request) {
            $atleta_id = 0;

            $venta = Venta::find($request->id);
            $atleta_id = $venta->atleta_id;

            $venta->delete();

            $atleta = Atleta::find($venta->atleta_id);

            if($atleta->nombre_equipo != 'SIN EQUIPO'){
                Atleta::where('nombre_equipo', $atleta->nombre_equipo)->where('created_at', $atleta->created_at)->delete();
            } else {
                $atleta->delete();
            }

            if($request->accion == 1){
                Mail::to($atleta->correo)->send(new Anular($atleta));
            }

        });
    }
}
