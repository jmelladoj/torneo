<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
    protected $guarded = ['id'];
    protected $appends = ['run_atleta', 'nombre_atleta', 'correo_atleta', 'categoria_atleta', 'invitado'];


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
        return $this->atleta_id != null ? $this->atleta->categoria->categoria_nombre . ' ' . $this->atleta->categoria->nombre : 'SIN CATEGORÍA';
    }

    public function getInvitadoAttribute(){
        return $this->atleta_id != null ? $this->atleta->invitado : 0;
    }

    public function atleta(){
        return $this->belongsTo(Atleta::class, 'atleta_id');
    }
}
