<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function doctor()
    {
        return $this->hasManyThrough('App\Models\Doctor','App\Models\Hospital','country_id','hospital_id','id','id');
    }

    public function hospital()
    {
        return $this->hasMany('App\Models\Hospital','country_id','id');
    }

}
