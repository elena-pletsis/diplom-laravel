<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','email', 'address', 'password', 'phone', 'club_member', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    //добавляем свою часть
    //roles во множественном числе т.к. 1 пользователь может иметь много ролей
    public function roles()
    {
        //https://laravel.com/docs/5.8/eloquent-relationships#many-to-many
        return $this->belongsToMany('App\Role', 'users_roles', 'user_id', 'role_id');
        //второй параметр указываем название таблицы в которой происходит связь, след параметр - столбец с пользователем в табл. user, и последний параметр - название столбца связанной модели (что связываем и затем с чем)
        //методы связи - записываются в свойства и roles станет свойством, roles - это коллекция со всеми ролями
    }

    // {{ Auth::user()->name }}
    // //в любом представлении чтобы вывести имя авторизированного пользователя для проверки (взять из layouts/app.blade.php) 

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }   

    public function isAdmin()
    {
        return $this->roles->contains('name', 'admin');
    }

    public function orders()
    {
        return $this->hasMany('App\Order'); 
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist'); 
    }

    public function reviews()
    {
        return $this->hasMany('App\Review'); 
    }

}
