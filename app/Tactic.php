<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tactic extends Model
{
  protected $fillable = ['name'];
    //
    public function types() {
	    return $this->belongsToMany('App\TacticType', 'tactic_tactictype', 'tactic_id', 'tactictype_id');
    }
    /*public function babies() {
	    return $this->hasMany('App\Baby','tactic_id');
    }*/
}
