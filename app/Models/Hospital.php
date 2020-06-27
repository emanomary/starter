<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospitals';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'address'];

    protected $hidden = ['created_at', 'updated_at'];

    ##################### Relations ######################
    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor','hospital_id','id');
    }
    ##################### End Relations ######################
}
