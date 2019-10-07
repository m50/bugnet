<?php

namespace App;

use App\Models\Mail\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
Use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'name', 'description', 'tags'
    ];
    protected $casts = [
        'tags' => 'array'
    ];
    protected $hidden = [
        'owner_id'
    ];


    public static function boot()
    {
        parent::boot();
        
        static::saving(function ($project) {
            $project->slug = Str::slug("$project->name $project->id");
        });
        static::creating(function ($project) {
            $project->api_key = md5($project->name . Carbon::now() . Str::random(32));
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function errors()
    {
        return $this->hasMany(Errors::class);
    }
}
