<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
public function product()
    {
        return $this->hasMany('App\Product');
    }
public function setSlugAttribute($value)
    {
    	if(!$value){
    		$this->attributes['slug'] = \Str::slug($this->attributes['title'], '-');
    	}
    	//https://laravel.com/docs/5.8/helpers#method-str-slug
    	else{
    		$this->attributes['slug'] = \Str::slug($value, '-');
    	}
    }
public function getImgAttribute($value)
    {
        return $value ? $value : '/images/no-photo.jpg';
    }

public function scopeWithImg($query)
    {
        return $query->whereNotNull('img');
    }
    
}
