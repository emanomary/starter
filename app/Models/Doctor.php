<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'title','hospital_id','sex','medical_id'];

    protected $hidden = ['created_at', 'updated_at','pivot'];

    ##################### Relations ######################
    public function hospital()
    {
        return $this->belongsTo('App\Models\Hospital','hospital_id','id');
    }


    public function service()
    {
        return $this->belongsToMany('App\Models\Service','doctor_service','doctor_id','service_id','id','id');
    }
    ##################### End Relations ######################
}
