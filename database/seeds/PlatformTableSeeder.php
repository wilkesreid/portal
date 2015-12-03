<?php

use Illuminate\Database\Seeder;

class PlatformTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('platforms')->truncate();
        
        $faker = Faker\Factory::create();
        
        $client_ids = \App\Client::lists('id')->all();
        
        for ($i=0;$i<50;$i++) {
	        DB::table('platforms')->insert([
		        'name' => $faker->domainName,
		        'url' => $faker->url,
		        'client_id' => $faker->randomElement($client_ids)
	        ]);
        }
        
    }
}
