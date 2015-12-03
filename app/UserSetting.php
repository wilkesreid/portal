<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    //
    protected $table = 'user_settings';
    
    protected $fillable = ['user_id','theme','role'];
    
    public function user() {
	    return $this->belongsTo('App\User');
    }
}
