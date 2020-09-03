<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyOwner extends Model
{
    protected $table='companies_owners';
    protected $fillable=
    ['owner_type',
    'ownership_percentage',
    'user_id',
    'company_id'];
}
