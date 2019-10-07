<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Errors extends Model
{
    protected $hidden = [
        'project_id'
    ];
    protected $casts = [
        'trace' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($error) {
            $error->slug = Str::slug("$error->name $error->id");
        });
    }

    public function owner()
    {
        return $this->belongsTo(Project::class);
    }
}
