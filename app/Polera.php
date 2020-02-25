<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Polera extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['cantidad_poleras', 'cantidad_poleras_hombre', 'cantidad_poleras_mujer'];

    public function getCantidadPolerasAttribute(){
        return $this->hasMany(Atleta::class, 'polera_id')->where('pago', 1)->OrWhere('invitado', 1)->groupBy('polera_id')->having('polera_id', $this->id)->count();
    }

    public function getCantidadPolerasHombreAttribute(){
        $categorias = [1, 2, 3, 4, 5];

        return $this->atletas($categorias, 1);
    }

    public function getCantidadPolerasMujerAttribute(){
        $categorias = [6, 7, 8, 9];

        return $this->atletas($categorias, 2);
    }

    public function atletas($categorias, $sexo){
        $atletas = Atleta::whereIn('categoria_id', $categorias)->where('polera_id', $this->id)->where('pago', 1)->OrWhere('invitado', 1)->count();
        $atletas_trio = Atleta::where('categoria_id', 10)->where('polera_id', $this->id)->where('sexo', $sexo)->count();

        return $atletas + $atletas_trio;
    }
}
