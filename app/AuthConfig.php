<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthConfig extends Model
{
    /**
     * $casts
     *
     * @var array
     */
    protected $casts = [ 'config' => 'array' ];

    /**
     * $fillable
     *
     * @var array
     */
    protected $fillable = [ 'config', 'user_id' ];

    /**
     * user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
