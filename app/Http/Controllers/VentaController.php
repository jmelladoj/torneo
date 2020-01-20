<?php

namespace App\Http\Controllers;

use App\Atleta;
use App\Mail\Anular;
use App\Mail\Confirmacion;
use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;


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

    public function procesar(Request $request){
        $bag = CertificationBagFactory::integrationWebpayNormal();
        $plus = TransbankServiceFactory::normal($bag);
        $response = $plus->getTransactionResult();

        $venta = Venta::where('token', $request->token_ws)->first();
        $atleta = Atleta::find($venta->atleta_id);

        if($response->detailOutput->responseCode == 0){
            if($atleta->nombre_equipo != 'SIN EQUIPO'){
                Atleta::where('nombre_equipo', $atleta->nombre_equipo)->where('created_at', $atleta->created_at)->update(['pago' => 1]);
            } else {
                $atleta->pago = 1;
                $atleta->save();
            }

            $venta->estado = 1;
            $venta->save();

            Mail::to($atleta->correo)->send(new Confirmacion($atleta));
        } else {
            $venta->delete();

            if($atleta->nombre_equipo != 'SIN EQUIPO'){
                Atleta::where('nombre_equipo', $atleta->nombre_equipo)->where('created_at', $atleta->created_at)->delete();
            } else {
                $atleta->delete();
            }

            Mail::to($atleta->correo)->send(new Anular($atleta));
        }

        $plus->acknowledgeTransaction();
        return RedirectorHelper::redirectBackNormal($response->urlRedirection);

    }

    public function finalizar(Request $request){
        $venta = Venta::where('token', $request->token_ws)->first();

        $titulo = "!! LO SENTIMOS ¡¡";
        $texto =  "HEMOS TENIDO ALGUNOS <br> INCONVENIENTES PARA RECIBIR <br> TU PAGO. INTÉNTELO NUEVAMENTE.";

        if($venta != null){
            $atleta = Atleta::find($venta->atleta_id);
            $titulo = "!! MUCHAS GRACIAS ¡¡";
            $texto = "YA ESTAS INSCRITO EN EL <br> TORNEO ARENA, NO OLVIDES SEGUIR <br> NUESTRAS REDES SOCIALES PARA NO <br> PERDER DE NINGÚN DETALLE O SORPRESA.";
        }

        return view('resultado')->with(compact('titulo', 'texto'));
    }
}
