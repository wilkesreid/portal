<?php

use Illuminate\Database\Seeder;
use App\Credential;

class DecryptEverything extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creds = Credential::get();
        foreach ($creds as $cred) {
	        $cred->password = $cred->password;
	        $cred->username = $cred->username;
	        $cred->save();
        }
    }
}
