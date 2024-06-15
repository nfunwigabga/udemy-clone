<?php

namespace App\Models;

use App\Traits\HasAvatar;
use App\Traits\WithHashId;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasAvatar;
    use WithHashId;

    protected $fillable = [
        'hashid',
        'first_name',
        'last_name',
        'username',
        'about',
        'email',
        'password',
        'avatar_disk',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->first_name.' '.$this->last_name
        );
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
        ->withTimestamps();
    }

    public function canAccessCourse(COurse $course)
    {
        return $this->enrollments->contains($course) || $this->courses->contains($course);
    }

    //    public function searchableAs()
    //    {
    //        return 'users';
    //    }
    //
    //    public function toSearchableArray()
    //    {
    //        return [
    //            'id' => $this->getKey(),
    //            'name' => $this->name,
    //            'image' => $this->avatar,
    //        ];
    //    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'notifications.'.$this->id;
    }
}
