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
        
        $theme = new App\Theme;
        $theme->name = "Journal";
        $theme->style_url = "/css/themes/journal/bootstrap.min.css";
        $theme->save();
    }
}
