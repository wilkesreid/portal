<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Storage;

class AuditFormField extends Model
{
    use SoftDeletes; // Enable this when wanting to implement an "undo" option
    
    protected $dates = ['deleted_at'];
    
    public function getAttributesAttribute($value) {
        return json_decode(html_entity_decode($value));
    }
    
    public function getOptionsAttribute($value) {
        return json_decode(html_entity_decode($value));
    }
    
    /*public function getValueAttribute($value) {
        if ($this->tag == 'file' && !Storage::disk('s3')->has($value)) {
            return "";
        }
        return $value;
    }*/
}
