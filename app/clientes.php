<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'id', 'nombre', 'estatus','email','direccion','telefono','descuento'
    ];
    public function cliente()
    {
        return $this->belongsTo('App\cotizaciones');
    
    }
}
