<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasFactory,HasRoles,Notifiable;

    protected $table ='admins';
    protected $guard_name = 'admin';
    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'notification'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function getDefaultGuardName(): string
    {
        return 'admin';
    }

}
