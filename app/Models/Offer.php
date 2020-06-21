<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'price', 'details'];

    protected $hidden = ['created_at', 'updated_at'];

    //public $timestamps = false;
}
