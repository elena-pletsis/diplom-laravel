<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;

class Category extends Model
{
    public function product()
        {
            return $this->hasMany('App\Product');
        }
    public function parent()
        {
        	return $this->belongsTo(self::class, 'parent_id'); //получим 1 родителя
        }
    public function children()
        {
        	return $this->hasMany(self::class, 'parent_id'); //получим детей
        }
    //https://laravel.com/docs/5.8/eloquent-mutators#defining-a-mutator
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

    public function scopeMainCategories($query)
        {
            return $query->where('parent_id', null);
        }

}

