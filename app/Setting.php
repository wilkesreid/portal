<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public static function getValue($name) {
	    return self::get($name)->value;
    }
    public static function get($name) {
	    return self::where('name',$name)->first();
    }
}
