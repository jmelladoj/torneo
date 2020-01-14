<?php

namespace App\Http\Controllers;

use App\Atleta;
use Illuminate\Http\Request;

class AtletaController extends Controller
{
    //
    public function index_categoria($id){
        return ['atletas' => Atleta::where('categoria_id', $id)->orderBy('nombre', 'asc')->get()];
    }
}
