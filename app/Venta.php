<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
    protected $guarded = ['id'];
    protected $appends = ['run_atleta', 'nombre_atleta', 'correo_atleta', 'categoria_atleta'];
    

    public function getRunAtletaAttribute(){
        return $this->atleta_id != null ? $this->atleta->run : 'SIN RUN';
    }

    public function getNombreAtletaAttribute(){
        return $this->atleta_id != null ? $this->atleta->nombre : 'SIN NOMBRE';
    }

    public function getCorreoAtletaAttribute(){
        return $this->atleta_id != null ? $this->atleta->correo : 'SIN CORREO';
    }

    public function getCategoriaAtletaAttribute(){
        return $this->atleta_id != null ? $this->atleta->categoria->categoria . ' ' . $this->atleta->categoria->nombre : 'SIN CORREO';
    }

    public function atleta(){
        return $this->belongsTo(Atleta::class, 'atleta_id');
    }
}
