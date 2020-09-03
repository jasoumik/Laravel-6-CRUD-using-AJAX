<?php

namespace App;

use App\Company;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table='projects';
    protected $fillable=['project_name','location','area_in_bigha',
    'company_id'];
    public function company(){
        return $this->hasMany(Company::class);
    }
}
