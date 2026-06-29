<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'role',
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
            'permissions' => 'array',
        ];
    }

    /**
     * Check if user has permission for a specific menu.
     * @param string $menu
     * @return bool
     */
    public function hasPermission(string $menu): bool
    {
        if ($this->role === 'manager') {
            return true;
        }

        if ($this->role === 'admin qc') {
            return in_array($menu, ['qc.upload', 'qc.manual', 'qc.history']);
        }

        if ($this->role === 'admin inventory') {
            return in_array($menu, ['products.index', 'inventory.index', 'inventory.mutations']);
        }

        if (empty($this->permissions)) {
            return false;
        }
        return in_array($menu, $this->permissions);
    }
}
