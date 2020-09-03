<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectWorker extends Model
{
    protected $table='projects_workers';
    protected $fillable=['project_id','user_id'];
}
