<?php

use Illuminate\Database\Seeder;
use Credential;

class PasswordEncrypter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credentials = Credential::get();
        foreach ($credentials as $cred) {
	        $cred->password = Crypt::encrypt($cred->password);
	        $cred->save();
        }
    }
}
