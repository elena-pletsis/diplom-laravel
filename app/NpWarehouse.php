<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NpWarehouse extends Model
{
	protected $table = 'npwarehouses';
	
    public function city()
        {
            return $this->belongsTo('App\NpCity');
        }
}
