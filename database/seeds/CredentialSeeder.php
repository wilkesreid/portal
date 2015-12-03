<?php

use Illuminate\Database\Seeder;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('credentials')->truncate();
	    
        $faker = \Faker\Factory::create();
        
        $platform_ids = \App\Platform::lists('id')->all();
        
        for ($i=0;$i<150;$i++) {
	        DB::table('credentials')->insert([
		        'username' => $faker->userName,
		        'password' => $faker->password,
		        'url' => $faker->url,
		        'comments' => $faker->text(50),
		        'type' => $faker->word,
		        'platform_id' => $faker->randomElement($platform_ids)
	        ]);
        }
    }
}
