<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        //DB::table('users')->truncate();
        
        for ($i=0;$i<10;$i++) {
	        DB::table('users')->insert([
		       'name' => $faker->name,
		       'email' => $faker->email,
		       'password' => Hash::make($faker->word)
	        ]);
        }
    }
}
