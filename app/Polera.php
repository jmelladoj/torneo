<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Polera extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['cantidad_poleras'];

    public function getCantidadPolerasAttribute(){
        return $this->hasMany(Atleta::class, 'polera_id')->where('pago', 1)->count();
    }
}
