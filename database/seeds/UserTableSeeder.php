<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\impuestos;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'user')->first();
        $role_admin = Role::where('name', 'admin')->first();
        $user = new User();
        $user->name = 'User';
        $user->email = 'user@example.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_user);
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_admin);

        /* user admin rafa */
     
        $user = new User();
        $user->name = 'Ing Rafael Núñez';
        $user->email = 'rafael.nunez@sattlink.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_admin);

        /* user admin marcelo */
        $user = new User();
        $user->name = 'Lic. Marcelo Rodriguez';
        $user->email = 'marcelo.rodriguez@sattlink.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_admin);


        $impuesto = new impuestos();
        $impuesto->cantidad = 16 ;
       // $impuesto->tipo_cambio_syscom = 20;
        $impuesto->utilidad = 40;
        $impuesto->save();
    }
}
