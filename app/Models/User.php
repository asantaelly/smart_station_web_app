<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


     /**
     * The roles that belong to the user
     */    
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role');
    }

    /**
     *  Checking the role of the authenticated user
     *  @param string $role
     *  @return boolean
     */
    public function hasRole($is_role) {

        $roles = $this->roles;
        foreach ($roles as $role) {
            if($role->name === $is_role){
                return true;
            break;
            }
        }

        return false;
    }

    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }
}
