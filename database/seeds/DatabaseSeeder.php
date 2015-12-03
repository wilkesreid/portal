<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //$this->call(UserTableSeeder::class);
        //$this->call(ThemesTableSeeder::class);
        //$this->call(SettingsSeeder::class);
        //$this->call(ClientSeeder::class);
        //$this->call(PlatformTableSeeder::class);
        $this->call(CredentialSeeder::class);

        Model::reguard();
    }
}
