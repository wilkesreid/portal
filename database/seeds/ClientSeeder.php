<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->truncate();
	    
	    $names = [
		    'Artisan Clinical Associates',
		    'Aurora Economic Development Commission',
		    'Casey Allen',
		    'Catherine Conroy',
		    'Chris Rud',
		    'Community 4:12',
		    'Dairy Joy Drive-In',
		    'Dr. Tom Nelson',
		    'Drury Designs',
		    'Emmanuel House',
		    'Ferguson',
		    'First Baptist Church of Geneva',
		    'Fox Valley Christian Action',
		    'Fox Valley Montessori',
		    'Gravity',
		    'Hursthouse',
		    'Jimi Allen Productions',
		    'John G. Blumberg',
		    'Michelle Meyer',
		    'Oak Trust Credit Union',
		    'SciTech Museum',
		    'Stacey Hanke',
		    'Steve Shamrock',
		    'Swifty Foundation'
	    ];
	    
	    foreach ($names as $name) {
		    Client::create([
			   'name' => $name 
		    ]);
	    }
    }
}
