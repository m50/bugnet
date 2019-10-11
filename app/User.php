<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
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

        static::created(
            function ($user) {
                $user->auth_config()->create(
                    ['config' => [
                    'avatar' => $user->gravatar
                    ]]
                );
                if ($user->id === 1) {
                    $user->is_admin = true;
                    $user->save();
                }
            }
        );
    }

    /**
     * Relation to owned projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    /**
     * Relation to shared projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shared_projects()
    {
        return $this->belongsToMany(Project::class)
            ->withTimestamps();
    }

    /**
     * Relation to auth config.
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
     * @param  string $password
     * @return void
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Get the gravatar of the user.
     * Note: The gravatar is only if you don't want to use what is in the
     * auth config.
     * @param  int|null    $size    = 30
     * @param  string|null $default = 'mp'
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
