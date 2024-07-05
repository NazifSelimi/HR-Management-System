<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class Department extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
    ];

    public function projects():HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function users():HasMany
    {
        return $this->hasMany(User::class);
    }
}
