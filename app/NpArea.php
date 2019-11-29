<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NpArea extends Model
{
	protected $table = 'npareas';
	
    public function cities()
    {
        return $this->hasMany('App\NpCity');
    }

}
