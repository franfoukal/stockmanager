<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratista extends Model
{
    //
    protected $fillable = [
        'nombre', 'centro_SAP', 'almacen_SAP'
    ];


    public function contratista()
    {
        return $this->belongsToMany('App\User');
    }

}
