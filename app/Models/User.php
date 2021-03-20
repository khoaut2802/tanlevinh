<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeCustomer($query)
    {
        return $query->where('user_type', 'user');
    }    

    public function scopeStaff($query)
    {
        return $query->where('user_type', 'staff');
    }  
    
    public function scopeAdmin($query)
    {
        return $query->where('user_type', 'admin');
    }  

    public function orders()
    {
        return $this->hasMany(Orders::class, 'user_id', 'id');
    }
}
