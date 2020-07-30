<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roles_user extends Model
{
    protected $table = "roles";
    protected $fillable = [
        'id', 'role_id',
        'user_id',
       
    ];

}
