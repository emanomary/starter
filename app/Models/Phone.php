<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phones';

    protected $primaryKey = 'id';

    protected $fillable = ['code', 'phone_no', 'user_id'];

    protected $hidden = ['created_at', 'updated_at','user_id'];

    ##################### Relations ######################
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    ##################### End Relations ######################
}
