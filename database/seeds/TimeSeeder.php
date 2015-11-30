<?php

use Illuminate\Database\Seeder;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = App\User::all()->lists('id')->all();
        
        DB::table('times')->delete();
        
        for ($i=0;$i<20;$i++) {
	        DB::table('times')->insert([
		       'user_id' => $faker->randomElement($users),
		       'time_started' => $faker->dateTime(),
		       'time_ended' => $faker->dateTime() 
	        ]);
        }
    }
}
