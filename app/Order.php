<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; //https://carbon.nesbot.com/


class Order extends Model
{
    public function status()
    {
    	return $this->belongsTo('App\Status'); 
    }
    
    public function items()
    {
    	return $this->hasMany('App\OrderItems'); 
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }


}
