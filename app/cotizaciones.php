<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cotizaciones extends Model
{
    protected $fillable = [
        'id', 'folio', 'forma', 'comentario', 'id_datosfiscales',
        'descuento','total','id_vendedor',
        'id_cliente',/* foreign key */
        'id_detalle_cotizacion' /* foreign key */
    ];
    public function vendedor()
    {
        return $this->hasOne('App\user','id_vendedor');
    }
}
