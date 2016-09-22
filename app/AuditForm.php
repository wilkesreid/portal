<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Ramsey\Uuid\Uuid;

class AuditForm extends Model
{
    protected $fillable = ['id', 'name', 'frozen'];
    
    public $incrementing = false;
    
    public function setIdAttribute($value) {
	    $uuid = Uuid::uuid1();
	    $this->attributes["id"] = $uuid->toString();
    }
    
    public function fields() {
        return $this->hasMany('App\AuditFormField');
    }
}
