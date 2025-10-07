<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'user_type',
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

    /**
     * Get the loans for the user.
     */
    public function loans()
    {
        return $this->hasMany(BookLoan::class);
    }

    /**
     * Get the currently borrowed books for the user.
     */
    public function currentLoans()
    {
        return $this->hasMany(BookLoan::class)->where('status', 'borrowed');
    }

    /**
     * Get the overdue loans for the user.
     */
    public function overdueLoans()
    {
        return $this->hasMany(BookLoan::class)
                    ->where('status', 'borrowed')
                    ->where('due_date', '<', now());
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user is member.
     */
    public function isMember()
    {
        return $this->user_type === 'member';
    }
}