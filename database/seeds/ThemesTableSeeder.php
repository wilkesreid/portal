<?php

use Illuminate\Database\Seeder;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('themes')->truncate();
	    
        $themes = ['cosmo','cyborg','journal','simplex','superhero'];
        
        foreach ($themes as $theme) {
	        $t = new App\Theme;
	        $t->name = ucwords($theme);
	        $t->style_url = "/css/themes/".$theme."/bootstrap.min.css";
	        $t->save();
        }
    }
}
