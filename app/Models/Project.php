<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class  Project extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'department_id'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function positions():BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'positions_projects_users')
            ->withPivot('user_id', 'start_date', 'end_date')
            ->withTimestamps();
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'positions_projects_users')
            ->withPivot('position_id', 'start_date', 'end_date')
            ->withTimestamps();
    }
}
