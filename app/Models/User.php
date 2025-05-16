<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasCustomTimestamps;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    // Menonaktifkan timestamps default
    public $timestamps = false;

    // Rename kolom timestamp default
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

    protected $fillable = [
        'name',
        'email',
        'role',
        'Status',
        'password',
        'Phone',
        'CreatedDate',
        'CreatedBy',
        'LastUpdatedDate',
        'LastUpdatedBy',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
