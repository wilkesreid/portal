<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('settings')->truncate();
	    
	    $settings = [
		    [
			    'name' => 'guest_theme',
			    'value' => '1'
		    ],
		    [
			    'name' => 'default_user_theme',
			    'value' => '1'
		    ],
		    [
			    'name' => 'default_role',
			    'value' => 'user'
		    ]
	    ];
        foreach ($settings as $setting) {
	        $this->newSetting($setting);
        }
    }
    
    private function newSetting($vals) {
	    $set = new App\Setting;
	    foreach ($vals as $key=>$val) {
		    $set->$key = $val;
	    }
	    $set->save();
    }
}
