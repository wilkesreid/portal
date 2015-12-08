<?php

use Illuminate\Database\Seeder;
use App\Credential;

class EncryptEverything extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //Crypt::setKey();
        $creds = Credential::get();
        foreach ($creds as $cred) {
	        $cred->password = Crypt::encrypt($cred->password);
	        $cred->username = Crypt::encrypt($cred->username);
	        $cred->save();
        }
    }
}
