<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atleta extends Model
{
    //
    protected $guarded = ['id'];
    protected $appends = ['nombre_categoria', 'talla_polera'];

    public function getNombreCategoriaAttribute(){
        return $this->categoria_id != null ? $this->categoria->nombre : 'SIN CATEGORÍA';
    }
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function getTallaPoleraAttribute(){
        return $this->polera_id != null ? $this->polera->talla : 'SIN POLERA';
    }
    public function polera(){
        return $this->belongsTo(Polera::class, 'polera_id');
    }
}
