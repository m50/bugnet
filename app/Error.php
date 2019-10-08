<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $guarded = [
        'id', 'slug', 'created_at'
    ];
    protected $hidden = [
        'project_id'
    ];
    protected $casts = [
        'trace' => 'array'
    ];
    protected $touches = [ 'project' ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($error) {
            $error->slug = Str::slug($error->name);
        });
    }

    public function owner()
    {
        return $this->belongsTo(Project::class);
    }
}
