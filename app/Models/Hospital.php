<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospitals';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'address','country_id'];

    protected $hidden = ['created_at', 'updated_at'];

    ##################### Relations ######################
    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor','hospital_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id','id');
    }
    ##################### End Relations ######################
}
