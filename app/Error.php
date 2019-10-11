<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    /**
     * $guarded
     *
     * @var array
     */
    protected $guarded = [
        'id', 'slug', 'created_at'
    ];
    /**
     * $hidden
     *
     * @var array
     */
    protected $hidden = [
        'project_id'
    ];
    /**
     * $casts
     *
     * @var array
     */
    protected $casts = [
        'trace' => 'array'
    ];
    /**
     * $touches
     *
     * @var array
     */
    protected $touches = [ 'project' ];

    /**
     * Get the route key name.
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saving(
            function ($error) {
                $error->slug = Str::slug($error->name);
            }
        );
    }

    /**
     * Relation to the owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Project::class);
    }
}
