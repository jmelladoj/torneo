<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['categoria_nombre', 'cupos_usados'];

    public function getCategoriaNombreAttribute(){
        switch ($this->categoria) {
            case 1:
                return 'INDIVIDUAL';
                break;
            case 2:
                return 'DUPLAS';
                break;
            case 3:
                return 'TRÍOS';
                break;
        }
    }

    public function getCuposUsadosAttribute(){
        return $this->hasMany(Atleta::class)->count();
    }
}
