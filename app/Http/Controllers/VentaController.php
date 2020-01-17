<?php

namespace App\Http\Controllers;

use App\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    //
    public function index(){
        return ['ventas' => Venta::orderBy('estado', 'asc')->get()];
    }
}
