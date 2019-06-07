<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratista extends Model
{
    //
    protected $fillable = [
        'nombre', 'centro_SAP', 'almacen_SAP'
    ];


    public function user()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function consumo()
    {
        return $this->belongsToMany('App\Consumo')->withTimestamps();
    }

}
