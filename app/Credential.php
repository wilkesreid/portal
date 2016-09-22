<?php

namespace App;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Crypt;
use App\Setting;
use App\User;
use Hash;
use Config;
use Cookie;

class Credential extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['username','password','comments', 'platform_id', 'type'];
    
    protected $dates = ['deleted_at'];
    
    protected $no_key_message = "N\A: Invalid Encryption Key";
    
    public function platform() {
	    return $this->belongsTo('\App\Platform');
    }
    
    public function getPasswordAttribute($value) {
	    // Get encryption key from client
	    $key = Cookie::get('key');
	    // Get hashed encryption key from database
	    $key_hash = Setting::where('name','encryption_key')->first()->value;
	    // Check client's given key against hashed one in database
	    if (!Hash::check($key,$key_hash)) {
		    return $this->no_key_message;
	    }
	    $encrypter = new \Illuminate\Encryption\Encrypter( $key, Config::get( 'app.cipher' ) );
	    return $encrypter->decrypt($value);
    }
    
    public function getUsernameAttribute($value) {
	    // Get encryption key from client
	    $key = Cookie::get('key');
	    // Get hashed encryption key from database
	    $key_hash = Setting::where('name','encryption_key')->first()->value;
	    // Check client's given key against hashed one in database
	    if (!Hash::check($key,$key_hash)) {
		    return $this->no_key_message;
	    }
	    $encrypter = new \Illuminate\Encryption\Encrypter( $key, Config::get( 'app.cipher' ) );
	    return $encrypter->decrypt($value);
    }
}
