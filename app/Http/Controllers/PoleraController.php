<?php

namespace App\Http\Controllers;

use App\Polera;
use Illuminate\Http\Request;

class PoleraController extends Controller
{
    //
    public function index(){
        return ['poleras' => Polera::orderBy('talla', 'asc')->get()];
    }

    public function crear_actualizar(Request $request){
        Polera::updateOrCreate(
            ['id' => $request->id],
            [
                'talla' => $request->talla
            ]
        );
    }

    public function borrar(Request $request){
        Polera::find($request->id)->delete();
    }
}
