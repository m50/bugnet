<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    protected $attributes = [
        'is_admin' => false,
    ];

    protected $appends = [
        'gravatar'
    ];

    protected $with = [ 'auth_config' ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->auth_config()->create(['config' => [
                'avatar' => $user->gravatar
            ]]);
        });
    }

    /**
     * projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    /**
     * shared_projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shared_projects()
    {
        return $this->belongsToMany(Project::class)
            ->withTimestamps();
    }

    /**
     * auth_config
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function auth_config()
    {
        return $this->hasOne(AuthConfig::class);
    }

    /**
     * setPasswordAttribute
     *
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * getGravatarAttribute
     *
     * @param int|null $size = 30
     * @param string|null $default = 'mp'
     * @return void
     */
    public function getGravatarAttribute(?int $size = null, ?string $default = null) : string
    {
        $size = $size ?? 30;
        $default = $default ?? 'mp';
        $email = md5($this->email);
        $url = "https://gravatar.com/avatar/{$email}?s={$size}&d={$default}";
        return $url;
    }
}
