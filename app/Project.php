<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    /**
     * $fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'tags', 'url'
    ];
    /**
     * $casts
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array'
    ];
    /**
     * $hidden
     *
     * @var array
     */
    protected $hidden = [
        'owner_id'
    ];

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
     * Boot up the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::saving(
            function ($project) {
                $project->slug = Str::slug($project->name);
            }
        );
        static::creating(
            function ($project) {
                $project->api_token = Str::random(60);
            }
        );
    }

    /**
     * Relation to owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relation to errors
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function errors()
    {
        return $this->hasMany(Error::class);
    }

    /**
     * Setter for the tags attribute to be ablt to transform strings or arrays.
     *
     * @param mixed $tags
     * @return void
     */
    public function setTagsAttribute($tags)
    {
        if (is_string($tags)) {
            $this->attributes['tags'] = collect(explode(',', $tags))
                ->map(
                    function ($tag) {
                        return strtolower(trim($tag));
                    }
                );
        } else {
            $this->attributes['tags'] = collect($tags)
                ->map(
                    function ($tag) {
                        return strtolower(trim($tag));
                    }
                );
        }
    }

    /**
     * Output the tags of the model as a comma separated string.
     *
     * @return string
     */
    public function tagsToString() : string
    {
        return implode(', ', $this->tags);
    }
}
