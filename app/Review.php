<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Review extends Model
{
    protected $table = "reviews";

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function product(){
    	return $this->belongsTo('App\Product');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

}
