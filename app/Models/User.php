<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'unit',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // === Relationships ===

    // CRs submitted by the user
    public function submittedChangeRequests()
    {
        return $this->hasMany(ChangeRequest::class, 'requestor_id');
    }

    // CRs assigned to the implementor
    public function assignedChangeRequests()
    {
        return $this->hasMany(ChangeRequest::class, 'implementor_id');
    }

    // Notifications sent to this user
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}



/*
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> 
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     
    protected $fillable = [
        'name',
        'email',
        'password',
        'userCategory',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
*/

