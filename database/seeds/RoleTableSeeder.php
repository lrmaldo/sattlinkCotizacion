<?php

use Illuminate\Database\Seeder;
use App\roles;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new roles();
        $role->name = 'admin';
        $role->description = 'Administrator';
        $role->save();
        $role = new roles();
        $role->name = 'vendedor';
        $role->description = 'Vendedor';
        $role->save();
    }
}
