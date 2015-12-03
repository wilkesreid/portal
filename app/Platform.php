<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    //
    protected $fillable = ['name','url','client_id'];
    
    public function client() {
	    return $this->belongsTo('\App\Client');
    }
    
    public function credentials() {
	    return $this->hasMany('\App\Credential');
    }
}
