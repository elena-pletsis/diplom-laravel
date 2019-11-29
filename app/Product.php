<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    	{
    	    return $this->belongsTo('App\Category');
    	}

    public function brand()
        {
            return $this->belongsTo('App\Brand');
        }

    public function modification()
        {
            return $this->hasMany('App\Modification');
        }

    public function gallery()
        {
            return $this->hasMany('App\Gallery');
        }

    public function wishlist()
        {
            return $this->hasMany('App\Wishlist'); 
        }

    public function review()
        {
            return $this->hasMany('App\Review'); 
        }

    public function relatedProducts()
        {
            return $this->belongsToMany('App\Product', 'related_products', 'product_id', 'related_id'); 

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

    public function scopeStatus($query)
        {
            return $query->where('status', '=', 1);
        }

    public function scopeHit($query)
        {
            return $query->where('hit', '=', 1);
        }

    public function scopeWithImg($query)
        {
            return $query->whereNotNull('img');
        }
    
    public function scopeLatest($query)
        {
            return $query->orderBy('created_at', 'DESC');
        }

    public function scopeFilter($q)
        {
            if (request('price_from')) {
                $q->where('price', '>', request('price_from'));
            }
            if (request('price_to')) {
                $q->where('price', '<', request('price_to'));
            }
            if (request('brand')) {
                $q->whereIn('brand_id', request('brand')); 
            }
            if(request('category')){
                $q->whereIn('category_id', request('category'));
            }

            return $q;
        }

}
