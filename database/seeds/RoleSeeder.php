<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        
        $roles = [
	        'administrator',
	        'user'
        ];
        foreach ($roles as $role) {
	        $this->newRole($role);
        }
    }
    
    public function newRole($name){
	    $role = new App\Role;
	    $role->name = $name;
	    $role->save();
    }
}
