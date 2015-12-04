<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Crypt;

class Credential extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['username','password','comments', 'platform_id'];
    
    protected $dates = ['deleted_at'];
    
    public function platform() {
	    return $this->belongsTo('\App\Platform');
    }
    
    public function getPasswordAttribute($value) {
	    if ($value != "")
	    return Crypt::decrypt($value);
	    else 
	    return "";
    }
}
