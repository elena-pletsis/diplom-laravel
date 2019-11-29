<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NpCity extends Model
{
    protected $table = 'npcities';

    public function area()
        {
            return $this->belongsTo('App\NpArea');
        }

    public function warehouses()
        {
            return $this->hasMany('App\NpWarehouse');
        }
}
