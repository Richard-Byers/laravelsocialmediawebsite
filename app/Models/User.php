<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected function avatar(): Attribute {
        return Attribute::make(get: function($value) {
            return $value ? '/storage/avatars/' . $value : '/fallback-avatar.jpg';
        });
    }

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

    public function feedPosts() {
        return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser');
    }

    public function following() {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function followers() {
        return $this->hasMany(Follow::class, 'followeduser');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'user_id');
    }
}
