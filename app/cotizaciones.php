<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cotizaciones extends Model
{
    protected $primaryKey ='id';
    protected $table = 'cotizaciones';
    protected $fillable = [
        'id', 'folio', 'forma', 'comentario', 'id_datosfiscales',
        'descuento','total','id_vendedor',
        'id_cliente',/* foreign key */
        'id_detalle_cotizacion' /* foreign key */
    ];
    public function vendedor()
    {
        return $this->hasOne(User::class,'id','id_vendedor');
    }
    public function cliente()
    {
        return $this->hasOne(clientes::class, 'id','id_cliente');
    }
}
