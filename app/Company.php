<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['company_name','ownership_type','date_started',
    'date_ended'];
      public function project(){
          return $this->belongsTo(Project::class);
      }
}
