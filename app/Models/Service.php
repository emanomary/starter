<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at','pivot'];

    public function doctor()
    {
        return $this->belongsToMany('App\Models\Doctor','doctor_service','service_id','doctor_id','id','id');
    }
}
