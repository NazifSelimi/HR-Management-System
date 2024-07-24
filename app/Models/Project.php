<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class  Project extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'department_id'
    ];

    public function department(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'departments_projects');
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_users');
    }
}
