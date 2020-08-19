<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Psy\Util\Json;

class User extends Authenticatable
{
    use Notifiable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'name', 'email', 'password',
    ];

    public function vendedor()
    {
        return $this->belongsTo('App\cotizaciones', 'id');
    }

    
    public function roles()
{
     return $this
        ->belongsToMany('App\Role')
        ->withTimestamps();
}

public function nombre_rol(){
    $rol = $this->hasOne('App\role_user','id');
    
    return $rol;
//return $rol;
    //return $this->belongsTo('\App\role',$rol); 
//return $this->belongsTo('App\role','id');
}
public function rol_user($id){

    return $this->roles()->where('user_id', $id)->first();
}

public function authorizeRoles($roles)
{
    if ($this->hasAnyRole($roles)) {
        return true;
    }
    abort(401, 'Esta acción no está autorizada.');
}
public function hasAnyRole($roles)
{
    if (is_array($roles)) {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
    } else {
        if ($this->hasRole($roles)) {
            return true;
        }
    }
    return false;
}
public function hasRole($role)
{
    if ($this->roles()->where('name', $role)->first()) {
        return true;
    }
    return false;
}

  
}
