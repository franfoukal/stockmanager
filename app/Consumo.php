<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    protected $fillable = ['datos_consumo', 'contratista_id', 'fecha'];

    protected $casts = [
        'datos_consumos' => 'array',
    ];
}
