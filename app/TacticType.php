<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TacticType extends Model
{
	protected $table = 'tactictypes';
	protected $fillable = ['name'];
    //
    public function tactics() {
	    return $this->belongsToMany('App\Tactic', 'tactic_tactictype', 'tactictype_id', 'tactic_id');
    }
}
