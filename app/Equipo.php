<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = ['datos_equipos', 'fecha', 'contratista_id'];

    protected $casts = [
        'datos_equipos' => 'array',
    ];

    public function contratista()
    {
        return $this->belongsToMany('App\Contratista')->withTimestamps();
    }

}



