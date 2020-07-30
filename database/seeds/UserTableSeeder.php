<?php

use Illuminate\Database\Seeder;
use App\roles;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_vendedor = roles::where('name', 'vendedor')->first();
        $role_admin = roles::where('name', 'admin')->first();
        
        $user = new User();
        $user->name ='vendedor1';
        $user->email = "ejemplo@ejemplo.com";
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_vendedor);

        //admin

        $user = new User();
        $user->name ='Admin';
        $user->email = "lrmaldo@gmail.com";
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_admin);
        
    }
}
