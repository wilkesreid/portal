<?php

use Illuminate\Database\Seeder;
use App\Credential;

class EncryptUsernames extends Seeder
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
	        $cred->username = Crypt::encrypt($cred->username);
	        $cred->save();
        }
    }
}
