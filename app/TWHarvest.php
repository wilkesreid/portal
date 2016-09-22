<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TWHarvest extends Model
{
    protected $table = "tw_harvest";
    protected $fillable = ["teamwork_milestone_id", "harvest_project_id"];
    public $timestamps = false;
}
