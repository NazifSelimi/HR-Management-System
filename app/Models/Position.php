<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
    ];

    public function projects() :BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('user_id', 'start_date', 'end_date')
            ->withTimestamps();
    }

    public function users() :BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('project_id', 'start_date', 'end_date')
            ->withTimestamps();
    }
}
