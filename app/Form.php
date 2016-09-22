<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Ramsey\Uuid\Uuid;

class Form extends Model
{
	public $incrementing = false;
	
    protected $fillable = ['id', 'name', 'data', 'hash'];
    
    protected $casts = [
        'data' => 'array',
    ];
    
    public function setIdAttribute($value) {
	    $uuid = Uuid::uuid1();
	    $this->attributes["id"] = $uuid->toString();
    }
}
