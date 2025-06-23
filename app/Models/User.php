<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


/**
 * @method bool hasPermissionTo(string $permission)
 * @method \Illuminate\Support\Collection getAllPermissions()
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

        public $timestamps = true;


    protected $fillable = [
        'Fullname',
        'Username',
        'Password',
        'rememberToken',
        'CR_DT',
        'PS_ID',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'PS_ID');
    }
  
}
