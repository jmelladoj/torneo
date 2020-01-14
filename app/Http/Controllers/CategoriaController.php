<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function index(){
        return ['categorias' => Categoria::orderBy('categoria', 'asc')->orderBy('nombre', 'asc')->get()];
    }

    public function categoria_espicifica($id){
        return ['categoria' => Categoria::where('id', $id)->first()];
    }

    public function crear_actualizar(Request $request){
        Categoria::updateOrCreate(
            ['id' => $request->id],
            [
                'nombre' => $request->nombre,
                'valor' => $request->valor,
                'cupos' => $request->cupos,
                'categoria' => $request->categoria,
                'limitancia_edad' => $request->limitancia_edad,
                'edad_minima' => $request->edad_minima
            ]
        );
    }

    public function borrar(Request $request){
        Categoria::find($request->id)->delete();
    }
}
