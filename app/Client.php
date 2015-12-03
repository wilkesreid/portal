<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = ['name'];
    
    public function platforms() {
	    return $this->hasMany('\App\Platform');
    }
}
