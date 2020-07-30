<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
    protected $table = 'role_user';

    public function rol_user(){
        return $this->belongsTo('\App\User','user_id');
    }
}
