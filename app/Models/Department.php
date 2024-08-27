<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Project;

// Correct namespace for Project

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'departments_projects');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'departments_users')
            ->withPivot('position')
            ->withTimestamps();
    }
}
