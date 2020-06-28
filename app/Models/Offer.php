<?php

namespace App\Models;

use App\Scopes\OfferScope;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';

    protected $primaryKey = 'id';

    protected $fillable = ['name_ar', 'name_en', 'price', 'details_ar', 'details_en','photo','status'];

    protected $hidden = ['created_at', 'updated_at'];

    //public $timestamps = false;

    ############### local scope ####################################
    public function scopeInactive($query)
    {
        return $query->where('status',1)->whereNull('photo');
    }
    ############### End local scope ###############################

    //register globa scope
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OfferScope);
    }

    /******************** Mutators **************************/
    public function setNameEnAttribute($value)
    {
        return $this->attributes['name_en'] = strtoupper($value);
    }

    /******************** End Mutators ************************************/

}
