<?php

namespace App\Http\Controllers;

use App\Atleta;
use App\Categoria;
use App\Mail\Transferencia;
use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

class AtletaController extends Controller
{
    //
    public function index_admin(){
        return ['atletas' => Atleta::where('pago', 1)->orWhere('invitado', 1)->orderBy('categoria_id', 'asc')->orderBy('nombre_equipo', 'asc')->orderBy('nombre', 'asc')->get()];
    }

    public function index_categoria($id){
        return ['atletas' => Atleta::where('categoria_id', $id)->orderBy('nombre_equipo', 'asc')->orderBy('nombre', 'asc')->get()];
    }

    public function validar_unico($texto){
        return json_encode(Atleta::where('run', $texto)->get()->count() > 0 ? false : true);
    }

    public function agregar_admin(Request $request){
        DB::transaction(function () use ($request) {
            $categoria = Categoria::find($request->categoria_id);
            $id = 0;

            for($i = 0; $i < count($request->atletas); $i++){
                if($categoria->categoria < 2){
                    $atleta = Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $request->email,
                            'encargado' => 1,
                            'fecha_nacimiento' => $request->atletas[$i]['fecha_nacimiento'] != null ? $request->atletas[$i]['fecha_nacimiento'] : 'SIN FECHA',
                            'box' => $request->box == '' ? 'SIN BOX' : $request->box,
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                            'invitado' =>  $request->tipo_pago
                        ]
                    );

                    $id = $atleta->id;
                } else {
                    $atleta = Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $i == 0 ? $request->email : 'SIN CORREO',
                            'encargado' => $i == 0 ? 1 : 0,
                            'box' => $request->box == '' ? 'SIN BOX' : $request->box,
                            'nombre_equipo' => $request->nombre_equipo != null ? $request->nombre_equipo : 'SIN EQUIPO',
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                            'invitado' =>  $request->tipo_pago
                        ]
                    );

                    if($i == 0){
                        $id = $atleta->id;
                    }
                }
            }

            $atleta = Atleta::find($id);

            Venta::create([
                'atleta_id' => $atleta->id,
                'monto_pago' => $categoria->valor,
            ]);

            if($request->tipo_pago == 0){
                Mail::to($atleta->correo)->send(new Transferencia($atleta));
            }
        });
    }

    public function agregar_usuario_webpay(Request $request){
        //DB::transaction(function () use ($request) {
            $ventas = Venta::get()->count();

            $categoria = Categoria::find($request->categoria_id);
            $id = 0;

            for($i = 0; $i < count($request->atletas); $i++){
                if($categoria->categoria < 2){
                    $atleta = Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $request->email,
                            'encargado' => 1,
                            'fecha_nacimiento' => $request->atletas[$i]['fecha_nacimiento'] != null ? $request->atletas[$i]['fecha_nacimiento'] : 'SIN FECHA',
                            'box' => $request->box == '' ? 'SIN BOX' : $request->box,
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                        ]
                    );

                    $id = $atleta->id;
                } else {
                    $atleta = Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $i == 0 ? $request->email : 'SIN CORREO',
                            'encargado' => $i == 0 ? 1 : 0,
                            'box' => $request->box == '' ? 'SIN BOX' : $request->box,
                            'nombre_equipo' => $request->nombre_equipo != null ? $request->nombre_equipo : 'SIN EQUIPO',
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                        ]
                    );

                    if($i == 0){
                        $id = $atleta->id;
                    }
                }
            }

            $atleta = Atleta::find($id);

            $bag = CertificationBagFactory::integrationWebpayNormal();
            $plus = TransbankServiceFactory::normal($bag);
            $plus->addTransactionDetail($categoria->valor, ($ventas + 1));

            $response = $plus->initTransaction(url('/inscripcion/procesar'), url('/inscripcion/finalizar'));

            Venta::create([
                'atleta_id' => $atleta->id,
                'monto_pago' => $categoria->valor,
                'token' => $response->token
            ]);

            return [
                'url' => $response->url,
                'token' => $response->token
            ];
        //});
    }

    public function agregar_usuario_transferencia(Request $request){
        //DB::transaction(function () use ($request) {
            $categoria = Categoria::find($request->categoria_id);
            $id = 0;

            for($i = 0; $i < count($request->atletas); $i++){
                if($categoria->categoria < 2){
                    $atleta = Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $request->email,
                            'encargado' => 1,
                            'fecha_nacimiento' => $request->atletas[$i]['fecha_nacimiento'] != null ? $request->atletas[$i]['fecha_nacimiento'] : 'SIN FECHA',
                            'box' => $request->box,
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                        ]
                    );

                    $id = $atleta->id;
                } else {
                    $atleta = Atleta::create(
                        [
                            'run' => $request->atletas[$i]['run'],
                            'nombre' => $request->atletas[$i]['nombre'],
                            'correo' => $i == 0 ? $request->email : 'SIN CORREO',
                            'encargado' => $i == 0 ? 1 : 0,
                            'nombre_equipo' => $request->nombre_equipo != null ? $request->nombre_equipo : 'SIN EQUIPO',
                            'polera_id' => $request->atletas[$i]['polera'],
                            'categoria_id' => $request->categoria_id,
                        ]
                    );

                    if($i == 0){
                        $id = $atleta->id;
                    }
                }
            }

            $atleta = Atleta::find($id);


            Venta::create([
                'atleta_id' => $atleta->id,
                'monto_pago' => $categoria->valor
            ]);
        //});
    }

    public function borrar(Request $request) {
        $atleta = Atleta::find($request->id);
        Venta::where('atleta_id', $atleta->id)->delete();

        if($atleta->nombre_equipo != 'SIN EQUIPO'){
            Atleta::where('nombre_equipo', $atleta->nombre_equipo)->where('created_at', $atleta->created_at)->delete();
        } else {
            $atleta->delete();
        }
    }
}
